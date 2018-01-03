<?php namespace Peos\Api\Transformers\Member\Pos;

use League\Fractal\TransformerAbstract;

class SettledTransactionTransformer extends TransformerAbstract {

    public function transform($settledResponse)
    {
        return [
			'type_id' => $settledResponse['transaction']->type_id,
			'notes' => $settledResponse['transaction']->notes,
			'transaction_number' => $settledResponse['transaction']->transaction_number,
			'barter_amount' => $settledResponse['barter_amount'],
			'barter_amount_display' => $settledResponse['barter_amount_display'],
			'tip_amount' => $settledResponse['tip_amount'],
			'tip_amount_display' => $settledResponse['tip_amount_display'],
			'charge_amount' => $settledResponse['charge_amount'],
			'charge_amount_display' => $settledResponse['charge_amount_display'],
			'merchantExchange' => ( is_object($settledResponse['merchantExchange']) ? [
				'name' => $settledResponse['merchantExchange']->name,
				'domain' => $settledResponse['merchantExchange']->domain,
			] : false),
			'merchantMember' => ( is_object($settledResponse['merchantMember']) ? [
				'name' => $settledResponse['merchantMember']->name,
				'slug' => $settledResponse['merchantMember']->slug,
			] : false),
			'merchantGiftcard' => ( is_object($settledResponse['merchantGiftcard']) ? [] : false),
			'merchantUser' => ( is_object($settledResponse['merchantUser']) ? [
				'email' => $settledResponse['merchantUser']->email,
				'firstname' => $settledResponse['merchantUser']->firstname,
				'lastname' => $settledResponse['merchantUser']->lastname,
			] : false),
			'customerExchange' => ( is_object($settledResponse['customerExchange']) ? [
				'name' => $settledResponse['customerExchange']->name,
				'domain' => $settledResponse['customerExchange']->domain,
			] : false),
			'customerMember' => ( is_object($settledResponse['customerMember']) ? [
				'name' => $settledResponse['customerMember']->name,
				'slug' => $settledResponse['customerMember']->slug,
			] : false),
			'customerBartercard' => ( is_object($settledResponse['customerBartercard']) ? [
				'number' => $settledResponse['customerBartercard']->number,
				'exchange' => [
					'domain' => $settledResponse['customerBartercard']->exchange->domain,
					'name' => $settledResponse['customerBartercard']->exchange->name,
				]
			] : false),
			'customerGiftcard' => ( is_object($settledResponse['customerGiftcard']) ? [] : false),
			'customerUser' => ( is_object($settledResponse['customerUser']) ? [
				'email' => $settledResponse['customerUser']->email,
				'firstname' => $settledResponse['customerUser']->firstname,
				'lastname' => $settledResponse['customerUser']->lastname,
			] : false),
        ];
    }
}