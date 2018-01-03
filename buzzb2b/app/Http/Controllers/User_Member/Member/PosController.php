<?php

namespace App\Http\Controllers\User_Member\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PosController extends Controller
{
    public function ViewPos(){
    	return view('user_member.member.pos.dashboard');
    }
}
