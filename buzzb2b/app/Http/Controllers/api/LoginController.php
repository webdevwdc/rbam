<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType;
use Hash;
use App\Helpers;
use App\Sitesetting;
use App\Mail\AdminPasswordRecovery;


class LoginController extends Controller
{
    public function login(Request $request){
         
         extract($request->all());
         $user = User::where('email',$email)->first();
         if(count($user)>0){

                           
                 if(Hash::check($password,$user->password)){

                              $token = \JWTAuth::fromUser($user);
                              $user['firstname'] = $user->first_name;
                              $user['lastname'] = $user->last_name;
                              $user['fullname'] = $user->first_name.' '.$user->last_name;
                              $user['avatarImagePath'] = 'uploads/user_image/'.$user->image;
                              $user['avatarImagePathSm'] = 'uploads/user_image/thumb/'.$user->image;
                              $user['avatarImagePathXs'] = 'uploads/user_image/thumb/'.$user->image;
                              $user_member = $user->members;
                              //dd($user_member);
                              if(count($user_member) > 0) {
                                  $memberArr = [];
                                  $primaryContact = [];
                                  foreach($user_member as $val){
                                      $getImage = (count($val->image) > 0)?$val->image->filename:''; 
                                      $val->isAdmin=(bool)$val->pivot->admin;
                                      $val->isPrimary=(bool)$val->pivot->primary;
                                      $val->isSelected=true;
                                      $val->monthlyTradeLimitDisplay=presentCashAmount($val->pivot->monthly_trade_limit);
                                      $val->monthlyTradeLimit=$val->pivot->monthly_trade_limit;
                                      $val->canPosSell=(bool)$val->pivot->can_pos_sell;
                                      $val->canPosPurchase=(bool)$val->pivot->can_pos_purchase;
                                      $val->canAccessBilling=(bool)$val->pivot->can_access_billing;
                                      $val->emailOnPurchase=(bool)$val->pivot->email_on_purchase;
                                      $val->emailOnSale=(bool)$val->pivot->email_on_sale;
                                      $memberArr['name']=$val->name;
                                      $memberArr['slug']=$val->slug;
                                      $memberArr['description']=$val->description;
                                      $memberArr['websiteUrl']=$val->website_url;
                                      $memberArr['onStandby']=(bool)$val->standby;
                                      $memberArr['name']=$val->name;
                                      $memberArr['logoFilePath']=$getImage;
                                      $memberArr['logoFilePathSm']=$getImage;
                                      $memberArr['logoFilePathXs']=$getImage;
                                      $memberArr['exchange']= ['data'=>$val->exchange];
                                      $get_address = Address::select('*','address1 as full')->where('addressable_id',$val->id)->where('addressable_type','Member')->first();
                                      
                                      if(count($get_address) > 0) {
                                          $default_address = $get_address;
                                      } else{
                                          $default_address = (object)[];
                                      }
                                      $memberArr['defaultAddress']= ['data'=>$default_address];
                                      $val->user[0]->firstname = $val->user[0]->first_name;
                                      $val->user[0]->lastname = $val->user[0]->last_name;
                                      $val->user[0]->fullname = $val->user[0]->first_name.' '.$val->user[0]->last_name;
                                      $memberArr['primaryContact']= ['data'=>$val->user[0]];
                                      $primary_phone = Phone::select('*')->where('phoneable_id',$val->id)->where('phoneable_type','Member')->first();
                                      $memberArr['primaryPhone']= ['data'=>$primary_phone];
                                      $val->member = ['data'=>$memberArr];
                                      unset($val->image);
                                      unset($val->exchange);
                                      unset($val->pivot);
                                      unset($val->user);
                                   }
                                  
                                 
                                  
                              }
                              
                              unset($user->members);
                              return response()->json(['data'=>['token' => $token] + ['user' => ['data'=>$user]] + ['memberAssociations' => ['data'=>$user_member]] + ['lat' => '22.5726'] + ['long' => '88.3639']]);

                     }
                     else{
                             return response()->json( array('error'=>array('message' => 'Sorry, but we can\'t find that user.','status_code'=>401)) );

                     }
               
         }
         else{
                 return response()->json( array('error'=>array('message' => 'Email does not exist.','status_code'=>401)));

         }
    }


    public function forgotPassword(Request $request){
       $email  = $request->email;
        $profile    = User::where('email',$email)->first();
        if(count($profile)>0){
            $new_pass = str_random(10);
            
            $site_from = Sitesetting::where('sitesettings_lebel','site_from_email')->first();
            $site_name = Sitesetting::where('sitesettings_lebel','site_name')->first();
            $data['from_email']     = $site_from->sitesettings_value;
            $data['form_name']      = $site_name->sitesettings_value ;
            $data['to_email']       = $email;
            $data['to_name']        = $profile->first_name;
            $data['password']       = $new_pass;
            
            \Mail::to($data['to_email'])->send(new AdminPasswordRecovery($data));
            
            $profile->password = $new_pass ;
            $profile->save();
            return response()->json(['success' => 'Password is sent to the email address. Please check in your inbox','data' => $profile]);
            
        }else{
            return response()->json(['error' => 'user is not found','data' =>'']);
        }
    }
    
    
}
