<?php

namespace App\Http\Controllers\User_Member\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User, \Auth,\Hash,\Redirect, App\Image, App\State, App\Address, App\Phone;
class MyAccountController extends Controller
{
    public function ViewAccount(){
        // $user = User::where('id',Auth::user()->id)->first();
    	$user = Auth::user();
        // dd($user);
    	return view('user_member.user.my-account.view-account',compact('user'));
    }

    public function ProfileImage(Request $request){
    	$this->validate($request,[
    	  'image'=>'required|mimes:jpg,jpeg,png',
    	]);
    	$user = User::where('id',Auth::user()->id)->first();
    	$file = $request->file('image');
    	$upload  = Image::UploadImage($file,$user);
    	return back()->with('success','Profile Image Upadated Successfully');
    }

    /*edit details*/
    public function EditDetails(){
        $user = User::where('id',Auth::user()->id)->first();
        return view('user_member.user.my-account.edit-details',compact('user'));
    }

    public function UpdateDetails(Request $request){
        $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required'
        ]);
        $input = $request->input();
        $user = User::where('id',Auth::user()->id)->first();
        if ($user) {
            $user->update(['first_name'=>$input['first_name'],'last_name'=>$input['last_name']]);
        }
        return back()->with('success','Profile Upadated Successfully');
    }

    public function ChangePassword(){
       return view('user_member.user.my-account.change-password');
    }

    public function UpdatePassword(Request $request){
        $this->validate($request,[
            'old_password'      => 'required|min:6',
            'new_password'      => 'required',
        ]);
        $input = $request->input();
        if($input['new_password']==$input['confirm_password']){
            $user = User::where('id',Auth::user()->id)->first();
            if( Hash::check($input['old_password'],$user->password) ){
                $user->update(['password'=>$input['new_password']]);
            }
            return back()->with('success','Password Changed Successfully.');
        }
       return back()->with('error','Confirm Password Not Matched.');
    }


    public function AddressList(){
        $address = Address::where('addressable_id',Auth::user()->id)->get();
        return view('user_member.user.my-account.view-address',compact('address'));
    }
    /*
    address default
    */
    public function DefaultAddress($id){
        $default = Address::where('addressable_id',Auth::user()->id)->where('is_default','Yes')->first();
        if($default){
          $default->update(['is_default'=>'No']);
        }
       $make_default = Address::where('id',$id)->where('is_default','No')->first();
       if($make_default){
          $make_default->update(['is_default'=>'Yes']);
        }
        return back()->with('success','Default Address Changed Successfully.');
    }
    /*
    adding address for logged in user
    */
    public function AddAddress(Request $request){
        $state = new State();
        $state = $state->AllCity();
        return view('user_member.user.my-account.add-address',compact('state'));
    }

    public function SaveAddress(Request $request){
        $this->validate($request,[
         'address1'=>'required|max:50',
         'city'=>'required',
         'state'=>'required',
         'zip'=>'required',
        ]);
        $input = $request->all();
        $type = 'User';
        if($input['is_default']=='Yes') {
           $default = Address::where('addressable_id',Auth::user()->id)->where('is_default','Yes')->first();
            if($default){
              $default->update(['is_default'=>'No']);
            }
        }
        Address::AddAddress($input,$type);
        return redirect::route('user-address')->with('success','Address Saved Successfully.');
    }

    public function DeleteAddress($id){
        Address::DeleteAddress($id);
        return redirect::route('user-address')->with('success','Address Deleted Successfully.');
    }

    public function PhoneList(){
        $phones = Phone::OrderBy('is_primary','ASC')->where('phoneable_id',Auth::user()->id)->get();
        return view('user_member.user.my-account.view-phone',compact('phones'));
    }

    public function AddPhone(){
        return view('user_member.user.my-account.add-phone');
    }
    public function SavePhone(Request $request){
        $this->validate($request,[
            'phone_number'=>'required|integer|min:10|digits_between:1,10',
        ]);
        $input = $request->all();
        if($input['is_primary']=='Yes') {
           $default = Phone::where('phoneable_id',Auth::user()->id)->where('is_primary','Yes')->first();
            if($default){
              $default->update(['is_primary'=>'No']);
            }
        }

        Phone::create([
        'phoneable_id'  => Auth::user()->id,
        'phoneable_type'=> 'User',
        'phone_type_id' => $input['phone_type'],
        'number'        => $input['phone_number'],
        'is_primary'       => $input['is_primary'],
        ]);
        return redirect::route('user-phone')->with('success','Phone Saved Successfully.');
    }

    /*making default phone of this user*/
    public function DefaultPhone($id){
        $default = Phone::where('phoneable_id',Auth::user()->id)->where('is_primary','Yes')->first();
        if($default){
          $default->update(['is_primary'=>'No']);
        }
       $make_default = Phone::where('id',$id)->where('is_primary','No')->first();
       if($make_default){
          $make_default->update(['is_primary'=>'Yes']);
        }
        return back()->with('success','Default Phone Changed Successfully.');
    }

    /*deleteing phone here for this logged in user*/
    public function DeletePhone($id){
        Phone::where('id',$id)->delete();
        return back()->with('success','Phone deleted Successfully.');
    }
}
