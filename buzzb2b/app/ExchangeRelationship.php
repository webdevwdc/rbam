<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRelationship extends Model
{   
    public $table = 'exchange_relationships';
    
    public  $fillable = ['exchange_id', 'partner_exchange_id', 'accept_barter_from', 'accept_giftcard_from', 'locked'];
}
