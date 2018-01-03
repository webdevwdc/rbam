<?php

namespace App\Http\Controllers\admin\Pos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Member;
use Session, \Auth;
use App\TransactionDetails,App\LedgerDetails;

class PurchaseController extends Controller
{
    public function View(){
    	$exchangeid = session::get('EXCHANGE_ID');
    	$members = Member::where('exchange_id',$exchangeid)->where('id','!=',1)->pluck('name','id');
    	return View('admin.pos.purchase.add',compact('members'));
    }

    public function SavePurchase(Request $request){
       
    	$input = $request->all();
       
        if (!empty($input['notes'])) {
          $notes = $input['notes'];
        }else{
          $notes = '';
        }

        if (!empty($input['tip_amount'])) {
          $tip = $input['tip_amount'];
        }else{
          $tip = 0;
        }
        
    	$exchangeid = session::get('EXCHANGE_ID');
    	$members = Member::where('exchange_id',$exchangeid)
    	         ->where('id',$input['merchant_member_slug'])->first();
        //echo "<pre>"; print_r($members); die();
        /*getting the purchase percentage of the selected member account code 7010 and 4140*/
        $barter_purchase_fee = ($input['barter_amount'] * $members->ex_purchase_comm_rate / 100)/100;
         /*end*/
        $referred_purchase_commision = (($barter_purchase_fee * $members->ref_purchase_comm_rate) / 100)/100;

        $purchase_fee = $barter_purchase_fee - $referred_purchase_commision;
        

                 
    	$transactions = TransactionDetails::create([
         'type_id'=>25,
         'customer_exchange_id'=>$exchangeid,
         'customer_member_id'=>1,
         
         'customer_user_id'=>Auth::guard('admin')->user()->id,
         'merchant_exchange_id'=>$exchangeid,
         'merchant_member_id'=>$input['merchant_member_slug'],
         
         'notes'=>$notes,
         'settled'=>1,
         'merchant_ref_member_id'=>$input['merchant_member_slug'],
         'merchant_ex_comm_rate'=>$members->ex_sale_comm_rate,
         'merchant_ref_comm_rate'=>$members->ref_sale_comm_rate,
        
    	]);

    	if($transactions){
    		/**
    		*@param 6010 Member/GC Barter Purchase
    		*/
    		LedgerDetails::create([
    			'exchange_id'=>$exchangeid,
    			'member_id'=>Auth::guard('admin')->user()->id,
    			'account_code'=>6010,
    			'amount'=>-($input['barter_amount']*100),
    			'transaction_id'=>$transactions->id,
    			'notes'=>$notes,
    		]);
    		/**
    		*@param 4010 Member/GC Barter Sale
    		*/
    		LedgerDetails::create([
    			'exchange_id'=>$exchangeid,
    			'member_id'=>$input['merchant_member_slug'],
    			'account_code'=>4010,
    			'amount'=>($input['barter_amount']*100),
    			'transaction_id'=>$transactions->id,
    			'notes'=>$notes,
    		]);

            /**
            *@param 7010 Exchange Earned Barter Revenue
            */
            LedgerDetails::create([
                'exchange_id'=>$exchangeid,
                'member_id'=>$input['merchant_member_slug'],
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
                'exchange_id'=>$exchangeid,
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
    			'exchange_id'=>$exchangeid,
    			'member_id'=>$input['merchant_member_slug'],
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
    			'exchange_id'=>$exchangeid,
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
    			'exchange_id'=>$exchangeid,
    			'member_id'=>$input['merchant_member_slug'],
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
    			'exchange_id'=>$exchangeid,
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
                'exchange_id'=>$exchangeid,
                'member_id'=>Auth::guard('admin')->user()->id,
                'giftcard_id'=>0,
                'account_code'=>7030,
                'amount'=>-($tip * 100),
                'transaction_id'=>$transactions->id,
                'notes'=>$notes,

               ]);
              LedgerDetails::create([
                'exchange_id'=>$exchangeid,
                'member_id'=>$input['merchant_member_slug'],
                'giftcard_id'=>0,
                'account_code'=>4030,
                'amount'=>($tip * 100),
                'transaction_id'=>$transactions->id,
                'notes'=>$notes,

               ]);
            }

    	}

    	/*here return to view page*/
    	return response()->json(['name'=>$members->name,'barter'=>$input['barter_amount'],'transactions' =>$transactions->id,'tip' =>$tip]);
    }

}
