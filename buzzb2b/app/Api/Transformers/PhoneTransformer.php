<?php namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Phones\Phone;

class PhoneTransformer extends TransformerAbstract {

    public function transform(Phone $phone)
    {
        return [
			'number' => $phone->number,
        ];
    }
}