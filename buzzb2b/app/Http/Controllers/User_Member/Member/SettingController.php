<?php

namespace App\Http\Controllers\User_Member\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Image,\Auth,\File, App\Member, App\MemberUser ,App\State ,App\Address, App\Phone, App\PhoneType, App\Role_user;
use App\User, \Session;
use App\MemberCashier;
class SettingController extends Controller
{
    public function ViewSetting(){
      $image=Image::where('imageable_id',Auth::user()->id)->first();
      $member_id = Session::get('MEMBER_ID');
      $member = Member::where('id',$member_id )->first();
      return view('user_member.member.setting.directory-setting',compact('image','member'));
    }

    public function SaveLogo(Request $request){
    	$this->validate($request,[
    		'member_logo'=>'required|mimes:jpg,jpeg,png',
    		]);
    	$image=Image::where('imageable_id',Auth::user()->id)->first();
    	if(!empty($image)){
    		$path = public_path().'/upload/members/'.$image->filename;
    		File::delete($path);
    		$file = $request->file('member_logo');
	    	$extension = $file->getClientOriginalExtension();
	    	$image_file_name = time() . '.' . $extension;
	    	$save = $file->move(public_path('upload/members/'), $image_file_name);
	    	$image->update([
	    		'imageable_id'=>Auth::user()->id,
	    		'image_type' =>'MemberLogo',
	    		'filename' =>$image_file_name,
	    		]);
	    	return back()->with('success','Member Logo Updated Successfully');
    	}else{
    	$file = $request->file('member_logo');
    	$extension = $file->getClientOriginalExtension();
    	$image_file_name = time() . '.' . $extension;
    	$save = $file->move(public_path('upload/members/'), $image_file_name);
    	Image::create([
    		'imageable_id'=>Auth::user()->id,
    		'image_type' =>'MemberLogo',
    		'filename' =>$image_file_name,
    		]);
    	return back()->with('success','Member Logo Saved Successfully.');
       }
    }

    public function SaveUrl(Request $request){
    	$this->validate($request,[
    		'website_url'=>'required|url']
    		);
      $member_id = Session::get('MEMBER_ID');
    	$input = $request->all();
    	$member = Member::where('id',$member_id)->first();
    	if (!empty($member)) {
    		$member->update(['website_url'=>$input['website_url'],'is_active_salesperson'=>$input['is_active_salesperson']]);
    	     return back()->with('success','Member Updated Successfully');
    	}else{
    		Member::create(['website_url'=>$input['website_url'],'is_active_salesperson'=>$input['is_active_salesperson']]);
    	     return back()->with('success','Member details updated successfully');
    	}
    }

    public function ViewUsers(){
	
     $member_id = Session::get('MEMBER_ID');
     $member_user = MemberUser::where('member_id',$member_id)
                 ->join('users','member_users.user_id','=','users.id')->where('deleted_at',Null)->get();
		 
     
     return view('user_member.member.setting.user-setting',compact('member_user'));
    }

    public function CreateUser(){
     $state = State::pluck('abbrev','id')->prepend('Select','');
     $member_id = Session::get('MEMBER_ID');
     $defaultAddress= Address::where('addressable_id',$member_id)->where('is_default','Yes')->first();
     $defaultPhone = Phone::where('phoneable_id',$member_id)->where('is_primary','Yes')->first();
     $phonetypeSelectionList= PhoneType::where('status','active')->pluck('name','id');
     return view('user_member.member.setting.add-user',compact('state','defaultAddress','defaultPhone','phonetypeSelectionList'));	
    }

    public function SaveCreateUser(Request $request)
    {   
       $this->validate($request,[
        'email'=>'required|email|max:255|unique:users',
        'firstname'=>'required',
        'lastname'=>'required',
        'password' => 'required|min:6',
        'password_confirmation'=>'required|same:password'
        ],[
        'firstname.required'=>'First name filed is required',
        'lastname.required'=>'Last name filed is required',
        ]);
	      $input = $request->all();
        //echo "<pre>"; print_r($input); die();
        $exchangeid	= session::get('EXCHANGE_ID');
        $member_id 	= Session::get('MEMBER_ID');
    	$userexist 	= User::where('email', $input['email'])->first();
	
      if($userexist)
      {
	       return Redirect::back()->with('error','The user email already exist');
      }
      else
      {
	    $save = User::create([
					'email'		=> $input['email'],
					'first_name'	=> $input['firstname'],
					'last_name'	=> $input['lastname'],
					'password'	=> $input['password']
				     ]
				    );
	    //exit();
      $input['admin'] = '';
	    if(count($input['admin'])>0)
	    {
		    $admin = 1;
	    }
	    MemberUser::create([
	      'member_id'		=> $member_id,
	      'user_id'			=> $save->id,
	      'monthly_trade_limit'	=> $input['monthly_trade_limit'],
	      'admin'			=> $admin
    
	      ]);
	    
	    Role_user::create([
			       'user_id'	=> $save->id,
			       'role_id'	=> 3 	
			       ]);
		
	    if ($input['create_new_address'] == 1) //want to create users new address
	    {
		Address::create([
				    'addressable_id'	=> $save->id,
				    'addressable_type'	=> 'User',
				    'address1'		=> $input['address1'],
				    'address2'		=> $input['address2'],
				    'city'		=> $input['city'],
				    'state_id'		=> $input['state_id'],
				    'zip'		=> $input['zip'],
				    'default'		=> 1
				]);
	    }
	    else
	    {
	       //crating user with exsitng address
	       $member_address = Address::where('addressable_id', '=', $member_id)->where('addressable_type', '=', 'Member')->first();
	       
	       Address::create([
				    'addressable_id'	=> $save->id,
				    'addressable_type'	=> 'User',
				    'address1'		=> $member_address['address1'],
				    'address2'		=> $member_address['address2'],
				    'city'		=> $member_address['city'],
				    'state_id'		=> $member_address['state_id'],
				    'zip'		=> $member_address['zip'],
				    'default'		=> 1
				]);
	       
	    }
	    
	    //print_r($input);exit();
	    if ($input['create_new_phone'] == 1) //want to create users new phone
	    {
		Phone::create([
				    'phoneable_id'	=> $save->id,
				    'phoneable_type'	=> 'User',
				    'phone_type_id'	=> $input['phone_type_id'],
				    'number'		=> $input['phone_number'],
				    'primary'		=> 1
				]);
	    }
	    else
	    {
	       //crating user with exsitng phone
	       $member_phone = Phone::where('phoneable_id', '=', $member_id)->where('phoneable_type', '=', 'Member')->first();
	       Phone::create([
				    'phoneable_id'	=> $save->id,
				    'phoneable_type'	=> 'User',
				    'phone_type_id'	=> $member_phone['phone_type_id'],
				    'number'		=> $member_phone['number'],
				    'primary'		=> 1
				]);
	    }
	  }
    	
    	return redirect::route('users_setting');

    }

    public function ViewAddress(){
     $member_id = Session::get('MEMBER_ID');
     $addresses = Address::orderBy('is_default','ASC')->where('addressable_id',$member_id)->get();
     return view('user_member.member.setting.address-setting',compact('addresses','modal'));
    }

    public function CreateAddress(){
      $state = State::pluck('abbrev','id')->prepend('Select','');
      return view('user_member.member.setting.create-address',compact('state'));
    }
    public function SaveAddress(Request $request){
      $this->validate($request,[
         'address1'=>'required',
         'city'=>'required',
         'state'=>'required',
         'zip'=>'required',
        ]);
      $input = $request->all();
      $member_id = Session::get('MEMBER_ID');
      if($input['address2']==''){
        $input['address2']=='Null';
      }
      if ($input['is_default']=='Yes') {
        $address = Address::where('addressable_id',$member_id)->where('is_default','Yes')->first();
        if(!empty($address))
        $address->update(['is_default'=>'No']);

      }
       Address::create([
         'address1'=>$input['address1'],
         'addressable_id'=>$member_id,
         'addressable_type'=>'Member',
         'address2'=>$input['address2'],
         'city'=>$input['city'],
         'state_id'=>$input['state'],
         'zip'=>$input['zip'],
         'is_default'=>$input['is_default'],
        ]); 
       
      return redirect::route('address_setting');
    }

    public function AddressDelete($id){
        Address::DeleteAddress($id);
       return redirect()->back()->with('success','Address Deleted Successfully');
    }

    public function ViewPhone(){
       $member_id = Session::get('MEMBER_ID');
       $phones = Phone::where('phoneable_id',$member_id)->get();
      return view('user_member.member.setting.phone-setting',compact('phones'));
    }
    
    public function CreatePhone(){     
     return view('user_member.member.setting.create-phone');
    }

    public function SavePhone(Request $request){
      $this->validate($request,[
        'phone_number'=>'required|integer|digits:10',
        ]);
      $input = $request->all();
      $member_id = Session::get('MEMBER_ID');
      if ($input['is_primary']=='Yes') {
        $phone = Phone::where('phoneable_id',$member_id)->where('is_primary','Yes')->first();
        if(!empty($phone))
        $phone->update(['is_primary'=>'No']);
      }
      Phone::create([
         'phoneable_id'=>$member_id,
         'phoneable_type'=>'Member',
         'phone_type_id'=>$input['phone_type'],
         'number'=>$input['phone_number'],
         'is_primary'=>$input['is_primary'],

        ]);
      return redirect::route('phone_setting');
    }

    /*delte a phone*/
    public function PhoneDelete($id){
      Phone::where('id', $id)->delete();
      return back()->with('success','Phone Deleted Successfully.');
    }

    /*cashier section start*/
    public function ViewCashier(){
      $member_id = Session::get('MEMBER_ID');
      $cashiers = MemberCashier::where('member_id',$member_id)
                    ->leftjoin('users','member_cashiers.user_id','=','users.id')
		    ->get();
     return view('user_member.member.setting.cashier-setting',compact('cashiers'));
    }

    public function CreateCashier(){
      $member_id = Session::get('MEMBER_ID');
      $member_users = MemberUser::where('member_id',$member_id)
                    ->join('users','member_users.user_id','=','users.id')->get();
      $cashiers = array_flatten(MemberCashier::select('user_id')->where('member_id', '=', $member_id)
                ->where('user_id', '!=', '0')->get()->toArray());
      return view('user_member.member.setting.create-cashier',compact('member_users','cashiers'));
    }

    public function SaveCashier(Request $request){
      $input = $request->all();
      $member_id = Session::get('MEMBER_ID');
      if (!empty($input['user_id'])) {
        MemberCashier::create([
          'member_id'=>$member_id,
          'user_id'=>$input['user_id'],
          'nickname'=>'null',
        ]);
        return back()->with('success','Cashier has been added. ');
      }
      $this->validate($request,[
        'nickname'=>'required',
        ]);
      //cashier using user_id
      if(!empty($input['nickname'])){
        MemberCashier::create([
          'member_id'=>$member_id,
          'user_id'=>0,
          'nickname'=>$input['nickname'],
        ]);
        return back()->with('success','Cashier has been added. ');
      }
    }
    
    public function DeleteUser(Request $request){
	    $id = $request->id;  
	    User::delete_user($id);
	    Session::flash('success', "User deleted successfully");
	    return redirect::route('users_setting');
    }
    
  public function DeleteCashier(Request $request){
	 $id = $request->user_id;
	 MemberCashier::where('user_id',$id)->delete();
	 Session::flash('succmsg', "Cashier deleted successfully");
	  return redirect::route('cashier_setting');
  }
}
