<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User, App\Role, App\Exchange;
use App\Member, App\State, App\PhoneType, App\MemberUser, App\Address, App\Phone, App\Role_user, App\CashReferral;
use \Session, \Validator,\Redirect, \Hash, \Auth, \Image, App\LedgerDetails;

class CashRefarralController extends Controller
{
    public function lists(Request $request)
    {
    	if($request->keyword !='')
    	{
    	    $data['keyword'] = $request->keyword;
            $data['lists'] = CashReferral::where(function($query) use ($data) {
                                    if($data['keyword'] != ''){
                                    $query->where('full_name','like','%'.$data['keyword'].'%');
                                    // $query->orwhere('city_name','like','%'.$data['keyword'].'%');
                                 }
                            })
                            ->orderBy('id','desc')->paginate(10);
    	}
    	else
    	{
    	    $data['lists'] = CashReferral::orderBy('id','desc')->paginate(10);
    	}
	
        return view('admin.cashReferrals.list',$data);
    }

    public function show($id)
    {
    	$data['record'] = CashReferral::where('id', $id)->first();

    	return view('admin.cashReferrals.show',$data);
    }
}