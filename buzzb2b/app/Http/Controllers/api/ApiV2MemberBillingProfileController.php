<?php
namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType;
use Hash;
use App\Helpers;
use App\Transformers\Member\Billing\PaymentProfileTransformer;
use App\Http\Controllers\api\GatewayRequest;


class ApiV2MemberBillingProfileController extends ApiV2Controller {

	/*
	 * @var User
	 */
	protected $user;

	public function __construct()
	{
		parent::__construct();

		$this->user = \JWTAuth::parseToken()->authenticate();
                
	}

	/**
	 * @api {get} /member/billing/profiles  Retrieve all payment accounts for a vault member customer
	 * @apiName getByMember
	 * @apiGroup MemberBillingProfile
	 *
	 * @apiParam {string}  member_slug  (required)  member slug
	 *
	 * @apiSuccess {Object} profiles
	 */
	public function getByMember(Request $request)
	{
                extract($request->all());
		try
		{
			
                        # get member
			$member = Member::where('slug', $member_slug)->first();

			if ( ! $member)
			{
				return $this->respondNotFound('That member could not be found.');
			}
                        $user = New User();
			# make sure this user is authorized per the member
			if ( ! $user->hasMemberAccess($member, 'billing'))
			{
				return $this->respondNotFound('That user does not have the permission to access billing data');
			}
			
                      
                        $response = $this->domain($member->exchange->domain)->getMemberCustomer($member);
                        
                        $response_other = $this->collection($response->vaultCustomer->paymentMethods)->sortByDesc('primary');
                        
                        return $this->respond($this->makeCollection($response_other, new PaymentProfileTransformer));
		}
		catch (FormValidationException $e)
		{
			return $this->respondValidationFailed($e);
		}
	}
        
        protected function collection(array $data)
	{
		return new \Illuminate\Support\Collection($data);
	}
        public function domain($domain = '')
	{       
		if ( ! $domain)
		{
			return $this->respondNotFound('Domain missing');
		}

		$this->domain = $domain;

		if ( ! \Config::has('peos.billing.gateway.accounts.' . $domain))
		{
			return $this->respondNotFound('Domain missing from config');
		}

		$production = \Config::get('peos.billing.gateway.accounts.' . $domain . '.production');

		$this->url = ($production) ? \Config::get('peos.billing.gateway.url.production') : \Config::get('peos.billing.gateway.url.development');

		$this->gatewayId = ($production) ? \Config::get('peos.billing.gateway.accounts.' . $domain . '.id') : \Config::get('peos.billing.gateway.accounts.sandbox.id');

		$this->gatewayKey = ($production) ? \Config::get('peos.billing.gateway.accounts.' . $domain . '.key') : \Config::get('peos.billing.gateway.accounts.sandbox.key');
                
		return $this;
	}
        
        
        protected function newRequest()
	{
		return new GatewayRequest($this->url, $this->gatewayId, $this->gatewayKey);
	}
        
        
        /**
	 * Retrieve a member vault customer
	 * 
	 * @param  EloquentObject  $member Member
	 * @return array
	 */
	public function getMemberCustomer($member)
	{
		$request = $this->newRequest();

		$response = $request->get('Customers/' . $this->getCustomerId($member));

		return $response;
	}
        
        protected function getEntityType($entity)
	{
		return strtolower(class_basename(get_class($entity))); // member, user
	}
        protected function getCustomerId($entity)
	{
		switch ( $this->getEntityType($entity) )
		{
			case 'member':
				$id = '1-' . $entity->id;
				break;

			case 'user':
				$id = '2-' . $entity->id;
				break;
			
			default:
				$id = false;
				break;
		}

		return strtolower($id);
	}
        
	/**
	 * @api {post} /member/billing/profile/create  Attempt to create a new payment account for a vault member customer
	 * @apiName Create
	 * @apiGroup MemberBillingProfile
	 *
	 * @apiParam {string}  member_slug             (required)  member slug
	 * @apiParam {string}  first_name              (required)
	 * @apiParam {string}  last_name               (required)
	 * @apiParam {string}  payment_type            (required)  CREDIT_CARD|CHECK
	 * @apiParam {int}     address_id              (required or 0)  address id for member billing address
	 * @apiParam {string}  address1                (required if: address_id = 0)
	 * @apiParam {string}  address2                (required if: address_id = 0)
	 * @apiParam {string}  city                    (required if: address_id = 0)
	 * @apiParam {int}     state_id                (required if: address_id = 0)  state id number (1-50, LA=19)
	 * @apiParam {string}  zip                     (required if: address_id = 0)  5-digit zip code
	 * @apiParam {string}  cc_number               (required if: payment_type = CREDIT_CARD)  16-digit card number
	 * @apiParam {string}  cc_cvv                  (required if: payment_type = CREDIT_CARD)  credit card cvv code
	 * @apiParam {string}  cc_exp_month            (required if: payment_type = CREDIT_CARD)  2-digit month
	 * @apiParam {string}  cc_exp_year             (required if: payment_type = CREDIT_CARD)  4-digit year\
	 * @apiParam {string}  check_routing_number    (required if: payment_type = CHECK)  bank account routing number
	 * @apiParam {string}  check_account_number    (required if: payment_type = CHECK)  checking account number
	 * @apiParam {string}  check_number            (required if: payment_type = CHECK)  check number
	 * @apiParam {int}     primary                 (optional)  makes this payment profile the members new primary (1=yes, 0=no (default))
	 *
	 * @apiSuccess {Object} settledResponse
	 */
	public function create(Request $request)
	{
		extract($request->all());
                $member = Member::where('slug', $member_slug)->first();
                if ( ! $member)
                {
                        return $this->respondNotFound('That member could not be found.');
                }

                $user = New User();
                # make sure this user is authorized per the member
                if ( ! $user->hasMemberAccess($member, 'billing'))
                {
                        return $this->respondNotFound('That user does not have the permission to access billing data');
                }
                
                if ($address_id)
                {
                        $address = Address::find($address_id);

                        if ( ! $address)
                        {
                                return $this->respondNotFound('Cannot find address for that ID.');
                        }
                }
                
                
                # create customer payment account through gateway
                $createPaymentAccountResponse = $this->createForMember($member, [
                        'payment_type' => $payment_type,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'address1' => ( ! empty($address)) ? $address->address1 : $address1,
                        'address2' => ( ! empty($address)) ? $address->address2 : $address2,
                        'city' => ( ! empty($address)) ? $address->city : $city,
                        'state_id' => ( ! empty($address)) ? $address->state->abbrev : $state_id,
                        'zip' => ( ! empty($address)) ? $address->zip : $zip,
                        'cc_number' => $cc_number,
                        'cc_cvv' => $cc_cvv,
                        'cc_exp_date' => $cc_exp_month . '/' . $cc_exp_year,
                        'check_routing_number' => $check_routing_number,
                        'check_account_number' => $check_account_number,
                        'check_number' => $check_number,
                        'primary' => $primary,
                ]);

                if ( ! $createPaymentAccountResponse->success)
                {
                        return $this->respondGeneralExceptionWithMessage($createPaymentAccountResponse->message);
                }

                // TODO! - transform this
                return $this->respondWithData(['createPaymentAccountResponse' => $createPaymentAccountResponse]);
            }
            
            
            
        public function createForMember(Member $member, array $data)
	{
		$response = $this->domain($member->exchange->domain)->createMemberPaymentAccount($member, $data);

		return $response;
	}
        
        public function createMemberPaymentAccount($member, array $input)
	{
		$request = $this->newRequest();

		$customerId = $this->getCustomerId($member);

		$customerData = [
			'customerId' => $customerId,
			'accountDuplicateCheckIndicator' => 0,
			'primary' => (bool) $input['primary'],
		];

		$customerData = $this->insertPaymentData($input, $customerData);

		$customerData = $this->insertApplicationData($customerData);

		$response = $request->post('Customers/' . $customerId .'/PaymentMethod', $customerData);

		return $response;
	}
        
        
        
        protected function insertPaymentData($input, $data)
	{
		switch ($input['payment_type']) {
			
			case 'CREDIT_CARD':

				$data['card'] = [
					'firstName' => ucwords($input['first_name']),
					'lastName' => ucwords($input['last_name']),
					'number' => $input['cc_number'],
					'cvv' => $input['cc_cvv'],
					'expirationDate' => $input['cc_exp_date'], // 04/2016
					'address' => $this->parseAddressInput($input['address1'], $input['address2'], $input['city'], $input['state_id'], $input['zip']),
				];

				break;

			case 'CHECK':

				$data['check'] = [
					'firstName' => ucwords($input['first_name']),
					'lastName' => ucwords($input['last_name']),
					'accountType' => 'CHECKING',
					'checkType' => 'WEB_INITIATED',
					'routingNumber' => $input['check_routing_number'],
					'accountNumber' => $input['check_account_number'],
					'checkNumber' => $input['check_number'],
					'address' => $this->parseAddressInput($input['address1'], $input['address2'], $input['city'], $input['state_id'], $input['zip']),
				];

				break;
			
			default:
				break;
		}

		return $data;
	}
       protected function insertApplicationData($data)
	{
		$data['developerApplication'] = [
			'developerId' => '10000543', // 12345678
			'version' => '1.2'
		];

		return $data;
	}     
        protected function parseAddressInput($address1, $address2, $city, $state, $zip)
	{
		$address = [
			'line1' => ucwords($address1) . ' ' . ucwords($address2),
			'city' => ucwords($city),
			'state' => $state,
			'zip' => $zip,
		];

		return $address;
	}
    
            

}
