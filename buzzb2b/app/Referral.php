<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Referral extends Model
{
    protected $table = 'referrals';
    public $fillable = [
                        'ravable_id',
                        'ravable_type',
                        'exchange_id',
                        'referring_user_id',
                        'referral_type',
                        'email',
                        'phone',
                        'personal_message',
                        'fullname',
                        'informed',
                        ];

        public function GetReferralname(){
            return $this->hasOne('App\User','id','referring_user_id');
        }

        public function GetUsername(){
            return $this->hasOne('App\User','id','ravable_id');
        }
}
