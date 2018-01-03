<?php namespace App\Http\Controllers\api;

class Settler {

	use DispatchableTrait;

	protected $transaction_type_id;
	protected $merchantExchange;
	protected $merchantMember;
	protected $merchantUser;
	protected $merchantGiftcard;
	protected $merchantSalesMember;
	protected $merchantReferrerMember;
	protected $customerExchange;
	protected $customerMember;
	protected $customerUser;
	protected $customerBartercard;
	protected $customerGiftcard;
	protected $customerSalesMember;
	protected $customerReferrerMember;
	
	protected $barter_amount;
	protected $tip_amount;
	protected $charge_amount;
	protected $credit_amount;
	protected $debit_amount;
	protected $notes;
	protected $member_cashier_id;

	protected $customer_ex_comm_rate;
	protected $merchant_ex_comm_rate;
	protected $customer_ref_comm_rate;
	protected $merchant_ref_comm_rate;
	protected $customer_sales_comm_rate;
	protected $merchant_sales_comm_rate;
	
	protected $customer_ex_comm_fee;
	protected $merchant_ex_comm_fee;
	protected $customer_ref_comm_fee;
	protected $merchant_ref_comm_fee;
	protected $customer_sales_comm_fee;
	protected $merchant_sales_comm_fee;
	
	protected $journalEntries;
	protected $transaction;

	/*
	 * @var TransactionRepo
	 */
	protected $transactionRepo;

	/*
	 * @var MemberRepo
	 */
	protected $memberRepo;

	/*
	 * @var GiftcardRepo
	 */
	protected $giftcardRepo;

	/*
	 * @var LedgerRepo
	 */
	protected $ledgerRepo;

	/*
	 * @var CalculatorInterface
	 */
	protected $calculator;

	public function __construct(TransactionRepo $transactionRepo, MemberRepo $memberRepo, GiftcardRepo $giftcardRepo, LedgerRepo $ledgerRepo, CalculatorInterface $calculator)
	{
		$this->transactionRepo = $transactionRepo;
		$this->memberRepo = $memberRepo;
		$this->giftcardRepo = $giftcardRepo;
		$this->ledgerRepo = $ledgerRepo;
		$this->calculator = $calculator;

		$this->transaction_type_id = false;
		$this->merchantExchange = false;
		$this->merchantMember = false;
		$this->merchantUser = false;
		$this->merchantGiftcard = false;
		$this->merchantSalesMember = false;
		$this->merchantReferrerMember = false;
		$this->customerExchange = false;
		$this->customerMember = false;
		$this->customerUser = false;
		$this->customerBartercard = false;
		$this->customerGiftcard = false;
		$this->customerSalesMember = false;
		$this->customerReferrerMember = false;
		
		$this->barter_amount = false;
		$this->tip_amount = false;
		$this->charge_amount = false;
		$this->credit_amount = false;
		$this->debit_amount = false;
		$this->notes = false;
		$this->member_cashier_id = false;

		$this->customer_ex_comm_rate = 0;
		$this->merchant_ex_comm_rate = 0;
		$this->customer_ref_comm_rate = 0;
		$this->merchant_ref_comm_rate = 0;
		$this->customer_sales_comm_rate = 0;
		$this->merchant_sales_comm_rate = 0;

		$this->customer_ex_comm_fee = 0;
		$this->merchant_ex_comm_fee = 0;
		$this->customer_ref_comm_fee = 0;
		$this->merchant_ref_comm_fee = 0;
		$this->customer_sales_comm_fee = 0;
		$this->merchant_sales_comm_fee = 0;

		$this->journalEntries = false;
		$this->transaction = false;
	}

	public function memberBartercardSale($merchantMember, $merchantUser, $customerBartercard)
	{
		$this->transaction_type_id = 11;
		
		$this->merchantMember = $merchantMember;
		$this->merchantUser = $merchantUser;
		$this->merchantExchange = $merchantMember->exchange;
		$this->merchantSalesMember = $merchantMember->activeSalespersonMember();
		$this->merchantReferrerMember = $merchantMember->referrer();

		$this->customerBartercard = $customerBartercard;

		$this->customerMember = $customerBartercard->member;
		$this->customerUser = $customerBartercard->user;
		$this->customerExchange = $customerBartercard->exchange;
		$this->customerSalesMember = $this->customerMember->activeSalespersonMember();
		$this->customerReferrerMember = $this->customerMember->referrer();

		return $this;
	}

	public function memberGiftcardSale($merchantMember, $merchantUser, $customerGiftcard)
	{
		$this->transaction_type_id = 12;
		
		$this->merchantMember = $merchantMember;
		$this->merchantUser = $merchantUser;
		$this->merchantExchange = $merchantMember->exchange;
		$this->merchantReferrerMember = $merchantMember->referrer();

		$this->customerGiftcard = $customerGiftcard;

		$this->customerExchange = $customerGiftcard->exchange;
		$this->customerUser = $customerGiftcard->user;

		return $this;
	}

	public function memberToMemberPurchase($customerMember, $customerUser, $merchantMember)
	{
		$this->transaction_type_id = 25;
		
		$this->merchantMember = $merchantMember;
		$this->merchantExchange = $merchantMember->exchange;
		$this->merchantSalesMember = $merchantMember->activeSalespersonMember();
		$this->merchantReferrerMember = $merchantMember->referrer();

		$this->customerMember = $customerMember;
		$this->customerExchange = $customerMember->exchange;
		$this->customerUser = $customerUser;
		$this->customerSalesMember = $customerMember->activeSalespersonMember();
		$this->customerReferrerMember = $customerMember->referrer();

		return $this;
	}

	public function memberCbaDeposit($customerMember, $customerUser)
	{       dd($customerMember);
		$this->transaction_type_id = 21;
		
		$this->merchantExchange = $customerMember->exchange;

		$this->customerMember = $customerMember;
		$this->customerExchange = $customerMember->exchange;
		$this->customerUser = $customerUser;

		return $this;
	}

	public function exchangeSaleGiftcardToMember($merchantExchange, $merchantUser, $customerGiftcard, $customerMember)
	{
		$this->transaction_type_id = 42;
		
		$this->merchantExchange = $merchantExchange;
		$this->merchantUser = $merchantUser;

		$this->customerGiftcard = $customerGiftcard;
		$this->customerMember = $customerMember;
		$this->customerExchange = $customerMember->exchange;

		return $this;
	}

	public function exchangeMemberBarterCredit($merchantExchange, $merchantUser, $customerMember)
	{
		$this->transaction_type_id = 71;
		
		$this->merchantExchange = $merchantExchange;
		$this->merchantUser = $merchantUser;

		$this->customerMember = $customerMember;
		$this->customerExchange = $customerMember->exchange;

		return $this;
	}

	public function exchangeMemberCbaCredit($merchantExchange, $merchantUser, $customerMember)
	{
		$this->transaction_type_id = 72;
		
		$this->merchantExchange = $merchantExchange;
		$this->merchantUser = $merchantUser;

		$this->customerMember = $customerMember;
		$this->customerExchange = $customerMember->exchange;

		return $this;
	}

	public function exchangeMemberBarterDebit($merchantExchange, $merchantUser, $customerMember)
	{
		$this->transaction_type_id = 73;
		
		$this->merchantExchange = $merchantExchange;
		$this->merchantUser = $merchantUser;

		$this->customerMember = $customerMember;
		$this->customerExchange = $customerMember->exchange;

		return $this;
	}

	public function exchangeMemberCbaWithdrawal($merchantExchange, $merchantUser, $customerMember)
	{
		$this->transaction_type_id = 75;
		
		$this->merchantExchange = $merchantExchange;
		$this->merchantUser = $merchantUser;

		$this->customerMember = $customerMember;
		$this->customerExchange = $customerMember->exchange;

		return $this;
	}

	public function exchangeMemberCbaDirectPayment($merchantExchange, $merchantUser, $customerMember)
	{
		$this->transaction_type_id = 81;
		
		$this->merchantExchange = $merchantExchange;
		$this->merchantUser = $merchantUser;

		$this->customerMember = $customerMember;
		$this->customerExchange = $customerMember->exchange;

		return $this;
	}

	public function load($charge_amount)
	{
		$this->charge_amount = $charge_amount;

		return $this->settle();
	}

	public function credit($credit_amount, $notes = false)
	{
		$this->credit_amount = $credit_amount;

		return $this->settle(false, false, $notes);
	}

	public function debit($debit_amount, $notes = false)
	{
		$this->debit_amount = $debit_amount;

		return $this->settle(false, false, $notes);
	}

	public function settle($barter_amount = false, $tip_amount = false, $notes = false, $member_cashier_id = false)
	{
		$this->barter_amount = $barter_amount;
		$this->tip_amount = $tip_amount;
		$this->notes = $notes;
		$this->member_cashier_id = $member_cashier_id;

		switch ($this->transaction_type_id) {
			
			case 11: // member pos sale to bartercard
				
				$settledTransaction = $this->settleMemberPosSaleBartercard();
				break;

			case 12: // member pos sale to giftcard
				
				$settledTransaction = $this->settleMemberPosSaleGiftcard();
				break;

			case 21: // member cba deposit
				
				$settledTransaction = $this->settleMemberCbaDeposit();
				break;

			case 25: // member user to member purchase
				
				$settledTransaction = $this->settleMemberUserToMemberPurchase();
				break;

			case 42: // exchange sale a giftcard to a child member
				
				$settledTransaction = $this->settleExchangeGiftcardSaleToMember();
				break;

			case 71: // exchange member barter credit
				
				$settledTransaction = $this->settleExchangeMemberBarterCredit();
				break;

			case 72: // exchange member cba credit
				
				$settledTransaction = $this->settleExchangeMemberCbaCredit();
				break;

			case 73: // exchange member barter debit
				
				$settledTransaction = $this->settleExchangeMemberBarterDebit();
				break;

			case 75: // exchange member cba withdrawal
				
				$settledTransaction = $this->settleExchangeMemberCbaWithdrawal();
				break;

			case 81: // exchange member cba direct payment
				
				$settledTransaction = $this->settleExchangeMemberCbaDirectPayment();
				break;
			
			default:
				
				break;
		}

		return $settledTransaction;
	}

	/**
	 * Settle a member POS bartercard sale
	 */
	private function settleMemberPosSaleBartercard()
	{
		// determine rates
		$this->customer_ex_comm_rate = $this->customerMember->ex_purchase_comm_rate;
		$this->merchant_ex_comm_rate = $this->merchantMember->ex_sale_comm_rate;

		$this->customer_ref_comm_rate = ($this->customerReferrerMember) ? $this->customerMember->ref_purchase_comm_rate : 0;
		$this->merchant_ref_comm_rate = ($this->merchantReferrerMember) ? $this->merchantMember->ref_sale_comm_rate : 0;

		$this->customer_sales_comm_rate = ($this->customerSalesMember) ? $this->customerMember->sales_purchase_comm_rate : 0;
		$this->merchant_sales_comm_rate = ($this->merchantSalesMember) ? $this->merchantMember->sales_sale_comm_rate : 0;

		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => $this->transaction_type_id,
			'merchant_exchange_id' => ($this->merchantExchange) ? $this->merchantExchange->id : 0,
			'merchant_member_id' => ($this->merchantMember) ? $this->merchantMember->id : 0,
			'merchant_user_id' => ($this->merchantUser) ? $this->merchantUser->id : 0,
			'merchant_ref_member_id' =>  ($this->merchantReferrerMember) ? $this->merchantMember->ref_member_id : 0,
			'merchant_sales_member_id' =>  ($this->merchantSalesMember) ? $this->merchantSalesMember->id : 0,
			'customer_exchange_id' => ($this->customerExchange) ? $this->customerExchange->id : 0,
			'customer_member_id' => ($this->customerMember) ? $this->customerMember->id : 0,
			'customer_user_id' => ($this->customerUser) ? $this->customerUser->id : 0,
			'customer_ref_member_id' => ($this->customerReferrerMember) ? $this->customerMember->ref_member_id : 0,
			'customer_sales_member_id' =>  ($this->customerSalesMember) ? $this->customerSalesMember->id : 0,
			'notes' => $this->notes,
			'member_cashier_id' => $this->member_cashier_id,
			'customer_ex_comm_rate' => $this->customer_ex_comm_rate,
			'merchant_ex_comm_rate' => $this->merchant_ex_comm_rate,
			'customer_ref_comm_rate' => $this->customer_ref_comm_rate,
			'merchant_ref_comm_rate' => $this->merchant_ref_comm_rate,
			'customer_sales_comm_rate' => $this->customer_sales_comm_rate,
			'merchant_sales_comm_rate' => $this->merchant_sales_comm_rate,
		]);

		// calculate commission rates
		
		$this->customer_ex_comm_fee = $this->calculator->getExchangeTransactionFee('purchase', $this->customerMember, $this->barter_amount);

		if ($this->customer_ref_comm_rate)
		{
			$this->customer_ref_comm_fee = $this->calculator->getMemberReferrerCommission('purchase', $this->customerMember, $this->barter_amount);
			$this->customer_ex_comm_fee = $this->customer_ex_comm_fee - $this->customer_ref_comm_fee;
		}

		if ($this->customer_sales_comm_rate)
		{
			$this->customer_sales_comm_fee = $this->calculator->getSalespersonMemberCommission('purchase', $this->customerMember, $this->barter_amount);
			$this->customer_ex_comm_fee = $this->customer_ex_comm_fee - $this->customer_sales_comm_fee;
		}

		$this->merchant_ex_comm_fee = $this->calculator->getExchangeTransactionFee('sale', $this->merchantMember, $this->barter_amount);

		if ($this->merchant_ref_comm_rate)
		{
			$this->merchant_ref_comm_fee = $this->calculator->getMemberReferrerCommission('purchase', $this->merchantMember, $this->barter_amount);
			$this->merchant_ex_comm_fee = $this->merchant_ex_comm_fee - $this->merchant_ref_comm_fee;
		}

		if ($this->merchant_sales_comm_rate)
		{
			$this->merchant_sales_comm_fee = $this->calculator->getSalespersonMemberCommission('purchase', $this->merchantMember, $this->barter_amount);
			$this->merchant_ex_comm_fee = $this->merchant_ex_comm_fee - $this->merchant_sales_comm_fee;
		}

		// create and persist journal entries
		$this->journalEntries = [];
		
		// Debit customer member’s barter account
		$this->journalEntries[] = $this->createJournalEntry('6010', -$this->barter_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

		// Credit merchant member’s barter account
		$this->journalEntries[] = $this->createJournalEntry('4010', $this->barter_amount, $transaction->id, ['member_id' => $this->merchantMember->id ]);

		if ($this->customer_ref_comm_fee)
		{
			// Debit Customer Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7070', -$this->customer_ref_comm_fee, $transaction->id, ['member_id' => $this->customerMember->id ]);

			// Credit Customer Member sponsor’s CBA account with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4070', $this->customer_ref_comm_fee, $transaction->id, ['member_id' => $this->customerMember->ref_member_id ]);
		}

		if ($this->merchant_ref_comm_fee)
		{
			// Debit Merchant Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7070', -$this->merchant_ref_comm_fee, $transaction->id, ['member_id' => $this->merchantMember->id ]);

			// Credit Merchant Member sponsor’s CBA account with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4070', $this->merchant_ref_comm_fee, $transaction->id, ['member_id' => $this->merchantMember->ref_member_id ]);
		}

		if ($this->customer_sales_comm_fee)
		{
			// Debit Customer Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7090', -$this->customer_sales_comm_fee, $transaction->id, ['member_id' => $this->customerMember->id ]);

			// Credit Customer Salesperson Member’s CBA account with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4090', $this->customer_sales_comm_fee, $transaction->id, ['member_id' => $this->customerSalesMember->id ]);
		}

		if ($this->merchant_sales_comm_fee)
		{
			// Debit Merchant Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7090', -$this->merchant_sales_comm_fee, $transaction->id, ['member_id' => $this->merchantMember->id ]);

			// Credit Merchant Salesperson Member’s CBA account with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4090', $this->merchant_sales_comm_fee, $transaction->id, ['member_id' => $this->merchantSalesMember->id ]);
		}

		if ($this->customer_ex_comm_fee)
		{
			// Debit Customer Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7010', -$this->customer_ex_comm_fee, $transaction->id, ['member_id' => $this->customerMember->id ]);

			// Credit Customer Member’s parent exchange with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4140', $this->customer_ex_comm_fee, $transaction->id, ['exchange_id' => $this->customerExchange->id ]);
		}

		if ($this->merchant_ex_comm_fee)
		{
			// Debit Merchant Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7010', -$this->merchant_ex_comm_fee, $transaction->id, ['member_id' => $this->merchantMember->id ]);

			// Credit Merchant Member’s parent exchange with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4140', $this->merchant_ex_comm_fee, $transaction->id, ['exchange_id' => $this->merchantExchange->id ]);
		}

		if ($this->tip_amount)
		{
			// Debit Customer Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7030', -$this->tip_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

			// Credit Merchant Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('4030', $this->tip_amount, $transaction->id, ['member_id' => $this->merchantMember->id ]);
		}

		// mark transaction as settled
		$this->transaction = $this->transactionRepo->settle($transaction);

		$settledResponse = $this->getSettledResponse();

		return $settledResponse;
	}

	/**
	 * Settle a member POS giftcard sale
	 */
	private function settleMemberPosSaleGiftcard()
	{
		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => $this->transaction_type_id,
			'merchant_exchange_id' => $this->merchantExchange->id,
			'merchant_member_id' => $this->merchantMember->id,
			'merchant_user_id' => $this->merchantUser->id,
			'merchant_ref_member_id' =>  ($this->merchantReferrerMember) ? $this->merchantMember->ref_member_id : 0,
			'customer_exchange_id' => $this->customerExchange->id,
			'customer_giftcard_id' => $this->customerGiftcard->id,
			'notes' => $this->notes,
			'member_cashier_id' => $this->member_cashier_id,
		]);

		// create and persist journal entries
		$this->journalEntries = [];
		
		// Debit customer giftcard's barter account
		$this->journalEntries[] = $this->createJournalEntry('6010', -$this->barter_amount, $transaction->id, ['giftcard_id' => $this->customerGiftcard->id ]);
		
		// Credit merchant member’s barter account
		$this->journalEntries[] = $this->createJournalEntry('4010', $this->barter_amount, $transaction->id, ['member_id' => $this->merchantMember->id ]);

		$this->transaction = $this->transactionRepo->settle($transaction);

		$settledResponse = $this->getSettledResponse();

		return $settledResponse;
	}

	/**
	 * Settle a member cba deposit
	 */
	private function settleMemberCbaDeposit()
	{
		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => 21,
			'merchant_exchange_id' => $this->merchantExchange->id,
			'customer_exchange_id' => $this->customerExchange->id,
			'customer_member_id' => $this->customerMember->id,
			'customer_user_id' => $this->customerUser->id,
		]);

		// create and persist journal entries
		$this->journalEntries = [];

		// Credit customer member’s cba account
		$this->journalEntries[] = $this->createJournalEntry('3010', $this->charge_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);
		
		// Credit merchant exchange’s unearned member barter revenue account
		$this->journalEntries[] = $this->createJournalEntry('4120', $this->charge_amount, $transaction->id, ['exchange_id' => $this->merchantExchange->id ]);

		$this->transaction = $this->transactionRepo->settle($transaction);

		$settledResponse = $this->getSettledResponse();

		return $settledResponse;
	}

	/**
	 * Settle a member user to member POS purchase
	 */
	private function settleMemberUserToMemberPurchase()
	{
		// determine rates
		$this->customer_ex_comm_rate = $this->customerMember->ex_purchase_comm_rate;
		$this->merchant_ex_comm_rate = $this->merchantMember->ex_sale_comm_rate;

		$this->customer_ref_comm_rate = ($this->customerReferrerMember) ? $this->customerMember->ref_purchase_comm_rate : 0;
		$this->merchant_ref_comm_rate = ($this->merchantReferrerMember) ? $this->merchantMember->ref_sale_comm_rate : 0;

		$this->customer_sales_comm_rate = ($this->customerSalesMember) ? $this->customerMember->sales_purchase_comm_rate : 0;
		$this->merchant_sales_comm_rate = ($this->merchantSalesMember) ? $this->merchantMember->sales_sale_comm_rate : 0;

		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => $this->transaction_type_id,
			'merchant_exchange_id' => ($this->merchantExchange) ? $this->merchantExchange->id : 0,
			'merchant_member_id' => ($this->merchantMember) ? $this->merchantMember->id : 0,
			'merchant_ref_member_id' =>  ($this->merchantReferrerMember) ? $this->merchantMember->ref_member_id : 0,
			'merchant_sales_member_id' =>  ($this->merchantSalesMember) ? $this->merchantSalesMember->id : 0,
			'customer_exchange_id' => ($this->customerExchange) ? $this->customerExchange->id : 0,
			'customer_member_id' => ($this->customerMember) ? $this->customerMember->id : 0,
			'customer_user_id' => ($this->customerUser) ? $this->customerUser->id : 0,
			'customer_ref_member_id' => ($this->customerReferrerMember) ? $this->customerMember->ref_member_id : 0,
			'customer_sales_member_id' =>  ($this->customerSalesMember) ? $this->customerSalesMember->id : 0,
			'notes' => $this->notes,
			'customer_ex_comm_rate' => $this->customer_ex_comm_rate,
			'merchant_ex_comm_rate' => $this->merchant_ex_comm_rate,
			'customer_ref_comm_rate' => $this->customer_ref_comm_rate,
			'merchant_ref_comm_rate' => $this->merchant_ref_comm_rate,
			'customer_sales_comm_rate' => $this->customer_sales_comm_rate,
			'merchant_sales_comm_rate' => $this->merchant_sales_comm_rate,
		]);

		// calculate commission rates
		
		$this->customer_ex_comm_fee = $this->calculator->getExchangeTransactionFee('purchase', $this->customerMember, $this->barter_amount);

		if ($this->customer_ref_comm_rate)
		{
			$this->customer_ref_comm_fee = $this->calculator->getMemberReferrerCommission('purchase', $this->customerMember, $this->barter_amount);
			$this->customer_ex_comm_fee = $this->customer_ex_comm_fee - $this->customer_ref_comm_fee;
		}

		if ($this->customer_sales_comm_rate)
		{
			$this->customer_sales_comm_fee = $this->calculator->getSalespersonMemberCommission('purchase', $this->customerMember, $this->barter_amount);
			$this->customer_ex_comm_fee = $this->customer_ex_comm_fee - $this->customer_sales_comm_fee;
		}

		$this->merchant_ex_comm_fee = $this->calculator->getExchangeTransactionFee('sale', $this->merchantMember, $this->barter_amount);

		if ($this->merchant_ref_comm_rate)
		{
			$this->merchant_ref_comm_fee = $this->calculator->getMemberReferrerCommission('purchase', $this->merchantMember, $this->barter_amount);
			$this->merchant_ex_comm_fee = $this->merchant_ex_comm_fee - $this->merchant_ref_comm_fee;
		}

		if ($this->merchant_sales_comm_rate)
		{
			$this->merchant_sales_comm_fee = $this->calculator->getSalespersonMemberCommission('purchase', $this->merchantMember, $this->barter_amount);
			$this->merchant_ex_comm_fee = $this->merchant_ex_comm_fee - $this->merchant_sales_comm_fee;
		}

		// record journal entries

		$this->journalEntries = [];
		
		// Debit customer member’s barter account
		$this->journalEntries[] = $this->createJournalEntry('6010', -$this->barter_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

		// Credit merchant member’s barter account
		$this->journalEntries[] = $this->createJournalEntry('4010', $this->barter_amount, $transaction->id, ['member_id' => $this->merchantMember->id ]);

		if ($this->customer_ref_comm_fee)
		{
			// Debit Customer Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7070', -$this->customer_ref_comm_fee, $transaction->id, ['member_id' => $this->customerMember->id ]);

			// Credit Customer Member sponsor’s CBA account with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4070', $this->customer_ref_comm_fee, $transaction->id, ['member_id' => $this->customerMember->ref_member_id ]);
		}

		if ($this->merchant_ref_comm_fee)
		{
			// Debit Merchant Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7070', -$this->merchant_ref_comm_fee, $transaction->id, ['member_id' => $this->merchantMember->id ]);

			// Credit Merchant Member sponsor’s CBA account with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4070', $this->merchant_ref_comm_fee, $transaction->id, ['member_id' => $this->merchantMember->ref_member_id ]);
		}

		if ($this->customer_sales_comm_fee)
		{
			// Debit Customer Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7090', -$this->customer_sales_comm_fee, $transaction->id, ['member_id' => $this->customerMember->id ]);

			// Credit Customer Salesperson Member’s CBA account with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4090', $this->customer_sales_comm_fee, $transaction->id, ['member_id' => $this->customerSalesMember->id ]);
		}

		if ($this->merchant_sales_comm_fee)
		{
			// Debit Merchant Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7090', -$this->merchant_sales_comm_fee, $transaction->id, ['member_id' => $this->merchantMember->id ]);

			// Credit Merchant Salesperson Member’s CBA account with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4090', $this->merchant_sales_comm_fee, $transaction->id, ['member_id' => $this->merchantSalesMember->id ]);
		}

		if ($this->customer_ex_comm_fee)
		{
			// Debit Customer Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7010', -$this->customer_ex_comm_fee, $transaction->id, ['member_id' => $this->customerMember->id ]);

			// Credit Customer Member’s parent exchange with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4140', $this->customer_ex_comm_fee, $transaction->id, ['exchange_id' => $this->customerExchange->id ]);
		}

		if ($this->merchant_ex_comm_fee)
		{
			// Debit Merchant Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7010', -$this->merchant_ex_comm_fee, $transaction->id, ['member_id' => $this->merchantMember->id ]);

			// Credit Merchant Member’s parent exchange with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4140', $this->merchant_ex_comm_fee, $transaction->id, ['exchange_id' => $this->merchantExchange->id ]);
		}

		if ($this->tip_amount)
		{
			// Debit Customer Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7030', -$this->tip_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

			// Credit Merchant Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('4030', $this->tip_amount, $transaction->id, ['member_id' => $this->merchantMember->id ]);
		}

		$this->transaction = $this->transactionRepo->settle($transaction);

		$settledResponse = $this->getSettledResponse();

		return $settledResponse;
	}

	/**
	 * Settle an exchange giftcard sale to a member
	 */
	private function settleExchangeGiftcardSaleToMember()
	{
		// calculate commission rates
		$this->customer_ex_comm_fee = $this->calculator->getExchangeGiftcardFee($this->customerMember, $this->barter_amount);

		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => $this->transaction_type_id,
			'merchant_exchange_id' => $this->merchantExchange->id,
			'merchant_user_id' => ( ! empty($this->merchantUser)) ? $this->merchantUser->id : 0,
			'customer_giftcard_id' => $this->customerGiftcard->id,
			'customer_member_id' => $this->customerMember->id,
			'customer_exchange_id' => ( ! empty($this->customerExchange)) ? $this->customerExchange->id : 0,
			'notes' => $this->notes,
		]);

		// create and persist journal entries
		$this->journalEntries = [];
		
		// Credit customer giftcard's barter account
		$this->journalEntries[] = $this->createJournalEntry('3050', $this->barter_amount, $transaction->id, ['giftcard_id' => $this->customerGiftcard->id ]);

		// Debit customer member’s barter account
		$this->journalEntries[] = $this->createJournalEntry('4050', -$this->barter_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

		if ($this->customer_ex_comm_fee)
		{
			// Debit Customer Member’s CBA account
			$this->journalEntries[] = $this->createJournalEntry('7020', -$this->customer_ex_comm_fee, $transaction->id, ['member_id' => $this->customerMember->id ]);

			// Credit Merchant Exchange with the calculated commission
			$this->journalEntries[] = $this->createJournalEntry('4160', $this->customer_ex_comm_fee, $transaction->id, ['exchange_id' => $this->merchantExchange->id ]);

			$this->charge_amount = $this->customer_ex_comm_fee;
		}

		$this->transaction = $this->transactionRepo->settle($transaction);

		$settledResponse = $this->getSettledResponse();

		return $settledResponse;
	}

	/**
	 * Settle an exchange member barter credit
	 */
	private function settleExchangeMemberBarterCredit()
	{
		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => $this->transaction_type_id,
			'merchant_exchange_id' => $this->merchantExchange->id,
			'merchant_user_id' => $this->merchantUser->id,
			'customer_exchange_id' => $this->customerExchange->id,
			'customer_member_id' => $this->customerMember->id,
			'notes' => $this->notes,
		]);

		// record journal entries
		$this->journalEntries = [];
		
		// Credit customer member’s barter account
		$this->journalEntries[] = $this->createJournalEntry('4020', $this->credit_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

		// Credit merchant exchange's barter expense account
		$this->journalEntries[] = $this->createJournalEntry('8020', $this->credit_amount, $transaction->id, ['exchange_id' => $this->merchantExchange->id ]);

		$this->transaction = $this->transactionRepo->settle($transaction);

		return true;
	}

	/**
	 * Settle an exchange member barter debit
	 */
	private function settleExchangeMemberBarterDebit()
	{
		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => $this->transaction_type_id,
			'merchant_exchange_id' => $this->merchantExchange->id,
			'merchant_user_id' => $this->merchantUser->id,
			'customer_exchange_id' => $this->customerExchange->id,
			'customer_member_id' => $this->customerMember->id,
			'notes' => $this->notes,
		]);

		// record journal entries
		$this->journalEntries = [];
		
		// Debit customer member’s barter account
		$this->journalEntries[] = $this->createJournalEntry('4080', -$this->debit_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

		// Debit merchant exchange's barter expense account
		$this->journalEntries[] = $this->createJournalEntry('8030', -$this->debit_amount, $transaction->id, ['exchange_id' => $this->merchantExchange->id ]);

		$this->transaction = $this->transactionRepo->settle($transaction);

		return true;
	}

	/**
	 * Settle an exchange member cba credit
	 */
	private function settleExchangeMemberCbaCredit()
	{
		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => $this->transaction_type_id,
			'merchant_exchange_id' => $this->merchantExchange->id,
			'merchant_user_id' => $this->merchantUser->id,
			'customer_exchange_id' => $this->customerExchange->id,
			'customer_member_id' => $this->customerMember->id,
			'notes' => $this->notes,
		]);

		// record journal entries
		$this->journalEntries = [];
		
		// Credit customer member’s cba account
		$this->journalEntries[] = $this->createJournalEntry('4040', $this->credit_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

		// Credit merchant exchange's cba expense account
		$this->journalEntries[] = $this->createJournalEntry('8040', $this->credit_amount, $transaction->id, ['exchange_id' => $this->merchantExchange->id ]);

		$this->transaction = $this->transactionRepo->settle($transaction);

		return true;
	}

	/**
	 * Settle an exchange member cba direct payment
	 */
	private function settleExchangeMemberCbaDirectPayment()
	{
		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => $this->transaction_type_id,
			'merchant_exchange_id' => $this->merchantExchange->id,
			'merchant_user_id' => $this->merchantUser->id,
			'customer_exchange_id' => $this->customerExchange->id,
			'customer_member_id' => $this->customerMember->id,
			'notes' => $this->notes,
		]);

		// record journal entries
		$this->journalEntries = [];
		
		// Credit customer member’s cba account
		$this->journalEntries[] = $this->createJournalEntry('3020', $this->credit_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

		// Credit merchant exchange’s unearned member barter revenue account
		$this->journalEntries[] = $this->createJournalEntry('4120', $this->credit_amount, $transaction->id, ['exchange_id' => $this->merchantExchange->id ]);

		$this->transaction = $this->transactionRepo->settle($transaction);

		return true;
	}

	/**
	 * Settle an exchange member cba withdrawal
	 */
	private function settleExchangeMemberCbaWithdrawal()
	{
		// create transaction
		$transaction = $this->transactionRepo->record([
			'type_id' => $this->transaction_type_id,
			'merchant_exchange_id' => $this->merchantExchange->id,
			'merchant_user_id' => $this->merchantUser->id,
			'customer_exchange_id' => $this->customerExchange->id,
			'customer_member_id' => $this->customerMember->id,
			'notes' => $this->notes,
		]);

		// record journal entries
		$this->journalEntries = [];
		
		// Debit customer member’s cba account
		$this->journalEntries[] = $this->createJournalEntry('7040', -$this->debit_amount, $transaction->id, ['member_id' => $this->customerMember->id ]);

		// Debit merchant exchange’s unearned member barter revenue account
		$this->journalEntries[] = $this->createJournalEntry('4120', -$this->debit_amount, $transaction->id, ['exchange_id' => $this->merchantExchange->id ]);

		$this->transaction = $this->transactionRepo->settle($transaction);

		return true;
	}

	private function getSettledResponse()
	{
		return $response = [
			'transaction' => $this->transaction,
			'transaction_type_id' => $this->transaction_type_id,
			'customer_ex_comm_rate' => $this->customer_ex_comm_rate,
			'merchant_ex_comm_rate' => $this->merchant_ex_comm_rate,
			'customer_ref_comm_rate' => $this->customer_ref_comm_rate,
			'merchant_ref_comm_rate' => $this->merchant_ref_comm_rate,
			'customer_sales_comm_rate' => $this->customer_sales_comm_rate,
			'merchant_sales_comm_rate' => $this->merchant_sales_comm_rate,
			'barter_amount' => $this->barter_amount,
			'barter_amount_display' => presentBarterAmount($this->barter_amount, 'T$0.00'),
			'tip_amount' => $this->tip_amount,
			'tip_amount_display' => presentCashAmount($this->tip_amount, '$0.00'),
			'charge_amount' => $this->charge_amount,
			'charge_amount_display' => presentCashAmount($this->charge_amount, '$0.00'),
			'customer_ex_comm_fee' => presentCashAmount($this->customer_ex_comm_fee, '$0.00'),
			'merchant_ex_comm_fee' => presentCashAmount($this->merchant_ex_comm_fee, '$0.00'),
			'customer_ref_comm_fee' => presentCashAmount($this->customer_ref_comm_fee, '$0.00'),
			'merchant_ref_comm_fee' => presentCashAmount($this->merchant_ref_comm_fee, '$0.00'),
			'customer_sales_comm_fee' => presentCashAmount($this->customer_sales_comm_fee, '$0.00'),
			'merchant_sales_comm_fee' => presentCashAmount($this->merchant_sales_comm_fee, '$0.00'),
			'journalEntries' => $this->journalEntries,
			'merchantExchange' => $this->merchantExchange,
			'merchantMember' => $this->merchantMember,
			'merchantGiftcard' => $this->merchantGiftcard,
			'merchantUser' => $this->merchantUser,
			'merchantSalesMember' => $this->merchantSalesMember,
			'customerExchange' => $this->customerExchange,
			'customerMember' => $this->customerMember,
			'customerBartercard' => $this->customerBartercard,
			'customerGiftcard' => $this->customerGiftcard,
			'customerUser' => $this->customerUser,
			'customerSalesMember' => $this->customerSalesMember,
			'notes' => $this->notes,
			'member_cashier_id' => $this->member_cashier_id,
		];
	}

	private function createJournalEntry($code, $amount, $transaction_id, array $account)
	{
		$entryData = [
			'account_code' => $code,
			'amount' => $amount,
			'transaction_id' => $transaction_id,
		];

		foreach ($account as $key => $value)
		{
			$entryData[$key] = $value;
			
			if ($key == 'member_id')
			{
				$member = $this->memberRepo->getById($value);
				$entryData['exchange_id'] = $member->exchange->id;
			}

			if ($key == 'giftcard_id')
			{
				$giftcard = $this->giftcardRepo->getById($value);
				$entryData['exchange_id'] = $giftcard->exchange->id;
			}
		}

		return $this->ledgerRepo->createJournalEntry($entryData);
	}

}