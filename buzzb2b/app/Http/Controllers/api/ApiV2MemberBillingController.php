<?php

namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType, App\LedgerDetails;
use Hash;
use App\Helpers;
use App\Transformers\Member\Billing\UserMemberDashboardTransformer;
use App\Http\Controllers\api\Settler;
use App\Http\Controllers\api\GatewayRequest;


class ApiV2MemberBillingController extends ApiV2Controller {

	

	protected $user;

	public function __construct()
	{
		parent::__construct();

		$this->user = \JWTAuth::parseToken()->authenticate();
                $this->id = $this->user->id;
                
	}
	/**
	 * @api {post} /member/billing/load/new  Attempt to create a new payment gateway vault customer, and then charge an input payment, saving it if successful
	 * @apiName LoadNew
	 * @apiGroup MemberBilling
	 *
	 * @apiParam {string}  customer_member_slug    (required)  customer member slug
	 * @apiParam {string}  first_name              (required)
	 * @apiParam {string}  last_name               (required)
	 * @apiParam {string}  address_id              (required or 0)
	 * @apiParam {string}  payment_type            (required)
	 * @apiParam {string}  address1                (required if: address_id = 0)
	 * @apiParam {string}  address2                (required if: address_id = 0)
	 * @apiParam {string}  city                    (required if: address_id = 0)
	 * @apiParam {string}  state_id                (required if: address_id = 0)
	 * @apiParam {string}  zip                     (required if: address_id = 0)
	 * @apiParam {string}  cc_number               (required if: payment_type = CREDIT_CARD)
	 * @apiParam {string}  cc_cvv                  (required if: payment_type = CREDIT_CARD)
	 * @apiParam {string}  cc_exp_month            (required if: payment_type = CREDIT_CARD)
	 * @apiParam {string}  cc_exp_year             (required if: payment_type = CREDIT_CARD)
	 * @apiParam {string}  check_routing_number    (required if: payment_type = CHECK)
	 * @apiParam {string}  check_account_number    (required if: payment_type = CHECK)
	 * @apiParam {string}  check_number            (required if: payment_type = CHECK)
	 * @apiParam {string}  charge_amount           (required)  total cash amount of payment
	 *
	 * @apiSuccess {Object} settledResponse
	 */
	public function loadNew(Request $request)
	{
			extract($request->all());
			$input_amount = $charge_amount;
			$charge_amount = sanitizeDecimalForStore($input_amount);

			# get customer member
			$customerMember = Member::where('slug', $customer_member_slug)->first();

			if ( ! $customerMember)
			{
				return $this->respondNotFound('That customer member could not be found.');
			}

			# authorize transaction
			$this->memberCba($customerMember, $this->user)->load($charge_amount,'');

			# create member customer through gateway
			$createCustomerResponse = $this->createMember($customerMember->exchange->domain, $customerMember, [
				'first_name' => $first_name,
				'last_name' => $last_name,
			]);

			if ( ! $createCustomerResponse->success)
			{
				return $this->respondGeneralExceptionWithMessage($createCustomerResponse->message);
			}

			# determine billing address
			if ($address_id)
			{
				
				$address = Address::find($address_id);
				
				if (count($address)==0)
				{
					return $this->respondNotFound('Could not find that billing address!');
				}
			}
			
			# attempt to process transaction through gateway and save data as a payment account if successful
			$chargeCustomerResponse = $this->domain($customerMember->exchange->domain)->chargeNewMemberAccount($customerMember, [
				'amount' => $input_amount,
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
			]);

			if ( ! $chargeCustomerResponse->success)
			{
				return $this->respondGeneralExceptionWithMessage($chargeCustomerResponse->message);
			}

			# settle transaction
                        $settler = new Settler();
			$settledResponse = $settler->memberCbaDeposit($customerMember, $this->user)->load($charge_amount);

			# raise event: transaction settled
			$settledResponse['transaction']->raise(new MemberUserCbaLoaded($settledResponse));

			return $this->respond($this->makeItem($settledResponse, new SettledTransactionTransformer));
		
	}
public function createMember($domain, Member $member, array $data)
	{
		// todo: check that a customer doesn't already exist
		// $existingCustomerResponse = $this->gateway->domain($domain)->getMemberCustomer($member);
		$response = $this->domain($domain)->createMemberCustomer($member, $data);

		return $response;
	}
public function createMemberCustomer($member, array $input)
	{
		
		$request = $this->newRequest();

		$customerData = [
			'customerId' => $this->getCustomerId($member),
			'firstName' => substr(ucwords($input['first_name']), 0, 49),
			'lastName' => substr(ucwords($input['last_name']), 0, 49),
			'company' => substr($this->getCustomerCompanyName($member), 0, 49),
			'sendEmailReceipts' => false,
			'customerDuplicateCheckIndicator' => 1,
		];

		$customerData = $this->insertApplicationData($customerData);

		$response = $request->post('Customers', $customerData);

		return $response;
	}
	protected function getCustomerCompanyName($entity)
	{
		switch ( $this->getEntityType($entity) )
		{
			case 'member':
				$company = $entity->name;
				break;

			case 'user':
				$company = $entity->first_name . ' ' . $entity->last_name;
				break;
			
			default:
				$company = '';
				break;
		}

		return $company;
	}

	/**
	 * @api {post} /member/billing/load/profile  Attempt to deposit funds into a member's CBA account by charging a selected payment profile of an existing payment gateway vault customer
	 * @apiName LoadProfile
	 * @apiGroup MemberBilling
	 *
	 * @apiParam {string}  customer_member_slug    (required)  customer member slug
	 * @apiParam {string}  billing_profile_id      (required)  payment gateway account id
	 * @apiParam {string}  charge_amount           (required)  total cash amount of payment
	 *
	 * @apiSuccess {Object} settledResponse
	 */
	public function loadProfile(Request $request)
	{
                        extract($request->all());
			$input_amount = $charge_amount;
			$charge_amount = sanitizeDecimalForStore($input_amount);

			# fetch customer member
			$customerMember = Member::where('slug', $customer_member_slug)->first();

			if ( !$customerMember)
			{
				return $this->respondNotFound('That customer member could not be found.');
			}

			# authorize transaction
			$memberCba = $this->memberCba($customerMember, $this->user)->load($charge_amount,$date);
                        if(!$memberCba) {
                            return $this->respondNotFound('Minimum CBA deposit not met.');
                        }
                        
                        

			# attempt to process transaction through gateway
                        $chargeCustomerResponse = $this->domain($customerMember->exchange->domain)->chargeAccount($customerMember, $billing_profile_id, $input_amount);
                        
			

			if ( ! $chargeCustomerResponse->success)
			{
				return $this->respondGeneralExceptionWithMessage($chargeCustomerResponse->message);
			}
                        
			# settle transaction
                        $settler = new Settler();
			$settledResponse = $settler->memberCbaDeposit($customerMember, $this->user)->load($charge_amount);
                        
                        $this->settledResponse = $settledResponse;
                        $settledResponse['transaction'] = $settledResponse;

			# raise event: transaction settled
			//$settledResponse['transaction']->raise(new MemberUserCbaLoaded($settledResponse));

			# dispatch all events
			//$this->dispatchEventsFor($settledResponse['transaction']);
			
			return $this->respond($this->makeItem($settledResponse, new SettledTransactionTransformer));
		
	}
	
	
	public function chargeNewMemberAccount($member, array $input)
	{
		$request = $this->newRequest();

		$customerId = $this->getCustomerId($member);

		$customerData = [
			'amount' => $input['amount'],
			'addToVault' => true,
			'addToVaultOnFailure' => false,
			'paymentVaultToken' => [
				'customerId' => $customerId,
				// 'paymentMethodId' => '6',
				'paymentType' => $input['payment_type'],
			],
			'allowPartialCharges' => false,
			'transactionDuplicateCheckIndicator' => 1,
			'orderId' => uniqid($customerId . '-'), // {customerid}-4b3403665fea6
		];

		$customerData = $this->insertPaymentData($input, $customerData);

		$customerData = $this->insertExtendedInformation($customerData);
		
		$customerData = $this->insertApplicationData($customerData);

		$response = $request->post('Payments/Charge', $customerData);

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
					'address' => $input['address1'].' '.$input['address2'].' '.$input['city'].' '.$input['zip'], //$this->parseAddressInput($input['address1'], $input['address2'], $input['city'], $input['state_id'], $input['zip'])
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

         protected function newRequest()
	{
		return new GatewayRequest($this->url, $this->gatewayId, $this->gatewayKey);
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
        
        
        
        public function memberCba(Member $customerMember, User $customerUser)
	{       $this->customerMember = $customerMember;
		$this->customerUser = $customerUser;
		$this->customerExchange = $customerMember->exchange;

		$this->merchantExchange = $customerMember->exchange;
                
                $user = New User();
                # make sure this user is authorized per the member
                if ( ! $user->hasMemberAccess($customerMember, 'billing'))
                {
                        return $this->respondNotFound('That user does not have the permission to access billing data');
                }
                return $this;
	}
        
        
        /**
	 * Charge an existing payment account associated with the paying entity
	 * 
	 * @param  EloquentObject  $payingEntity Member or User
	 * @param  string  $paymentMethodId
	 * @param  string  $amount
	 * @return array
	 */
	public function chargeAccount($payingEntity, $paymentMethodId, $amount)
	{   
		$request = $this->newRequest();

		$customerId = $this->getCustomerId($payingEntity);

		$customerData = [
			'amount' => $amount,
			'paymentVaultToken' => [
				'customerId' => $customerId,
				'paymentMethodId' => $paymentMethodId,
				// 'paymentType' => $input['payment_type'],  [CREDIT_CARD|CHECK]
			],
			'allowPartialCharges' => false,
			'transactionDuplicateCheckIndicator' => 1,
			'orderId' => uniqid($customerId . '-'), // {customerid}-4b3403665fea6
		];

		$customerData = $this->insertExtendedInformation($customerData);
		
		$customerData = $this->insertApplicationData($customerData);

		$response = $request->post('Payments/Charge', $customerData);

		return $response;
	}
         protected function insertApplicationData($data)
	{
		$data['developerApplication'] = [
			'developerId' => '10000543', // 12345678
			'version' => '1.2'
		];

		return $data;
	}  
        
        protected function insertExtendedInformation($data)
	{
		$levelTwoData = [
			'orderDate' => date("Y-m-d H:i:s"),
			'taxAmount' => '0.00',
			'status' => 'EXEMPT',
		];

		$extendedInformation = [
			'typeOfGoods' => 'DIGITAL',
			'levelTwoData' => $levelTwoData,
			'mailOrTelephoneData' => ['type' => 'SINGLE_PURCHASE'],
		];

		$data['extendedInformation'] = $extendedInformation;

		return $data;
	}
        
        
        public function memberCbaDeposit($customerMember, $customerUser)
	{
		$this->transaction_type_id = 21;
		
		$this->merchantExchange = $customerMember->exchange;

		$this->customerMember = $customerMember;
		$this->customerExchange = $customerMember->exchange;
		$this->customerUser = $customerUser;

		return $this;
	}
        
        public function load($amount,$date)
	{
		
		$this->charge_amount = $amount;
               // does this deposit amount meet the customer's minimum deposit requirement (exchange min + member outstanding CBA debt)
		if ($this->charge_amount < $this->minimumCbaDeposit($date)) {
                   return false;
                } else {
                    return true;
                }  
	}
        
        public function minimumCbaDeposit($date = '')
	{
		$depositTotal = $this->customerExchange->ex_default_min_cra_deposit; // get from config
                
                $query = LedgerDetails::
			 whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
			->where('member_id', $this->id);
			

		if ($date)
			$query = $query->where('created_at', '<=', $date->addSeconds(5));
		
		$total = (int) $query->sum('amount');
                if ($total < 0)
			$depositTotal += (-$total);

		return $depositTotal;
        }
        
        public function cbaBalance($date = false)
	{
		$ledgerRepo = $this->getLedgerRepo();

		return $ledgerRepo->getMemberCbaBalance($this->id, $date);
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
        protected function getEntityType($entity)
	{
		return strtolower(class_basename(get_class($entity))); // member, user
	}


}
