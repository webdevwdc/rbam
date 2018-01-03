<?php namespace App\Transformers\Member\Billing;

use League\Fractal\TransformerAbstract;

class PaymentProfileTransformer extends TransformerAbstract {

    public function transform($profiles)
    {   
        return [
			'paymentId' => $profiles->paymentId,
			'method' => $profiles->method,
			'primary' => $profiles->primary,
			'ccLastFour' => ($profiles->card) ? $profiles->card->lastFourDigits : '',
        ];
    }
}