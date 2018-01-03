<?php namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Users\User;

class UserMemberDashboardTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
        'member',
    ];

    public function transform(User $user)
    {
    	$member = $user->selectedMember();

    	$data['accountSummary'] = ( ! $user->hasCurrentMemberAccess('admin')) ? null : [
			'barterBalance' => $member->barterBalance(),
			'barterBalanceDisplay' => presentBarterAmount($member->barterBalance(), 'T$0.00'),
			'availableBarterCredit' => $member->availableBarterCredit(),
			'availableBarterCreditDisplay' => presentBarterAmount($member->availableBarterCredit(), 'T$0.00'),
			'cbaBalance' => $member->cbaBalance(),
			'cbaBalanceDisplay' => presentCashAmount($member->cbaBalance(), '$0.00'),
			'referralCommissionsToDate' => $member->cbaCommissionTotal(),
			'referralCommissionsToDateDisplay' => presentCashAmount($member->cbaCommissionTotal(), '$0.00'),
    	];

    	$data['recentActivity'] = ( ! $user->hasCurrentMemberAccess('admin')) ? null : [
			'last30DaysBarterSaleTotal' => $member->barterRecentSaleTotal(),
			'last30DaysBarterSaleTotalDisplay' => presentBarterAmount($member->barterRecentSaleTotal(), 'T$0.00'),
			'last30DaysBarterPurchaseTotal' => $member->barterRecentPurchaseTotal(),
			'last30DaysBarterPurchaseTotalDisplay' => presentBarterAmount($member->barterRecentPurchaseTotal(), 'T$0.00'),
    	];

    	$data['userPermissions'] = [
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

    	return $data;
    }

    public function includeMember(User $user)
    {
        return $this->item($user->selectedMember(), new MemberTransformer);
    }
}