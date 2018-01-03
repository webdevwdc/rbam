<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User, App\Role, App\Exchange, App\Member;
use \Session, \Validator,\Redirect, \Hash, \Auth, \Image;

class SettingController extends Controller
{
    public function lists(Request $request)
    {
        $data['keyword']        = '';
        if($request->keyword !=''){
            $data['keyword'] = $request->keyword;
            $data['lists'] = Exchange::where(function($query) use ($data) {
                                    if($data['keyword'] != ''){
                                    $query->where('name','like','%'.$data['keyword'].'%');
                                    $query->orwhere('city_name','like','%'.$data['keyword'].'%');
                                 }
                            })
                            ->orderBy('id','desc')->paginate(10);
        }
        else{
            $data['lists'] = Exchange::orderBy('name','asc')->paginate(10);
        }
        return view('admin.exchange.list',$data);
    }
    
    public function create(){
	$exchangeid = 1;
        $data = array();
	$data['refsSelectionList'] = Member::where('exchange_id',$exchangeid)->pluck('name','id')->prepend('None','0');
	$data['salespersonSelectionList'] = Member::where('exchange_id',$exchangeid)->where('is_active_salesperson',1)->pluck('name','id')->prepend('None','0');
        return view('admin.exchange.add',$data);
    }
    public function store(Request $request){

      $validator = Validator::make(
				  $request->all(),
				   [
				    'city_name'=> 'required|unique:exchanges,city_name',
                                    'name'=> 'required|unique:exchanges,name'
				   ]
		    );
	    if ($validator->fails()){
		    $messages = $validator->messages();
		    return Redirect::back()->withErrors($validator->errors())->withInput();
	    }else{
                
                
                $insert                                     = new Exchange();
                $insert->name                               = $request->name;
                $insert->city_name                          = $request->city_name;
                $insert->domain                             = strtolower($request->name);
                $insert->member_purchase_comm_rate          = 1000;
                $insert->member_ref_purchase_comm_rate      = 2000;
                $insert->ex_default_use_giftcards           = 1;
                $insert->ex_default_giftcard_comm_rate      = 1000;
                $insert->ex_default_member_accept_giftcards = 1;
                $insert->ex_default_min_cra_deposit         = 5000;
                
                $insert->save();
                return Redirect::route('admin_exchange')->with('success','Exchange added successfully');
                
            }
    }
    public function edit($id){
        $data['details']        = Exchange::find($id);
        return view('admin.exchange.edit',$data);
    }
    public function update(Request $request,$id){
            $validator = Validator::make(
				  $request->all(),
				   [
                                    'city_name'=> 'required|unique:exchanges,city_name,'.$id,
                                    'name'=> 'required|unique:exchanges,name,'.$id
				   ]
	    );
	    
	    if ($validator->fails()){
		    $messages = $validator->messages();
		    return Redirect::back()->withErrors($validator->errors())->withInput();
	    }else{
                
                
		$update                    = Exchange::find($id);
                $update->name              = $request->name;
                $update->city_name         = $request->city_name;
                $update->domain            = strtolower($request->name);
                $update->save();
                
                return Redirect::route('admin_exchange')->with('success','Exchange updated successfully');
	    }
            
	}
	
    
    public function change_status(Request $request)
    {
	$id 	        = $request->id;
	$rec            = Exchange::find($id);
	if(count($rec)>0)
	{
		$status         = $rec->status;
		if($status=='Active'){
		    $rec->status = 'Inactive';
		}
		else if($status=='Inactive'){
		    $rec->status = 'Active';
		}
		$rec->save();
		return Redirect::route('admin_exchange')->with('success','Exchange status updated successfully');
	}
    }

    public function delete(Request $request){
	$id 	        = $request->id;
        $golfCourse = GolfCourse::where('country_id',$id)->count();
        if($golfCourse>0){
            return back()->with('error','Exchange cannot be deleted because this destination is in used');
        }else{
            $nCard= Exchange::find($id);
            $nCard->delete();
            return back()->with('success','Exchange deleted successfully');
        }
    }
}
