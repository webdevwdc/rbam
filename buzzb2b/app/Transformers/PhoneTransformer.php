<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Phone;

class PhoneTransformer extends TransformerAbstract {

    public function transform(Phone $phone)
    {
        return [
			'number' => $phone->number,
        ];
    }
}