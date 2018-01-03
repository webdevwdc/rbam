<?php

namespace App\Http\Controllers\User_Member\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\LedgerDetails;
use Auth,\Session;
use Illuminate\Support\Facades\Input;

class DashboardController extends Controller
{
    /*public function __construct()
    {
        dd(9);
    }*/

    public function ViewDashboard(Request $request){
	
	$exchange_id    = session::get('EXCHANGE_ID');
        $member_id      = session::get('MEMBER_ID');
	
	
	/* for switch member */
        if(Input::get('member_id') == '') {
            $member_id = Session::get('MEMBER_ID');
        } else {
            Session::put('MEMBER_ID', Input::get('member_id'));
            $member_id = Session::get('MEMBER_ID');
        }
        
    	$referral = LedgerDetails::where('member_id',$member_id)
               ->where('account_code',4070)->get()->sum('amount');
        $referral = '$'.number_format($referral/100,2);

        $modal= new LedgerDetails();
        $cbabalance = $modal->GetMemberCBA();
        $barter_balance = $modal->GetMemberBarterBalance();

        /*sales*/
        $last_day = date('Y-m-d', strtotime('today - 30 days'));
        $sales = LedgerDetails::where('member_id',$member_id)
               ->where('account_code',4090)->where('created_at', '>=',$last_day)->get()->sum('amount');
        $sales = '$'.number_format($sales/100,2);

        $purchase = LedgerDetails::where('member_id',$member_id)
                  ->where('account_code',7090)->where('created_at', '>=',$last_day)->get()->sum('amount');
                $purchase = '$'.number_format($sales/100,2);

    	return view('user_member/member/dashboard',compact('referral','cbabalance','barter_balance','sales','purchase'));
    }

    public function Logout(){
    	Auth::logout();
        Session::flush();
        return Redirect::route('login_dashboard')->with('success', 'You have logged out successfully.');
    }
}
