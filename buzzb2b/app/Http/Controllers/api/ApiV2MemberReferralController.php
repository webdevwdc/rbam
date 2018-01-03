<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType,App\Category, App\Referral, App\Sitesetting;
use Hash;
use App\Helpers;
use Twilio;
use App\Mail\MemberReferral;

class ApiV2MemberReferralController extends Controller
{
    protected $user;

    public function __construct(){
        parent::__construct();
        $this->user = \JWTAuth::parseToken()->authenticate();
    }
    
    public function send(Request $request){        
        # get member	
        $referringMember = Member::where('slug', $request->member_slug)->first();
        
        if ( ! $referringMember){
            return response()->json( array('error'=>array('message' => 'That sending member could not be found.','status_code'=>401)) );
        }
        
        $email = $request->contact_email;
	$phone = $request->contact_phone;
        
        // an email OR a phone number must be submitted
        if ( ! $email && ! $phone){
            return response()->json( array('error'=>array('message' => 'Please enter at least one valid email address or mobile phone number.','status_code'=>401)) );
        }
        
        $fullname = $request->contact_fullname;
        $informed = $request->contact_informed ? true : false;
        $personal_message = $request->personal_message;
        
        // if there is an email...
        if ($email){        
            $emailExists = Referral::where('email', $email)->where('ravable_id', $referringMember->id)->first();
            if(!$emailExists){
                $newReferral = new Referral();
                $newReferral->ravable_id = $referringMember->id;
                $newReferral->ravable_type = 'Member';
                $newReferral->exchange_id = $referringMember->exchange->id;
                $newReferral->referring_user_id = $this->user->id;
                $newReferral->referral_type = 'email';
                $newReferral->email = $email;
                $newReferral->personal_message = $personal_message;
                $newReferral->fullname = $fullname;
                $newReferral->informed = $informed;
                $newReferral->save();
                
                //Send Email
                if($personal_message != '') {
                    $site_from = Sitesetting::where('sitesettings_lebel','site_from_email')->first();
                    $site_name = Sitesetting::where('sitesettings_lebel','site_name')->first();
                    
                    $data['from_email']         = $site_from->sitesettings_value;
                    $data['form_name']          = $site_name->sitesettings_value ;
                    
                    $data['to_email']           = $email;
                    $data['to_name']            = $fullname;
                    $data['personal_message']   = $personal_message;
                    $data['subject']            = ( ! is_null($this->user)) ? 'A note from ' . $this->user->first_name . ' with ' . $referringMember->name : 'A note from ' . $referringMember->name;
                    
                    \Mail::to($email)->send(new MemberReferral($data));
                }
            }
        }
        
        // if there is a phone number...
        if ($phone){           
            $validPhoneNumber = $this->sanitizeNumber($phone);
            if ($validPhoneNumber){
                $phoneExists = Referral::where('phone', $phone)->where('ravable_id', $referringMember->id)->first();
                if(!$phoneExists){
                    $newReferral = new Referral();
                    $newReferral->ravable_id = $referringMember->id;
                    $newReferral->ravable_type = 'Member';
                    $newReferral->exchange_id = $referringMember->exchange->id;
                    $newReferral->referring_user_id = $this->user->id;
                    $newReferral->referral_type = 'phone';
                    $newReferral->phone = sanitizePhoneForStore($validPhoneNumber);
                    $newReferral->personal_message = $personal_message;
                    $newReferral->fullname = $fullname;
                    $newReferral->informed = $informed;
                    $newReferral->save();
                    //Send text
                    $strTextMsg = 'From: ' . $this->user->first_name . ' ' . $this->user->last_name;

                    if ($personal_message){
                        $strTextMsg .= $personal_message;
                    }
                    
                    $strTextMsg .= 'https://vimeo.com/128273907';
                    Twilio::message($phone, $strTextMsg);
                }
            }
        }
        return response()->json( array('success' => true, 'email' => ($email) ?: '', 'phone' => ($phone) ?: '', 'status_code'=>200));
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
