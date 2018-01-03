<?php namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Exchanges\Exchange;

class ExchangeTransformer extends TransformerAbstract {

    public function transform(Exchange $exchange)
    {
        return [
			'name' => $exchange->name,
			'domain' => $exchange->domain,
        ];
    }
}