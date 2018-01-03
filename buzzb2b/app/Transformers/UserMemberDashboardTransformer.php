<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;
use App\LedgerDetails;
use Carbon\Carbon;

class UserMemberDashboardTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
        'member',
    ];

    public function transform(User $user)
    {
    	
		$member = $user->selectedMember();
		

    	$data['accountSummary'] = ( ! $user->hasCurrentMemberAccess('admin')) ? null : [
			'barterBalance' => $this->barterBalance($member->id),
			'barterBalanceDisplay' => presentBarterAmount($this->barterBalance($member->id), 'T$0.00'),
			'availableBarterCredit' => $this->availableBarterCredit($member->id),
			'availableBarterCreditDisplay' => presentBarterAmount($this->availableBarterCredit($member->id), 'T$0.00'),
			'cbaBalance' => $member->cbaBalance(),
			'cbaBalanceDisplay' => presentCashAmount($this->cbaBalance($member->id), '$0.00'),
			'referralCommissionsToDate' => $this->cbaCommissionTotal($member->id),
			'referralCommissionsToDateDisplay' => presentCashAmount($this->cbaCommissionTotal($member->id), '$0.00'),
    	];

    	$data['recentActivity'] = ( ! $user->hasCurrentMemberAccess('admin')) ? null : [
			'last30DaysBarterSaleTotal' => $this->barterRecentSaleTotal($member->id),
			'last30DaysBarterSaleTotalDisplay' => presentBarterAmount($this->barterRecentSaleTotal($member->id), 'T$0.00'),
			'last30DaysBarterPurchaseTotal' => $this->barterRecentPurchaseTotal($member->id),
			'last30DaysBarterPurchaseTotalDisplay' => presentBarterAmount($this->barterRecentPurchaseTotal($member->id), 'T$0.00'),
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
	
	public function barterBalance($member_id,$date = false)
	{	
		return $this->getMemberBarterBalance($member_id, $date);
	}

	/**
	 * Retrieve a member's cba balance
	 * 
	 * @return int PeosDecimal
	 */
	public function cbaBalance($member_id,$date = false)
	{
		return $this->getMemberCbaBalance($member_id, $date);
	}

	/**
	 * Retrieve a member's cba commissions total
	 * 
	 * @return int PeosDecimal
	 */
	public function cbaCommissionTotal($member_id)
	{
		return $this->getMemberCbaCommissionTotal($member_id);
	}

	/**
	 * Retrieve a salesperson member's cba commissions total
	 * 
	 * @return int PeosDecimal
	 */
	public function cbaSalespersonCommissionTotal($member_id)
	{
		return $this->getSalespersonMemberCbaCommissionTotal($member_id);
	}

	////////////

	public function barterRecentPurchaseTotal($member_id,$days = 30)
	{
		return $this->getMemberRecentBarterPurchaseTotal($days, $member_id);
	}

	public function barterRecentSaleTotal($member_id,$days = 30)
	{
		return $this->getMemberRecentBarterSaleTotal($days, $member_id);
	}

	/**
	 * Retrieve a member's available barter credit (balance + credit limit)
	 * 
	 * @return int PeosDecimal
	 */
	public function availableBarterCredit($member_id)
	{
		return $this->barterBalance($member_id) + 2; //$this->credit_limit
	}

	public function minimumCbaDeposit()
	{
		$depositTotal = $this->exchange->ex_default_min_cra_deposit; // get from config

		if ($this->cbaBalance() < 0)
			$depositTotal += (-($this->cbaBalance()));

		return $depositTotal;
	}

	public function getMemberBarterBalance($member_id, $date = false)
	{
		$query = LedgerDetails::whereIn('account_code', ['4010', '4020', '4050', '4080', '6010'])
			->where('member_id', $member_id);
		if ($date)
			$query = $query->where('created_at', '<=', $date->addSeconds(5));
		
		return (int) $query->sum('amount');
	}

	/**
	 * Retrieve a member's cba balace on a specified date, defaults to now
	 * 
	 * @param  int     $member_id
	 * @param  Carbon  $date
	 * @return int     PeosDecimal
	 */
	public function getMemberCbaBalance($member_id, $date = false)

	{
		$query = LedgerDetails::whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
			->where('member_id', $member_id);
			

		if ($date)
			$query = $query->where('created_at', '<=', $date->addSeconds(5));
		
		return (int) $query->sum('amount');	
	}

	/**
	 * Retrieve a member's cba commission total since a specified date, defaults to now
	 * 
	 * @param  int     $member_id
	 * @param  string  $date
	 * @return int     PeosDecimal
	 */
	public function getMemberCbaCommissionTotal($member_id, $date = false)
	{
		$query = LedgerDetails::whereIn('account_code', ['4070'])
			->where('member_id', $member_id);
			

		if ($date)
			$query = $query->where('created_at', '<=', $date);
		
		return (int) $query->sum('amount');	
	}

	/**
	 * Retrieve a salesperson member's cba commission total since a specified date, defaults to now
	 * 
	 * @param  int     $member_id
	 * @param  string  $date
	 * @return int     PeosDecimal
	 */
	public function getSalespersonMemberCbaCommissionTotal($member_id, $date = false)
	{
		$query = LedgerDetails::whereIn('account_code', ['4090'])
			->where('member_id', $member_id);
			

		if ($date)
			$query = $query->where('created_at', '<=', $date);
		
		return (int) $query->sum('amount');	
	}

	public function getMemberRecentBarterPurchaseTotal($days = 30, $member_id)
	{
		$carbon = Carbon::now('America/Chicago');

		$now = Carbon::now('America/Chicago')->toDateTimeString();

		$dateRange = [$carbon->subDays($days), $now];

		return (int) LedgerDetails::whereIn('account_code', ['6010'])
			->where('member_id', $member_id)
			->whereBetween('created_at', $dateRange)
			->sum('amount');
	}

	public function getMemberRecentBarterSaleTotal($days = 30, $member_id)
	{
		$carbon = Carbon::now('America/Chicago');

		$now = Carbon::now('America/Chicago')->toDateTimeString();

		$dateRange = [$carbon->subDays($days), $now];

		return (int) LedgerDetails::whereIn('account_code', ['4010'])
			->where('member_id', $member_id)
			->whereBetween('created_at', $dateRange)
			->sum('amount');
	}

	public function getGiftcardBarterBalance($giftcard_id)
	{
		return (int) LedgerDetails::whereIn('account_code', ['3050', '4010', '6010'])
			->where('giftcard_id', $giftcard_id)
			->sum('amount');
	}

	public function getGiftcardOriginalBarterBalance($giftcard_id)
	{
		return (int) LedgerDetails::whereIn('account_code', ['3050'])
			->where('giftcard_id', $giftcard_id)
			->sum('amount');
	}

	public function getGiftcardOriginalEntry($giftcard_id)
	{
		return LedgerDetails::whereIn('account_code', ['3050'])
			->where('giftcard_id', $giftcard_id)
			->first();
	}

	public function deleteByTransaction(Transaction $transaction)
	{
		$ledgerIds = $transaction->entries->lists('id');

		return $this->model->destroy($ledgerIds);
	}

	public function getTotalForTransactionsIdsByCodes($transactionIds, $accountCodes)
	{
		$query = LedgerDetails::whereIn('transaction_id', $transactionIds)
			->whereIn('account_code', $accountCodes);
			

		return (int) $query->sum('amount');	
	}
	
	public function MemberCashAccounts($query)
	{
		return $query->whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090']);
	}
	public function MemberBarterAccounts($query)
	{
		return $query->whereIn('account_code', ['4010', '4020', '4050', '4080', '6010']);
	}

    public function includeMember(User $user)
    {
        return $this->item($user->selectedMember(), new MemberTransformer);
    }
}