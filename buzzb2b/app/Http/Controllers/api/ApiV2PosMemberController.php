<?php

namespace App\Http\Controllers\api;

//use Peos\Services\Authorizer\AuthorizerException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType,App\Category,App\MemberCashier;
use Hash;
use App\Helpers;
//use App\Peos\Services\Authorizer\Authorizer;
//use App\Transformers\Member\Pos\SettledTransactionTransformer;
use App\Transformers\MemberCashierTransformer;
// use App\Transformers\MerchantMemberTransformer;
use App\Api\Transformers\MerchantMemberTransformer;

class ApiV2PosMemberController extends ApiV2Controller
{
    protected $merchantExchange;
    protected $merchantMember;
    protected $merchantUser;
    protected $customerUser;
    protected $barter_amount;
    protected $tip_amount;
    protected $user;
    protected $id;

    public function __construct(){
        parent::__construct();
        $this->merchantExchange = null;
	$this->merchantMember = null;
        $this->merchantUser = null;
        $this->customerUser = null;
        $this->barter_amount = 0;
        $this->tip_amount = 0;
        
        //$this->authorizer = $authorizer;
        $this->user = \JWTAuth::parseToken()->authenticate();
    }
    
//    public function memberPurchase(Request $request){
//        extract($request->all());
//        
//        $barter_amount = sanitizeDecimalForStore($request->barter_amount);
//        $tip_amount = sanitizeDecimalForStore($request->tip_amount);
//        $notes = $request->notes;
//        
//        # get customer member
//        $customerMember = Memeber::where('slug', $request->customer_member_slug)->first();
//        if ( ! $customerMember){
//            return response()->json( array('error'=>array('message' => 'That customer member could not be found.','status_code'=>401)) );
//        }
//        
//        # get merchant member
//	$merchantMember = Memeber::where('slug', $request->merchant_member_slug)->first();
//        if ( ! $merchantMember){
//            return response()->json( array('error'=>array('message' => 'That merchant member could not be found.','status_code'=>401)) );
//        }
//        
//        # authorize transaction
//    }
    
    
    /**
    * @api {get} /pos/member/cashiers  Retrieve a list of cashiers for the specified merchant member, if any
    * @apiName CashierList
    * @apiGroup Pos
    *
    * @apiParam {string}  merchant_member_slug    (required)  merchant member slug
    *
    * @apiSuccess {array} memberCashierList
    */
    public function cashierList(Request $request)
    {
        try
        {
            # get merchant member
            $merchantMember = Member::where('slug', $request->merchant_member_slug)->first();
    
            if ( ! $merchantMember)
            {
                    return $this->respondNotFound('That merchant member could not be found.');
            }
            
            $memberCashierList = MemberCashier::where('member_id',$merchantMember->id)->get();
            foreach($memberCashierList as $val){
                
            }
    
            return $this->respond($this->makeCollection($memberCashierList, new MemberCashierTransformer));
        }
        catch (FormValidationException $e)
        {
            return $this->respondValidationFailed($e);
        }
    }
    
    public function merchantsList(Request $request){
        try
        {
            # validate input
            //$this->merchantsListForm->validate(\Input::all());

            # get customer member
            //$customerMember = $this->memberRepo->getBySlug(\Input::get('customer_member_slug'));
            
            $customerMember = Member::where('slug', $request->customer_member_slug)->first();

            if ( ! $customerMember)
            {                
                return $this->respondNotFound('That customer member could not be found.');
            }

            //$memberMerchantsList = $this->memberRepo->memberMerchantsList($customerMember->exchange->id, [$customerMember->id]);
            $memberMerchantsList = Member::where('exchange_id', $customerMember->exchange->id)->where('prospect', false)->whereNotIn('id', [$customerMember->id])->orderBy('name', 'asc')->get();

            // return $memberMerchantsList;

            // return $this->makeCollection($memberMerchantsList, new MerchantMemberTransformer);

            // dd($t);
            
            // return $this->respondWithData($memberMerchantsList);
            return $this->respond($this->makeCollection($memberMerchantsList, new MerchantMemberTransformer));
        }
        catch (FormValidationException $e)
        {
            return $this->respondValidationFailed($e);
        }
    }
    
    public function authorizerMerchant(){
        $authrizationStatus = true;
        if ( ! empty($this->merchantUser))
        {
            // is this merchant user allowed to make this sale on behalf of the merchant member?
            $role = 'cashier';
            if ( ! $role || ! $this->merchantMember)
                $authrizationStatus = false;

            $userMember = Member::where('id', $this->merchantMember->id)->first();
            //dd($userMember);
            if (empty($userMember))
            {
                $authrizationStatus = false;
            }
            
            if ( ! $userMember || ! $role)
                $authrizationStatus = false;

            switch ($role)
            {
                case 'primary':
                        $access = $userMember->memberuser->primary;
                        break;

                case 'admin':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin ) ? true : false;
                        break;

                case 'billing':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin || $userMember->memberuser->can_access_billing ) ? true : false;
                        break;

                case 'cashier':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin || $userMember->memberuser->can_pos_sell || $userMember->memberuser->can_pos_purchase ) ? true : false;
                        break;

                case 'seller':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin || $userMember->memberuser->can_pos_sell ) ? true : false;
                        break;

                case 'purchaser':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin || $userMember->memberuser->can_pos_purchase ) ? true : false;
                        break;
                
                default:
                        $access = false;
                        break;
            }
            $authrizationStatus = $access;
            if ( ! $authrizationStatus)
            {
                return $this->respondNotFound('That user does not have the permission to make this sale.');
                //throw new AuthorizerException('That user does not have the permission to make this sale');
            }
        }
        if ($this->merchantMember->standby)
            return $this->respondNotFound('Merchant is on standby and currently not allowed to sell.');
            //throw new AuthorizerException('Merchant is on standby and currently not allowed to sell');
        
        $this->merchantExchange = $this->merchantMember->exchange;
        return $this;
    }
    
    public function authorizerCustomerMember($customerMember, $customerUser, $memberPurchaseTransaction = true){
        $this->customerMember = $customerMember;
        $this->customerUser = $customerUser;
        $this->customerExchange = $this->customerMember->exchange;
        
        if ($memberPurchaseTransaction)
        {
            // does this customer user have permission to purchase on behalf of this customer member?
            $role = 'purchaser';
            if ( ! $role || ! $customerMember)
                $authrizationStatus = false;

            $userMember = Member::where('id', $customerMember->id)->first();

            if (empty($userMember))
            {
                $authrizationStatus = false;
            }
            
            if ( ! $userMember || ! $role)
                $authrizationStatus = false;

            switch ($role)
            {
                case 'primary':
                        $access = $userMember->memberuser->primary;
                        break;

                case 'admin':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin ) ? true : false;
                        break;

                case 'billing':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin || $userMember->memberuser->can_access_billing ) ? true : false;
                        break;

                case 'cashier':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin || $userMember->memberuser->can_pos_sell || $userMember->memberuser->can_pos_purchase ) ? true : false;
                        break;

                case 'seller':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin || $userMember->memberuser->can_pos_sell ) ? true : false;
                        break;

                case 'purchaser':
                        $access = ( $userMember->memberuser->primary || $userMember->memberuser->admin || $userMember->memberuser->can_pos_purchase ) ? true : false;
                        break;
                
                default:
                        $access = false;
                        break;
            }
            $authrizationStatus = $access;
            if ( ! $authrizationStatus)
            {
                throw new AuthorizerException('That user is not allowed to make purchases on behalf of that member.');
            }
        }

        // does this merchant exchange accept barter from customer exchange?
        if( ! $this->merchantExchange->acceptsBarterFromCustomerExchange($this->customerExchange))
            throw new AuthorizerException('Barter not allowed between these exchanges.');

        return $this;
    }
    
    public function memberPurchase(Request $request)
    {
        try
        {
            # validate input
            //$this->memberPurchaseForm->validate(\Input::all());

            $barter_amount = sanitizeDecimalForStore($request->barter_amount);
            $tip_amount = sanitizeDecimalForStore($request->tip_amount);
            $notes = $request->notes;

            # get customer member
            //$customerMember = $this->memberRepo->getBySlug(\Input::get('customer_member_slug'));
            $customerMember = Member::where('slug', $request->customer_member_slug)->first();
            $this->merchantUser = $customerMember;
            if ( ! $customerMember)
            {
                return $this->respondNotFound('That customer member could not be found.');
            }
            
            # get merchant member
            //$merchantMember = $this->memberRepo->getBySlug(\Input::get('merchant_member_slug'));
            $merchantMember = Member::where('slug', $request->merchant_member_slug)->first();
            $this->merchantMember = $merchantMember;
            if ( ! $merchantMember)
            {
                return $this->respondNotFound('That merchant member could not be found.');
            }
            
            # authorize transaction
            $merchantExchange = $this->authorizerMerchant($merchantMember);
            $authCustMember = $this->authorizerCustomerMember($customerMember, $this->user);
            $this->tip_amount = $tip_amount;

            // is the tip amount less than zero?
            if ($this->tip_amount < 0)
                    throw new AuthorizerException('Invalid tip amount.');
            
            $this->barter_amount = $barter_amount;
		
            // is the barter amount less than zero?
            if ($this->barter_amount < 0)
                    throw new AuthorizerException('Invalid barter amount.');

            // does this customer member have barter spending power to allow this transaction?
            if ($this->barter_amount > $this->customerMember->availableBarterCredit())
                    throw new AuthorizerException('Declined. Customer does not have enough barter balance.');

            // does this transaction exceed this member user's monthly spending limit?
            if ( ! $this->customerUser->allowedToSpendBarterAmountPerMember($this->customerMember, $this->barter_amount))
                    throw new AuthorizerException('Declined. User over monthly spending limit.');
            
            
            // customer CBA fee check
            $customerTransactionFee = $this->calculator->getExchangeTransactionFee('purchase', $this->customerMember, $this->barter_amount);
            
            // does this customer member have enough cba balance for fee & any tip?
            if (($customerTransactionFee + $this->tip_amount) > $this->customerMember->cbaBalance())
                throw new AuthorizerException('Declined. Customer does not have enough member CBA balance.');

            
            // merchant CBA fee check
            $merchantTransactionFee = $this->calculator->getExchangeTransactionFee('sale', $this->merchantMember, $this->barter_amount);

            // does this merchant member have enough cba balance for fee
            if ($merchantTransactionFee > $this->merchantMember->cbaBalance())
                throw new AuthorizerException('Declined. Merchant does not have enough member CBA balance.');
            
            
            
            
            //# authorize transaction
            //$this->authorizer->merchant($merchantMember)->customerMember($customerMember, $this->user)->tip($tip_amount)->barter($barter_amount);
            //
            //# settle transaction
            //$settledResponse = $this->settler->memberToMemberPurchase($customerMember, $this->user, $merchantMember)->settle($barter_amount, $tip_amount, $notes);
            //
            //# raise event: transaction settled
            //$settledResponse['transaction']->raise(new MemberUserBarterPurchaseMade($settledResponse, ['payment' => $customerMember]));
            //
            //# dispatch all events
            //$this->dispatchEventsFor($settledResponse['transaction']);
            //
            //return $this->respond($this->makeItem($settledResponse, new SettledTransactionTransformer));
        }
        catch (FormValidationException $e)
        {
            return $this->respondValidationFailed($e);
        }
        catch (AuthorizerException $e)
        {
            return $this->respondGeneralException($e);
        }
    }
}
