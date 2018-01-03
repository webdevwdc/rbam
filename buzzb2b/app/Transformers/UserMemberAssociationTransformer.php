<?php namespace Peos\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Members\Member;

class UserMemberAssociationTransformer extends TransformerAbstract {

    protected $defaultIncludes = [
        'member',
    ];

	public function transform(Member $member)
    {
        return [
            'isAdmin' => (bool) $member->pivot->admin,
            'isPrimary' => (bool) $member->pivot->primary,
            'isSelected' => (bool) $member->pivot->selected,
            'monthlyTradeLimit' => $member->pivot->monthly_trade_limit,
            'monthlyTradeLimitDisplay' => presentCashAmount($member->pivot->monthly_trade_limit),
            'canPosSell' => (bool) $member->pivot->can_pos_sell,
            'canPosPurchase' => (bool) $member->pivot->can_pos_purchase,
            'canAccessBilling' => (bool) $member->pivot->can_access_billing,
            'emailOnPurchase' => (bool) $member->pivot->email_on_purchase,
            'emailOnSale' => (bool) $member->pivot->email_on_sale
        ];
    }

    public function includeMember(Member $member)
    {
        return $this->item($member, new MemberTransformer);
    }
}