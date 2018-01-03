<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType,App\Category, App\CashReferral, App\Sitesetting, App\Tag, App\MemberTag;
use Hash;
use App\Helpers;
use Twilio;
use App\Mail\MemberCashReferral;

class ApiV2MemberReferralCashController extends ApiV2Controller
{
    /*
    * @var User
    */
    protected $user;
    
    public function __construct()
    {
        parent::__construct();        
        $this->user = \JWTAuth::parseToken()->authenticate();
    }
    
    public function getDirectory(Request $request){
        $members = array();
        $keyword = $request->keyword;
        
        if(!$keyword){
            return $this->respondNotFound('Keyword cannot be blank.');
        }
        
        $tags = Tag::where('name', 'LIKE', $keyword)->get();
        
        if(!$tags){
            return $this->respondNotFound('Tags not available.');
        }
        
        foreach($tags AS $tag){
            foreach($tag->member_tag AS $mtag){
                //echo $mtag->member_id . '<br>';
                $member = Member::where('id', $mtag->member_id)->first();
                if($member){
                    $members[] = $member;
                }                
            }
        }
        return response()->json( array('success' => true, 'member' => $members, 'status_code'=>200));
        //dd($tags);
    }
    
    public function send(Request $request){
        # get member	
        //$referringMember = Member::where('slug', $request->member_slug)->first();
        
        $refer_to_member_email = $request->refer_to_member_email;
	$refer_to_member_phone = $request->refer_to_member_phone;
        
        //if ( ! $referringMember)
        //{
        //    return $this->respondNotFound('That sending member could not be found.');
        //}
        
        if ( ! $refer_to_member_email && ! $refer_to_member_phone)
        {
            return $this->respondNotFound('Please enter at least one valid "to" email address or "to" mobile phone number.');
        }
        
        $fullname = $request->contact_fullname;
        //$informed = $request->contact_informed ? true : false;
        $informed = false;
        $company_name = $request->company_name;
        $personal_message = $request->personal_message;
        
        #get company
        $merchantMember = Member::where('id', $company_name)->first();
        
        $memberUser = User::where('id', $merchantMember->memberuser->user_id)->orderBy('id', 'ASC')->first();
        
        // Get member email
        $member_actual_email = $memberUser->email;
        
        // Get member phone
        $member_phone_arr = Phone::select('number')
                            ->where('phoneable_id', $merchantMember->id)
                            ->where('phoneable_type', 'Member')
                            ->where('is_primary', 'Yes')
                            ->first();
                            
        if(count($member_phone_arr) == 0){
            $member_phone_arr = Phone::select('number')
                                ->where('phoneable_id', $merchantMember->id)
                                ->where('phoneable_type', 'Member')
                                ->first();
        }
                             
        $member_actual_phone = $member_phone_arr['number'];
        
        // if there is an email...
        if ($member_actual_email)
        {
            $emailExists = CashReferral::where('email', $member_actual_email)->where('ravable_id', $merchantMember->id)->first();
            if(!$emailExists){
                $newReferral = new CashReferral();
                $newReferral->ravable_id = $merchantMember->id;
                $newReferral->ravable_type = 'Member';
                $newReferral->exchange_id = $merchantMember->exchange->id;
                $newReferral->referring_user_id = $this->user->id;
                $newReferral->referral_type = 'email';
                $newReferral->email = $refer_to_member_email;
                $newReferral->phone = $refer_to_member_phone;
                $newReferral->personal_message = $personal_message;
                $newReferral->fullname = $fullname;
                $newReferral->informed = $informed;
                $newReferral->save();
                
                //Send Email
                $site_from = Sitesetting::where('sitesettings_lebel','site_from_email')->first();
                $site_name = Sitesetting::where('sitesettings_lebel','site_name')->first();
                
                $data['from_email']         = $site_from->sitesettings_value;
                $data['form_name']          = $site_name->sitesettings_value ;
                
                $data['to_email']           = $member_actual_email;
                $data['to_name']            = $merchantMember->business_1099_name;
                $data['personal_message']   = $personal_message;
                $data['sender_fullname']    = $this->user->first_name;
                $data['customer_fullname']  = $fullname;
                $data['customer_email']     = $refer_to_member_email;
                $data['customer_phone']     = $refer_to_member_phone;
                $data['subject']            = ( ! is_null($this->user)) ? 'A note from ' . $this->user->first_name . ' with ' . $merchantMember->name : 'A note from ' . $merchantMember->name;
                
                //\Mail::to($member_actual_email)->send(new MemberCashReferral($data));
		
		\Mail::to($member_actual_email)->send(new MemberCashReferral($data));
		
		
                //if($personal_message != '') {
                //    $site_from = Sitesetting::where('sitesettings_lebel','site_from_email')->first();
                //    $site_name = Sitesetting::where('sitesettings_lebel','site_name')->first();
                //    
                //    $data['from_email']         = $site_from->sitesettings_value;
                //    $data['form_name']          = $site_name->sitesettings_value ;
                //    
                //    $data['to_email']           = $refer_to_member_email;
                //    $data['to_name']            = $fullname;
                //    $data['personal_message']   = $personal_message;
                //    $data['subject']            = ( ! is_null($this->user)) ? 'A note from ' . $this->user->first_name . ' with ' . $merchantMember->name : 'A note from ' . $merchantMember->name;
                //    
                //    \Mail::to($refer_to_member_email)->send(new MemberCashReferral($data));
                //}
            }
        }
        
        // if there is a phone number...
        if($member_actual_phone){
            $textToPhone = '+91' . $member_actual_phone;
            $strTextMsg = $merchantMember->business_1099_name . ',  ' . $this->user->first_name . ' has sent you a cash customer. Please call the referral to earn their business!';            
            Twilio::message($textToPhone, $strTextMsg);
	    
        }
        //if ($member_actual_phone)
        //{
        //    $validPhoneNumber = $this->sanitizeNumber($refer_to_member_phone);
        //    if ($validPhoneNumber){
        //        $phoneExists = CashReferral::where('phone', $member_actual_phone)->where('ravable_id', $merchantMember->id)->first();
        //        
        //        $newReferral = new CashReferral();
        //        $newReferral->ravable_id = $merchantMember->id;
        //        $newReferral->ravable_type = 'Member';
        //        $newReferral->exchange_id = $merchantMember->exchange->id;
        //        $newReferral->referring_user_id = $this->user->id;
        //        $newReferral->referral_type = 'phone';
        //        $newReferral->phone = sanitizePhoneForStore($validPhoneNumber);
        //        $newReferral->personal_message = $personal_message;
        //        $newReferral->fullname = $fullname;
        //        $newReferral->informed = $informed;
        //        $newReferral->save();
        //        //Send text
        //        $strTextMsg = 'From: ' . $this->user->first_name . ' ' . $this->user->last_name;
        //        $strTextMsg .= 'Referring Member: ' . $merchantMember->business_1099_name;
        //        if ($personal_message){
        //            $strTextMsg .= $personal_message;
        //        }                
        //        
        //        Twilio::message($refer_to_member_phone, $strTextMsg);
        //    }
        //}
        return response()->json( array('success' => true, 'email' => ($refer_to_member_email) ?: '', 'phone' => ($refer_to_member_phone) ?: '', 'status_code'=>200));
    }
    
    private function sanitizeNumber($phone, $international = false)
    {
        $format = "/(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/";
    
        $alt_format = '/^(\+\s*)?((0{0,2}1{1,3}[^\d]+)?\(?\s*([2-9][0-9]{2})\s*[^\d]?\s*([2-9][0-9]{2})\s*[^\d]?\s*([\d]{4})){1}(\s*([[:alpha:]#][^\d]*\d.*))?$/';

        // Trim & Clean extension
        $phone = trim($phone);
        $phone = preg_replace( '/\s+(#|x|ext(ension)?)\.?:?\s*(\d+)/', ' ext \3', $phone);

        if (preg_match($alt_format, $phone, $matches))
        {
            return '(' . $matches[4] . ') ' . $matches[5] . '-' . $matches[6] . ( !empty( $matches[8] ) ? ' ' . $matches[8] : '' );
        }
        elseif(preg_match($format, $phone, $matches))
        {
            // format
            $phone = preg_replace($format, "($2) $3-$4", $phone);

            // Remove likely has a preceding dash
            $phone = ltrim($phone, '-');

            // Remove empty area codes
            if (false !== strpos(trim($phone), '()', 0))
            { 
                $phone = ltrim(trim($phone), '()');
            }

            // Trim and remove double spaces created
            return preg_replace('/\\s+/', ' ', trim($phone));
        }

        return false;
    }
}
