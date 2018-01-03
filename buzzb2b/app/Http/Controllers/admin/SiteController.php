<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User, App\Role, App\Role_user, App\Exchange, App\Member, App\State, App\Address, App\Phone, App\ExchangeUser, App\PhoneType;
use \Session, \Validator,\Redirect, \Hash, \Auth, \Image;

class SiteController extends Controller
{
    public function financial()
    {
	$data			= array();
	$exchange_id		= Session::get('EXCHANGE_ID');
	$exchange_data 		= Exchange::find($exchange_id);
	$data['exchange_data']	= $exchange_data;

	
	$data['minimum_cba_deposite']			= $data['exchange_data']->ex_default_min_cra_deposit/100;
	$data['member_purchase_fee']			= $data['exchange_data']->member_purchase_comm_rate/100;
	$data['member_sale_fee']			= $data['exchange_data']->member_sale_comm_rate/100;
	$data['member_referral_purchase_commission']	= $data['exchange_data']->member_ref_purchase_comm_rate/100;
	$data['member_referral_sale_commission']	= $data['exchange_data']->member_ref_sale_comm_rate/100;
	$data['member_salesperson_purchase_commission']	= $data['exchange_data']->member_salesperson_purchase_comm_rate/100;
	$data['member_salesperson_sale_commission']	= $data['exchange_data']->member_salesperson_sale_comm_rate/100;
	$data['default_giftcard_commission_rate']	= $data['exchange_data']->ex_default_giftcard_comm_rate/100;

	$data['exchange_uses_gift_cards']		= false;
	if($data['exchange_data']->ex_default_use_giftcards == 1)
	{
	    $data['exchange_uses_gift_cards']		= true;
	}
	
	$data['new_member_acdept_gift_cards']		= false;
	if($data['exchange_data']->ex_default_member_accept_giftcards == 1)
	{
	    $data['new_member_acdept_gift_cards']	= true;
	}
	
        return view('admin.site.index',$data);
    }
    
    public function financial_store(Request $request)
    {
	$validator = Validator::make(
				  $request->all(),[
				    'minimum_cba_deposite'=> 'required',
                    'member_purchase_fee'=> 'required',
				    'member_sale_fee'=> 'required',
				    'member_referral_purchase_commission'=> 'required',
                    'member_referral_sale_commission'=> 'required',
				    'member_salesperson_purchase_commission'=> 'required',
                     'member_salesperson_sale_commission'=> 'required',
				    'default_giftcard_commission_rate'=> 'required'
				   ]);
	if ($validator->fails()){
		$messages = $validator->messages();
		return Redirect::back()->withErrors($validator->errors())->withInput();
	}else{
	    
	    $exchange = Exchange::find(Session::get('EXCHANGE_ID'));
	    
	    $exchange->member_purchase_comm_rate   = $request->member_purchase_fee*100;
	    $exchange->member_ref_purchase_comm_rate = $request->member_referral_purchase_commission*100;
	    $exchange->ex_default_use_giftcards           	= $request->exchange_uses_gift_cards;
	    $exchange->ex_default_giftcard_comm_rate      	= $request->default_giftcard_commission_rate*100;
	    $exchange->ex_default_member_accept_giftcards 	= $request->new_member_acdept_gift_cards;
	    $exchange->ex_default_min_cra_deposit         	= $request->minimum_cba_deposite*100;
	    
	    $exchange->member_sale_comm_rate         		= $request->member_sale_fee*100;
	    $exchange->member_ref_sale_comm_rate         	= $request->member_referral_sale_commission*100;
	    $exchange->member_salesperson_purchase_comm_rate	= $request->member_salesperson_purchase_commission*100;
	    $exchange->member_salesperson_sale_comm_rate	= $request->member_salesperson_sale_commission*100;
	    $exchange->save();
	    return Redirect::route('admin_setting_finance')->with('success','Exchange financial details updated.');
	    
	}
	
    }
    
    public function address(){
	$data		= array();
	$exchange_id	= Session::get('EXCHANGE_ID');
	$data['lists']  = Address::where('addressable_id', '=', $exchange_id)->where('addressable_type', '=', 'Exchange')->get();
	return view('admin.site.address', $data);
    }
    
    public function address_create()
    {
        $data['state'] = State::pluck('name','id');
        return view('admin.site.add_address', $data);
    }
    
    public function address_store(Request $request)
    {
	$validator = Validator::make(
					$request->all(),[
					  'address1'=> 'required',
					  'city'=> 'required',
					  'zip'=> 'required'
					 ]);
	
	if ($validator->fails())
	{
	    $messages = $validator->messages();
	    return Redirect::back()->withErrors($validator->errors())->withInput();
	}
	else
	{
	    $exchange_address = new Address();
	    $exchange_address->addressable_id  = Session::get('EXCHANGE_ID');
	    $exchange_address->addressable_type	= 'Exchange';
	    $exchange_address->address1		= $request->address1;
	    $exchange_address->address2		= $request->address2;
	    $exchange_address->city		= $request->city;
	    $exchange_address->state_id		= $request->state;
	    $exchange_address->zip		= $request->zip;
	    
	    if($request->is_default == 'Yes')
            {
                Address::where('addressable_id', '=', Session::get('EXCHANGE_ID'))->where('addressable_type', '=', 'Exchange')->update(array('is_default' => 'No'));
            }
	    
	    $exchange_address->is_default	= $request->is_default;
	    
	    $exchange_address->save();
	    
	    return Redirect::route('admin_setting_address')->with('success','Address added successfully');
	}
    }
    
    public function phone()
    {
	$data		= array();
	$exchange_id	= Session::get('EXCHANGE_ID');
	
	$data['lists']  = Phone::where('phoneable_id', '=', $exchange_id)->where('phoneable_type', '=', 'Exchange')->get();
	return view('admin.site.phone', $data);
    }
    
    public function phone_create()
    {
        $data['state'] = State::pluck('name','id');
        return view('admin.site.add_phone', $data);
    }
    
    public function phone_store(Request $request)
    {
	$validator = Validator::make($request->all(),[
			  'phone_number'	=> 'required|integer|min:10|digits_between:1,10',
			  'phone_type'		=> 'required'
			 ]);
	
	if ($validator->fails())
	{
	    $messages = $validator->messages();
	    return Redirect::back()->withErrors($validator->errors())->withInput();
	}
	else
	{
	    $exchange_phone			= new Phone();
	    $exchange_phone->phoneable_id 		= Session::get('EXCHANGE_ID');
	    $exchange_phone->phoneable_type		= 'Exchange';
	    $exchange_phone->phone_type_id	= $request->phone_type;
	    $exchange_phone->number		= $request->phone_number;
	    $exchange_phone->is_primary		= 'No';
	    $exchange_phone->save();
	    
	    return Redirect::route('admin_setting_phone')->with('success','Phone added successfully');
	}
    }
    
    public function lists(Request $request)
    {
        $data['keyword']        = '';
        if($request->keyword !=''){
            $data['keyword']            = $request->keyword;
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
    
    
    public function store(Request $request){

      $validator = Validator::make($request->all(),[
				    'city_name'=> 'required|unique:exchanges,city_name',
                    'name'=> 'required|unique:exchanges,name'
				   ]);
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
	
    public function staffs(){
	$data		= array();
	$exchange_id	= Session::get('EXCHANGE_ID');
	
	$data['lists']  = ExchangeUser::where('exchange_id', '=', $exchange_id)->get();
	return view('admin.site.staffs', $data);	
    }
    
    public function staff_create(Request $request){
	$data = array();
	$data['stateSelectionList'] = State::pluck('abbrev','id')->prepend('Select','');
	$data['phonetypeSelectionList'] = PhoneType::pluck('name','id');
	return view('admin.site.add_staff', $data);
    }
    
    public function staff_store(Request $request){
      $exchangeid = session::get('EXCHANGE_ID');
      $validator = Validator::make(
				  $request->all(),
				   [
					'email' => 'required|email',
					'firstname' => 'required',
					'lastname' => 'required',
					'password' => 'required_if:generate_pw,""|confirmed',
			
					'address1' => 'required_if:create_new_address,1',
					'address2' => 'different:address1',
					'city' => 'required_if:create_new_address,1',
					'state_id' => 'required_if:create_new_address,1|sometimes|not_in:0',
					'zip' => 'required_if:create_new_address,1|numeric',
			
					'phone_number' => 'required_if:create_new_phone,1|phone',
				   ],
				   [
					'email.required' => 'Please enter a valid Email address',
					'email.email' => 'Email must be a proper email address',
					'firstname.required' => 'Please enter a valid First Name',
					'lastname.required' => 'Please enter a valid Last Name',
					'password.required_if' => 'Please enter a Password',
					'password.confirmed' => 'Password and Password Confirmation do not match',
			
					'address1.required_if' => 'Please enter a Street Address',
					'address2.different' => 'The Suite/Unit must be different than the street address',
					'city.required_if' => 'Please enter a City',
					'state_id.required_if' => 'Please select a State',
					'state_id.not_in' => 'Please select a State',
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
		
		$user = User::where('email',$request->email)->first();
		if (count($user) == 0) {
             if(!empty($request->admin)){
             	$admin=1;
             }else{
             	$admin=0;
             } 	
             	    /*** First User Create ***/
		    $user = new User();
		    $user->email = $request->email;
		    $user->first_name = $request->firstname;
		    $user->last_name = $request->lastname;
		    $user->is_admin = $admin;
		    if($request->generate_pw==1){
			$randpass = substr($request->firstname,0,3).mt_rand(100,999);
			$user->password = $randpass;
		    }else{
			$user->password = $request->password;
		    }
		    $user->save();
			
		    /*** First Exchange User Create ***/
		    $insert  = new ExchangeUser();
		    $insert->exchange_id = $exchangeid;
		    $insert->user_id = $user->id;
		    $insert->is_exchange_admin = $request->admin;
		    $insert->save();
		    
		    /*** assigning role for this user ***/
		    Role_user::create([
				   'user_id'	=> $user->id,
				   'role_id'	=> 4 	
				   ]);
		    
		    if($request->create_new_address==1){
			$address = new Address();
			$address->addressable_id = $user->id;
			$address->addressable_type = 'User';
			$address->address1 = $request->address1;
			$address->address2 = $request->address2;
			$address->city = $request->city;
			$address->state_id = $request->state_id;
			$address->zip = $request->zip;
			$address->save();		    
		    }
    
		    if($request->create_new_phone==1){
			$phone = new Phone();
			$phone->phoneable_id = $user->id;
			$phone->phoneable_type = 'User';
			$phone->number = $request->phone_number;
			$phone->phone_type_id = $request->phone_type_id;		
			$phone->save();		    
		    }
		}
		else
		{
		    return Redirect::back()->with('error','Sorry! The email is exist in our database');
		}

	    return Redirect::route('admin_setting_staffs')->with('success','Staff added successfully');
                
            }
    }

    public function staff_edit(Request $request){
      $exchangeid = session::get('EXCHANGE_ID');
      $userid = $request->route('id');
      $data['details']  = ExchangeUser::where('user_id', '=', $userid)->first();
      return view('admin.site.edit_staff', $data);  
    }
    
    public function staff_update(Request $request,$id){
	    $update               = ExchangeUser::where('user_id',$id)->first();
	    $update->primary = ($request->primary)? 1:0;
	    $update->is_exchange_admin = ($request->admin)? 1:0;
	    $update->is_salesperson = ($request->is_salesperson)? 1:0;
	    $update->is_member_admin = ($request->is_member_admin)? 1:0;
	    $update->can_view_accounting = ($request->can_view_accounting)? 1:0;
	    $update->save();
	    
	    return Redirect::route('admin_setting_staffs')->with('success','Staff updated successfully');

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
    
    public function delete_staff($id)
    {
    	
	$echange_user	= ExchangeUser::find($id);
	User::where('id',$echange_user->user_id)->delete();
	$echange_user->delete();
	Session::flash('success', "Staff has been deleted successfully");
	return Redirect::route('admin_setting_staffs');
    }
}
