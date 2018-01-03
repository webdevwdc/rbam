<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member, App\LedgerDetails,Crypt, Session, App\TransactionDetails;
use App\Cardpool;
use Excel;

class MemberAccountDetailsController extends Controller
{   
    public function ViewUserAccounts(Request $request,$id){

        $input = $request->all();
        
        if(empty($input)){
           $input['day'] = '-1 month';
           $input['type'] = 'All';
           $input['user'] = 'All';
        }
       
    	$member = Member::where('id',$id)->first();
        
    	/*barter accounts*/
		$accounts = LedgerDetails::where('member_id',$id)->where(function($query){
							$query->where('account_code',4020)
		    	            ->orWhere('account_code',4080)
                            ->orWhere('account_code',4010);
		})->sum('amount');

        $val = ($member['credit_limit'] /100 ) + ($accounts / 100);
        $member['credit_limit'] = number_format($val,2); 
        $member['account'] = $accounts/100;
        
		/*for cba details*/
        $cba = LedgerDetails::where('member_id',$id)->where(function($query){
                            $query->where('account_code',7040)
                            ->orWhere('account_code',3020)
                            ->orWhere('account_code',4040)
                            ->orWhere('account_code',7010);
        })->sum('amount');


        $member['cba_account'] = $cba/100;

        /* account  searching start*/
        $search = [];

        
	    if (!empty($input['type'])) {
            $type = $input['type'];
            switch($type){
                case 'sales': $type = [4010];
                break ;

                case 'purchase':$type = [6010];
                break;

                case 'cba_deposit':$type = [3020,4120];
                break;

                case 'cba_withdraw':$type = [7040];
                break;

                case 'referral-bonues': $type = [3020, 4120];
                break ;

                case 'sales-commissions':$type = [4090];
                break;

                case 'credits':$type = [3020,4120,4090];
                break;
            }
        }
        if (!empty($input['day'])) { 
        if ($input['day']=='this_week') {
             
             $today = date('Y-m-d').' 23:59:59';;
             $this_week = date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';
             $search = LedgerDetails::whereBetween('created_at',[$this_week,$today]);
             if($type !='All'){
              $search->whereIn('account_code',$type);
             }else{
               $search->paginate(10); 
             }
             $search = $search->paginate(10);
        }

        /*search using this month*/
        if ($input['day']=='this_month') {
             $today = date('Y-m-d').' 23:59:59';
             $this_month = date('Y-m-d',strtotime('today - 30 days')).' 00:00:00';
             $search = LedgerDetails::whereBetween('created_at',[$this_month,$today]);
             if($type !='All'){
              $search->whereIn('account_code',$type);
             }else{
               $search->paginate(10); 
             }
             $search = $search->paginate(10);
             
        }
        /*search  using three months */
        if ($input['day']=='three_months') {
             $today = date('Y-m-d').' 23:59:59';
             $six_month = date('Y-m-d',strtotime('today - 180 days')).' 00:00:00';
             $search = LedgerDetails::whereBetween('created_at',[$six_month,$today]);
             if($type !='All'){
              $search->whereIn('account_code',$type);
             }else{
               $search->paginate(10); 
             }
             $search = $search->paginate(10);
             
        }

        /*search using six months*/
        if ($input['day']=='six_months') {
             $today = date('Y-m-d').' 23:59:59';
             $six_month = date('Y-m-d',strtotime('today - 180 days')).' 00:00:00';
             $search = LedgerDetails::whereBetween('created_at',[$six_month,$today]);
             if($type !='All'){
              $search->whereIn('account_code',$type);
             }else{
               $search->paginate(10); 
             }
             $search = $search->paginate(10);
             
        }
        /*search using one year*/
        if ($input['day']=='one_year') {
             $today = date('Y-m-d').' 23:59:59';
             $one_year = date('Y-m-d',strtotime('today - 364 days')).' 00:00:00';
             $search = LedgerDetails::whereBetween('created_at',[$one_year,$today]);
             if($type !='All'){
              $search->whereIn('account_code',$type);
             }else{
               $search->paginate(10); 
             }
             $search = $search->paginate(10);
             
        }
        /*searching using forever*/
        if ($input['day']=='All') {
             
             $search = new LedgerDetails();
             if($type !='All'){
              $search->whereIn('account_code',$type);
             }else{
               $search->paginate(10); 
             }
             $search = $search->paginate(10);
             
        }
     }  
         $start_date = date('Y-m-d').' 23:59:59';;
         $end_date = date('Y-m-d',strtotime('today - 7 days')).' 00:00:00'; 
    	return view('/admin/members/account_details',compact('member','search','start_date','end_date'));
    }

    //user debit and credit barter accounts 
    public function CreateUserBarterAccounts(Request $request,$id){
        $this->validate($request,[
          'amount'=>'required|numeric'
        ]);
    	$input = $request->all();


        $transaction_model = new TransactionDetails();
        $transaction = $transaction_model->InsertTransaction($input, $id);
        
        
        $model = new LedgerDetails();
        $barter_insert = $model->InsertBarter($input,$id,$transaction);
        return back()->with('success','Barter Debited Successfully');
    }
    
    //admin credit and debit cba account of user
    public function CreateUserCbaAccount(Request $request,$id){
        $this->validate($request,[
          'amount'=>'required|numeric'
        ]);
    	$input = $request->all();
    	$exchangeid = session::get('EXCHANGE_ID');

        $transaction_model = new TransactionDetails();
        $transaction = $transaction_model->InsertTransaction($input, $id);

        $model = new LedgerDetails();
        $barter_insert = $model->InsertCba($input,$id,$transaction);
        return back();
    	
    }
    /*amdin delete transaction*/
    public function DeleteTransaction($id=null){
        $id = Crypt::decrypt($id);
        $ledger = LedgerDetails::where('id',$id)->first();

        if(count($ledger)>0){
            //$transaction = TransactionDetails::where('id',$ledger->transaction_id)->delete();
            $ledger->delete();
            return back()->with('success','Transaction Deleted Successfully');
        }else{
            return back()->with('error','Transaction Not Found');
        }

    }

    /*uploading excel sheet*/
    public function ViewUploadExcel(){
        return view('admin.uploadExcel');
    }
    public function UploadExcel(Request $request){
      $input = $request->all();
      $file = $request->file('excel_file');
      
      $handle = Excel::load($file)->get();
      foreach ($handle as $key => $value) {
        Cardpool::create([
            'number'=>$value->card_number,
            'type'=>1,
            'available'=>1,
            'exchange_id'=>1,
            'download'=>0,
        ]);
      }

      return "success";
    }
}
