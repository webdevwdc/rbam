<?php

namespace App\Http\Controllers\User_Member\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LedgerDetails;
use App\MemberUser;
use Auth;
use Session;
class TransactionController extends Controller
{
    public function ViewTransaction(Request $request)
    {
        $memberID = MemberUser::where('user_id', Auth::user()->id)->first()->member_id;

        $today = date('Y-m-d').' 23:59:59';
        $exchangeid = session::get('EXCHANGE_ID');
        $this_week = date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';

        $records = LedgerDetails::orderBy('created_at','DESC')
        ->where('member_id', $memberID)
        ->whereBetween('created_at',[$this_week,$today])->paginate(10);

        if ($request->isMethod('post')) {
            $input = $request->all();
            
            $input = $request->all();
        
            if (isset($input['type'])) {

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

                    case 'All': $type = [];
                    break;

                }
            }
            else
            {
                $type = [];
            }
            
            $exchangeid = session::get('EXCHANGE_ID');
            $search = [];

            if(isset($input['day']))
            {
                /*searching using week*/
                if ($input['day'] == 'this_week') {
                    $today = date('Y-m-d').' 23:59:59';
                    $this_week = date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';

               //$records = LedgerDetails::whereBetween('created_at',[$this_week,$today])->get();
                    $records = LedgerDetails::where('member_id', $memberID)->where(function($query)use($today,$this_week,$type,$input,$exchangeid){
                        if($input['day']!='All'){
                            $query->whereBetween('created_at', array($this_week, $today));
                        }
                        if(count($type) > 0)
                        {
                            $query->whereIn('account_code',$type);
                        }
                    })->paginate(10);
                }
                /*end of the week*/

                /*for this month*/
                if ($input['day'] == 'this_month') {
                    $today = date('Y-m-d').' 23:59:59';
                    $this_month = date('Y-m-d',strtotime('today - 30 days')).' 00:00:00';

                    $records = LedgerDetails::where('member_id', $memberID)->where(function($query)use($today,$this_month,$type,$input,$exchangeid){
                        if($input['day']!='All'){
                            $query->whereBetween('created_at', array($this_month, $today));
                        }
                        if(count($type) > 0)
                        {
                            $query->whereIn('account_code',$type);
                        }
                    })->paginate(10);
                }
                /*end of this month*/

                /*searching using last three months*/
                if ($input['day'] == 'three_months') {
                    $today = date('Y-m-d').' 23:59:59';
                    $three_month = date('Y-m-d',strtotime('today - 90 days')).' 00:00:00';

                    $records = LedgerDetails::where('member_id', $memberID)->where(function($query)use($today,$three_month,$type,$input,$exchangeid){
                        if($input['day']!='All'){
                            $query->whereBetween('created_at', array($three_month, $today));
                        }
                        if(count($type) > 0)
                        {
                            $query->whereIn('account_code',$type);
                        }
                    })->paginate(10);
                }
                /*end of using last three months*/

                /*searching using last six months*/
                if ($input['day'] == 'six_months') {
                    $today = date('Y-m-d').' 23:59:59';
                    $six_month = date('Y-m-d',strtotime('today - 180 days')).' 00:00:00';

                    $records = LedgerDetails::where('member_id', $memberID)->where(function($query)use($today,$six_month,$type,$input,$exchangeid){
                        if($input['day']!='All'){
                            $query->whereBetween('created_at', array($six_month, $today));
                        }
                        if(count($type) > 0)
                        {
                            $query->whereIn('account_code',$type);
                        }
                    })->paginate(10);
                }
                /*end of using last six months*/

                /*searching using last one year*/
                if ($input['day'] == 'one_year') {
                    $today = date('Y-m-d').' 23:59:59';
                    $one_year = date('Y-m-d',strtotime('today - 364 days')).' 00:00:00';

                    $records = LedgerDetails::where('member_id', $memberID)->where(function($query)use($today,$one_year,$type,$input,$exchangeid){
                        if($input['day']!='All'){
                            $query->whereBetween('created_at', array($one_year, $today));
                        }
                        if(count($type) > 0)
                        {
                            $query->whereIn('account_code',$type);
                        }
                    })->paginate(10);
                }
                /*end of the searching*/

                /*searching using all records*/
                if ($input['day'] == 'All') {


                    $records = LedgerDetails::where('member_id', $memberID)->where(function($query)use($type,$input,$exchangeid){
                        if($input['day']=='All'){
                            $query->get();
                        }
                        if(count($type) > 0)
                        {
                            $query->whereIn('account_code',$type);
                        }
                    })->paginate(10);
                }
                /*end of using searchin all records*/
            }

            if(isset($input['from']) && isset($input['to']))
            {
                $startdate = date('Y-m-d', strtotime($input['from'])).' 00:00:00';
                $enddate = date('Y-m-d', strtotime($input['to'])).' 23:59:59';

                $records = LedgerDetails::where('member_id', $memberID)->where(function($query)use($startdate,$enddate,$type,$input,$exchangeid){
                    $query->whereBetween('created_at', array($startdate, $enddate));
                    
                    if(count($type) > 0)
                    {
                        $query->whereIn('account_code',$type);      
                    }
                })->paginate(10);
            }
        }

        // dd($records);

        $data['records'] = $records;

        $thisLedgerDetail = new LedgerDetails();

        $data['cbaBalance'] = $thisLedgerDetail->GetMemberCBA();
        $data['barterBalance'] = $thisLedgerDetail->GetMemberBarterBalance();
        $start_date = date('Y-m-d').' 23:59:59';
        $end_date= date('Y-m-d',strtotime('today - 7 days')).' 00:00:00';
        return view('user_member.member.transaction.view-transaction', $data,compact('start_date','end_date'));
    }
}