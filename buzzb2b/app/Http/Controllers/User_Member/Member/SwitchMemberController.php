<?php

namespace App\Http\Controllers\User_Member\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MemberUser, App\Member,\Auth;

class SwitchMemberController extends Controller
{
    public function SwitchMember(){
    	
    	$members = MemberUser::where('user_id',Auth::user()->id)
    	          ->join('members','member_users.member_id','=','members.id')
    	          ->join('exchanges','members.exchange_id','=','exchanges.id')
    	          ->select('members.name as membername','exchanges.name as exchange_name','member_users.member_id')
    	          ->get();
    	return view('user_member.member.switch.switch-member',compact('members'));
    }
}
