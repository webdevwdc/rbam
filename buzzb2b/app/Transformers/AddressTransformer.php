<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Address;

class AddressTransformer extends TransformerAbstract {

    public function transform(Address $address)
    {
        return [
			'full' =>$address->address1 .', ' . $address->address2 .'<br>' . $address->city .', ' . $address->state->abbrev .' ' . $address->zip,
			'lat' => $address->lat,
			'lng' => $address->lng,
        ];
    }
}