<?php

namespace App\Http\Controllers\admin\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PosController extends Controller
{
    public function View(){
    	return View('admin.pos.dashboard');
    }
}
