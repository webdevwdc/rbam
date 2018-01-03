<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCardDetails extends Model
{   
	protected $fillable = ['exchange_id', 'number', 'active', 'user_id', 'issue_member_id'];
	protected $table = 'giftcards';

    /*getting the list of issued gift card*/
    public function IssuedGiftCards($model,$exchange_id){
    	$gifts = $model->where('giftcards.exchange_id',$exchange_id)->orderBy('giftcards.created_at','DESC')
    	       ->join('members','giftcards.issue_member_id','=','members.id')->get();
    	return $gifts;
    }

    /*all member with same exchange*/
    public function AllMember($exchange_id){
    	$members = Member::where('exchange_id',$exchange_id)->orderBy('name','ASC')->pluck('name','id');
    	return $members;
    }
    
    /*all member with same exchange*/
    public function AllMemberExceptLoggedInUser($exchange_id, $member_id){
    	$members = Member::where('exchange_id',$exchange_id)->where('id', '!=', $member_id)->where('deleted_at', NULL)->orderBy('name','ASC')->pluck('name','id');
    	return $members;
    }

    /*checking card availability  from cardpool table*/
    public function CardAvailability($card){
    	$availability = Cardpool::where('number',$card)->where('available','>',0)->first();
    	return $availability;

    }

    public function GetMemberBarterBalance($member_id){
        $barter_balance = LedgerDetails::where('member_id',$member_id)
                            ->whereIn('account_code', ['4010', '4020', '4050', '4080', '6010'])
                            ->get()
                            ->sum('amount');
        return $barter_balance = ($barter_balance/100);
    }

    /*member cba balance*/
    public function GetMemberCBA($member_id){
        $cba_balance = LedgerDetails::where('member_id',$member_id)
                            ->whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
                            ->get()
                            ->sum('amount');
        return $cba_balance = ($cba_balance/100);
    }

}
