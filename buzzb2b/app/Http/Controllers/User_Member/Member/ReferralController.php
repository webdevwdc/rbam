<?php

namespace App\Http\Controllers\User_Member\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Referral,\Session, \Auth, App\Sitesetting;
use App\Mail\MemberReferral;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //die('aaaa');
        $data[] = '';
        return view('user_member.member.referrals.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function SaveReferral(Request $request)
    {   
        $this->validate($request,[
             'email_address' => 'required|email',
              'full_name'=>'required'
            ]);
        $input = $request->all();
        if(isset($input['informed'])==''){
            $input['informed'] = 0;
        }
        $member_id = Session::get('MEMBER_ID');
        $exchange_id = Session::get('EXCHANGE_ID');
        if(!empty($input['mobile_number'])){
            $data =  Referral::create([
             'email'=>$input['email_address'],
             'ravable_id'=>$member_id,
             'ravable_type'=>'Member',
             'referral_type'=>'phone',
             'exchange_id'=>$exchange_id,
             'referring_user_id'=>Auth::user()->id,
             'personal_message'=>$input['personal_message'],
             'phone'=>$input['mobile_number'],
             'fullname'=>$input['full_name'],
             'informed'=>$input['informed'],
            ]);

        }else{
          $data = Referral::create([
             'email'=>$input['email_address'],
             'ravable_id'=>$member_id,
             'ravable_type'=>'Member',
             'referral_type'=>'email',
             'exchange_id'=>$exchange_id,
             'referring_user_id'=>Auth::user()->id,
             'personal_message'=>$input['personal_message'],
             'phone'=>'Null',
             'fullname'=>$input['full_name'],
             'informed'=>$input['informed'],
            ]);
        }

        /****** Mail send code starts here *****/
        if($request->personal_message != '') {
            $data = [];
            $site_from = Sitesetting::where('sitesettings_lebel','site_from_email')->first();
            $site_name = Sitesetting::where('sitesettings_lebel','site_name')->first();
            
            $data['from_email']         = $site_from->sitesettings_value;
            $data['form_name']          = $site_name->sitesettings_value ;
            
            $data['to_email']           = $request->email_address;
            $data['to_name']            = $request->full_name;
            $data['personal_message']   = $request->personal_message;
            $data['subject']            = 'A note from '. Session::get('USER_NAME').' with '.Session::get('EXCHANGE_CITY_NAME');
            
            \Mail::to($data['to_email'])->send(new MemberReferral($data));
        }
        /****** Mail send code ends here *****/
        
        return back()->with('success','Thank you for your referral! It has been successfully delivered.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
