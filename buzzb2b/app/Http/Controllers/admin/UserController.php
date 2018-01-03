<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType;
use \Session, \Validator,\Redirect, \Hash, \Auth, \Image;
use File;
use Mailchimp;
use DB;

class UserController extends Controller
{   
	

    public function lists(Request $request){
	//die('aaa');
		$data['keyword']    	= '';
		$exchange_id 		= Session::get('EXCHANGE_ID');
		$data['exchange_id']	= $exchange_id;
		
		if($request->keyword !='')
		{  
		
		    $data['keyword']    = $request->keyword;
                   $data['lists'] = User::where('email','LIKE',"%{$data['keyword']}%")
                                  ->orWhere('first_name','LIKE',"%{$data['keyword']}%")
                                 ->wherehas('members', function($query) use ($data){
			                      $query->where('exchange_id', $data['exchange_id']);
			        })->paginate(10);
			}
		else{ 
			$data['lists'] = User::wherehas('members', function($query) use ($data){
			    $query->where('exchange_id', $data['exchange_id']);
			})->paginate(10);
			
			//$data['lists'] = User::paginate(10);
		}


		return view('admin.user.list',$data);
    }
    
    public function create(){
        $data = array();
		$data['state'] = ['0'=>'Select']+State::orderBy('abbrev','ASC')->pluck('abbrev','id')->all();
		$data['phonetype'] = PhoneType::orderBy('id','ASC')->pluck('name','id')->all();
        return view('admin.user.add',$data);
    }
   
    public function store(Request $request){
    	$this->validate($request,[
    		        'email'	=> 'required|unique:users,email',
					'first_name'=> 'required',
					'last_name'	=> 'required',
					'address1'=> 'required',
					'city'	=> 'required',
					'state_id'=> 'required',
					'zip'=> 'required',
					'phone_number'=> 'required|numeric|min:10',
					'password'=>'required|min:6|confirmed'
				],['address1.required'=>'Street address field is required ']);

		$input = $request->all();

		// Unsetting this field because, "display_phone_number" is used to masking phone number
		unset($input['display_phone_number']);
		if(!empty($input['is_admin'])){
           $admin=1;
		}else{
			$admin=0;
		}

		Mailchimp::subscribe(
			                'd4b79e20a4',
			                request()->input('email'),
			                [], 
			                false
			                );
		
		$save = User::create([
            'first_name'=>$input['first_name'],
            'last_name'=>$input['last_name'],
            'email'=>$input['email'],
            'password'=>$input['password'],
            'is_admin' => $admin,
			]);
		
		//creating address for this user
		Address::create([
            'addressable_id'=>$save->id,
            'addressable_type'=>'User',
            'address1'=>$input['address1'],
            'address2'=>$input['address2'],
            'city'=>$input['city'],
            'state_id'=>$input['state_id'],
            'zip'=>$input['zip'],
            'created_at'=>date('Y-m-d h:i:s'),
			]);
		//creating phone for this user
		Phone::create([
             'phoneable_id'=>$save->id,
             'phoneable_type'=>'User',
             'phone_type_id'=>$input['phone_type_id'],
             'number'=>$input['phone_number'],
			]);
		//assigning role for this user
		 Role_user::create([
			       'user_id'	=> $save->id,
			       'role_id'	=> 3 	
			       ]);
        //sending mail to admin and user
		if(!empty($input['email_user_after'])){
		        $newdata 					= array();
				$newdata['from_email']     	= 'admin@buzzB2B.com';
				$newdata['form_name']      	= 'BuzzB2B' ;
				$newdata['to_email']      	= $input['email'] ;
				$newdata['name']        	= ucfirst($input['first_name'])." ".ucfirst($input['last_name']);
				$newdata['email']			= $input['email'];
				$newdata['password']		= $input['password'];
								
				$mail_config = [
				'from_mail'=>'admin@buzzB2B.com',
				'from_name'=>'BuzzB2B',
				'to_mail'=>'kuldeep.mishra@webskitters.com',];
							
				\Mail::send('emails.adduser_notify',$newdata,function($message) use ($mail_config){
					$message->subject("User Registration");
					$message->from($mail_config['from_mail']);
					$message->to($mail_config['to_mail']);
				});
		}

		return Redirect::route('admin_user')->with('success','User added successfully'); 
    }

	public function edit($id, Request $request){
		   $data['details'] = User::find($id);
		
		if($request->action == "ProcessUser"){
			
			$validator = Validator::make($request->all(),[
							'email'			=> 'required|unique:users,email,'.$id,
							'first_name'	=> 'required',
							'last_name'		=> 'required',
						]
		    );
			if ($validator->fails()){
				$messages = $validator->messages();
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else{
				$modelUpdate 				= User::find($id);
				$modelUpdate->email 		= $request->email;
				$modelUpdate->first_name 	= $request->first_name;
				$modelUpdate->last_name  	= $request->last_name;
				$modelUpdate->save();
				return Redirect::route('admin_user_edit',$id)->with('success','New User Added Successfully');
			}
		}

        return view('admin.user.edit',$data);
    }
	
	
	public function uploadimage($id,Request $request){
		$data = array();
		$data['details'] = User::find($id);
		
		if($request->action == "ProcessImage"){
			$modelUpdate = User::find($id);
			
			$image_file = Input::file('image');
			if($image_file != ''){
				$extension = $image_file->getClientOriginalExtension();
				$fileName = time() . '.' . $extension;
				$path= public_path('upload/user_image/thumb/' . $fileName);			
				$image_file->move(public_path('upload/user_image/'), $fileName);
				$_image= \Image::make(public_path('upload/user_image/'.$fileName))->resize(200, 200, function ($c) {$c->aspectRatio();$c->upsize();});
				$upload_success= $_image->save($path);
				
				if ($upload_success) {
					if (file_exists(public_path('upload/user_image/'.$request->old_image))){
						@unlink(public_path('upload/user_image/'.$request->old_image));
					}				
					if (file_exists(public_path('upload/user_image/thumb/'.$request->old_image))){
						@unlink(public_path('upload/user_image/thumb/'.$request->old_image));
					}	
					$modelUpdate->image 		= $fileName;
					$modelUpdate->updated_at	= date('Y-m-d h:i:s');
					$modelUpdate->save();
				}
				else{
					return Redirect::route('admin_user_image',$id)->with('errormessage','Upload Failed!');	
				}
			}
			else{
				$modelUpdate->image = $request->old_image;
				$modelUpdate->save();
			}
			return Redirect::route('admin_user_image',$id)->with('succmsg','Image Uploaded successfully!');
			
		}
		return view('admin.user.image',$data);
	}
	
	public function edit_member_associations($id){
		$data['details']= User::where("id",$id)->get();
	
		$data['addressable_id'] = $id;
		return view('admin.user.edit_member_associations',$data);	    
	}
	
	public function edit_exchange_associations($id){
		$data['details']= array();
		$data['addressable_id'] = $id;
		return view('admin.user.edit_exchange_associations',$data);	    
	}
	
	/*   Address Segment For User ====  Start  */
	
	public function edit_address($id){
		$data['details']= Address::where("addressable_id",$id)->get();
		$data['addressable_id'] = $id;
		return view('admin.user.edit_address',$data);
	}
	
	public function update_address($id, Request $request){
		$data['details']= Address::where("addressable_id",$id)->first();
		$data['addressable_id'] = $id;
		$data['state'] = [''=>'Select']+State::orderBy('abbrev','ASC')->pluck('abbrev','id')->all();
		
		if($request->action == "ProcessAddress"){
			
			$validator = Validator::make($request->all(),[
						'address1'		=> 'required',
						'city'			=> 'required',
						'state_id'		=> 'required',
						'zip'			=> 'required',
					]);
			if ($validator->fails()){
				$messages = $validator->messages();
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else{
				$modelInsert 					= new Address();
				$modelInsert->addressable_id 	= $id;
				$modelInsert->addressable_type	= 'User';
				$modelInsert->address1 			= $request->address1;
				$modelInsert->address2 			= $request->address2;
				$modelInsert->city 				= $request->city;
				$modelInsert->state_id 			= $request->state_id;
				$modelInsert->zip 				= $request->zip;
				
				if($request->default_address == 1){
					$getdefaultExists = Address::where("addressable_id",$id)->where('addressable_type','User')->where('is_default','Yes')->first();
					if(count($getdefaultExists)>0){
						$getdefaultExists->is_default = 'No';
						$getdefaultExists->updated_at = date('Y-m-d h:i:s');
						$getdefaultExists->save();
					}
					$modelInsert->is_default = 'Yes';
				}
				else{
					$modelInsert->is_default = 'No';	
				}
				$modelInsert->save();
				return Redirect::route('admin_user_address_edit',$id)->with('success','New Address Added Successfully');
			}
		}
		return view('admin.user.update_address',$data);
	}
	
	public function delete_address($id,$adid){
		$modelDelete = Address::where('id',$id)->where("addressable_id",$adid)->where('is_default','No')->first();	
		$modelDelete->delete();
		return Redirect::route('admin_user_address_edit',$adid)->with('success','Address Deleted Successfully');
	}
	
	public function default_address($id,$adid){
		$get_request_for_default = Address::where('id',$id)->where("addressable_id",$adid)->where('is_default','No')->first();
		if(count($get_request_for_default)>0){
			$all_result = Address::where("addressable_id",$adid)->get();
			if(count($all_result)>0){
				foreach($all_result as $ar){
					$ar->is_default = 'No';
					$ar->save();	
				}
			}
			$get_request_for_default->is_default = 'Yes';
			$get_request_for_default->updated_at = date('Y-m-d h:i:s');
			$get_request_for_default->save();
		}
		return Redirect::route('admin_user_address_edit',$adid)->with('success','Change Address Default Successfully');
	}
	
	/*   Address Segment For User ====  End  */
	
	
	/*   Phone Segment For User ====  Start  */
	
	
	public function edit_phone($id){
		$data['details']= Phone::where("phoneable_id",$id)->get();
		$data['phoneable_id'] = $id;
		return view('admin.user.edit_phone',$data);
	}
	
	public function update_phone($id, Request $request){
		$data['details']= Phone::where("phoneable_id",$id)->first();
		$data['phoneable_id'] = $id;
		$data['phonetype'] = PhoneType::orderBy('id','ASC')->pluck('name','id')->all();
		
		if($request->action == "ProcessPhone"){
			
			$validator = Validator::make($request->all(),[
                 'phone_number'	=> 'required|integer|digits:10',
			]);
			if ($validator->fails()){
				$messages = $validator->messages();
				return Redirect::back()->withErrors($validator->errors())->withInput();
			}
			else{
				$modelInsert 					= new Phone();
				$modelInsert->phoneable_id 		= $id;
				$modelInsert->phoneable_type	= 'User';
				$modelInsert->phone_type_id 	= $request->phone_type_id;
				$modelInsert->number 			= $request->phone_number;
				if($request->primary == 1){
					$getprimaryExists = Phone::where("phoneable_id",$id)->where('phoneable_type','User')->where('is_primary','Yes')->first();
					if(count($getprimaryExists)>0){
						$getprimaryExists->is_primary = 'No';
						$getprimaryExists->updated_at = date('Y-m-d h:i:s');
						$getprimaryExists->save();
					}
					$modelInsert->is_primary = 'Yes';
				}
				else{
					$modelInsert->is_primary = 'No';	
				}
				$modelInsert->created_at 		= date('Y-m-d h:i:s');
				$modelInsert->save();
				return Redirect::route('admin_user_phone_edit',$id)->with('success','New Phone Number Added Successfully');
			}
		}
		return view('admin.user.update_phone',$data);
	}
	
	public function delete_phone($id,$phid){
		$modelDelete = Phone::where('id',$id)->where("phoneable_id",$phid)->where('phoneable_type','User')->where('is_primary','No')->first();	
		$modelDelete->delete();
		return Redirect::route('admin_user_phone_edit',$phid)->with('success','Phone Number Deleted Successfully');
	}

	public function default_phone($id,$phid){
		$get_request_for_default = Phone::where('id',$id)->where("phoneable_id",$phid)->where('phoneable_type','User')->where('is_primary','No')->first();
		if(count($get_request_for_default)>0){
			$all_result = Phone::where("phoneable_id",$phid)->where('phoneable_type','User')->get();
			if(count($all_result)>0){
				foreach($all_result as $ar){
					$ar->is_primary = 'No';
					$ar->save();	
				}
			}
			$get_request_for_default->is_primary = 'Yes';
			$get_request_for_default->updated_at = date('Y-m-d h:i:s');
			$get_request_for_default->save();
		}
		return Redirect::route('admin_user_phone_edit',$phid)->with('success','Change Phone Number Default Successfully');
	}
	
	/*   Phone Segment For User ====  End  */

	public function makeAdmin($id){

		$user = User::where('id',$id)->first();
		if($user->is_admin==0){
			$user->update(['is_admin'=>1]);
		}else{
			$user->update(['is_admin'=>0]);
		}
		return back()->with('success','Record successfully updated');
	}

    public function memberAdmin($id){
		$user = MemberUser::where('member_id',$id)->first();
		$user_id = $user->user_id;

		$user_data = User::find($user_id);

		if($user->admin==0)
		{
			$user->update(['admin'=>1]);
			$user_data->update(['is_admin'=>1]);
		}
		else
		{
			$user->update(['admin'=>0]);
			$user_data->update(['is_admin'=>0]);
		}
		return back()->with('success','Record successfully updated');
	}
}
