<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User, App\Role, App\Exchange;
use App\Member, App\State, App\PhoneType, App\MemberUser, App\Address, App\Phone, App\Role_user;
use \Session, \Validator,\Redirect, \Hash, \Auth, \Image, App\LedgerDetails;
use Mailchimp;

class MemberController extends Controller
{
    public function lists(Request $request){
	  $exchangeid	= session::get('EXCHANGE_ID');
	  $arr_member_id	= MemberUser::select('member_id')->where('user_id', Session::get('ADMIN_ACCESS_ID'))->first();
	    $member_id 	= $arr_member_id['member_id'];
      
	
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
            $data['lists'] = Member::where('exchange_id',$exchangeid)->where('id', '!=', $member_id)->where('deleted_at', NULL)->paginate(10);

            foreach ($data['lists'] as $key => $value) {
                //getting barter balance
            	$barter = LedgerDetails::where('member_id',$value->id)
            	         ->where('account_code',4020)->orWhere('account_code',4080)->sum('amount');
            	$data['lists'][$key]->barter = $barter;

            	//cba balance
            	$cba = LedgerDetails::where('member_id',$value->id)
            	      ->where('account_code',7040)->orWhere('account_code',3020)
            	      ->orWhere('account_code',4040)->sum('amount');
            	$data['lists'][$key]->cba = $cba;

              $member = MemberUser::where('member_id',$value->id)->first();
              $data['lists'][$key]->admin = $member['admin'];
        	}

        }
        return view('admin.members.list',$data);
    }
    
    public function create(){
	
	//$input['firstname'] = 'abc';$input['lastname']  = 'xyz';echo $member_slug = str_slug($input['firstname'].' '.$input['lastname']);exit();
	
	$exchangeid = session::get('EXCHANGE_ID');
        $data = array();
    	$data['refsSelectionList'] = Member::where('exchange_id',$exchangeid)->pluck('name','id')->prepend('None','');
    	$data['salespersonSelectionList'] = Member::where('exchange_id',$exchangeid)->where('is_active_salesperson',1)->pluck('name','id')->prepend('None','');
    	$data['stateSelectionList'] = State::pluck('abbrev','id')->prepend('Select','');
    	$data['phonetypeSelectionList'] = PhoneType::pluck('name','id');
            return view('admin.members.add',$data);
    }

    public function store(Request $request){

    $this->validate($request,[
          'name' => 'required',
          'business_1099_name' => 'required',
          'tax_id_number' => 'required',
          'website' => 'url',
          'ex_purchase_comm_rate' => 'numeric',
          'ex_sale_comm_rate' => 'numeric',
          'ref_purchase_comm_rate' => 'required_with:ref_member_id',
          'ref_sale_comm_rate' => 'required_with:ref_member_id',
          'sales_purchase_comm_rate' => 'required_with:salesperson_member_id',
          'sales_sale_comm_rate' => 'required_with:salesperson_member_id',
          'giftcard_comm_rate' => 'numeric',
          'credit_limit' => 'numeric',
          'email' => 'email|required',
          'firstname' => 'required_if:create_new_user,1',
          'lastname' => 'required_if:create_new_user,1',
          'password' => 'required_if:create_new_user,1',
          'address1' => 'required',
          'address2' => 'different:address1',
          'city' => 'required',
          'state_id' => 'required',
          'zip' => 'required|numeric',
          'phone_number' => 'required|phone',
           ],
           [ 
            'state_id.required' => 'Please Select a state',
          'name.required' => 'Please enter a Name',
          'business_1099_name.required' => 'Please enter a Business 1099 Name',
          'tax_id_number.required' => 'Please enter a Tax ID Number',
          'website.url' => 'Website must be in form of "http://example.com"',
          'ex_purchase_comm_rate.numeric' => 'The Exchange Member Purchase Commission Rate must be a numeric value',
          'ex_sale_comm_rate.numeric' => 'The Exchange Member Sale Commission Rate must be a numeric value',
          'ref_purchase_comm_rate.required_with' => 'Please enter a Referrer Member Purchase Commission Rate',
          'ref_sale_comm_rate.required_with' => 'Please enter a Referrer Member Sale Commission Rate',
          'sales_purchase_comm_rate.required_with' => 'Please enter a Salesperson Member Purchase Commission Rate',
          'sales_sale_comm_rate.required_with' => 'Please enter a Salesperson Member Sale Commission Rate',
          'giftcard_comm_rate.required' => 'Please enter a Giftcard Sale Commission Rate',
          'giftcard_comm_rate.numeric' => 'The Giftcard Sale Commission Rate must be a numeric value',
          'credit_limit.numeric' => 'The Beginning Credit Limit must be a numeric value',
          'email.email' => 'Email must be a proper email address',
          'email.required_with' => 'Please enter a valid Email address',
          'firstname.required_if' => 'Please enter a valid First Name',
          'lastname.required_if' => 'Please enter a valid Last Name',
          'password.min' => 'Password must be at least 6 characters',
          'password.confirmed' => 'Password and Password Confirmation do not match',
          'password.required' => 'Please enter a Password',
          'address1.required' => 'Please enter a Street Address',
          'address2.different' => 'The Suite/Unit must be different than the street address',
          'city.required' => 'Please enter a City',
          'state_id.not_in' => 'Please select a State',
          'zip.required' => 'Please enter a Zip/Postal code',
          'zip.numeric' => 'The Zip/Postal code must be a numeric value',
          'display_phone_number.required' => 'Please enter a Primary Contact Number',
          'display_phone_number.phone' => 'Please enter the Phone Number as all numbers, no dashes or parentheses',           
           ]);	
      
     //echo $exchangeid; die();
	  $input = $request->all();

    // Unsetting this field because, "display_phone_number" is used to masking phone number
    unset($input['display_phone_number']);

    $exchangeid = session::get('EXCHANGE_ID');
	  if (!empty($input['website_url'])) {
	  	$web = $input['website_url'];
	  }else{
	  	$web = 'N/A';
	  }
	  if (!empty($input['accept_giftcards'])) {
	  	$gift = $input['accept_giftcards'];
	  }else{
	  	$gift = 'N/A';
	  }
	  if (!empty($input['prospect'])) {
	  	$prospect = $input['prospect'];
	  }else{
	  	$prospect = 'N/A';
	  }
	  if (!empty($input['is_active_salesperson'])) {
	  	$sales = $input['is_active_salesperson'];
	  }else{
	  	$sales = 'N/A';
	  }
	  if (!empty($input['view_on_dir'])) {
	  	$dir = $input['view_on_dir'];
	  }else{
	  	$dir = 0;
	  }
	  //echo "<pre>"; print_r($input); die();
	  
	  /*creating new user*/
	  if ($input['create_new_user']==1) {
          Mailchimp::subscribe( 'd4b79e20a4',request()->input('email'),[], false);
          
          $user = User::where('email',$input['email'])->first();
           /*if user is exists by this mail*/
           if(count($user)>0){
             return Redirect::back()->with('error','The user email already exist');
           }else{/*if user is not  exists using this mail*/

            $is_admin = 0;
            if(isset($input['is_admin']) && $input['is_admin'] != '')
            {
              $is_admin = 1;
            }

           	  $save = User::create([
                 'first_name'=>$input['firstname'],
                 'last_name'=>$input['lastname'],
                 'email'=>$input['email'],
                 'password'=>$input['password'],
                 'is_admin'=>$is_admin
           	  	]);
            }
		  
		  $member_slug 		= str_slug($input['firstname'].' '.$input['lastname']);
		  $member_new_slug 	= '';
		  $member_slug_count 	= Member::where('slug', $member_slug)->count();
		  if($member_slug_count>0)
		  {
		    $member_new_slug = $member_slug.'-'.($member_slug_count+1);
		  }
		  

           	  $member = Member::create([
                  'exchange_id'=>$exchangeid,
                  'slug'=>$member_new_slug,
                  'name'=> $input['firstname'].' '.$input['lastname'],
                  'business_1099_name'=>$input['business_1099_name'],
                  'tax_id_number'=>$input['tax_id_number'],
                  'website_url'=>$web,
                  'ex_purchase_comm_rate'=>$input['ex_purchase_comm_rate'],
                  'ex_sale_comm_rate'=>$input['ex_sale_comm_rate']*100,
                  'giftcard_comm_rate'=>$input['giftcard_comm_rate']*100,
                  'credit_limit'=>$input['credit_limit']*100,
                  'accept_giftcards'=>$gift,
                  'prospect'=>$prospect,
                  'is_active_salesperson'=>$sales,
                  'description'=>$input['description'],
                  'view_on_dir'=>$dir,
                  'ref_member_id'=>$input['ref_member_id'],
                  'ref_purchase_comm_rate'=>$input['ref_purchase_comm_rate'],
                  'ref_sale_comm_rate' =>$input['ref_sale_comm_rate'],
                  'salesperson_member_id'=>$input['salesperson_member_id'],
                  'sales_purchase_comm_rate'=>$input['sales_purchase_comm_rate'],
                  'sales_sale_comm_rate'=>$input['sales_sale_comm_rate']
           	    ]);
	            MemberUser::create([
				   'member_id'=>$member->id,//this is member table increament id
				   'user_id'=>$save->id, //this is the user table id of created member
           'admin'=> $is_admin
				]);
                
				Address::create([
                    'addressable_id'=>$member->id,
                    'addressable_type'=>'Member',
                    'address1'=>$input['address1'],
                    'address2'=>$input['address2'],
                    'city'=>$input['city'],
                    'state_id'=>$input['state_id'],
                    'zip'=>$input['zip']
					]);
				$default = Address::where('addressable_id', $member->id)->where('is_default', 'Yes')->first();
				if (count($default)>0) {
					$default->update([
                      'is_default'=>'No',
				    ]);
				}

				/*phone*/
				Phone::create([
                'phoneable_id' => $member->id,
		        'phoneable_type' => 'Member',
		        'number' => $input['phone_number'],
		        'phone_type_id' =>$input['phone_type_id'],
				]);
				$primary = Phone::where('phoneable_id', $member->id)->where('is_primary', 'Yes')->first();
				if (count($primary)>0) {
					$primary->update([
                      'is_primary'=>'No',
				    ]);
				}
                /*assigning role to this member*/
				Role_user::create([
                  'user_id'=>$save->id,
                  'role_id'=>2,
			  ]);
       }
       return Redirect::route('admin_member')->with('success','Member added successfully');
	  
      /*creating existing  user*/
	  if ($input['create_new_user']==2) {
	  	$user = User::where('email',$input['email'])->first();
	  	if (count($user)>0) {
	  		$member = Member::create([
                  'exchange_id'=>$exchangeid,
                  'slug'=>'',
                  'name'=> $input['name'],
                  'business_1099_name'=>$input['business_1099_name'],
                  'tax_id_number'=>$input['tax_id_number'],
                  'website_url'=>$web,
                  'ex_purchase_comm_rate'=>$input['ex_purchase_comm_rate'],
                  'ex_sale_comm_rate'=>$input['ex_sale_comm_rate']*100,
                  'giftcard_comm_rate'=>$input['giftcard_comm_rate']*100,
                  'credit_limit'=>$input['credit_limit']*100,
                  'accept_giftcards'=>$gift,
                  'prospect'=>$prospect,
                  'is_active_salesperson'=>$sales,
                  'description'=>$input['description'],
                  'view_on_dir'=>$dir,
                  'ref_member_id'=>$input['ref_member_id'],
                  'ref_purchase_comm_rate'=>$input['ref_purchase_comm_rate'],
                  'ref_sale_comm_rate' =>$input['ref_sale_comm_rate'],
                  'salesperson_member_id'=>$input['salesperson_member_id'],
                  'sales_purchase_comm_rate'=>$input['sales_purchase_comm_rate'],
                  'sales_sale_comm_rate'=>$input['sales_sale_comm_rate']
           	    ]);

	  		MemberUser::create([
				   'member_id'=>$member->id,//this is member table increament id
				   'user_id'=>$user->id, //this is the user table id of created member
				]);

	  		Address::create([
                    'addressable_id'=>$member->id,
                    'addressable_type'=>'Member',
                    'address1'=>$input['address1'],
                    'address2'=>$input['address2'],
                    'city'=>$input['city'],
                    'state_id'=>$input['state_id'],
                    'zip'=>$input['zip']
					]);
				$default = Address::where('addressable_id', $member->id)->where('is_default', 'Yes')->first();
				if (count($default)>0) {
					$default->update([
                      'is_default'=>'No',
				    ]);
				}

			/*phone*/
				Phone::create([
                'phoneable_id' => $member->id,
		        'phoneable_type' => 'Member',
		        'number' => $input['phone_number'],
		        'phone_type_id' =>$input['phone_type_id'],
				]);
				$primary = Phone::where('phoneable_id', $member->id)->where('is_primary', 'Yes')->first();
				if (count($primary)>0) {
					$primary->update([
                      'is_primary'=>'No',
				    ]);
				}

        return Redirect::route('admin_member')->with('success','Member added successfully');
	  	}
	  	return Redirect::back()->with('error','Sorry! The user email is not exist in our database');
	  }
	 
      
    }
    /*end member create*/
    public function edit($id){
        $data['details'] = Exchange::find($id);
        return view('admin.members.edit',$data);
    }
    public function update(Request $request,$id){
            $validator = Validator::make(
			  $request->all(),[
                'city_name'=> 'required|unique:exchanges,city_name,'.$id,
                'name'=> 'required|unique:exchanges,name,'.$id
			   ]);
	    
	    if ($validator->fails()){
		    $messages = $validator->messages();
		    return Redirect::back()->withErrors($validator->errors())->withInput();
	    }else{
	          $update  = Exchange::find($id);
            $update->name = $request->name;
            $update->city_name = $request->city_name;
            $update->domain = strtolower($request->name);
            $update->save();
            return Redirect::route('admin_member')->with('success','Exchange updated successfully');
	    }
            
	}
	
    
    public function change_status(Request $request)
    {
	$id  = $request->id;
	$rec = Exchange::find($id);
	if(count($rec)>0)
	{
		$status = $rec->status;
		if($status=='Active'){
		    $rec->status = 'Inactive';
		}
		else if($status=='Inactive'){
		    $rec->status = 'Active';
		}
		$rec->save();
		return Redirect::route('admin_member')->with('success','Exchange status updated successfully');
	}
    }

    public function delete(Request $request){
	$id = $request->id;
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