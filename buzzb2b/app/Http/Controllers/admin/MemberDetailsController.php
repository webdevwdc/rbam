<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User, App\Role, App\Exchange;
use App\Member, App\State, App\PhoneType, App\MemberUser, App\Address, App\Phone, App\Category, App\Image, App\Tag, App\Cardpool;
use App\Bartercard, App\MemberTag;
use \Session, \Validator,\Redirect, \Hash, \File, \Auth, \Image as Imgupload;

class MemberDetailsController extends Controller
{
    public function index($id)
    {
	$exchangeid = session::get('EXCHANGE_ID');
	$data['member'] = Member::find($id);
	$data['refsSelectionList']		= Member::where('exchange_id',$exchangeid)->pluck('name','id')->prepend('None','');
	$data['salespersonSelectionList']	= Member::where('exchange_id',$exchangeid)->where('is_active_salesperson',1)->pluck('name','id')->prepend('None','');
	$data['stateSelectionList'] 		= State::pluck('abbrev','id')->prepend('Select','');
	$data['phonetypeSelectionList']		= PhoneType::pluck('name','id');
	
	$data['prospect'] = false;
	
	if($data['member']->prospect == 1)
	{
	    $data['prospect'] = true;
	}
	
	$data['salesperson'] = false;
	
	if($data['member']->is_active_salesperson == 1)
	{
	    $data['salesperson'] = true;
	}
	
	return view('admin.members.details',$data);
	
    }
    
    public function update_details(Request $request,$id)
    {
	$validator = Validator::make(
				  $request->all(),[
                    'name'=> 'required',
                    'business_1099_name'=> 'required',
				    'tax_id_number'	=> 'required'
				   ]);
	
	if ($validator->fails()){
		    $messages = $validator->messages();
		    return Redirect::back()->withErrors($validator->errors())->withInput();
	} else {
	    
		    $update_member				= Member::find($id);
		    $update_member->name			= $request->name;
		    $update_member->business_1099_name		= $request->business_1099_name;
		    $update_member->tax_id_number		= $request->tax_id_number;
		    $update_member->website_url			= $request->website;
		    $update_member->standby			= $request->standby;
		    $update_member->prospect			= $request->is_prospect;
		    $update_member->is_active_salesperson	= $request->is_active_salesperson;
		    $update_member->save();
		    
		    return Redirect::back()->with('success','Member details updated successfully');
	    }
    }
    
    public function address($id)
    {
	$exchangeid		    = session::get('EXCHANGE_ID');
	$data['member'] 	= Member::find($id);
	$data['lists']		= Address::where('addressable_id', '=', $id)->groupBy('address1','address2','city','state_id','zip')->get();
	return view('admin.members.address', $data);
    }
    
    public function address_create($id)
    {
	$data		= array();
	$data['member'] = Member::find($id);
	$data['state']  = State::pluck('name','id');
	return view('admin.members.add_address', $data);
    }
    
    public function address_store(Request $request, $id)
    {
	$validator = Validator::make(
					$request->all(),
					 [
					  'address1'	=> 'required',
					  'city'	=> 'required',
					  'zip'		=> 'required'
					 ]
				   );
	
	if ($validator->fails())
	{
	    $messages = $validator->messages();
	    return Redirect::back()->withErrors($validator->errors())->withInput();
	}
	else
	{
		    $data['member'] = Member::find($id);
		    
		    if($request->is_default == 'Yes')
	            {
	                Address::where('addressable_id', '=', $data['member']->id)->update(array('is_default' => 'No'));
	            }
		    
		    $member_address			= new Address();
		    $member_address->addressable_id 	= $data['member']->id;
		    $member_address->addressable_type	= 'Member';
		    $member_address->address1		= $request->address1;
		    $member_address->address2		= $request->address2;
		    $member_address->city		= $request->city;
		    $member_address->state_id		= $request->state;
		    $member_address->zip		= $request->zip;
		    $member_address->is_default	= $request->is_default;
		    $member_address->save();
		    return Redirect::route('admin_member_address', $data['member']->id)->with('success','Address added successfully');
		}
    }
    
    
    public function change_default_address($id)
    {
        $address             = Address::find($id);
        $address->is_default = 'Yes';
        $address->save();
	
	    $user_id = $address->addressable_id;
	
        Address::where('addressable_id',$user_id)->where('id','!=',$id)->update(array('is_default' => 'No'));
	
	$data['member'] = Member::find($user_id);
	
        return Redirect::route('admin_member_address', $data['member']->id);
    }
    
    public function delete_address($id)
    {
	$address 	= Address::find($id);
	$user_id	= $address->addressable_id;
	$data['member'] = Member::find($user_id);
	
        if (!empty($address)){
            if ($address->is_default == 'Yes'){
                Session::flash('error', "Default address can not be deleted");
                return Redirect::route('admin_manage_address');
            }
            $address->delete();
            Session::flash('success', "Address deleted successfully");            
        }
	
        return Redirect::route('admin_member_address', $data['member']->id);
    }
    
    public function phone($id)
    {
	$exchangeid		= session::get('EXCHANGE_ID');
	$data['member'] = Member::find($id);
	
	$data['lists'] = Phone::where('phoneable_id', $data['member']->id)->groupBy('number','phone_type_id')->get();
	return view('admin.members.phone', $data);
    }
    
    public function phone_create($id)
    {
	$data		= array();
	$data['member'] = Member::find($id);
	$data['phone']  = PhoneType::pluck('name','id');
	return view('admin.members.add_phone', $data);
    }
    
    public function phone_store(Request $request, $id){
		$validator = Validator::make($request->all(),[
		  'phone_number'	=> 'required|numeric|min:10',
		  'phone_type'		=> 'required',
		  'is_primary'		=> 'required'
		 ]);
		
		if ($validator->fails()){
		    $messages = $validator->messages();
		    return Redirect::back()->withErrors($validator->errors())->withInput();
		}
		else{
		    $data['member'] = Member::find($id);
		    if($request->is_primary == 'Yes'){
	          Phone::where('phoneable_id', '=', $data['member']->id)->update(array('is_primary' => 'No'));
	        }
		    
		    $member_phone			= new Phone();
		    $member_phone->phoneable_id 	= $data['member']->id;
		    $member_phone->phoneable_type	= 'Member';
		    $member_phone->number		= $request->phone_number;
		    $member_phone->phone_type_id	= $request->phone_type;
		    $member_phone->is_primary		= $request->is_primary;
		    $member_phone->save();
		    
		    return Redirect::route('admin_member_phone', $data['member']->id)->with('success','Phone added successfully');
		}
    }
    
    
    public function change_default_phone($id)
    {
        $phone               = Phone::find($id);
        $phone->is_primary = 'Yes';
        $phone->save();
	
	$user_id	     = $phone->phoneable_id;
	
        Phone::where('phoneable_id',$user_id)->where('id','!=',$id)->update(array('is_primary' => 'No'));
	
	$data['member'] = Member::find($user_id);
	
        return Redirect::route('admin_member_phone', $data['member']->id);
    }
    
    public function delete_phone($id)
    {
	$phone 		= Phone::find($id);
	$user_id	= $phone->phoneable_id;
	$data['member'] = Member::find($user_id);
	
        if (!empty($phone)){
            if ($phone->is_primary == 'Yes'){
                Session::flash('error', "Default phone can not be deleted");
                return Redirect::route('admin_member_phone', $data['member']->id);
            }
            $phone->delete();
            Session::flash('success', "Phone deleted successfully");            
        }
	
        return Redirect::route('admin_member_phone', $data['member']->id);
    }
    
    public function member_user($id){


	$exchange_id  = Session::get('EXCHANGE_ID'); 
	$data = array();
	$data['member_id']  = $id;
	$data['member'] 	= Member::find($id);
	
	
	
     $data['lists'] = $data['lists'] =  MemberUser::where('user_id',MemberUser::where('member_id',$id)->first()->user_id)
                    ->join('users','member_users.user_id','=','users.id')->first();

     //echo "<pre>"; print_r($data['lists']); die();
	return view('admin.members.member_user', $data);
    }
    
    public function member_user_edit($id){
	$data = array();
	$data['member']  = $data['details'] = Member::find($id);
	return view('admin.members.member_user_edit', $data);	
    }
    
    
    public function member_user_update(Request $request){
	$data = array();
	$id = $request->route('id');
	$member 	= MemberUser::where('member_id', $id)->first();
        $member->primary = ($request->primary)? $request->primary:0;
	$member->admin = ($request->admin)? $request->admin : 0;
	$member->can_access_billing = ($request->can_access_billing)? $request->can_access_billing:0;
	$member->can_pos_sell = ($request->can_pos_sell)? $request->can_pos_sell:0;
	$member->can_pos_purchase = ($request->can_pos_purchase)? $request->can_pos_purchase:0;
	$member->monthly_trade_limit = ($request->monthly_trade_limit)? $request->monthly_trade_limit:0;
	$member->save();
	return Redirect::route('admin_member_user',$member->member_id)->with('success','User Updated successfully');	
    }

    public function issue_bartercard(Request $request){
    	$memberid = $request->member_id;
    	$userid = $request->user_id;
    	$bartercard = $request->barter_card;
    	$exchangeid		= session::get('EXCHANGE_ID');
    	if($bartercard!=''){
	    	$cardpool = Cardpool::where('number', $bartercard)->where('exchange_id',$exchangeid)->where('available',1)->first();
	    	if($cardpool){
	    		$card = new Bartercard();
	    		$card->exchange_id = $exchangeid;
	    		$card->member_id = $memberid;
	    		$card->user_id = $userid;
	    		$card->number = $bartercard;
	    		$card->active = 1;
	    		$card->save();
	    		$cardpool->available = 0;
	    		$cardpool->save();
	    		echo 1;
	    	}else{
	    		echo 0;
	    	}    		
    	}else{
    		echo 2;
    	}


    }

    public function member_user_delete($id){
        Bartercard::where('user_id',$id)->delete();
        return Redirect::back()->with('success','Bartercard Revoked successfully');
    }

    
    public function directory_profile($id){ 
	
	$data['member'] = $data['details'] 		= Member::find($id);
	
	$data['member_id'] = $id;
	
	
	$data['categories'] = Category::pluck('name','id');
	return view('admin.members.profile', $data);	
    }
    
    public function admin_directory_profile_update(Request $request){
	$memberid = $request->route('id');

	$membertagsArr = array();
	$membercategoriesArr = array();
	
 	if($request->file('member_logo'))
	{
	    $imagename  = time().'-logo' . '.' . $request->file('member_logo')->getClientOriginalExtension();
	    
	    // move original image 
	    $path       = public_path('upload/members/' . $imagename);
	    Imgupload::make($request->file('member_logo')->getRealPath())->save($path);
	    
	    // create thumb
	    $thumb_path = public_path('upload/members/thumb/' . $imagename);
	    Imgupload::make($request->file('member_logo')->getRealPath())->resize(120, 120)->save($thumb_path);

	    $oldimg     = Image::where('imageable_id',  $memberid)->first();
	    
	    if($oldimg){
		$image_path         = public_path('upload/members/'.$oldimg->filename);
		$image_thumb_path   = public_path('upload/members/thumb/'.$oldimg->filename);
		
		File::Delete($image_path);
		File::Delete($image_thumb_path);
				
		Image::where('imageable_id',  $memberid)->delete();
	    }

	    $newimg             = new Image();
	    $newimg->imageable_id     = $memberid;
	    $newimg->image_type     = 'MemberLogo';
	    $newimg->filename     = $imagename;
	    $newimg->save();
	}
	    
	
	
	if(count($request->member_categories)){
	    foreach($request->member_categories as $memcat){
		$membercategoriesArr[] = $memcat;
	    }	    
	}
	
	$member = Member::find($memberid);
	$member->description = $request->description;
	$member->view_on_dir = $request->view_on_dir;
	$member->save();
	$member->category()->sync($membercategoriesArr);
	
	
		    
	return Redirect::back()->with('success','Directory Profile Updated successfully');
    }
    
    public function member_user_create(Request $request,$id){
    $input = $request->all();
	$data 	= array();
	$id = $request->route('id');

 	$data['memberid'] = $id;
	$data['member'] = Member::find($id);
	$data['stateSelectionList'] 		= State::pluck('abbrev','id')->prepend('Select','');
	$data['phonetypeSelectionList']		= PhoneType::pluck('name','id')->prepend('Select','');;
	$data['defaultPhone']		= Phone::where('phoneable_id', $id)->where('is_primary','Yes')->first();

	$data['defaultAddress']		= Address::where('addressable_id', $id)->where('is_default','Yes')->first();
	/*echo "<pre>"; print_r($data['defaultAddress']); die();*/
	return view('admin.members.add_member_user',$data);
    }
    
    public function member_user_store(Request $request){
      $memberid = $request->route('id');	
      $validator = Validator::make(
		$request->all(),
		 [
		      'email' => 'email|required',
		      'firstname' => 'required',
		      'lastname' => 'required',
		      'password' => 'required|confirmed',
		      'address1' => 'required_if:create_new_address,1',
		      'address2' => 'different:address1',
		      'city' => 'required_if:create_new_address,1',
		      'state_id' => 'required_if:create_new_address,1|not_in:0',
		      'zip' => 'required_if:create_new_address,1|numeric',
		      'phone_number' => 'required_if:create_new_phone,1|phone',
		 ],
		 [
		      'email.email' => 'Email must be a proper email address',
		      'email.required' => 'Please enter a valid Email address',
		      'firstname.required' => 'Please enter a valid First Name',
		      'lastname.required' => 'Please enter a valid Last Name',
		      'password.min' => 'Password must be at least 8 characters',
		      'password.confirmed' => 'Password and Password Confirmation do not match',
		      'password.required' => 'Please enter a Password',
		      'address1.required_if' => 'Please enter a Street Address',
		      'address2.different' => 'The Suite/Unit must be different than the street address',
		      'city.required_if' => 'Please enter a City',
		      'state_id.required_if' => 'Please select a State',
		      'zip.required_if' => 'Please enter a Zip/Postal code',
		      'zip.numeric' => 'The Zip/Postal code must be a numeric value',
		      'phone_number.required_if' => 'Please enter a Phone Number',
		      'phone_number.phone' => 'Please enter the Phone Number as all numbers, no dashes or parentheses',				    
		 ]
	    );
	    if ($validator->fails()){
		    $messages = $validator->messages();
		    return Redirect::back()->withErrors($validator->errors())->withInput();
	    }else{
		
		$userexist = User::where('email', $request->email)->first();
		
		if(!$userexist){
		    $user = new User();
		    $user->email = $request->email;
		    $user->first_name = $request->firstname;
		    $user->last_name = $request->lastname;
		    if($request->generate_pw==1){
			$randpass = substr($request->firstname,0,3).mt_rand(100,999);
			$user->password = $randpass;
		    }else{
			$user->password = $request->password;
		    }
		    $user->save();
		}else{
		    return Redirect::back()->with('error','Sorry! The user email is not exist in our database')->withInput();
		}
		    
		$memberuser = new MemberUser();
		$memberuser->member_id = $memberid;
		$memberuser->user_id = $user->id;
		$memberuser->monthly_trade_limit = $request->monthly_trade_limit;
		$memberuser->admin = ($request->admin)? $request->admin:0;
		$memberuser->save();
		
		$address = new Address();
		$address->addressable_id = $memberid;
		$address->addressable_type = 'Member';
		    
		if($request->create_new_address){
		    $address->address1 = $request->address1;
		    $address->address2 = $request->address2;
		    $address->city = $request->city;
		    $address->state_id = $request->state_id;
		    $address->zip = $request->zip;
		}else{
	        $curaddress = Address::where('addressable_id', $memberid)->where('is_default','Yes')->first();
		    $address->address1 = $curaddress->address1;
		    $address->address2 = $curaddress->address2;
		    $address->city = $curaddress->city;
		    $address->state_id = $curaddress->state_id;
		    $address->zip = $curaddress->zip;		       
		}
		    $address->save();
		
		    $phone = new Phone();
		    $phone->phoneable_id = $memberid;
		    $phone->phoneable_type = 'Member';		
		
		if($request->create_new_phone){
		    $phone->number = $request->number;
		    $phone->phone_type_id = $request->phone_type_id;			    
		}else{
		    $curphone = Phone::where('phoneable_id', $memberid)->where('is_primary','Yes')->first();
		    $phone->number = $curphone->number;
		    $phone->phone_type_id = $curphone->phone_type_id;			    
		}
		$phone->save();
		
		return Redirect::route('admin_member_user',$memberid)->with('success','User added successfully');
	    }
    }
    
    public function settings($id)
    {
	$exchangeid		= session::get('EXCHANGE_ID');
	$data['member'] 	= Member::find($id);
	
	$data['lists']		= Phone::where('phoneable_id', '=', $data['member']->id)->where('phoneable_type', '=', 'Member')->get();
	
	return view('admin.members.settings', $data);
    }
    
    public function delete_member($id)
    {
    	$member	= Member::find($id);
	$member->delete_member($id);
	Session::flash('success', "Member deleted successfully");
	return Redirect::route('admin_member');
    }
    
    public function set_tags(Request $request)
    {
	$tag_label	= $request->input('term');
	$member_id	= $request->input('member_id');
	$arr_tag	= Tag::where('name', $tag_label)->first();
	
	
	//MemberTag::where('member_id', $member_id)->delete();
	
	if(count($arr_tag) > 0) // Tag is already present
	{
	    $tag_id = $arr_tag->id;
	    
	    //insert into Member Tag Table
	    $member_tag = new MemberTag();
	    $member_tag->member_id 	= $member_id;
	    $member_tag->tag_id		= $tag_id;
	    $member_tag->save();
	    
	    /*$arr_member_tag = MemberTag::where('member_id', $member_id)->where('tag_id', $tag_id)->get();
	    if(count($arr_member_tag) != 0){
	    }*/
	}
	else
	{
	    //insert into Tag table
	    $tag = new Tag();
	    $tag->name = $tag_label;
	    $tag->save();
	    
	    //insert into Member Tag Table
	    $member_tag = new MemberTag();
	    $member_tag->member_id	= $member_id;
	    $member_tag->tag_id		= $tag->id;
	    $member_tag->save();
	}
	
    }
    
    public function remove_tags(Request $request)
    {
	$tag_label	= $request->input('term');
	$member_id	= $request->input('member_id');
	
	$arr_tag	= Tag::where('name', $tag_label)->first();
	$tag_id 	= $arr_tag->id;
	
	MemberTag::where('member_id', $member_id)->where('tag_id', $tag_id)->delete();
    }
}