<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LedgerDetails, App\Address, App\MemberUser, App\Phone, App\Member;
use  Auth,\Session;
use Illuminate\Support\Facades\Input;

class SwitchMemberController extends Controller
{
    public function SwitchMember(){
	$user_id	= Auth::guard('admin')->user()->id;
	$arr_member	= MemberUser::where('user_id', $user_id)->skip(0)->take(1)->get();
	Session::put('USER_ID', $user_id);
	$exchange_id	= Session::get('EXCHANGE_ID');
	
	//$data['all_member_user'] = MemberUser::where('member_users.user_id', $user_id)
	//			    ->where('members.exchange_id', $exchange_id)
	//			    ->where('member_users.member_id', '!=', $arr_member[0]->member_id)
	//			    ->join('members','member_users.user_id','=','members.id')
	//			    ->get();
				    
	$data['all_member_user'] = MemberUser::where('member_users.user_id', $user_id)
				    ->where('member_users.member_id', '!=', $arr_member[0]->member_id)
				    ->join('members','member_users.user_id','=','members.id')
				    ->get();

	//dd($data['all_member_user']);
    	return view('member.switch.member-switch', $data);
    }
    
    public function SwitchSelectMember(Request $request)
    {
	echo '<><>'.$member_id 	= Input::get('member_id');
	echo '<><>'.$exchange_id	= Input::get('exchange_id');
	
	$member_name = Member::find($member_id)->name;
	
	
	Session::put('MEMBER_ID', $member_id);
	Session::put('EXCHANGE_ID', $exchange_id);
	
	$referral = LedgerDetails::where('member_id',$member_id)
		    ->where('exchange_id',$exchange_id)
		    ->where('account_code',4070)->get()->sum('amount');
        $referral = '$'.number_format($referral/100,2);
	
	$cbabalance = LedgerDetails::where('member_id',$member_id)
			->where('exchange_id',$exchange_id)
			->whereIn('account_code',['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
			->get()->sum('amount');
        $cbabalance = '$'.number_format($cbabalance/100,2);
	
	/*sales last 30 days*/
        $last_day = date('Y-m-d', strtotime('today - 30 days'));
        $sales = LedgerDetails::where('exchange_id',$exchange_id)->where('member_id',$member_id)
               ->where('account_code',4090)->where('created_at', '>=',$last_day)->get()->sum('amount');
               $sales = '$'.number_format($sales/100,2);

        $purchase = LedgerDetails::where('exchange_id',$exchange_id)->where('member_id',$member_id)
                  ->where('account_code',7090)->where('created_at', '>=',$last_day)->get()->sum('amount');
                $purchase = '$'.number_format($sales/100,2);
        //echo "<pre>";print_r($sales); die();
        $barter_balance = LedgerDetails::where('exchange_id',$exchange_id)->where('member_id',$member_id)
                            ->whereIn('account_code', ['4010', '4020', '4050', '4080', '6010'])
                            ->get()
                            ->sum('amount');
                                  
        if($barter_balance > 0) {
            $barter_balance = $barter_balance/100;
        }
        $barter_balance = '$'.number_format($barter_balance,2);
       

        /*available balance*/
        $credit_barter= LedgerDetails::where('exchange_id',$exchange_id)->where('member_id',$member_id)
                            ->whereIn('account_code',['4010','4020','4050','4080','6010'])
                            ->get()
                            ->sum('amount');
                            $barter_available='';
        $credit_limit = MemberUser::where('user_id',Auth::guard('admin')->user()->id)
                      ->join('members','member_users.member_id','=','members.id')->first();
                      
          if(count($credit_limit)>0){
            $credit_limit = ($credit_barter) + $credit_limit->credit_limit;
            $barter_available = '$'.number_format($credit_limit/100,2);
          }
        /*address*/
        $address = Address::where('addressable_id',Auth::guard('admin')->user()->id)->first();
        $phone = Phone::where('phoneable_id',Auth::guard('admin')->user()->id)->first();
        return view('member.dashboard.index',compact('referral','cbabalance','sales','barter_balance','address','barter_available','purchase','phone', 'member_name'));
	
	
	
	//echo $exchange_id = session::get('EXCHANGE_ID');
    }
    

}
