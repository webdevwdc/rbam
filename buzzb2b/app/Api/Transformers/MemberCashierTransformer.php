<?php namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Members\Cashier;

class MemberCashierTransformer extends TransformerAbstract {

	public function transform(Cashier $cashier)
    {
        return [
			'id' => $cashier->id,
			'name' => $cashier->name,
        ];
    }
}