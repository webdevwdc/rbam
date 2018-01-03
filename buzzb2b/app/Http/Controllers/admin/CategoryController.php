<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User, App\Role, App\Category;
use \Session, \Validator,\Redirect, \Hash, \Auth, \Image;
class CategoryController extends Controller
{   
    public function lists(Request $request)
    {
        $data['keyword']        = '';
        if($request->keyword !=''){
            $data['keyword']            = $request->keyword;
            $data['lists'] = Category::where(function($query) use ($data) {
                                    if($data['keyword'] != ''){
                                    $query->where('name','like','%'.$data['keyword'].'%');
                                 }
                            })
                            ->orderBy('id','desc')->paginate(10);
        }
        else{
            $data['lists'] = Category::orderBy('name','asc')->paginate(10);
        }
        //echo json_encode($data);die;
        return view('admin.category.list',$data);
    }
    
    public function create(){
        $data = array();
        return view('admin.category.add',$data);
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
                
                $slug = str_slug($request->name, '-');
                $insert          = new Category();
                $insert->name    = $request->name;
                $insert->status  = $request->status;
                $insert->slug    = $slug;
                $insert->save();
                return Redirect::route('admin_category')->with('success','category added successfully');
                
            }
    }
    
    public function edit($id){
        $data['details'] = Category::find($id);
        return view('admin.category.edit',$data);
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
            
            $slug = str_slug($request->name, '-');
            $update                    = Category::find($id);
            $update->name              = $request->name;
            $update->status            = $request->status;
            $update->slug              = $slug;
            $update->save();
            
            return Redirect::route('admin_category')->with('success','category updated successfully');
        }
        
    }
	
    
    public function change_status(Request $request)
    {
	$id 	        = $request->id;
	$rec            = Category::find($id);
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
    		return Redirect::route('admin_category')->with('success','category status updated successfully');
    	}
    }

    public function delete(Request $request){
            $id 	= $request->id;
            $nCard= Category::find($id);
            $nCard->delete();
            return back()->with('success','category deleted successfully');
    }
}
