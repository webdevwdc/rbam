<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\LedgerDetails;
use Auth, \Session, DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ 

        $exchange_id = session::get('EXCHANGE_ID');
        
        $today = date('Y-m-d').' 23:59:59';
        $this_week = date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';
        $search = LedgerDetails::whereBetween('created_at',[$this_week,$today])->paginate(10);
        // for Barter Balance
        $barter_balance = LedgerDetails::where('exchange_id',$exchange_id)
                            ->whereIn('account_code', ['4010', '4020', '4050', '4080', '6010'])
                            ->get()
                            ->sum('amount');
        $barter_balance = '$'.number_format($barter_balance/100,2);
        
        // for CBA Balance
        $cba_balance = LedgerDetails::where('exchange_id',$exchange_id)
                            ->whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
                            ->get()
                            ->sum('amount');

        $cba_balance = '$'.number_format( $cba_balance/100,2);
        $start_date = date('Y-m-d').' 23:59:59';
        $end_date= date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';
        return view('member.transaction.index',compact('barter_balance','cba_balance','search','start_date','end_date'));
    }

    public function SearchTranscation(Request $request){
        $input = $request->all();
        $exchange_id = session::get('EXCHANGE_ID');
        $barter_balance = LedgerDetails::where('exchange_id',$exchange_id)
                            ->whereIn('account_code', ['4010', '4020', '4050', '4080', '6010'])
                            ->get()
                            ->sum('amount');
        $barter_balance = '$'.number_format($barter_balance/100,2);
        
        // for CBA Balance
        $cba_balance = LedgerDetails::where('exchange_id',$exchange_id)
                            ->whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
                            ->get()
                            ->sum('amount');

        $cba_balance = '$'.number_format( $cba_balance/100,2);

        if (!empty($input['type'])) {
            $type = $input['type'];
            switch($type)
            {
                case 'cba-deposits': $type = [3020,4120];
                break ;

                case 'sales':$type = [4010];
                break;

                case 'purchases':$type = [6010];
                break;

                case 'member-cba-withdrawals':$type = [7040];
                break;

                
            }
        }
        if (!empty($input['day'])) {
        if ($input['day']=='this_week') {
             //echo "<pre>"; print_r($input); die();
             $today = date('Y-m-d').' 23:59:59';
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
        $start_date = date('Y-m-d').' 23:59:59';
        $end_date= date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';
        return view('member.transaction.index',compact('search','barter_balance','cba_balance','start_date','end_date'));
      }

      /*search using date range*/
      public function DateSearchTranscation(Request $request){
        $this->validate($request,[
        'from'=>'required',
        'to'=>'required',
       ]);
       $exchange_id = session::get('EXCHANGE_ID');
        $barter_balance = LedgerDetails::where('exchange_id',$exchange_id)
                            ->whereIn('account_code', ['4010', '4020', '4050', '4080', '6010'])
                            ->get()
                            ->sum('amount');
        $barter_balance = '$'.number_format($barter_balance/100,2);
        
        // for CBA Balance
        $cba_balance = LedgerDetails::where('exchange_id',$exchange_id)
                            ->whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
                            ->get()
                            ->sum('amount');

        $cba_balance = '$'.number_format( $cba_balance/100,2);
        
       $input = $request->all();
       $start_date = date('Y-m-d',strtotime($input['from']));
       $end_date = date('Y-m-d',strtotime($input['to']));
       $search = LedgerDetails::whereBetween('created_at',[$start_date,$end_date])->paginate(10);
       return view('member.transaction.index',compact('search','barter_balance','cba_balance','start_date','end_date'));
    }
}
