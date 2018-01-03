<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth, \Session, App\TransactionDetails;
class LedgerDetails extends Model
{
    protected $table = 'ledger';
    public $fillable = [
                        'exchange_id',
                        'member_id',
                        'giftcard_id',
                        'account_code',
                        'account_code_name',
                        'amount',
                        'transaction_id',
                        'notes',
                        'created_at',
                        ];

    public function Members(){
        return $this->belongsTo('App\Member','member_id');
    }
    
    /*member cba balnce and barter balance*/
    public function GetMemberCBA(){
        $member_id      = Session::get('MEMBER_ID');
        $exchange_id    = Session::get('EXCHANGE_ID');
        
        $cba_balance = LedgerDetails::where('member_id',$member_id)->where('exchange_id',$exchange_id)
                            ->whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
                            ->get()
                            ->sum('amount');
        return $cba_balance = '$'.number_format($cba_balance/100,2);
    }

    public function GetMemberBarterBalance(){
        $member_id      = Session::get('MEMBER_ID');
        $exchange_id    = Session::get('EXCHANGE_ID');
        
        $barter_balance = LedgerDetails::where('member_id',$member_id)->where('exchange_id',$exchange_id)
                            ->whereIn('account_code', ['4010', '4020', '4050', '4080', '6010'])
                            ->get()
                            ->sum('amount');
        return $barter_balance = '$'.number_format($barter_balance/100,2);
    }

    /*end member section*/
    
    /*member account barter credit*/
    public function InsertBarter($input,$id,$transaction){
        $exchangeid = session::get('EXCHANGE_ID');
        if($input['account']==2){
                $amount = $input['amount'] * 100;
                LedgerDetails::create([
                    'exchange_id'=>$exchangeid,
                    'amount' =>$amount,
                    'member_id'  =>$id,
                    'giftcard_id'=>0,
                    'account_code'=>4020,
                    'account_code_name'=>'Member Barter Credit (Exchange)',
                    'transaction_id'=>$transaction,
                    'notes'=>$input['notes'],

                ]);
                 /*inserting without member id*/
                LedgerDetails::create([
                    'exchange_id'=>$exchangeid,
                    'amount' =>$amount,
                    'member_id'  =>0,
                    'giftcard_id'=>0,
                    'account_code'=>8020,
                    'account_code_name'=>'Exchange Credit Member Barter',
                    'transaction_id'=>$transaction,
                    'notes'=>$input['notes'],

                ]);
        }
        if($input['account']==1){ //debited from barter 
                $amount = -$input['amount'] * 100;
                LedgerDetails::create([
                    'exchange_id'=>$exchangeid,
                    'amount' =>$amount,
                    'member_id'  =>$id,
                    'giftcard_id'=>0,
                    'account_code'=>4080,
                    'account_code_name'=>'Member Barter Debit (Exchange)',
                    'transaction_id'=>$transaction,
                    'notes'=>$input['notes'],

                ]);

                LedgerDetails::create([
                    'exchange_id'=>$exchangeid,
                    'amount' =>$amount,
                    'member_id'  =>0,
                    'giftcard_id'=>0,
                    'account_code'=>8030,
                    'account_code_name'=>'Exchange Debit Member Barter',
                    'transaction_id'=>$transaction,
                    'notes'=>$input['notes'],

                ]);      
        }       
    }

    /*
    inserting in ladger table as cba credit and debit
    */
    /*code here for insert cba*/
    public function InsertCba($input,$id,$transaction){
        $exchangeid = session::get('EXCHANGE_ID');
        if($input['account']==3){
            $amount = -$input['amount'] * 100;
            Self::create([
                'exchange_id'=>$exchangeid,
                'amount' =>$amount,
                'member_id'  =>$id,
                'account_code'=>7040,
                'account_code_name'=>'Member CBA Withdrawal',
                'transaction_id'=>$transaction,
                'notes'=>$input['notes'],
                ]);

            Self::create([
                'exchange_id'=>$exchangeid,
                'amount' =>$amount,
                'member_id'  =>0,
                'account_code'=>4120,
                'account_code_name'=>'Exchange Unearned Member Barter Revenue',
                'transaction_id'=>$transaction,
                'notes'=>$input['notes'],
                ]);


        }

        if($input['account']==4){
            $amount = $input['amount'] * 100;
            Self::create([
                'exchange_id'=>$exchangeid,
                'amount' =>$amount,
                'member_id'  =>$id,
                'account_code'=>3020,
                'account_code_name'=>'Member CBA Direct Payment',
                'transaction_id'=>$transaction,
                'notes'=>$input['notes'],
                ]);

            /*inserting in  ladger table without member id*/
            Self::create([
                'exchange_id'=>$exchangeid,
                'amount' =>$amount,
                'member_id'  =>0,
                'account_code'=>4120,
                'account_code_name'=>'Exchange Unearned Member Barter Revenue',
                'transaction_id'=>$transaction,
                'notes'=>$input['notes'],
                ]);
        }


        if($input['account']==5){ //member cba exchange credit
            $amount = $input['amount'] * 100;
            Self::create([
                'exchange_id'=>$exchangeid,
                'amount' =>$amount,
                'member_id'  =>$id,
                'giftcard_id'=>0,
                'account_code'=>4040,
                'account_code_name'=>'Member CBA Credit (Exchange)',
                'transaction_id'=>$transaction,
                'notes'=>$input['notes'],
                ]);

            Self::create([
                'exchange_id'=>$exchangeid,
                'amount' =>$amount,
                'member_id'  =>0,
                'giftcard_id'=>0,
                'account_code'=>8040,
                'account_code_name'=>'Exchange Credit Member CBA',
                'transaction_id'=>$transaction,
                'notes'=>$input['notes'],
                ]);
        }
    }

    /*
    inserting in ladger for gift card entry
    */
    /*code here for gift card entry*/
    public static function InsertLedgerForGiftCard($insertArr, $input){

        Self::create([
            'exchange_id'     => $insertArr['exchange_id'],
            'giftcard_id'     => $insertArr['giftcard_id'],
            'account_code'    => 3050,
            'amount'          => ($input['amount']*100),
            'transaction_id'  => $insertArr['transaction_id'],
            'notes'           => $input['notes']
         ]);

        Self::create([
            'exchange_id'     => $insertArr['exchange_id'],
            'member_id'       => $insertArr['member_id'],
            'account_code'    => 4050,
            'amount'          => -($input['amount']*100),
            'transaction_id'  => $insertArr['transaction_id'],
            'notes'           => $input['notes']
        ]);

        Self::create([
            'exchange_id'     => $insertArr['exchange_id'],
            'member_id'       => $insertArr['member_id'],
            'account_code'    => 7020,
            'amount'          => -($input['amount']*10),
            'transaction_id'  => $insertArr['transaction_id'],
            'notes'           => $input['notes']
        ]);

        Self::create([
            'exchange_id'     => $insertArr['exchange_id'],
            'account_code'    => 4160,
            'amount'          => ($input['amount']*10),
            'transaction_id'  => $insertArr['transaction_id'],
            'notes'           => $input['notes']
        ]);
    }

    public function transaction()
    {
        return $this->belongsTo('App\TransactionDetails', 'transaction_id', 'id');
    }
    
    public function getMemberCbaBalance($member_id, $date = false){
        $query = $this
                    ->whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
                    ->where('member_id', $member_id)
                    ->where('deleted_at', null);

            if ($date)
                    $query = $query->where('created_at', '<=', $date->addSeconds(5));
            
            return (int) $query->sum('amount');
    }
    
}
