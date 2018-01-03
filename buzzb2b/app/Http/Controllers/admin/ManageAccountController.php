<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class ManageAccountController extends Controller{
   public function ManageAccount(){
   	$data = array();
    $data['user'] = User::where('id',Auth::guard('admin')->user()->id)->first();

   	return view('admin.account.manage-account',$data);
   }
}
