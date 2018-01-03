<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
class TransactionDetails extends Model
{
    protected $fillable = ['type_id', 'customer_exchange_id', 'customer_member_id', 'customer_ex_comm_rate', 'customer_giftcard_id', 'customer_user_id', 'customer_ref_member_id', 'customer_ref_comm_rate', 'customer_sales_member_id', 'customer_sales_comm_rate', 'merchant_exchange_id', 'merchant_member_id', 'merchant_ex_comm_rate', 'merchant_giftcard_id', 'merchant_user_id', 'merchant_ref_member_id', 'merchant_ref_comm_rate', 'merchant_sales_member_id', 'merchant_sales_comm_rate', 'notes', 'card_present', 'settled', 'member_cashier_id'];

    protected $table = 'transactions';

    /*getting transaction type*/
    public function TransactionType($account=''){
    	if($account != '') {

    		if($account==1){ //barter exchange debit
	    		$type_id = 73;
	    	} 

	    	if($account==2){//barter exchange credit
	    		$type_id = 71;
	    	}
            if($account==3){//debit cba 
                $type_id = 75;
            }
            if($account==4){ //direct payment cba credit
                $type_id = 81;
            }
            if($account==5){
                $type_id = 72;
            }
    	    }else{
    		  $type_id = 42;
    	    }

    	return $type_id;
    } 

    /*transaction table entry*/
    public function InsertTransaction($input,$id=''){
    	$exchangeid = session::get('EXCHANGE_ID');
    	if(isset($input['member_id']) && $input['member_id'] != '') {
    		$customer_member_id = $input['member_id'];
    	} else {
    		$customer_member_id = $id;
    	}

        $account = '';
        if(isset($input['account']) && $input['account'] != '') {
            $account = $input['account'];
        }
    	$type = $this->TransactionType($account);
        $transactions = Self::create([
            'type_id'=>$type,
            'customer_exchange_id'=>$exchangeid,
            'customer_member_id'=>$customer_member_id, 
            'merchant_exchange_id'  =>$exchangeid, 
            'notes'  => $input['notes'],
      	]);

      	return $transactions->id;
    }

    public function customerFromUser()
    {
        return $this->belongsTo('App\Member', 'merchant_member_id', 'id');
    }

    public function customerToUser()
    {
        return $this->belongsTo('App\Member', 'customer_user_id', 'id');
    }

    public function transactionTypeData()
    {
        return $this->belongsTo('App\TransactionType', 'type_id', 'id');
    }
    
    /**
    * Retrieves all transactions for a member
    * 
    * @param  Member  $member         
    * @param  mixed   $startDate       false|Carbon
    * @param  mixed   $endDate         false|Carbon
    * @param  string  $selectedType    sales|purchases|cba-deposits|cba-withdrawals|referral-bonuses|sales-commissions|credits|debits|all(false)
    * @param  int     $selectedUserId  user id
    * @param  int     $selectedCashierId  cashier id
    * @param  int     $perPage         amount of records per page (defaults to false)
    * @return Collection
    */
   public function getByMember($member, $startDate = false, $endDate = false, $selectedType = 'all', $selectedUserId = false, $selectedCashierId = false, $perPage = false)
   {
	   $transactions = $this;

	   switch ($selectedType) {
		   
		   case 'sales':
			   
			   $transactions = $transactions->where(function($query) use ($member, $startDate, $endDate, 
				   $selectedUserId, $selectedCashierId)
			   {
				   $query->where('merchant_member_id', $member->id)->whereIn('type_id', [11, 12, 25])->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }

				   if ($selectedUserId)
				   {
					   $query->where('merchant_user_id', $selectedUserId);
				   }

				   if ($selectedCashierId)
				   {
					   $query->where('member_cashier_id', $selectedCashierId);
				   }
			   });

			   break;
		   
		   case 'purchases':

			   $transactions = $transactions->where(function($query) use ($member, $startDate, $endDate, 
				   $selectedUserId)
			   {
				   $query->where('customer_member_id', $member->id)->whereIn('type_id', [11, 12, 25, 42])->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }

				   if ($selectedUserId)
				   {
					   $query->where('customer_user_id', $selectedUserId);
				   }
			   });

			   break;

		   case 'cba-deposits':

			   $transactions = $transactions->where(function($query) use ($member, $startDate, $endDate, 
				   $selectedUserId)
			   {
				   $query->where('customer_member_id', $member->id)->whereIn('type_id', [21, 81])->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }

				   if ($selectedUserId)
				   {
					   $query->where('customer_user_id', $selectedUserId);
				   }
			   });

			   break;

		   case 'cba-withdrawals':

			   if ($selectedUserId)
				   return false;

			   $transactions = $transactions->where(function($query) use ($member, $startDate, $endDate)
			   {
				   $query->where('customer_member_id', $member->id)->whereIn('type_id', [75])->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }
			   });

			   break;

		   case 'referral-bonuses':

			   if ($selectedUserId)
				   return false;

			   $transactions = $transactions->where(function($query) use ($member, $startDate, $endDate)
			   {
				   // include all referrals with earned commission
				   $query->where('customer_ref_member_id', $member->id)->whereIn('type_id', [11, 25])->where('customer_ref_comm_rate', '<>', 0)->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }
			   
			   })->orWhere(function($query) use ($member, $startDate, $endDate)
			   {
				   // include all referrals with earned commission
				   $query->where('merchant_ref_member_id', $member->id)->whereIn('type_id', [11, 25])->where('merchant_ref_comm_rate', '<>', 0)->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }
			   });

			   break;

		   case 'sales-commissions':

			   if ($selectedUserId)
				   return false;

			   $transactions = $transactions->where(function($query) use ($member, $startDate, $endDate)
			   {
				   // include all sales commissions for purchases
				   $query->where('customer_sales_member_id', $member->id)->whereIn('type_id', [11, 25])->where('customer_sales_comm_rate', '<>', 0)->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }
			   
			   })->orWhere(function($query) use ($member, $startDate, $endDate)
			   {
				   // include all sales commissions for sales
				   $query->where('merchant_sales_member_id', $member->id)->whereIn('type_id', [11, 25])->where('merchant_sales_comm_rate', '<>', 0)->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }
			   });

			   break;

		   case 'credits':

			   if ($selectedUserId)
				   return false;

			   $transactions = $transactions->where(function($query) use ($member, $startDate, $endDate)
			   {
				   $query->where('customer_member_id', $member->id)->whereIn('type_id', [71, 72])->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }
			   });

			   break;

		   case 'debits':

			   if ($selectedUserId)
				   return false;

			   $transactions = $transactions->where(function($query) use ($member, $startDate, $endDate)
			   {
				   $query->where('customer_member_id', $member->id)->whereIn('type_id', [73])->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }
			   });

			   break;

		   default:
			   
			   $transactions = $transactions->where(function($query) use ($member, $startDate, $endDate, $selectedUserId)
			   {
				   $query->where('customer_member_id', $member->id)->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }

				   if ($selectedUserId)
				   {
					   $query->where('customer_user_id', $selectedUserId);
				   }
			   })
			   ->orWhere(function($query) use ($member, $startDate, $endDate, $selectedUserId)
			   {
				   $query->where('merchant_member_id', $member->id)->where('deleted_at', null);

				   if ($startDate && $endDate)
				   {
					   $query->whereBetween('created_at', [$startDate, $endDate]);
				   }

				   if ($selectedUserId)
				   {
					   $query->where('merchant_user_id', $selectedUserId);
				   }
			   });

			   if ( ! $selectedUserId)
			   {
				   $transactions->orWhere(function($query) use ($member, $startDate, $endDate)
				   {
					   // include all referrals with earned commission
					   $query->where('customer_ref_member_id', $member->id)->where('customer_ref_comm_rate', '<>', 0)->where('deleted_at', null);

					   if ($startDate && $endDate)
					   {
						   $query->whereBetween('created_at', [$startDate, $endDate]);
					   }

				   })->orWhere(function($query) use ($member, $startDate, $endDate)
				   {
					   // include all referrals with earned commission
					   $query->where('merchant_ref_member_id', $member->id)->where('merchant_ref_comm_rate', '<>', 0)->where('deleted_at', null);

					   if ($startDate && $endDate)
					   {
						   $query->whereBetween('created_at', [$startDate, $endDate]);
					   }

				   })->orWhere(function($query) use ($member, $startDate, $endDate)
				   {
					   // include all sales commissions for purchases
					   $query->where('customer_sales_member_id', $member->id)->where('customer_sales_comm_rate', '<>', 0)->where('deleted_at', null);

					   if ($startDate && $endDate)
					   {
						   $query->whereBetween('created_at', [$startDate, $endDate]);
					   }
				   
				   })->orWhere(function($query) use ($member, $startDate, $endDate)
				   {
					   // include all sales commissions for sales
					   $query->where('merchant_sales_member_id', $member->id)->where('merchant_sales_comm_rate', '<>', 0)->where('deleted_at', null);

					   if ($startDate && $endDate)
					   {
						   $query->whereBetween('created_at', [$startDate, $endDate]);
					   }

				   });
			   }

			   break;
	   }
		   
	   $transactions->with('entries', 'type', 'merchantMember', 'customerMember', 'merchantExchange', 'customerExchange', 'customerReferrer')
		   ->orderBy('created_at', 'desc');

	   return ($perPage) ? $transactions->paginate($perPage) : $transactions->get();
   }
   
   public function entries()
    {
	return $this->hasMany('App\LedgerDetails', 'transaction_id');
    }

    public function type()
    {
	return $this->hasOne('App\TransactionType', 'id', 'type_id');
    }
    
    public function merchantMember()
    {
	return $this->hasOne('App\Member', 'id', 'merchant_member_id');
    }
    
    public function customerMember()
    {
	return $this->hasOne('App\Member', 'id', 'customer_member_id');
    }
    
    public function merchantExchange()
    {
	return $this->hasOne('App\Exchange', 'id', 'merchant_exchange_id');
    }
    
    public function customerExchange()
    {
	return $this->hasOne('App\Exchange', 'id', 'customer_exchange_id');
    }
    
    public function customerReferrer()
    {
	return $this->hasOne('App\Member', 'id', 'customer_ref_member_id');
    }
    
    public function getAmountForMember($member)
    {
	switch ($this->type_id)
	{
		case 11:
			
			if (in_array($member->id, [$this->customer_member_id, $this->merchant_member_id]))
			{
				return $this->amount;
			}
    
			$amount = 0;
    
			if (in_array($member->id, [$this->customer_ref_member_id, $this->merchant_ref_member_id]))
			{
				$amount += $this->amount;
			}
    
			if (in_array($member->id, [$this->customer_sales_member_id, $this->merchant_sales_member_id]))
			{
				$amount += $this->amount;
			}
    
			return $amount;
    
			break;
    
		case 12:
			
			if (in_array($member->id, [$this->customer_member_id, $this->merchant_member_id]))
			{
				return $this->amount;
			}
    
			return 0;
    
			break;
    
		case 25:
			
			if (in_array($member->id, [$this->customer_member_id, $this->merchant_member_id]))
			{
				return $this->amount;
			}
    
			$amount = 0;
    
			if (in_array($member->id, [$this->customer_ref_member_id, $this->merchant_ref_member_id]))
			{
				$amount += $this->amount;
			}
    
			if (in_array($member->id, [$this->customer_sales_member_id, $this->merchant_sales_member_id]))
			{
				$amount += $this->amount;
			}
    
			return $amount;
    
			break;
    
		case 21:
		case 42:
		case 71:
		case 72:
		case 73:
		case 75:
		case 81:
			return $this->amount;
			break;
		
		default:
			return 0;
			break;
	}
    }
    
    /**
    * Returns a descriptive transaction type for members
    * 
    * @param   Member   $member
    * @param   boolean  $detail_level  simple|detail
    * @return  string
    */
    public function getTypeForMember($member, $detail_level = 'simple')
    {
	   $referrerAsterisk = (in_array($member->id, [
		   $this->customer_ref_member_id,
		   $this->merchant_ref_member_id,
	   ])) ? ' *' : '';

	   $salespersonAsterisk = (in_array($member->id, [
		   $this->customer_sales_member_id,
		   $this->merchant_sales_member_id,
	   ])) ? ' **' : '';

	   switch ($this->type_id)
	   {
		   case 11:

			   // member customer
			   if ($this->customer_member_id == $member->id)
			   {
				   return ($detail_level == 'simple') ? 'Purchase' : 'Bartercard Purchase';
			   }
			   // member merchant
			   elseif ($this->merchant_member_id == $member->id)
			   {
				   return ($detail_level == 'simple') ? 'Sale' . $referrerAsterisk . $salespersonAsterisk : 'Bartercard Sale' . $referrerAsterisk . $salespersonAsterisk;
			   }
			   // salesperson member
			   elseif (in_array($member->id, [
					   $this->customer_sales_member_id,
					   $this->merchant_sales_member_id,
				   ]))
			   {
				   return ($detail_level == 'simple') ? 'Commission' . $referrerAsterisk . $salespersonAsterisk: 'Barter Sales Commission' . $referrerAsterisk . $salespersonAsterisk;
			   }
			   // member referrer
			   elseif (in_array($member->id, [
					   $this->customer_ref_member_id,
					   $this->merchant_ref_member_id,
				   ]))
			   {
				   return ($detail_level == 'simple') ? 'Referral Bonus' : 'Member Referral Bonus';
			   }
			   else
			   {
				   return '';
			   }
			   break;

		   case 12:
			   
			   if ($this->customer_member_id == $member->id)
			   {
				   // giftcard customer
				   return ($detail_level == 'simple') ? 'Purchase' : 'Giftcard Purchase';
			   }
			   elseif ($this->merchant_member_id == $member->id)
			   {
				   // member merchant
				   return ($detail_level == 'simple') ? 'Sale' : 'Giftcard Sale';
			   }
			   else
			   {
				   // member referral
				   return ($detail_level == 'simple') ? 'Referral Bonus' : 'Member Referral Bonus';
			   }
			   break;

		   case 25:
			   if ($this->customer_member_id == $member->id)
			   {
				   // member referral
				   return ($detail_level == 'simple') ? 'Purchase' : 'Member Purchase';
			   }
			   elseif ($this->merchant_member_id == $member->id)
			   {
				   return ($detail_level == 'simple') ? 'Sale' . $referrerAsterisk . $salespersonAsterisk : 'Member Sale' . $referrerAsterisk . $salespersonAsterisk;
			   }
			   else
			   {
				   // member referral
				   return ($detail_level == 'simple') ? 'Referral Bonus' : 'Member Referral Bonus';
			   }
			   break;

		   case 21:
			   return ($detail_level == 'simple') ? 'CBA Deposit' : 'Member CBA Deposit';
			   break;
		   case 42:
			   return ($detail_level == 'simple') ? 'Giftcard Issue' : 'Exchange Giftcard Issue';
			   break;
		   case 71:
			   return ($detail_level == 'simple') ? 'Barter Credit' : 'Member Barter Credit';
			   break;
		   case 72:
			   return ($detail_level == 'simple') ? 'CBA Credit' : 'Member CBA Credit';
			   break;
		   case 73:
			   return ($detail_level == 'simple') ? 'Barter Debit' : 'Member Barter Debit';
			   break;
		   case 75:
			   return ($detail_level == 'simple') ? 'CBA Withdrawal' : 'Member CBA Withdrawal';
			   break;
		   case 81:
			   return ($detail_level == 'simple') ? 'CBA Deposit' : 'Member Direct CBA Deposit';
			   break;
		   
		   default:
			   return '';
			   break;
	   }
    }
    
    /**
    * Returns the name of the member's trading partner for this transaction
    * 
    * @param   Member   $member
    * @return  string
    */
    public function getPartnerNameForMember($member)
    {
	   switch ($this->type_id)
	   {
		   case 11:
			   
			   if ($this->customer_member_id == $member->id)
			   {
				   // bartercard purchase
				   return $this->merchantMember->name;
			   }
			   elseif ($this->merchant_member_id == $member->id)
			   {
				   // bartercard sale
				   return $this->customerMember->name;
			   }
			   else
			   {
				   // member customer referral
				   return $this->customerMember->name;
			   }
			   break;

		   case 12:
			   
			   if ($this->customer_member_id == $member->id)
			   {
				   // giftcard purchase
				   return $this->merchantMember->name;
			   }
			   elseif ($this->merchant_member_id == $member->id)
			   {
				   // giftcard sale
				   return 'Giftcard Sale';
			   }
			   break;

		   case 25:
			   if ($this->customer_member_id == $member->id)
			   {
				   // purchase
				   return $this->merchantMember->name;
			   }
			   elseif ($this->merchant_member_id == $member->id)
			   {
				   // sale
				   return $this->customerMember->name;
			   }
			   else
			   {
				   // member customer referral
				   return $this->customerMember->name;
			   }
			   break;

		   case 21:
		   case 42:
		   case 71:
		   case 72:
		   case 73:
		   case 75:
		   case 81:
			   return ($this->merchantExchange->name) ?: '';
			   break;
		   
		   default:
			   return '';
			   break;
	   }
    }
    
    /**
    * Returns the tip amount of this transaction in regards to this member's account
    * 
    * @param   Member   $member
    * @return  string
    */
    public function getTipAmountForMember($member)
    {
	   switch ($this->type_id)
	   {
		   case 11:
		   case 25:
			   
			   if (in_array($member->id, [$this->customer_member_id, $this->merchant_member_id]))
			   {
				   return $this->tip_amount;
			   }

			   return 0;
			   break;

		   default:
			   return 0;
			   break;
	   }
    }
}
