<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\MemberCashier;

class MemberCashierTransformer extends TransformerAbstract {

	public function transform(Cashier $cashier)
    {
        return [
			'id' => $cashier->id,
			'name' => $cashier->name,
        ];
    }
}