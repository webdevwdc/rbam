<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User, App\Sitesetting, App\Role, App\Address, App\State, App\Exchange, App\Phone, App\Cardpool,App\LedgerDetails;
use Auth; 
use Session;

class LoginController extends Controller
{   
    public function HomeIndex(){
       return view('landing_view_page.welcome');
    }
    public function Index(Request $request){

        if( $request->isMethod('post') ){
            $this->validate($request,[
                'email'=>'required',
                'password'=>'required|min:6'
                ]);
        	$input = $request->all();
        
            $checkMemberUserExists  = User::where('email', $input['email'])->where('deleted_at',Null)->first();
            if( count($checkMemberUserExists) > 0 ){ 
                $auth       = auth()->guard('web');
                if(Auth::attempt(['email' => $input['email'], 'password' => $input['password']]))
                {
                    $role_name          = $checkMemberUserExists->roleuser->RoleType->name;

                    $role_display_name  = $checkMemberUserExists->roleuser->RoleType->display_name;
                    $role_id            = $checkMemberUserExists->roleuser->RoleType->id;
                    
                    Session::put('USER_ID', $checkMemberUserExists->id);
                    Session::put('USER_NAME', $checkMemberUserExists->first_name. ' '.$checkMemberUserExists->last_name);
                    Session::put('USER_EMAIL', $input['email']);
                    
                    if($role_name == 'member') //this is for Member
                    {
                       $user_detail = User::select('users.is_admin', 'members.id AS member_id', 'members.exchange_id', 'exchanges.id', 'exchanges.domain',                                                   'exchanges.name', 'exchanges.city_name')
                            ->where('users.id', $checkMemberUserExists->id)
                            ->join('member_users', 'users.id', '=', 'member_users.user_id')
                            ->join('members', 'member_users.member_id', '=', 'members.id')
                            ->join('exchanges', 'members.exchange_id', '=', 'exchanges.id')
                            ->first();

                       Session::put('IS_ADMIN', $user_detail->is_admin);
                       Session::put('EXCHANGE_ID', $user_detail->exchange_id);
                       Session::put('EXCHANGE_NAME', $user_detail->name);
                       Session::put('EXCHANGE_CITY_NAME', $user_detail->city_name);
                       Session::put('MemberRole', $role_name);
                       Session::put('MEMBER_ID', $user_detail->member_id);
                       
                       return redirect::route('member_dashboard');
                    
                    }
                    else if($role_name == 'user') //this is for User
                    {   
                         Session::put('MemberRole', $role_name);
                        return redirect::route('user_dashboard');  
                    }
                    else //this is for Admin
                    { 
                     return redirect::route('admin_dashboard');
                    }
                } else {
                    return redirect::back()->with('error', 'Invalid email address or/and password provided.');
                }
            }else{
                return redirect::back()->with('error', 'Invalid email address or/and password provided.');
            }
        }
        
        return view('login');
    }


    /*landing page giftcard blance checking*/
    public function ViewGiftCard(){
        return view('landing_view_page.giftcard_balance');
    }

    public function CheckBalanceGiftCard(Request $request){
        $this->validate($request,[
            'card_number'=>'required|min:16'
        ]);
        $input = $request->all();
        $available_giftcards = Cardpool::where('number',$input['card_number'])->first();
        if($available_giftcards){
          $barter_balance = LedgerDetails::where('member_id',$available_giftcards->issue_member_id)
                            ->whereIn('account_code', ['4010', '4020', '4050', '4080', '6010'])
                            ->get()
                            ->sum('amount');
           return back()->with('success',$barter_balance);
        }else{
          return back()->with('error','Could not find that card, please try again.');
        }
    }
    /*end*/
    
    
}
