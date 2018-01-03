<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session,DB, App\TransactionDetails,App\LedgerDetails;

class TransactionController extends Controller
{
    
    public function SearchTranscation(Request $request){ 
        $today = date('Y-m-d').' 23:59:59';
        $exchangeid = session::get('EXCHANGE_ID');
        $this_week = date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';
        $records = LedgerDetails::orderBy('created_at','DESC')
                 ->where('exchange_id',$exchangeid)
                 ->whereBetween('created_at',[$this_week,$today])->paginate(20);

        if ($request->isMethod('post')) {
        	$input = $request->all();
            
        	if ($input['type']) {
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

                    case 'giftcard-barter-beposit':$type = [3050];
                    break;
                }
            }
        
        	
        	$exchangeid	= session::get('EXCHANGE_ID');
        	$search = [];
        	/*searching using week*/
        	if ($input['day'] == 'this_week') {
        	    $today = date('Y-m-d').' 23:59:59';
                $this_week = date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';
                
               //$records = LedgerDetails::whereBetween('created_at',[$this_week,$today])->get();
        	$records = LedgerDetails::where(function($query)use($today,$this_week,$type,$input,$exchangeid){
		            if($input['day']!='All'){
		                $query->where('exchange_id',$exchangeid)->whereBetween('created_at', array($this_week, $today));
		            }
		            if($type!='All'){
		                $query->where('account_code',$type);
		            }        
			    })->paginate(20);
        	}
        	/*end of the week*/

        	/*for this month*/
        	if ($input['day'] == 'this_month') {
        	    $today = date('Y-m-d').' 23:59:59';
                $this_month = date('Y-m-d',strtotime('today - 30 days')).' 00:00:00';

        	$records = LedgerDetails::where(function($query)use($today,$this_month,$type,$input,$exchangeid){
		            if($input['day']!='All'){
		                $query->where('exchange_id',$exchangeid)->whereBetween('created_at', array($this_month, $today));
		            }
		            if($type!='All'){
		                $query->where('account_code',$type);
		            }        
			    })->paginate(20);
        	}
        	/*end of this month*/

        	/*searching using last three months*/
        	if ($input['day'] == 'three_months') {
        	    $today = date('Y-m-d').' 23:59:59';
                $three_month = date('Y-m-d',strtotime('today - 90 days')).' 00:00:00';

        	$records = LedgerDetails::where(function($query)use($today,$three_month,$type,$input,$exchangeid){
		            if($input['day']!='All'){
		                $query->where('exchange_id',$exchangeid)->whereBetween('created_at', array($three_month, $today));
		            }
		            if($type!='All'){
		                $query->where('account_code',$type);
		            }        
			    })->paginate(20);
        	}
            /*end of using last three months*/

            /*searching using last six months*/
            if ($input['day'] == 'six_months') {
                $today = date('Y-m-d').' 23:59:59';
                $six_month = date('Y-m-d',strtotime('today - 180 days')).' 00:00:00';

            $records = LedgerDetails::where(function($query)use($today,$six_month,$type,$input,$exchangeid){
                    if($input['day']!='All'){
                        $query->where('exchange_id',$exchangeid)->whereBetween('created_at', array($six_month, $today));
                    }
                    if($type!='All'){
                        $query->where('account_code',$type);
                    }        
                })->paginate(20);
            }
            /*end of using last six months*/

            /*searching using last one year*/
            if ($input['day'] == 'one_year') {
                $today = date('Y-m-d').' 23:59:59';
                $one_year = date('Y-m-d',strtotime('today - 364 days')).' 00:00:00';

            $records = LedgerDetails::where(function($query)use($today,$one_year,$type,$input,$exchangeid){
                    if($input['day']!='All'){
                        $query->where('exchange_id',$exchangeid)->whereBetween('created_at', array($one_year, $today));
                    }
                    if($type!='All'){
                        $query->where('account_code',$type);
                    }        
                })->paginate(20);
            }
            /*end of the searching*/
            
            /*searching using all records*/
            if ($input['day'] == 'All') {

            $records = LedgerDetails::where(function($query)use($type,$input,$exchangeid){
                    if($input['day']=='All'){
                        $query->where('exchange_id',$exchangeid)->get();
                    }
                    if($type!='All'){
                        $query->where('account_code',$type);
                    }        
                })->paginate(20);
            }
            /*end of using searchin all records*/
        }
        $start_date = date('Y-m-d').' 23:59:59';
        $end_date = date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';
        return view('admin.transaction.index',compact('records','start_date','end_date'));
    }

    /*search using date range*/
    public function DateRangeSearchTranscation(Request $request){
       $this->validate($request,[
        'from'=>'required',
        'to'=>'required',
       ]);
       $input = $request->all();
       $start_date = date('Y-m-d',strtotime($input['from']));
       $end_date = date('Y-m-d',strtotime($input['to']));
       $records = LedgerDetails::whereBetween('created_at',[$start_date,$end_date])->paginate(20);
       return view('admin.transaction.index',compact('records','start_date','end_date'));
    }
   
}
