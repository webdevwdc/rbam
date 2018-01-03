<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User, App\Role, App\PhoneType;
use \Session, \Validator,\Redirect, \Hash, \Auth, \Image;
class PhoneTypeController extends Controller
{
    public function lists(Request $request)
    {
        $data['keyword']        = '';
        if($request->keyword !=''){
            $data['keyword']            = $request->keyword;
            $data['lists'] = PhoneType::where(function($query) use ($data) {
                                    if($data['keyword'] != ''){
                                    $query->where('name','like','%'.$data['keyword'].'%');
                                 }
                            })
                            ->orderBy('id','desc')->paginate(10);
        }
        else{
            $data['lists'] = PhoneType::orderBy('name','asc')->paginate(10);
        }
        //echo json_encode($data);die;
        return view('admin.phonetype.list',$data);
    }
    
    public function create(){
        $data = array();
        return view('admin.phonetype.add',$data);
    }
    
    public function store(Request $request){
        
        $validator = Validator::make(
			  $request->all(),
			   [
                'name'=> 'required|unique:exchanges,name',
                'status'=>'required'
			   ]
		    );
	    if ($validator->fails()){
		    $messages = $validator->messages();
		    return Redirect::back()->withErrors($validator->errors())->withInput();
	    }else{
                $insert           = new PhoneType();
                $insert->name     = $request->name;
                $insert->status   = $request->status;
		
                $insert->save();
                return Redirect::route('admin_phone_type')->with('success','Phone type added successfully');
                
            }
    }
    
    public function edit($id){
        $details= PhoneType::find($id);
        return view('admin.phonetype.edit',compact('details'));
    }
    
    public function update(Request $request,$id){
        
        $validator = Validator::make(
                              $request->all(),
                               [
                                'name'=> 'required|unique:exchanges,name,'.$id,
                                'status'=>'required'
                               ]
        );
        
        if ($validator->fails()){
                $messages = $validator->messages();
                return Redirect::back()->withErrors($validator->errors())->withInput();
        }else{
            $update         = PhoneType::find($id);
            $update->name   = $request->name;
            $update->status = $request->status;
            $update->save();
            
            return Redirect::route('admin_phone_type')->with('success','Phone type updated successfully');
        }
        
    }
	
    
    public function change_status(Request $request)
    {
	$id 	        = $request->id;
	$rec            = PhoneType::find($id);
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
		return Redirect::route('admin_phone_type')->with('success','Phone type status updated successfully');
	}
    }

    public function delete(Request $request){
        $id 	= $request->id;
        $nCard= PhoneType::find($id);
        $nCard->delete();
        return back()->with('success','Phone type deleted successfully');
    }
}
