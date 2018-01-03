<?php
namespace App\Http\Controllers\api;

/*use \Peos\Api\Validation\Pos\Card\CardLookupForm;
use Laracasts\Validation\FormValidationException;*/

/*use Peos\Repositories\Bartercards\BartercardRepo;
use Peos\Repositories\Giftcards\GiftcardRepo;

use Peos\Api\Transformers\GiftcardTransformer;*/

use App\Transformers\BartercardTransformer;
use App\Transformers\GiftcardTransformer;

use Illuminate\Http\Response as IlluminateResponse;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Bartercard;
use App\Member;
use App\TransactionDetails;
use App\LedgerDetails;

class ApiV2PosCardController extends Controller {

	/*
	 * @var CardLookupForm
	 */
	protected $cardLookupForm;

	/*
	 * @var BartercardRepo
	 */
	protected $bartercardRepo;

	/*
	 * @var GiftcardRepo
	 */
	protected $giftcardRepo;

	/*
	 * @var User
	 */
	protected $user;

	protected $fractal;

	public function __construct()
	{
		$this->fractal = \App::make('League\Fractal\Manager');
	}

	// public function __construct(/*CardLookupForm $cardLookupForm, BartercardRepo $bartercardRepo, GiftcardRepo $giftcardRepo*/)
	// {
		/*echo $this->user = \JWTAuth::parseToken()->authenticate();
		exit;*/

		/*parent::__construct();

		$this->cardLookupForm = $cardLookupForm;
		
		$this->bartercardRepo = $bartercardRepo;
		$this->giftcardRepo = $giftcardRepo;

		$this->user = \JWTAuth::parseToken()->authenticate();*/
	// }

	/**
	 * @api {get} /pos/card/lookup Request barter or giftcard information
	 * @apiName Lookup
	 * @apiGroup Pos
	 *
	 * @apiParam {string}  card_number    (required)  16-digit card number
	 *
	 * @apiSuccess {Object} Card
	 */
	public function lookup(Request $request)
	{
		$cardNumber = $request->get('card_number');

		$card = Bartercard::where('number', $cardNumber)->first();

		// dd(class_basename($card));

		if(!is_null($card) && count($card) > 0)
		{
			if (class_basename($card) === 'Bartercard')
			{
				if (is_null($card->member))
					return ['data' => 'The member associated with this card has been removed.'];
				
				if (is_null($card->user))
					return ['data' => 'The user a
				ccount associated with this card has been removed.'];

				if ( !$card->user->belongsToMemberId($card->member->id))
					return $this->respondNotFound('That card is no longer valid.');

				return $this->makeItem($card, new BartercardTransformer);
			}
			elseif (class_basename($card) === 'Giftcard')
			{
				return $this->makeItem($card, new GiftcardTransformer);
			}
		}
		else
		{
			return [data => 'That card could not be found.'];
		}
	}

	public function makeItem($data, $transformer)
	{
		$item = new Item($data, $transformer);

		return $this->fractal->createData($item)->toArray();
	}

	/**
	 * Returns a card object (barter or gift) given a card number
	 * 
	 * @param  string $number card number
	 * @return Bartercard|Giftcard|false
	 */
	private function getCardData($number)
	{		
		// first, try to look it up as a bartercard
		$bartercard = $this->bartercardRepo->getByNumber($number);

		if ($bartercard)
			return $bartercard;

		// next, try to look it up as a giftcard
		$giftcard = $this->giftcardRepo->getByNumber($number);

		if ($giftcard)
			return $giftcard;

		return false;
	}

	public function cardSale(Request $request)
	{
		// dd($request);

		$barterAmount = $request->get('barter_amount');
		$tipAmount = $request->get('tip_amount');
		$notes = $request->get('notes');
		$merchantMemberSlug = $request->get('merchant_member_slug');
		$cardNumber = $request->get('card_number');

		if(!empty($merchantMemberSlug))
		{
			$merchantMember = Member::where('slug', $merchantMemberSlug)->first();

			if(!(!is_null($merchantMember) && count($merchantMember) > 0))
			{
				return ['data' => 'That merchant member could not be found.'];
			}

			$card = Bartercard::where('number', $cardNumber)->first();

			// dd(class_basename($card));

			if(!(!is_null($card) && count($card) > 0))
			{
				return ['data' => 'That card could not be found.'];
			}

			switch (class_basename($card)) 
			{
				case 'Bartercard':

					/*one entry will be in transaction table*/
			        $transactions = TransactionDetails::create([
			         'type_id'=>11,
			         'customer_exchange_id'=>$merchantMember->exchange_id,
			         'customer_member_id'=>1,
			         'customer_giftcard_id'=>0,
			         'customer_user_id'=>$merchantMember->id,
			         'merchant_exchange_id'=>$merchantMember->exchange_id,
			         'merchant_member_id'=>$merchantMember->id,
			         
			         'notes'=>$notes,
			         'card_present'=>0,
			         'settled'=>1,
			         'customer_ref_member_id'=>0,
			         'merchant_ref_member_id'=>$merchantMemberSlug,
			         
			         'merchant_ex_comm_rate'=>$merchantMember->ex_sale_comm_rate,
			         'merchant_ref_comm_rate'=>$merchantMember->ref_sale_comm_rate,
			         
			        ]);

			        /*getting the purchase percentage of the selected member account code 7010 and 4140*/
			        $barter_sale_fee = ($barterAmount * $merchantMember->ex_sale_comm_rate / 100)/100;
			         /*end*/
			        $referred_sale_commision = (($barter_sale_fee * $merchantMember->ref_sale_comm_rate) / 100)/100;

			        $sale_fee = $barter_sale_fee - $referred_sale_commision;
			        

			        /*and 10 entries will be in ledger table*/
			        if($transactions)
			        {
			            /**
			            *@param 6010 Member/GC Barter Purchase
			            */
			            LedgerDetails::create([
			              'exchange_id'=>$merchantMember->exchange_id,
			              'member_id'=>$merchantMember->id,
			              'account_code'=>6010,
			              'amount'=>-($barterAmount*100),
			              'transaction_id'=>$transactions->id,
			              'notes'=>$notes,
			            ]);
			            /**
			            *@param 4010 Member/GC Barter Sale
			            */
			            LedgerDetails::create([
			              'exchange_id'=>$merchantMember->exchange_id,
			              'member_id'=>$merchantMember->id,
			              'account_code'=>4010,
			              'amount'=>($barterAmount*100),
			              'transaction_id'=>$transactions->id,
			              'notes'=>$notes,
			            ]);

			            /**
			            *@param 7010 Exchange Earned Barter Revenue
			            */
			            LedgerDetails::create([
			                'exchange_id'=>$merchantMember->exchange_id,
			                'member_id'=>$merchantMember->id,
			                'giftcard_id'=>0,
			                'account_code'=>7010,
			                'amount'=> -($barter_sale_fee*100),
			                'transaction_id'=>$transactions->id,
			                'notes'=>$notes,
			            ]);
			            /**
			            *@param 4140 Exchange Earned Barter Revenue
			            */
			            LedgerDetails::create([
			                'exchange_id'=>$merchantMember->exchange_id,
			                'member_id'=>0,
			                'giftcard_id'=>0,
			                'account_code'=>4140,
			                'amount'=>($barter_sale_fee*100),
			                'transaction_id'=>$transactions->id,
			                'notes'=>$notes,
			            ]);

			            /**
			            *@param 7070 Member Sponsor Purchase Commission Paid 
			            */
			            LedgerDetails::create([
			              'exchange_id'=>$merchantMember->exchange_id,
			              'member_id'=>$merchantMember->id,
			              'giftcard_id'=>0,
			              'account_code'=>7070,
			              'amount'=>-($referred_sale_commision*100),
			              'transaction_id'=>$transactions->id,
			              'notes'=>$notes,
			            ]);
			            /**
			            *@param 4070 Member Sponsor Commission Earned
			            */
			            LedgerDetails::create([
			              'exchange_id'=>$merchantMember->exchange_id,
			              'member_id'=>$merchantMember->ref_member_id,
			              'account_code'=>4070,
			              'amount'=>($referred_sale_commision*100),
			              'transaction_id'=>$transactions->id,
			              'notes'=>$notes,
			            ]);
			            /**
			            *@param 7010 Member Commission Paid
			            */
			            LedgerDetails::create([
			              'exchange_id'=>$merchantMember->exchange_id,
			              'member_id'=>$merchantMember->id,
			              'giftcard_id'=>0,
			              'account_code'=>7010,
			              'amount'=>-($sale_fee*100),
			              'transaction_id'=>$transactions->id,
			              'notes'=>$notes,
			            ]);
			            /**
			            *@param 4140
			            *@param exchagneid 
			            */
			            LedgerDetails::create([
			              'exchange_id'=>$merchantMember->exchange_id,
			              'member_id'=>$merchantMember->id,
			              'account_code'=>4140,
			              'amount'=>($sale_fee*100),
			              'transaction_id'=>$transactions->id,
			              'notes'=>$notes,
			            ]);

			        

			            /**
			            *@param if input has tip then entry will be
			            */
			            if(!empty($tipAmount)){
			                LedgerDetails::create([
			                'exchange_id'=>$merchantMember->exchange_id,
			                'member_id'=>$merchantMember->id,
			                'giftcard_id'=>0,
			                'account_code'=>7030,
			                'amount'=>-($tipAmount*100),
			                'transaction_id'=>$transactions->id,
			                'notes'=>$notes,

			               ]);
			              LedgerDetails::create([
			                'exchange_id'=>$merchantMember->exchange_id,
			                'member_id'=>$merchantMember->id,
			                'giftcard_id'=>0,
			                'account_code'=>4030,
			                'amount'=>($tipAmount*100),
			                'transaction_id'=>$transactions->id,
			                'notes'=>$notes,

			               ]);
			            }
			        }

					break;

				case 'Giftcard':
					break;
				
				default:
					
					return ['data' => 'There was an error processing that card.'];
					
					break;
			}
		}
		else
		{
			return ['data' => 'Invaid request'];
		}
	}

	public function memberPurchase(Request $request)
	{
		$barterAmount = $request->get('barter_amount');
		$tipAmount = $request->get('tip_amount');
		$notes = $request->get('notes');
		$merchantMemberSlug = $request->get('merchant_member_slug');
		$cardNumber = $request->get('card_number');

		if(!empty($merchantMemberSlug))
		{
			$merchantMember = Member::where('slug', $merchantMemberSlug)->first();

			if(!(!is_null($merchantMember) && count($merchantMember) > 0))
			{
				return ['data' => 'That merchant member could not be found.'];
			}

			$card = Bartercard::where('number', $cardNumber)->first();

			// dd(class_basename($card));

			if(!(!is_null($card) && count($card) > 0))
			{
				return ['data' => 'That card could not be found.'];
			}

			switch (class_basename($card)) 
			{
				case 'Bartercard':

					/*one entry will be in transaction table*/
			        $transactions = TransactionDetails::create([
			         /*'type_id'=>11,
			         'customer_exchange_id'=>$merchantMember->exchange_id,
			         'customer_member_id'=>1,
			         'customer_giftcard_id'=>0,
			         'customer_user_id'=>$merchantMember->id,
			         'merchant_exchange_id'=>$merchantMember->exchange_id,
			         'merchant_member_id'=>$merchantMember->id,
			         
			         'notes'=>$notes,
			         'card_present'=>0,
			         'settled'=>1,
			         'customer_ref_member_id'=>0,
			         'merchant_ref_member_id'=>$merchantMemberSlug,
			         
			         'merchant_ex_comm_rate'=>$merchantMember->ex_sale_comm_rate,
			         'merchant_ref_comm_rate'=>$merchantMember->ref_sale_comm_rate,*/

			         'type_id'=>25,
			         'customer_exchange_id'=>$merchantMember->exchange_id,
			         'customer_member_id'=>1,
			         
			         'customer_user_id'=>$merchantMember->id,
			         'merchant_exchange_id'=>$merchantMember->exchange_id,
			         'merchant_member_id'=>$merchantMemberSlug,
			         
			         'notes'=>$notes,
			         'settled'=>1,
			         'merchant_ref_member_id'=>$merchantMemberSlug,
			         'merchant_ex_comm_rate'=>$merchantMember->ex_sale_comm_rate,
			         'merchant_ref_comm_rate'=>$merchantMember->ref_sale_comm_rate,
			         
			        ]);

			        /*getting the purchase percentage of the selected member account code 7010 and 4140*/
			        $barter_purchase_fee = ($barterAmount * $members->ex_purchase_comm_rate / 100)/100;
         /*end*/
			        $referred_purchase_commision = (($barter_purchase_fee * $members->ref_purchase_comm_rate) / 100)/100;

			        $purchase_fee = $barter_purchase_fee - $referred_purchase_commision;
			        

			        /*and 10 entries will be in ledger table*/
			        if($transactions)
			        {
			            /**
			    		*@param 6010 Member/GC Barter Purchase
			    		*/
			    		LedgerDetails::create([
			    			'exchange_id'=>$merchantMember->exchange_id,
			    			'member_id'=>$merchantMember->id,
			    			'account_code'=>6010,
			    			'amount'=>-($barterAmount*100),
			    			'transaction_id'=>$transactions->id,
			    			'notes'=>$notes,
			    		]);
			    		/**
			    		*@param 4010 Member/GC Barter Sale
			    		*/
			    		LedgerDetails::create([
			    			'exchange_id'=>$merchantMember->exchange_id,
			    			'member_id'=>$merchantMemberSlug,
			    			'account_code'=>4010,
			    			'amount'=>($barterAmount*100),
			    			'transaction_id'=>$transactions->id,
			    			'notes'=>$notes,
			    		]);

			            /**
			            *@param 7010 Exchange Earned Barter Revenue
			            */
			            LedgerDetails::create([
			                'exchange_id'=>$merchantMember->exchange_id,
			                'member_id'=>$merchantMemberSlug,
			                'giftcard_id'=>0,
			                'account_code'=>7010,
			                'amount'=> -($barter_purchase_fee*100),
			                'transaction_id'=>$transactions->id,
			                'notes'=>$notes,
			            ]);
			            /**
			            *@param 4140 Exchange Earned Barter Revenue
			            */
			            LedgerDetails::create([
			                'exchange_id'=>$merchantMember->exchange_id,
			                'member_id'=>0,
			                'giftcard_id'=>0,
			                'account_code'=>4140,
			                'amount'=>($barter_purchase_fee*100),
			                'transaction_id'=>$transactions->id,
			                'notes'=>$notes,
			            ]);

			    		/**
			    		*@param 7070 Member Sponsor Purchase Commission Paid 
			    		*/
			    		LedgerDetails::create([
			    			'exchange_id'=>$merchantMember->exchange_id,
			    			'member_id'=>$merchantMemberSlug,
			    			'giftcard_id'=>0,
			    			'account_code'=>7070,
			    			'amount'=>-($referred_purchase_commision*100),
			    			'transaction_id'=>$transactions->id,
			    			'notes'=>$notes,
			    		]);
			    		/**
			    		*@param 4070 Member Sponsor Commission Earned
			    		*/
			    		LedgerDetails::create([
			    			'exchange_id'=>$merchantMember->exchange_id,
			    			'member_id'=>1,
			    			'giftcard_id'=>0,
			    			'account_code'=>4070,
			    			'amount'=>($referred_purchase_commision*100),
			    			'transaction_id'=>$transactions->id,
			    			'notes'=>$notes,
			    		]);
			    		/**
			    		*@param 7010 Member Commission Paid
			    		*/
			    		LedgerDetails::create([
			    			'exchange_id'=>$merchantMember->exchange_id,
			    			'member_id'=>$merchantMemberSlug,
			    			'giftcard_id'=>0,
			    			'account_code'=>7010,
			    			'amount'=>-($purchase_fee*100),
			    			'transaction_id'=>$transactions->id,
			    			'notes'=>$notes,
			    		]);
			    		/**
			    		*@param 4140
			    		*@param exchagneid 
			    		*/
			    		LedgerDetails::create([
			    			'exchange_id'=>$merchantMember->exchange_id,
			    			'member_id'=>1,
			    			'giftcard_id'=>0,
			    			'account_code'=>4140,
			    			'amount'=>($purchase_fee*100),
			    			'transaction_id'=>$transactions->id,
			    			'notes'=>$notes,
			    		]);

			    		

			            /**
			            *@param if input has tip then entry will be
			            */
			            if(!empty($input['tip_amount'])){
			                LedgerDetails::create([
			                'exchange_id'=>$merchantMember->exchange_id,
			                'member_id'=>$merchantMember->id,
			                'giftcard_id'=>0,
			                'account_code'=>7030,
			                'amount'=>-($tipAmount*100),
			                'transaction_id'=>$transactions->id,
			                'notes'=>$notes,

			               ]);
			              LedgerDetails::create([
			                'exchange_id'=>$merchantMember->exchange_id,
			                'member_id'=>$merchantMember->id,
			                'giftcard_id'=>0,
			                'account_code'=>4030,
			                'amount'=>($tipAmount*100),
			                'transaction_id'=>$transactions->id,
			                'notes'=>$notes,

			               ]);
			            }
			        }

					break;

				case 'Giftcard':
					break;
				
				default:
					
					return ['data' => 'There was an error processing that card.'];
					
					break;
			}
		}
		else
		{
			return ['data' => 'Invaid request'];
		}
	}

}
