<?php
namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType,App\Category, App\TransactionDetails;
use Hash;
use App\Helpers;
use Carbon\Carbon;

class ApiV2MemberTransactionController extends ApiV2Controller {

	/*
	 * @var User
	 */
	protected $user;

	public function __construct()
	{
		parent::__construct();
		$this->user = \JWTAuth::parseToken()->authenticate();
	}

	/**
	 * @api {get} /member/transactions/selected  Get transaction data for the user's selected member
	 * @apiName AllForSelected
	 * @apiGroup MemberTransaction
	 *
	 * @apiParam {string}   type              all|sales|purchases|cba-deposits|cba-withdrawals|referral-bonuses|credits
	 * @apiParam {string}   date_range_start  (required if date_range_end exists)  format: 2016-01-04
	 * @apiParam {string}   date_range_end    (required if date_range_start exists)  format: 2016-01-04
	 *
	 * @apiSuccess {Object} response
	 */
	public function allForSelected(Request $request)
	{
		// get selected member of user
		$selectedMember = $this->user->selectedMember();
		
		if ( ! $selectedMember)
		{
			return $this->respondNotFound('A selected member could not be found for this user.');
		}

		// get transaction type information
		//$selectedType = \Input::get('type', 'all');
		$selectedType = ($request->type) ? $request->type : 'all';

		if ( $selectedType && ( ! in_array($selectedType, ['all','sales','purchases','cba-deposits','cba-withdrawals','referral-bonuses','credits'])))
		{
			return $this->respondValidationFailed('Invalid transaction type.');
		}
		

		// set date range start (if any)
		try
		{
			//$date_range_start = \Input::get('date_range_start', false);
			$date_range_start = ($request->date_range_start) ? $request->date_range_start : false;
			$startDate = ($date_range_start) ? (new Carbon($date_range_start, 'America/Chicago')) : false;
		}
		catch(\Exception $e)
		{
			return $this->respondValidationFailed('Invalid date range start.');
		}

		// set date range end (if any)
		try
		{
			//$date_range_end = \Input::get('date_range_end', false);
			$date_range_end = ($request->date_range_end) ? $request->date_range_end : false;
			$endDate = ($date_range_end) ? (new Carbon($date_range_end, 'America/Chicago')) : false;
		}
		catch(\Exception $e)
		{
			return $this->respondValidationFailed('Invalid date range end.');
		}

		// get transactions
		$transactionDetails = new TransactionDetails();
		$transactions = $transactionDetails->getByMember($selectedMember, ( ! $startDate) ? false : $startDate->toDateTimeString(), ( ! $endDate) ? false: $endDate->toDateTimeString(), $selectedType);

		if ( ! $transactions)
		{
			return $this->respondNotFound('No transactions found for the given criteria.');
		}

		$transactionData = [];

		foreach ($transactions as $transaction)
		{
			$amount = ($selectedType == 'referral-bonuses') ? $transaction->getReferralCommissionAmountForMember($selectedMember) : $transaction->getAmountForMember($selectedMember);
			
			$transactionData[] = [
				'transactionNumber' => $transaction->transaction_number,
				'shortDate' => $transaction->short_date,
				'simpleType' => $transaction->getTypeForMember($selectedMember, 'simple'),
				'detailedType' => $transaction->getTypeForMember($selectedMember, 'detail'),
				'partnerName' => $transaction->getPartnerNameForMember($selectedMember),
				'amount' => presentPeosAmount($amount, '--'),
				'tip' => presentPeosAmount($transaction->getTipAmountForMember($selectedMember), '--'),
				'notes' => $transaction->notes,
				'cbaBalance' => presentPeosAmount($selectedMember->cbaBalance($transaction->created_at), '--'),
				'barterBalance' => presentPeosAmount($selectedMember->barterBalance($transaction->created_at), '--')
			];
		}

		return $this->respondWithData($transactionData);
	}

}
