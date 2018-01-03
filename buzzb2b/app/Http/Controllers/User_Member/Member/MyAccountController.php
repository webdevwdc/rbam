<?php

namespace App\Http\Controllers\User_Member\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User,App\Image;
use Auth;
use File;
use Hash;

class MyAccountController extends Controller
{
    public function ViewAccount(){

    	return view('user_member.member.my-account');
    }

    public function ProfilePhoto(Request $request){
    	$file = $request->file('profile_picture');
    	if(!empty($file)){
            $this->validate($request,[
                'profile_picture'=>'required|mimes:jpg,jpeg,png|max:1000',
                ]);

          $size = $file->getClientSize();

          if($size>3145728)
            return back()->with('error','Upload file size is maximum 3 MB');

            /*$user = User::where('id',Auth::user()->id)->first();
            $upload  = Image::UploadImage($file,$user);*/

            $user = User::where('id', Auth::user()->id)->first();

            $path = public_path().'/upload/members/'.$user->image;

            if(file_exists($path))
            {
                File::delete($path);
            }

            $extension = $file->getClientOriginalExtension();
            $file_name = time().'.'.$extension;
            $path = public_path().'/upload/members';
            $upload = $file->move($path,$file_name);

            $user->update(['image'=>$file_name]);
          
          return back()->with('success','Profile picture updated successfully.');
    	}
    	
    	return view('user_member.member.my-account.profile-image');
    }

    public function EditProfile(Request $request){
        $input = $request->all();
        $user = User::where('id',Auth::user()->id)->first();
        if(!empty($input)){
            $user->update([
                'first_name'=>$input['first_name'],
                'last_name'=>$input['last_name'],
                ]);
        }
        
        return view('user_member.member.my-account.edit-profile',compact('user'));
    }

    public function ChangePassword(Request $request){

        $input = $request->all();
        $user = User::where('id',Auth::user()->id)->first();
        if(!empty($input)){
            $user->update([
                'first_name'=>$input['first_name'],
                'last_name'=>$input['last_name'],
                ]);
        }
        
        return view('user_member.member.my-account.change-password',compact('user'));
    }

    public function UpdatePassword(Request $request){
        $this->validate($request,[
            'old_password'      => 'required|min:6',
            'new_password'      => 'required',
            'confirm_password' => 'required|same:new_password'
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
}
