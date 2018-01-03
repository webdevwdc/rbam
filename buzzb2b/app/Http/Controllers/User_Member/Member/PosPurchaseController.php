<?php

namespace App\Http\Controllers\User_Member\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member;
use Session, \Auth;
use App\TransactionDetails,App\LedgerDetails,App\MemberUser;

class PosPurchaseController extends Controller
{
    public function ViewPurchase(){
    	$exchangeid = session::get('EXCHANGE_ID');
        $member_id = MemberUser::where('user_id',Auth::user()->id)->first()->member_id;
    	$members = Member::where('exchange_id',$exchangeid)->where('id','!=',$member_id)->pluck('name','id');
    	return view('user_member.member.pos.purchase.add',compact('members'));
    }

    public function SaveMemberPurchase(Request $request){
    	  $input = $request->all();

        if (!empty($input['notes'])) {
          $notes = $input['notes'];
        }else{
          $notes = 'Null';
        }

        if (!empty($input['tip'])) {
          $tip = $input['tip'];
        }else{
          $tip = 0;
        }
        
        $exchangeid = session::get('EXCHANGE_ID');
        $members = Member::where('exchange_id',$exchangeid)
                 ->where('id',$input['member_slug'])->first();
        

        $barter_purchase_fee = ($input['barter_amount'] * $members->ex_purchase_comm_rate / 100)/100;

         /*end*/
        $referred_purchase_commision = (($barter_purchase_fee * $members->ref_purchase_comm_rate) / 100)/100;

        $purchase_fee = $barter_purchase_fee - $referred_purchase_commision;
         
    	  $transactions = TransactionDetails::create([
    		'type_id'=>25,
    		'customer_exchange_id'=>$exchangeid,
    		'customer_member_id'=>Auth::user()->id,
    		'customer_user_id'=>$input['member_slug'],
    		'merchant_exchange_id'=>$exchangeid,
    		'merchant_member_id'=>Auth::user()->id,
    		'customer_ex_comm_rate'=>0,
    		'customer_ref_comm_rate'=>0,
    		'note'=>$input['memo'],
    		'settled'=>1,
    		'merchant_ref_member_id'=>0,
    		'merchant_ex_comm_rate'=>0,
    		'merchant_ref_comm_rate'=>0,
    	]);

    	if($transactions){
        /**
        *@param 6010 Member/GC Barter Purchase
        */
        LedgerDetails::create([
          'exchange_id'=>$exchangeid,
          'member_id'=>Auth::user()->id,
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
          'member_id'=>$input['member_slug'],
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
                'member_id'=>$input['member_slug'],
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
            'member_id'=>$input['member_slug'],
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
            'member_id'=>$input['member_slug'],
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
                'member_id'=>Auth::user()->id,
                'giftcard_id'=>0,
                'account_code'=>7030,
                'amount'=>-($tip*100),
                'transaction_id'=>$transactions->id,
                'notes'=>$notes,

               ]);
              LedgerDetails::create([
                'exchange_id'=>$exchangeid,
                'member_id'=>$input['member_slug'],
                'giftcard_id'=>0,
                'account_code'=>4030,
                'amount'=>($tip*100),
                'transaction_id'=>$transactions->id,
                'notes'=>$notes,

               ]);
            }

      }
        return response()->json(['name'=>$members->name,'barter'=>$input['barter_amount'],'transactions' =>$transactions->id,'tip' =>$tip]);
    }
}
