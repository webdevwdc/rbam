<?php namespace Peos\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Cards\Giftcards\Giftcard;

class GiftcardTransformer extends TransformerAbstract {

    protected $defaultIncludes = [
        'exchange',
        'user'
    ];

    public function transform(Giftcard $giftcard)
    {
        return [
            'cardType' => 'gift',
            'number' => $giftcard->number,
            'currentBalance' => $giftcard->barterBalance(),
            'originalBalance' => $giftcard->originalBarterBalance()
        ];
    }

    public function includeExchange(Giftcard $giftcard)
    {
        return $this->item($giftcard->exchange, new ExchangeTransformer);
    }

    public function includeUser(Giftcard $giftcard)
    {
        if ($giftcard->user)
        {
            return $this->item($giftcard->user, new UserTransformer);
        }

        return null;
    }
}