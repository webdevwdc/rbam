<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bartercard,\Session,App\GiftCardDetails, App\LedgerDetails, App\MemberUser, App\TransactionDetails,\Auth;

class GiftCardController extends Controller
{   
	
    public function ViewGIftCard(){
    	$model = new GiftCardDetails();
    	$exchangeid = session::get('EXCHANGE_ID');
      $gifts = $model->IssuedGiftCards($model,$exchangeid);
    	return view('admin/giftcards/giftcards',compact('gifts'));
    }

    public function IssueGiftCard(){
      $arr_member_id = MemberUser::select('member_id')->where('user_id', Session::get('ADMIN_ACCESS_ID'))->first();
	    $member_id = $arr_member_id['member_id'];
    	$model = new GiftCardDetails();
    	$exchangeid = session::get('EXCHANGE_ID');
    	$members = $model->AllMemberExceptLoggedInUser($exchangeid, $member_id);
    	return view('admin.giftcards.issue-giftcard',compact('members'));
    }

    public function SaveIssueGiftCard(Request $request){
    	$this->validate($request,[
              'card_number'=>'required',
              'amount'=>'required|numeric|min:1',
              'member_id'=>'required',
            ]);
    	$input = $request->all();
    	$model = new GiftCardDetails();
    	$exchangeid = session::get('EXCHANGE_ID');
    	$available = $model->CardAvailability($input['card_number']);
	
    	if(count($available)>=0){
        $ledger = new GiftCardDetails();

        /*checking the balance of this member*/
        $balance =  $ledger->GetMemberBarterBalance($input['member_id']);
        $cba = $ledger->GetMemberCBA($input['member_id']);

        if($balance > 100 && $cba > 100){//found barter balance then issue a gift card 
          //entry in giftcard table
          $gift = GiftCardDetails::create([
            		    'exchange_id'     => $exchangeid,
            		    'number'          => $input['card_number'],
            		    'active'          => 1,
            		    'issue_member_id' => $input['member_id'],
            		  ]);

          if($gift){
            $giftcard_id = $gift->id;
            //cardpool table entry update available data
            $available->update(['available'=>$available->available-1]);

            // insert into transaction table
            $arr_member_id = MemberUser::select('member_id')->where('user_id',Session::get('ADMIN_ACCESS_ID'))->first();
            $member_id = $arr_member_id['member_id'];

            $newTransaction = new TransactionDetails();
            $transaction_id = $newTransaction->insertTransaction($input);
            
            // insert into Ledger table
            $insertArr = [
                          'exchange_id'     => $exchangeid,
                          'member_id'       => $member_id,
                          'giftcard_id'     => $giftcard_id,
                          'transaction_id'  => $transaction_id
                         ];

            LedgerDetails::InsertLedgerForGiftCard($insertArr, $input); // for four entries 

          } 
          return back()->with('success','Gift Card Issued Successfully');
        }else{//if no balance is available
        	return back()->with('error','Declined. Not enough member barter balance or cba balance.');
        }
          
    	}else{
           //card is not available 
    		return back()->with('error','That is not a valid card number, or it is no longer available for issue. Please try another card number. ');
    	}
    }
}
