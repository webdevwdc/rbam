<?php namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Addresses\Address;

class AddressTransformer extends TransformerAbstract {

    public function transform(Address $address)
    {
        return [
			'full' => $address->present()->full(),
			'lat' => $address->lat,
			'lng' => $address->lng,
        ];
    }
}