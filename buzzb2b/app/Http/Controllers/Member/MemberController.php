<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LedgerDetails, App\Address, App\MemberUser, App\Phone;
use Auth, \Session;

class MemberController extends Controller
{   
    
    public function Member(){
        
        $exchange_id    = session::get('EXCHANGE_ID');
        $member_id      = session::get('MEMBER_ID');
        $user_id        = session::get('ADMIN_ACCESS_ID');
        
        
        /*referral commision */
        $referral = LedgerDetails::where('exchange_id',$exchange_id)
               ->where('account_code',4070)->get()->sum('amount');
                $referral = number_format($referral/100,2);

        $cbabalance = LedgerDetails::where('exchange_id',$exchange_id)
                 ->whereIn('account_code',['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
                 ->get()->sum('amount');
        $cbabalance = '$'.number_format($cbabalance/100,2);

        /*sales last 30 days*/
        $last_day = date('Y-m-d', strtotime('today - 30 days'));
        $sales = LedgerDetails::where('exchange_id',$exchange_id)
               ->whereIn('account_code',[4010])->where('created_at', '>=',$last_day)->get()->sum('amount');
               $sales = '$'.number_format($sales/100,2);
        //echo "<pre>"; print_r($sales); 

        $purchase = LedgerDetails::where('exchange_id',$exchange_id)
                  ->whereIn('account_code',[6010])->where('created_at', '>=',$last_day)->get()->sum('amount');
                $purchase = '$'.number_format($purchase/100,2);
        //echo "<pre>";print_r($purchase); 
        $barter_balance = LedgerDetails::where('exchange_id',$exchange_id)
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
        return view('member.dashboard.index',compact('referral','cbabalance','sales','barter_balance','address','barter_available','purchase','phone'));
    }
}
