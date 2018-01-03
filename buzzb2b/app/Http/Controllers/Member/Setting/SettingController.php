<?php

namespace App\Http\Controllers\Member\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member,\Auth, App\Image, Session, App\MemberUser,App\MemberCashier, App\State, App\PhoneType;
use App\Phone, App\Address, App\User,\Redirect, \File;
class SettingController extends Controller
{
    public function MemebrSettings(){
    	$member = Member::where('id',Auth::guard('admin')->user()->id)->first();
    	$image = Image::where('imageable_id',Auth::guard('admin')->user()->id)->first();
    	return view('member/setting/setting',compact('member','image'));
    }

    public function SaveLogo(Request $request,$id){
    	$this->validate($request,[
    		'member_logo'=>'required|mimes:jpg,jpeg,png',
    		]);
      $image = Image::where('imageable_id',Auth::guard('admin')->user()->id)->first();

      if(count($image)>0){

        $image_path = public_path('upload/members/'.$image->filename);
          if (File::exists($image_path)) {
           unlink($image_path);
          }

        $input = $request->all();
        $file = $request->file('member_logo');

        $extension = $file->getClientOriginalExtension();
        $image_file_name = time() . '.' . $extension;
        $save = $file->move(public_path('upload/members/'), $image_file_name);
        $image->update([
          'filename' =>$image_file_name,
          ]);
      return back()->with('success','Member Logo Updated Successfully');
      
      }else{

        $input = $request->all();
        $file = $request->file('member_logo');

        $extension = $file->getClientOriginalExtension();
        $image_file_name = time() . '.' . $extension;
        $save = $file->move(public_path('upload/members/'), $image_file_name);
        Image::create([
          'imageable_id'=>$id,
          'image_type' =>'MemberLogo',
          'filename' =>$image_file_name,
          ]);
        return back()->with('success','Member Logo Saved Successfully'); 
      }
      
    	
    }

    public function UpdateDirectorySetting(Request $request,$id){
    	$this->validate($request,[
    		'website_url'=>'required|url']
    		);
    	$input = $request->all();
    	$member = Member::where('id',$id)->first();
    	$member->update(['website_url'=>$input['website_url'],'is_active_salesperson'=>$input['is_active_salesperson']]);
    	return back()->with('success','Member Updated Successfully');
    }

    /*users setting*/
    public function UsersSettings($id){
       $exchangeid	= session::get('EXCHANGE_ID');
       $member		= Member::where('id',$id)->first();
       $users	    = MemberUser::where('user_id',$id)
                    ->join('users','member_users.member_id','=','users.id')
                    ->join('members','member_users.member_id','=','members.id')
                    ->where('exchange_id',$exchangeid)
                    ->get();
       return view('member/setting/users',compact('member','users')); 
    }

     

    public function UsersCreate($id){
       $member= Member::where('id',$id)->first();
       $exchangeid = session::get('EXCHANGE_ID');
       $state = State::pluck('abbrev','id')->prepend('Select','');
       $phone = PhoneType::pluck('name','id')->prepend('Select','');
       $defaultPhone = Phone::where('phoneable_id', $id)->where('is_primary','Yes')->first();
       $defaultAddress= Address::where('addressable_id', $id)->where('is_default','Yes')->first();
       $refsSelectionList = Member::where('exchange_id',$exchangeid)->pluck('name','id')->prepend('None','');
       $salespersonSelectionList = Member::where('exchange_id',$exchangeid)->where('is_active_salesperson',1)->pluck('name','id')->prepend('None','');
       return view('member/user/add',compact('salespersonSelectionList','member','state','phone','defaultPhone','defaultAddress','refsSelectionList'));
    }

    /*saving users save*/
    public function UsersSave(Request $request){
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
            'password' => 'required|confirmed',
            'address1' => 'required',
            'address2' => 'different:address1',
            'city' => 'required',
            'state_id' => 'not_in:0',
            'zip' => 'required|numeric',
            'phone_number' => 'required|phone',
            ],
            [
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
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password and Password Confirmation do not match',
            'password.required' => 'Please enter a Password',
            'address1.required' => 'Please enter a Street Address',
            'address2.different' => 'The Suite/Unit must be different than the street address',
            'city.required' => 'Please enter a City',
            'state_id.not_in' => 'Please select a State',
            'zip.required' => 'Please enter a Zip/Postal code',
            'zip.numeric' => 'The Zip/Postal code must be a numeric value',
            'phone_number.required' => 'Please enter a Phone Number',
            'phone_number.phone' => 'Please enter the Phone Number as all numbers, no dashes or parentheses',                   
            ]
            );
        $input = $request->all();
        $exchangeid = session::get('EXCHANGE_ID');
        $userexist = User::where('email', $input['email'])->first();
        if($input['create_new_user']==1){
            if($userexist){
            return back()->with('error','The user email already exist');
        }else{
        $user = User::create([
               'email'=>$input['email'],
               'password'=>$input['password'],
               'first_name'=>$input['firstname'],
               'last_name'=>$input['lastname'],
            ]);
         if($user){
            $insert              = new Member();
            $insert->exchange_id = $exchangeid;
            $insert->slug = '';
            $insert->name = $request->name;
            $insert->business_1099_name = $request->business_1099_name;
            $insert->tax_id_number = $request->tax_id_number;
            $insert->website_url = $request->website;
            $insert->ex_purchase_comm_rate = $request->ex_purchase_comm_rate;
            $insert->ex_sale_comm_rate = $request->ex_sale_comm_rate*100;
            $insert->giftcard_comm_rate = $request->giftcard_comm_rate*100;
            $insert->credit_limit = $request->credit_limit*100;
            $insert->accept_giftcards = $request->will_accept_gcs;
            $insert->prospect = $request->is_prospect;
            $insert->is_active_salesperson = ($request->is_active_salesperson)? $request->is_active_salesperson: 0;
            //$insert->password_confirmation = $request->password_confirmation;
            $insert->description = $request->description;
            $insert->view_on_dir = $request->view_on_dir;
            $insert->ref_member_id = ($request->ref_member_id) ? $request->ref_member_id : 0;
            $insert->ref_purchase_comm_rate = $request->ref_purchase_comm_rate*100;
            $insert->ref_sale_comm_rate = $request->ref_sale_comm_rate*100;
            $insert->salesperson_member_id = ($request->salesperson_member_id) ? $request->salesperson_member_id : 0;
            $insert->sales_purchase_comm_rate = $request->sales_purchase_comm_rate;
            $insert->sales_sale_comm_rate = $request->sales_sale_comm_rate;
            $insert->save();


            $memberuser = new MemberUser();
            $memberuser->member_id = $user->id;
            $memberuser->user_id = $insert->id;
            $memberuser->save();


            $address = new Address();
            $address->addressable_id = $user->id;
            $address->addressable_type = 'Member';
            $address->address1 = $request->address1;
            $address->address2 = $request->address2;
            $address->city = $request->city;
            $address->state_id = $request->state_id;
            $address->zip = $request->zip;


            $address->save();

            $phone = new Phone();
            $phone->phoneable_id = $user->id;
            $phone->phoneable_type = 'Member';
            $phone->number = $request->phone_number;
            $phone->phone_type_id = $request->phone_type_id;    

            $isprimaryphone = Phone::where('phoneable_id', $insert->id)->where('is_primary', 'Yes')->first();
            if(!$isprimaryphone){
                $phone->is_primary = 'Yes';
            }else{
                $phone->is_primary = 'No';
            }   

            $phone->save();
        
        }
        return back()->with('success','The user Created Successfully');
        }
        }else{
            if(!$userexist){
            return Redirect::back()->with('error','Sorry! The user email is not exist in our database')->withInput();
            }else{
            $user = $userexist;
            }

        }
        
    }

    public function UsersEdit($id){
        $details= Member::where('members.id',$id)
                ->join('users','members.id','=','users.id')->first();
        $member = User::where('id',Auth::guard('admin')->user()->id)->first();
        $member_user = MemberUser::where('member_id',$id)->first();
        return view('member.members.member_user_edit',compact('member','details','member_user'));
    }


    public function UsersPhone($id){
        $member = User::where('id',$id)->first();
        $exchangeid  = session::get('EXCHANGE_ID');
        $phones = User::where('users.id',$id)
                  ->join('member_users','users.id','=','member_users.user_id')
                  ->join('members','member_users.member_id','members.id')
                  ->join('phones','members.id','=','phones.phoneable_id')
                  ->where('members.exchange_id',$exchangeid)
                  ->where('phones.phoneable_type','Member')
                  ->get();
        return view('member/setting/phone',compact('member','phones'));
    }

    public function CreatePhone($id){
     $member = User::where('id',$id)->first();
     $exchangeid  = session::get('EXCHANGE_ID');
     $users  = MemberUser::where('user_id',$id)
            ->join('users','member_users.member_id','=','users.id')
            ->join('members','member_users.member_id','=','members.id')
            ->where('exchange_id',$exchangeid)
            ->first();
     if(count($users)>0){
        return view('member/setting/add-phone',compact('member'));
     }else{
      return back()->with('error','Create a user');  
     }
     
    }

    public function SavePhone(Request $request){
        $this->validate($request,[
            'phone_number'=>'required|numeric|min:10',
            ]);
        $input = $request->all();
        $exchangeid  = session::get('EXCHANGE_ID');
        $users = User::where('users.id', $input['user_id'])
               ->join('member_users','users.id','=','member_users.user_id')
               ->join('members','member_users.member_id','members.id')
               ->where('members.exchange_id',$exchangeid)
               ->get();
        if (count($users)>0) {
            foreach ($users as $key => $user) {
                $is_primary = Phone::where('phoneable_id',$user->member_id)->get();
                $primary_phone = 'Yes';
                foreach ($is_primary as $key => $primary) {
                     if ($primary->is_primary == 'Yes') {
                         $primary_phone = 'No';
                     }
                 } 
                Phone::create([
                'phoneable_id'=>$user->member_id,
                'phone_type_id'=>$input['phone_type'],
                'phoneable_type'=>'Member',
                'number'=>$input['phone_number'],
                'is_primary'=>$primary_phone ,
                ]);
                return back()->with('success','New Phone Added');
            }
        }else{
            return back()->with('error','create a new user');
        }
    }

    public function DeletePhone($id){
        Phone::where('id',$id)->delete();
        return back()->with('success', 'Phone Deleted Successfully');
    }

    /*members adderss setting*/
    public function UsersAddress($id){
        $exchangeid  = session::get('EXCHANGE_ID');
        $member      = User::where('id',$id)->first();

        $addresses = User::where('users.id',$id)
                  ->join('member_users','users.id','=','member_users.user_id')
                  ->join('members','member_users.member_id','members.id')
                  ->join('addresses','members.id','=','addresses.addressable_id')
                  ->where('members.exchange_id',$exchangeid)
                  ->where('addresses.addressable_type','Member')
                  ->get();
        return view('member/setting/addresses',compact('member','users','addresses')); 
    }

    public function DeleteAddress($id){
        Address::where('id',$id)->delete();
        return back()->with('success','Address Deleted Successfully');

    }

    public function CreateAddress($id){
     $state  = State::pluck('name','id');
     $member = User::where('id',$id)->first();
     $exchangeid  = session::get('EXCHANGE_ID');
     $users  = MemberUser::where('user_id',$id)
            ->join('users','member_users.member_id','=','users.id')
            ->join('members','member_users.member_id','=','members.id')
            ->where('exchange_id',$exchangeid)
            ->first();
     if(count($users)>0){
        return view('/member/setting/add-address',compact('state','member'));
     }else{
      return back()->with('error','Create a user');  
     }
     
    }

    public function SaveAddress(Request $request){
        $this->validate($request,[
               'address1'    => 'required',
               'city'    => 'required',
               'zip'     => 'required'
         ],
         [
          'address1.required'=>'The Street Address Field is required',
          'address2.different' => 'The Suite/Unit must be different than the street address',
          'city.required_if' => 'Please enter a City',
          'zip.required_if' => 'Please enter a Zip/Postal code',
          'zip.numeric' => 'The Zip/Postal code must be a numeric value',                
         ]);
        $input = $request->all();
        if($input['address2']==''){
            $address2 ='';
        }else{
            $address2 =$input['address2'];
        }
        $exchangeid  = session::get('EXCHANGE_ID');
        $users = User::where('users.id', $input['user_id'])
               ->join('member_users','users.id','=','member_users.user_id')
               ->join('members','member_users.member_id','members.id')
               ->where('members.exchange_id',$exchangeid)
               ->get();
            foreach ($users as $key => $user) {
                $default_address = Address::where('addressable_id',$user->member_id)->get();
                $address='Yes';
                foreach ($default_address as $key => $address) {
                    if($address->is_default == 'Yes'){
                        $address = 'No';
                    }else{
                      $address = $input['is_default'];
                    }
                }
            Address::create([
                'addressable_id'=>$user->member_id,
                'addressable_type'=>'Member',
                'address1'=>$input['address1'],
                'address2'=>$address2,
                'city'=>$input['city'],
                'state_id'=>$input['state'],
                'zip'=>$input['zip'],
                'is_default'=>$address,
                ]);
            return back()->with('success','New Address Added');
        }

    }

    /*cashiers section start*/
    public function ListCashiers($id){
      $member = User::where('id',$id)->first();
      $cashiers = MemberCashier::orderBy('member_cashiers.created_at','DESC')
                ->where('user_id',$id)
                ->leftjoin('users','member_cashiers.member_id','=','users.id')
                ->get();
      return view('member.setting.cashiers',compact('member','cashiers'));
    }
    /*view of creating cashiers*/
    public function CreateCashiers($id){
        $member = User::where('id',$id)->first();
        $exchangeid  = session::get('EXCHANGE_ID');
        $member_users  = MemberUser::where('member_users.user_id',$id)
            ->join('users','member_users.member_id','=','users.id')
            ->join('members','member_users.member_id','=','members.id')
            ->where('exchange_id',$exchangeid)
            ->get();
        $cashiers = MemberCashier::select('member_id')->where('user_id',$id)->get()->toArray();
        return view('member.setting.add-cashier',compact('member','member_users','cashiers'));
    }

      public function SaveCashiers(Request $request){
      $input = $request->all();
      if(!empty($input['member_id'])){
        $member =User::where('id',$input['user_id'])->first();
        $data = MemberCashier::where('member_id',$input['member_id'])->onlyTrashed()->first();
        /*if already in database in trashed mode*/
        if(count($data)>0){
        $data->restore();
        return redirect()->route('users-cashiers', [$member->id]);
        }
         /*if not available in database */
         if (!empty($input['member_id'])) {
          MemberCashier::create([
            'member_id'=>$input['member_id'],
            'user_id'=>$input['user_id'],
             'nickname'=>'',
          ]);
         return redirect()->route('users-cashiers', [$member->id])->with('success','User is now as cashier ');
        }
      }else{
        $this->validate($request,[
          'nickname'=>'required'
          ]);
      /*making cashier uisng nickname user is not a member list*/
      if(!empty($input['nickname'])){
        MemberCashier::create([
          'member_id'=>'',
          'user_id'=>$input['user_id'],
           'nickname'=>$input['nickname'],
        ]);
        return back()->with('success','Cashier has been added. ');
      }
    }
      
    }

    /*deattach method*/
    public function DeleteCashier(Request $request){
      $input = $request->all();
      MemberCashier::where('member_id',$input['member_id'])->delete();
      return back()->with('success','Cashier has been removed Successfully. ');
    }
}
