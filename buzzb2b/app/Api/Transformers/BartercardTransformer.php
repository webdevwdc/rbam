<?php namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Bartercard;

class BartercardTransformer extends TransformerAbstract {

    protected $defaultIncludes = [
        'exchange',
        'member',
        'user'
    ];

    public function transform(Bartercard $bartercard)
    {
        return [
            'cardType' => 'barter',
            'number' => $bartercard->number,
        ];
    }

    public function includeExchange(Bartercard $bartercard)
    {
        return $this->item($bartercard->exchange, new ExchangeTransformer);
    }

    public function includeMember(Bartercard $bartercard)
    {
        return $this->item($bartercard->member, new MemberTransformer);
    }

    public function includeUser(Bartercard $bartercard)
    {
        return $this->item($bartercard->user, new UserTransformer);
    }
}