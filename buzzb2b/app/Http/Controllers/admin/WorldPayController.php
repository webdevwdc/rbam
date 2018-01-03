<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorldPayController extends Controller
{  
   public function ViewWorldPay(){
   	return view('admin.worldpay.add');
   }
}
