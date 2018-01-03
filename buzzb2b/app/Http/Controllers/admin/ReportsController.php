<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Session;
use App\LedgerDetails;

class ReportsController extends Controller
{
    public function Reports(){
    	return view('admin.reports.reports');
    }

    public function TopTraders(){
	$exchange_id = session::get('EXCHANGE_ID');
	
	$seacrh_criteria = 'this_week';
	
		if($seacrh_criteria == 'this_week')
		{
		    $dateRange = $this->GetCurrentWeek();
		    
		    

		    $data['list'] = DB::table('ledger')->join('members', 'ledger.member_id', '=', 'members.id')
					->select('members.id as member_id', 'members.name as member_name', 'members.slug as member_slug', 
					    \DB::raw("SUM(ABS(ledger.amount)) AS total_barter"))
					->where('ledger.exchange_id', $exchange_id)
					->whereIn('ledger.account_code', ['4010', '6010'])
					->whereBetween('ledger.created_at', $dateRange)
					->orderBy('total_barter', 'desc')
					->groupBy('member_id')->get();
				//->whereIn('ledger.member_id', '53')
		}
	  return view('admin.reports.top-monthly-traders', $data);
    }

    public function ViewTraders(Request $request){
    	$input = $request->all();
    	$exchange_id = session::get('EXCHANGE_ID');

    	/*searching with filter date this month*/
    	if($input['date'] == 'this_month'){
    		$today_date = date('Y-m-d 23:59:59');
    	    $first_date = date('Y-m-01'); 
            $dateRange = [$first_date, $today_date];

			$data = $this->GetQuery($dateRange,$exchange_id);
			return view('admin.reports.top-monthly-traders', $data);
    	}
    	/*searching with current week*/
    	if($input['date'] == 'this_week'){
    		$dateRange = $this->GetCurrentWeek();

    		$data = $this->GetQuery($dateRange,$exchange_id);

			return view('admin.reports.top-monthly-traders', $data);
    	}
    	/*searching with this month before 90 days */
    	if($input['date'] == 'three_months'){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = date('Y-m-d' , strtotime('-90 day', time()));
    		$dateRange = [$last_date, $today_date];
    		$data = $this->GetQuery($dateRange,$exchange_id);

			return view('admin.reports.top-monthly-traders', $data);
    	}
    	/*searching with 180 days*/
    	if($input['date'] == 'six_months'){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = date('Y-m-d' , strtotime('-180 day', time()));
    		$dateRange = [$last_date, $today_date];
    		$data = $this->GetQuery($dateRange,$exchange_id);

			return view('admin.reports.top-monthly-traders', $data);
    	}

    	/*getting six one year results*/
    	if($input['date']=='one_year'){
    	    $today_date = date('Y-m-d 23:59:59');
    		$last_date = date('Y-m-d' , strtotime('-1 year', time()));
    		$dateRange = [$last_date, $today_date];
    		$data = $this->GetQuery($dateRange,$exchange_id);

			return view('admin.reports.top-monthly-traders', $data);	
    	}

    	/*getting all date results*/
    	if($input['date']=='all'){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = '';
    		$dateRange = [$last_date, $today_date];
    		$data = $this->GetQuery($dateRange,$exchange_id);
			return view('admin.reports.top-monthly-traders', $data);	
    	}

    	if($input['start_date'] && $input['end_date']){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = '';
    		$dateRange = [$input['start_date'], $input['end_date']];
    		$data = $this->GetQuery($dateRange,$exchange_id);
			return view('admin.reports.top-monthly-traders', $data);
    	}
       
    }

    /*member standby*/
    public function MemberOnStandby(){
        return view('admin.reports.member-standby');
    }
    public function ShowMemberOnStandby(Request $request){
        $input = $request->all();
        $exchange_id = session::get('EXCHANGE_ID');
        if($input['date']=='this_week'){
            $dateRange = $this->GetCurrentWeek();
            $data = $this->StandByMember($dateRange,$exchange_id);
        	return view('admin.reports.member-standby',$data);
        }
        /*this month*/
        if($input['date']=='this_month'){
			$today_date = date('Y-m-d 23:59:59');
    	    $first_date = date('Y-m-01'); 
            $dateRange = [$first_date, $today_date];
            $data = $this->StandByMember($dateRange,$exchange_id);
        	return view('admin.reports.member-standby',$data);	
        }

        /*searching with this month before 90 days */
    	if($input['date'] == 'three_months'){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = date('Y-m-d' , strtotime('-90 day', time()));
    		$dateRange = [$last_date, $today_date];
    		$data = $this->StandByMember($dateRange,$exchange_id);
        	return view('admin.reports.member-standby',$data);
    	}

    	/*searching with six months*/
    	if($input['date'] == 'six_months'){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = date('Y-m-d' , strtotime('-180 day', time()));
    		$dateRange = [$last_date, $today_date];
    		$data = $this->StandByMember($dateRange,$exchange_id);
        	return view('admin.reports.member-standby',$data);
    	}

    	/*getting  one year results*/
    	if($input['date']=='one_year'){
    	    $today_date = date('Y-m-d 23:59:59');
    		$last_date = date('Y-m-d' , strtotime('-1 year', time()));
    		$dateRange = [$last_date, $today_date];
    		$data = $this->StandByMember($dateRange,$exchange_id);
        	return view('admin.reports.member-standby',$data);	
    	}

    	/*getting all date results*/
    	if($input['date']=='all'){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = '';
    		$dateRange = [$last_date, $today_date];
    		$data = $this->StandByMember($dateRange,$exchange_id);
        	return view('admin.reports.member-standby',$data);	
    	}
        /*using date range result*/
    	if($input['start_date'] && $input['end_date']){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = '';
    		$dateRange = [$input['start_date'], $input['end_date']];
    		$data = $this->StandByMember($dateRange,$exchange_id);
        	return view('admin.reports.member-standby',$data);
    	}
    }
    /*accounts total by member*/
    public function AccountsTotalbyMemeber(){
      return view('admin.reports.accounts-total-by-member');  
    }

    public function InterExchangeTrading(){
    	$dateRange = $this->GetCurrentWeek();
        $exchange_trders = $this->ExchangeTrading($dateRange);
    return view('admin.reports.inter-exchange-trading',compact('exchange_trders'));
    }

    

    /*inter exchange trading start*/
    public function ShowExchangeTrading(Request $request){
    	$input = $request->all();

    	if ($input['date']=='this_week') {
    		$dateRange = $this->GetCurrentWeek();
    		$exchange_trders = $this->ExchangeTrading($dateRange);
    		return view('admin.reports.inter-exchange-trading',compact('exchange_trders'));
    	}

    	/*exchange traders of this month*/
    	if ($input['date']=='this_month') {
    		$today_date = date('Y-m-d 23:59:59');
    	    $first_date = date('Y-m-01');
    		$dateRange = [$first_date, $today_date];
    		$exchange_trders = $this->ExchangeTrading($dateRange);
    		return view('admin.reports.inter-exchange-trading',compact('exchange_trders'));
    	}

    	/*exchange traders of three months*/
    	if ($input['date']=='three_months') {
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = date('Y-m-d' , strtotime('-90 day', time()));
    		$dateRange = [$last_date, $today_date];
    		$exchange_trders = $this->ExchangeTrading($dateRange);
    		return view('admin.reports.inter-exchange-trading',compact('exchange_trders'));
    	}

    	/*exchange traders of six months*/
    	if ($input['date']=='six_months') {
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = date('Y-m-d' , strtotime('-180 day', time()));
    		$dateRange = [$last_date, $today_date];
    		$exchange_trders = $this->ExchangeTrading($dateRange);
    		return view('admin.reports.inter-exchange-trading',compact('exchange_trders'));
    	}

    	/*searching with one year*/
    	if($input['date'] == 'one_year'){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = date('Y-m-d' , strtotime('-1 year', time()));
    		$dateRange = [$last_date, $today_date];
    		$exchange_trders = $this->ExchangeTrading($dateRange);
    		return view('admin.reports.inter-exchange-trading',compact('exchange_trders'));
    	}

    	/*getting all date results*/
    	if($input['date']=='all'){
    		$today_date = date('Y-m-d 23:59:59');
    		$last_date = '';
    		$dateRange = [$last_date, $today_date];
    		$exchange_trders = $this->ExchangeTrading($dateRange);
    		return view('admin.reports.inter-exchange-trading',compact('exchange_trders'));	
    	}
        /*using date range result*/
    	if($input['start_date'] && $input['end_date']){
    		$dateRange = [$input['start_date'], $input['end_date']];
    		$exchange_trders = $this->ExchangeTrading($dateRange);
    		return view('admin.reports.inter-exchange-trading',compact('exchange_trders'));
    	}
    }


    /*getting current week*/
    public function GetCurrentWeek(){
    	if(date('D') != 'Sun'){
		  $start_day_week = date('Y-m-d 00:00:01',strtotime('last Sunday')); 
	    }
	    else{
		$start_day_week = date('Y-m-d 00:00:01');   
	    }
	
	    if(date('D') != 'Sat'){
		 $last_day_week = date('Y-m-d 23:59:59',strtotime('next Saturday')); 
	    }
	    else{
		 $last_day_week = date('Y-m-d 23:59:59');   
	    }
	    
	    $dateRange = [$start_day_week, $last_day_week];
	    return $dateRange;
    }


    /*query for searching trade*/
    public function GetQuery($dateRange,$exchange_id){
        $data['list'] = DB::table('ledger')->join('members', 'ledger.member_id', '=', 'members.id')
		->select('members.id as member_id', 'members.name as member_name', 'members.slug as member_slug', 
		    \DB::raw("SUM(ABS(ledger.amount)) AS total_barter"))
		->where('ledger.exchange_id', $exchange_id)
		->whereIn('ledger.account_code', ['4010', '6010'])
		->whereBetween('ledger.created_at', $dateRange)
		->orderBy('total_barter', 'desc')
		->groupBy('member_id')->get();
	    return $data;

    }

    /*query for member on standby*/
    public function StandByMember($dateRange,$exchange_id){
    	$data['list'] = DB::table('members')
			->select('members.id as member_id', 'members.name as member_name')
			->where('exchange_id', $exchange_id)
			->whereBetween('created_at', $dateRange)
			->where('standby',1)->orderBy('name', 'asc')->get();
			return $data;
    }

    /*query for excahgne trading */
    public function ExchangeTrading($dateRange)
    {
	
    	$exchange_trders = LedgerDetails::join('exchanges','ledger.exchange_id','=','exchanges.id')
    		                 ->groupBy('city_name')->whereBetween('ledger.created_at',[$dateRange])->get();
    		foreach ($exchange_trders as $key => $value) {
    		/*tip earn and tip out*/
    			$tip_earn = LedgerDetails::where('exchange_id',$value->exchange_id)->where('account_code',4030)->sum('amount');
    			$exchange_trders[$key]->tip_earn = $tip_earn;
    			
			    $tip_out = LedgerDetails::where('exchange_id',$value->exchange_id)
			             ->where('account_code',7030)->sum('amount');
    			$exchange_trders[$key]->tip_out = $tip_out;
    			
                /*sales earn and out*/
    			$sales_earn = LedgerDetails::where('exchange_id',$value->exchange_id)
    			            ->where('account_code',4090)->sum('amount');
    			$exchange_trders[$key]->sales_earn = $sales_earn;
    			$sales_out = LedgerDetails::where('exchange_id',$value->exchange_id)
    			           ->where('account_code',7090)->sum('amount');
    			$exchange_trders[$key]->sales_out = $sales_out;

                /*gift earn and out*/
    			$gift_earn = LedgerDetails::where('exchange_id',$value->exchange_id)
    			           ->where('account_code',4160)->sum('amount');
    			$exchange_trders[$key]->gift_earn = $gift_earn;
    			$gift_out = LedgerDetails::where('exchange_id',$value->exchange_id)
    			           ->where('account_code',7020)->sum('amount');
    			$exchange_trders[$key]->gift_out = $gift_out;

    		    /*barter credit*/
    			$barter_earn = LedgerDetails::where('exchange_id',$value->exchange_id)
    			           ->where('account_code',4020)->sum('amount');
    			$exchange_trders[$key]->barter_earn = $barter_earn;

    			$barter_out = LedgerDetails::where('exchange_id',$value->exchange_id)
    			           ->where('account_code',4020)->sum('amount');
    			$exchange_trders[$key]->barter_out = $barter_out;
    			
    			/*barter fee in*/
    			$barter_in = LedgerDetails::where('exchange_id',$value->exchange_id)
    			           ->where('account_code',4010)->sum('amount');
    			$exchange_trders[$key]->barter_in = $barter_in;

    			$barter_fee_out = LedgerDetails::where('exchange_id',$value->exchange_id)
    			           ->where('account_code',7010)->sum('amount');
    			$exchange_trders[$key]->barter_fee_out = $barter_fee_out;

    			/*referral fee in*/
    			$referral_in = LedgerDetails::where('exchange_id',$value->exchange_id)
    			           ->where('account_code',4070)->sum('amount');
    			$exchange_trders[$key]->referral_in = $referral_in;
    			$referral_out = LedgerDetails::where('exchange_id',$value->exchange_id)
    			           ->where('account_code',7070)->sum('amount');
    			$exchange_trders[$key]->referral_out = $referral_out;
    		}
    	return $exchange_trders;
    }
    
}
