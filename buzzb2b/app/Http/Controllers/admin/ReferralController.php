<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,\Session; 
use App\Referral;
use App\User;

class ReferralController extends Controller
{
    public function ViewRefferal(){
        $exchange_id = Session::get('EXCHANGE_ID');
    	$referrals = Referral::where('exchange_id',$exchange_id)
                   ->join('users','referrals.referring_user_id','=','users.id')
                   ->paginate(10);
                  
    	
    	return view('admin/referrals/referrals',compact('referrals'));
    }
}
