<?php namespace Peos\Services\Authorizer;

use App\Peos\Services\Authorizer\AuthorizerException;

use App\Exchange;
use App\Member;
use App\User;
//use Peos\Cards\Bartercards\Bartercard;
//use Peos\Cards\Giftcards\Giftcard;
//use Peos\Services\Calculator\CalculatorInterface;

class Authorizer {

	protected $merchantExchange;
	protected $merchantMember;
	protected $merchantGiftcard;
	protected $merchantUser;
	protected $customerExchange;
	protected $customerMember;
	protected $customerBartercard;
	protected $customerGiftcard;
	protected $customerUser;
	protected $barter_amount;
	protected $tip_amount;
	protected $charge_amount;
	protected $debit_amount;
	protected $calculator;

	public function __construct(CalculatorInterface $calculator)
	{
		//$this->merchantExchange = null;
		//$this->merchantMember = null;
		//$this->merchantGiftcard = null;
		//$this->merchantUser = null;
		//$this->customerExchange = null;
		//$this->customerMember = null;
		////$this->customerBartercard = null;
		////$this->customerGiftcard = null;
		//$this->customerUser = null;
		//
		//$this->barter_amount = 0;
		//$this->tip_amount = 0;
		//$this->charge_amount = 0;
		//$this->debit_amount = 0;

		//$this->calculator = $calculator;
	}

	public function merchant(Member $merchantMember, User $merchantUser = null)
	{
		$this->merchantMember = $merchantMember;
		$this->merchantUser = $merchantUser;

		if ( ! empty($merchantUser))
		{
			// is this merchant user allowed to make this sale on behalf of the merchant member?
			if ( ! $merchantUser->hasMemberAccess($merchantMember, 'cashier'))
			{
				throw new AuthorizerException('That user does not have the permission to make this sale');
			}
		}

		// is this merchant member allowed to make a sale?
		if ($this->merchantMember->standby)
			throw new AuthorizerException('Merchant is on standby and currently not allowed to sell');

		$this->merchantExchange = $this->merchantMember->exchange;

		return $this;
	}

	public function memberCba(Member $customerMember, User $customerUser)
	{
		$this->customerMember = $customerMember;
		$this->customerUser = $customerUser;
		$this->customerExchange = $customerMember->exchange;

		$this->merchantExchange = $customerMember->exchange;

		// is this customer user allowed to access billing on behalf of the customer member?
		if ( ! $customerUser->hasMemberAccess($customerMember, 'billing'))
		{
			throw new AuthorizerException('That user does not have the permission to access billing data');
		}

		return $this;
	}

	public function bartercard(Bartercard $bartercard)
	{
		// is this barter card active per it's issuing parent member?
		if ( ! $bartercard->active)
			throw new AuthorizerException('Card has been deactivated.');

		$this->customerBartercard = $bartercard;
		$this->customerUser = $this->customerBartercard->user;
		$this->customerMember = $this->customerBartercard->member;
		$this->customerExchange = $this->customerMember->exchange;

		// does this merchant exchange accept barter from customer exchange?
		if($this->merchantMember->id == $this->customerMember->id)
			throw new AuthorizerException('A member cannot make a sale to itself.');

		// does this merchant exchange accept barter from customer exchange?
		if( ! $this->merchantExchange->acceptsBarterFromCustomerExchange($this->customerExchange))
			throw new AuthorizerException('Barter not allowed between these exchanges.');

		return $this;
	}

	public function customerMember(Member $customerMember, User $customerUser = null, $memberPurchaseTransaction = true)
	{
		$this->customerMember = $customerMember;
		$this->customerUser = $customerUser;
		$this->customerExchange = $this->customerMember->exchange;

		if ($memberPurchaseTransaction)
		{
			// does this customer user have permission to purchase on behalf of this customer member?
			if ( ! $customerUser->hasMemberAccess($customerMember, 'purchaser'))
			{
				throw new AuthorizerException('That user is not allowed to make purchases on behalf of that member.');
			}
		}

		// does this merchant exchange accept barter from customer exchange?
		if( ! $this->merchantExchange->acceptsBarterFromCustomerExchange($this->customerExchange))
			throw new AuthorizerException('Barter not allowed between these exchanges.');

		return $this;
	}

	public function giftcard(Giftcard $giftcard)
	{
		// is this gift card active per it's issuing parent exchange?
		if ( ! $giftcard->active)
			throw new AuthorizerException('Gift card has been deactivated.');

		$this->customerGiftcard = $giftcard;
		$this->customerUser = $this->customerGiftcard->user;
		$this->customerExchange = $this->customerGiftcard->exchange;

		// Merchant member accepts gift cards? 
		if ( ! $this->merchantMember->acceptsGiftcards())
			throw new AuthorizerException('Merchant member does not accept gift cards at this time.');

		// does this merchant exchange accept giftcards from customer exchange?
		if( ! $this->merchantExchange->acceptsGiftcardFromCustomerExchange($this->customerExchange))
			throw new AuthorizerException('Gift card purchases not allowed between these exchanges.');

		return $this;
	}

	public function tip($amount)
	{
		$this->tip_amount = $amount;

		// is the tip amount less than zero?
		if ($this->tip_amount < 0)
			throw new AuthorizerException('Invalid tip amount.');

		return $this;
	}

	public function barter($amount)
	{
		$this->barter_amount = $amount;
		
		// is the barter amount less than zero?
		if ($this->barter_amount < 0)
			throw new AuthorizerException('Invalid barter amount.');

		// does this customer member have barter spending power to allow this transaction?
		if ($this->barter_amount > $this->customerMember->availableBarterCredit())
			throw new AuthorizerException('Declined. Customer does not have enough barter balance.');

		// does this transaction exceed this member user's monthly spending limit?
		if ( ! $this->customerUser->allowedToSpendBarterAmountPerMember($this->customerMember, $this->barter_amount))
			throw new AuthorizerException('Declined. User over monthly spending limit.');
		
		
		// customer CBA fee check
		$customerTransactionFee = $this->calculator->getExchangeTransactionFee('purchase', $this->customerMember, $this->barter_amount);
		
		// does this customer member have enough cba balance for fee & any tip?
		if (($customerTransactionFee + $this->tip_amount) > $this->customerMember->cbaBalance())
			throw new AuthorizerException('Declined. Customer does not have enough member CBA balance.');

		
		// merchant CBA fee check
		$merchantTransactionFee = $this->calculator->getExchangeTransactionFee('sale', $this->merchantMember, $this->barter_amount);

		// does this merchant member have enough cba balance for fee
		if ($merchantTransactionFee > $this->merchantMember->cbaBalance())
			throw new AuthorizerException('Declined. Merchant does not have enough member CBA balance.');
	}

	public function gift($amount)
	{
		$this->barter_amount = $amount;

		// is the barter amount less than zero?
		if ($this->barter_amount < 0)
			throw new AuthorizerException('Invalid barter amount.');

		// does this customer giftcard have barter balance to allow this transaction?
		if ($this->barter_amount > $this->customerGiftcard->barterBalance())
			throw new AuthorizerException('Declined. Not enough barter balance on gift card');

		// do not allow tips on giftcards
		if ($this->tip_amount > 0)
			throw new AuthorizerException('Tips are not allowed on giftcards.');
	}

	public function load($amount)
	{
		$this->charge_amount = $amount;

		// does this deposit amount meet the customer's minimum deposit requirement (exchange min + member outstanding CBA debt)
		if ($this->charge_amount < $this->customerMember->minimumCbaDeposit())
			throw new AuthorizerException('Minimum CBA deposit not met.');
	}

	public function exchange(Exchange $merchantExchange, User $merchantUser = null)
	{
		$this->merchantExchange = $merchantExchange;
		$this->merchantUser = $merchantUser;

		return $this;
	}

	public function issueGiftcardToMember(Giftcard $giftcard, $amount, Member $customerMember = null)
	{
		$this->customerGiftcard = $giftcard;
		$this->customerMember = $customerMember;
		$this->customerExchange = $this->customerMember->exchange;

		// does this merchant exchange accept giftcards from customer exchange?
		if( ! $this->merchantExchange->acceptsGiftcardFromCustomerExchange($this->customerExchange))
			throw new AuthorizerException('Gift card purchases not allowed between these exchanges');

		$this->barter_amount = $amount;
		
		// is the barter amount less than zero?
		if ($this->barter_amount < 0)
			throw new AuthorizerException('Invalid barter amount.');

		// does this customer member have barter spending power to allow this transaction?
		if ($this->barter_amount > $this->customerMember->availableBarterCredit())
			throw new AuthorizerException('Declined. Not enough member barter balance');

		// APPROVE CBA FEES FOR SALE
		$giftcardIssueFee = $this->calculator->getExchangeGiftcardFee($this->customerMember, $this->barter_amount);

		// does this customer member have enough cba balance for fee?
		if ($giftcardIssueFee > $this->customerMember->cbaBalance())
			throw new AuthorizerException('Declined. Not enough member cba balance');

		return $this;
	}

	public function withdrawalCbaFromMember(Member $customerMember, $amount)
	{
		$this->customerMember = $customerMember;
		$this->customerExchange = $this->customerMember->exchange;

		$this->debit_amount = $amount;
		
		// is the barter amount less than zero?
		if ($this->debit_amount < 0)
			throw new AuthorizerException('Invalid debit amount.');

		// does this customer member have enough cba balance for withdrawal?
		if ($this->debit_amount > $this->customerMember->cbaBalance())
			throw new AuthorizerException('Declined. Not enough member cba balance');

		return $this;
	}

}