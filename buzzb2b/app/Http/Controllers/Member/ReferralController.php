<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Referral, App\Exchange, App\Member, App\Sitesetting;

use \Session, \Validator,\Redirect, \Hash, \Auth, \Image;
use App\Mail\MemberReferral;

class ReferralController extends Controller
{
    //
    public function create()
    {
        $data[] = '';
        return view('member.referrals.index', $data);    
    }
    
    public function store(Request $request)
    {   
            $this->validate($request,[
              'email_address' => 'required|email',
              'full_name'=>'required'
            ]);        
        $exchange_id        = session::get('EXCHANGE_ID'); //exchange_id
        $referring_user_id  = session::get('ADMIN_ACCESS_ID'); //referring_user_id
        $ravable_type       = 'Member';
        $arr_member         = Member::where('exchange_id', $exchange_id)->get();
        $ravable_id         = $arr_member[0]->id;
         
        
        $referral = new Referral();
        $referral->ravable_id           = $ravable_id; //this is a member table id
        $referral->ravable_type         = 'Member';
        $referral->exchange_id          = $exchange_id;
        $referral->referring_user_id    = $referring_user_id; //this is user table id
        $referral->referral_type        = 'email';
        $referral->email                = $request->email_address;
        $referral->personal_message     = $request->personal_message;
        $referral->fullname             = $request->full_name;
        $referral->informed             = ($request->informed != '') ? $request->informed : 0 ;
        $referral->save();
            
        if($request->mobile_number != '')
        {
            $referral = new Referral();
            $referral->ravable_id           = $ravable_id;
            $referral->ravable_type         = 'Member';
            $referral->exchange_id          = $exchange_id;
            $referral->referring_user_id    = $referring_user_id;
            $referral->referral_type        = 'phone';
            $referral->email                = $request->email_address;
            $referral->phone                = $request->mobile_number;
            $referral->personal_message     = $request->personal_message;
            $referral->fullname             = $request->full_name;
            $referral->informed             = ($request->informed != '') ? $request->informed : 0;
            $referral->save();
        }
        
        /****** Mail send code starts here *****/
        if($request->personal_message != '') {
            $site_from = Sitesetting::where('sitesettings_lebel','site_from_email')->first();
            $site_name = Sitesetting::where('sitesettings_lebel','site_name')->first();
            
            $data['from_email']         = $site_from->sitesettings_value;
            $data['form_name']          = $site_name->sitesettings_value ;
            
            $data['to_email']           = $request->email_address;
            $data['to_name']            = $request->full_name;
            $data['personal_message']   = $request->personal_message;
            $data['subject']            = 'A note from '. Session::get('ADMIN_ACCESS_NAME').' with '.Session::get('EXCHANGE_CITY_NAME');
            
            \Mail::to($data['to_email'])->send(new MemberReferral($data));
        }
        /****** Mail send code ends here *****/
            
            
        return Redirect::back()->with('success','Thank you, your referral has been sent to'.' '.ucwords($request->full_name));
        
    }
}
