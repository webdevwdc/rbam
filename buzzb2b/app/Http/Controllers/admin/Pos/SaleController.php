<?php

namespace App\Http\Controllers\admin\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bartercard, App\Member, App\TransactionDetails, App\LedgerDetails,App\MemberCashier;
use Session, \Auth;
use DB;
class SaleController extends Controller
{
    public function View(){
    	return View('admin.pos.sale.search');
    }

    public function SearchBartercard(Request $request){
    	$input = $request->all();
    	$card_available = DB::table('bartercards')->where('number',$input['card_number'])->where('active',1)->first();
    	if(count($card_available)>0){
    		$details = Member::where('members.id',$card_available->member_id)
    		        ->join('exchanges','members.exchange_id','=','exchanges.id')
    		        ->select('members.name as membername','exchanges.name as exchange_name','members.id as memberid')
    		        ->first();

          $cashiers = MemberCashier::where('user_id',$card_available->user_id)->join('members','member_cashiers.member_id','=','members.id')->pluck('name','members.id');
         
    		return View('admin.pos.sale.add',compact('details','cashiers'));
    	}else{
    		return back()->with('error','BarterCard not found or card is Inactive');
    	}

    }

    /*save here for sale bartercard*/
    public function SaveSaleBarterCard(Request $request){
        $input = $request->all();
         
        $members = Member::where('id',$input['member_id'])->first();
        $exchangeid = session::get('EXCHANGE_ID');
        $members = Member::where('exchange_id',$exchangeid)
                 ->where('id',$input['member_id'])->first();
        

        /*getting the purchase percentage of the selected member account code 7010 and 4140*/
        $barter_sale_fee = ($input['barter_amount'] * $members->ex_sale_comm_rate / 100)/100;
         /*end*/
        $referred_sale_commision = (($barter_sale_fee * $members->ref_sale_comm_rate) / 100)/100;

        $sale_fee = $barter_sale_fee - $referred_sale_commision;
        
        /*one entry will be in transaction table*/
        $transactions = TransactionDetails::create([
         'type_id'=>11,
         'customer_exchange_id'=>$exchangeid,
         'customer_member_id'=>1,
         'customer_giftcard_id'=>0,
         'customer_user_id'=>Auth::guard('admin')->user()->id,
         'merchant_exchange_id'=>$exchangeid,
         'merchant_member_id'=>$input['member_id'],
         
         'notes'=>$input['notes'],
         'card_present'=>0,
         'settled'=>1,
         'customer_ref_member_id'=>0,
         'merchant_ref_member_id'=>$input['merchant_member_slug'],
         
         'merchant_ex_comm_rate'=>$members->ex_sale_comm_rate,
         'merchant_ref_comm_rate'=>$members->ref_sale_comm_rate,
         
        ]);
        

        /*and 10 entries will be in ledger table*/
        if($transactions){
            /**
            *@param 6010 Member/GC Barter Purchase
            */
            LedgerDetails::create([
              'exchange_id'=>$exchangeid,
              'member_id'=>$members->id,
              'account_code'=>6010,
              'amount'=>-($input['barter_amount']*100),
              'transaction_id'=>$transactions->id,
              'notes'=>$input['notes'],
            ]);
            /**
            *@param 4010 Member/GC Barter Sale
            */
            LedgerDetails::create([
              'exchange_id'=>$exchangeid,
              'member_id'=>Auth::guard('admin')->user()->id,
              'account_code'=>4010,
              'amount'=>($input['barter_amount']*100),
              'transaction_id'=>$transactions->id,
              'notes'=>$input['notes'],
            ]);

            /**
            *@param 7010 Exchange Earned Barter Revenue
            */
            LedgerDetails::create([
                'exchange_id'=>$exchangeid,
                'member_id'=>$input['member_id'],
                'giftcard_id'=>0,
                'account_code'=>7010,
                'amount'=> -($barter_sale_fee*100),
                'transaction_id'=>$transactions->id,
                'notes'=>$input['notes'],
            ]);
            /**
            *@param 4140 Exchange Earned Barter Revenue
            */
            LedgerDetails::create([
                'exchange_id'=>$exchangeid,
                'member_id'=>0,
                'giftcard_id'=>0,
                'account_code'=>4140,
                'amount'=>($barter_sale_fee*100),
                'transaction_id'=>$transactions->id,
                'notes'=>$input['notes'],
            ]);

            /**
            *@param 7070 Member Sponsor Purchase Commission Paid 
            */
            LedgerDetails::create([
              'exchange_id'=>$exchangeid,
              'member_id'=>$input['member_id'],
              'giftcard_id'=>0,
              'account_code'=>7070,
              'amount'=>-($referred_sale_commision*100),
              'transaction_id'=>$transactions->id,
              'notes'=>$input['notes'],
            ]);
            /**
            *@param 4070 Member Sponsor Commission Earned
            */
            LedgerDetails::create([
              'exchange_id'=>$exchangeid,
              'member_id'=>$members->ref_member_id,
              'account_code'=>4070,
              'amount'=>($referred_sale_commision*100),
              'transaction_id'=>$transactions->id,
              'notes'=>$input['notes'],
            ]);
            /**
            *@param 7010 Member Commission Paid
            */
            LedgerDetails::create([
              'exchange_id'=>$exchangeid,
              'member_id'=>$input['member_id'],
              'giftcard_id'=>0,
              'account_code'=>7010,
              'amount'=>-($sale_fee*100),
              'transaction_id'=>$transactions->id,
              'notes'=>$input['notes'],
            ]);
            /**
            *@param 4140
            *@param exchagneid 
            */
            LedgerDetails::create([
              'exchange_id'=>$exchangeid,
              'member_id'=>Auth::guard('admin')->user()->id,
              'account_code'=>4140,
              'amount'=>($sale_fee*100),
              'transaction_id'=>$transactions->id,
              'notes'=>$input['notes'],
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
                'amount'=>-($input['tip_amount']*100),
                'transaction_id'=>$transactions->id,
                'notes'=>$input['notes'],

               ]);
              LedgerDetails::create([
                'exchange_id'=>$exchangeid,
                'member_id'=>$input['member_id'],
                'giftcard_id'=>0,
                'account_code'=>4030,
                'amount'=>($input['tip_amount']*100),
                'transaction_id'=>$transactions->id,
                'notes'=>$input['notes'],

               ]);
            }

      }

        return redirect()->route('pos-sale')->with('success','sale created successfully');
    }
}
