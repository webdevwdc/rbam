<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Exchange;

class ExchangeTransformer extends TransformerAbstract {

    public function transform(Exchange $exchange)
    {
        return [
			'name' => $exchange->name,
			'domain' => $exchange->domain,
        ];
    }
}