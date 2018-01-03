@extends('user_member.member.layouts.base-2cols')
@section('title', 'Transactions')
@section('content')
 <style type="text/css">
 <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css"> <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
 .account{
margin-top: 16px;
margin-left: 31px;
}
.field{
	height: 32px;
    width: 186px;
}
.hidden{
	visibility: hidden;
}
.date{
margin-top: 12px;
}
 </style>   
<div class="row">
    <div class="col-md-12">

        {{-- messages section start--}}
        @include('member.includes.messages')
		{{-- messages section end--}}
	
		<div class="panel panel-info">
			
			<div class="panel-body">
				<div class="col-md-12 col-xs-12">
				
				    <div class="row">
						<div class="col-md-6">
							<h4>Barter Balance</h4>
							    <p><strong>T{{ $barter_balance}}</strong></p>
						</div>
						
						<div class="col-md-6">
							<h4>CBA Balance</h4>
							<p><strong>T{{ $cba_balance}}</strong></p>
						</div>
						    
				    </div>


				</div>
			</div>
	</div>
	<div>
      {!! Form::open(array('route'=>['member_transaction'], 'id'=>'search', 'class'=>'form-validate_')) !!}
       <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="account">
           {{ Form::select('day', ['-1 week'=>'This Week','-1 month'=>'Last 30 days','-3 month'=>'Last 3 months','-6 month'=>'Last 6 months','-1 year'=>'1 year','All'=>'Forever','10'=>'Date Range'], null, ['class' => 'field day']) }}
           {{ Form::select('type', ['All'=>'All Types',4040=>'CBA Deposit',7040=>'CBA Withdrawals',4070=>'Referral Bonuses',4090=>'Sales Commissions',8=>'Credit'], null, ['class' => 'day field type']) }}
           {{ Form::select('user', [1=>'All Users'], null, ['class' => 'field user']) }}
        </div>
       {!! Form::close() !!}
      </div>
      @if(!empty($search) && count($search)>0)
      <table class="table table-hover">
            <thead>
              <tr>
                <th>Date</th>
                <th>Type</th>
                <th>To / From</th>
                <th>Amount</th>
                <th>Tip</th>
                <th>Member CBA($)</th>
                <th>Member Barter (T$)</th>
                <th>Earned Revenue</th>
                <th>Unearned Revenue</th>
                <th>Notes</th>
              </tr>
            </thead>
            <tbody>
            
            @foreach($search as $account)
            <tr>
              <td>{{$account->created_at->format('m-d-Y')}}</td>
              <td>{{$account->account_code_name}}</td>
              <td>N/A</td>
              <td>
                @if($account->amount >0)
                {{$account->amount / 100}}</td>
                @else
                --
                @endif
              <td> -- </td>
              <td>
                @if($account->account_code == 7040 || $account->account_code == 3020 || $account->account_code==4040)
                {{$account->amount / 100}}
                @endif
              </td>
              <td>
                @if($account->account_code == 4080 || $account->account_code == 4020 )
                {{$account->amount / 100}}
                @endif
              </td>
              <td> N/A </td>
              <td> N/A </td>
              <td>{{$account->notes}}</td>
            </tr>
            @endforeach
            </tbody>
            @else
          <div style="margin-top: 20px;text-align: center;font-weight: 600;">No transactions match this criteria.</div>
          </table>
         @endif
         {!! Form::open(['route' => 'member_transaction']) !!}
            <div  class="date hidden">
         	<input type="text" name="from"  class="datepicker"> To 
         	<input type="text" name="to" class="datepicker">
         	<button type="submit" class="btn btn-primary">Filter</button>
           </div>
           {!! Form::close() !!}
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.day').change(function(){
		var val = $('.day').val();
		if(val!=10){
          $('#search').submit();
		}
		if(val==10){
			$('.hidden').removeClass('hidden');
		}
	});
});
</script>

<script> 
$(document).ready(function() {
 $(".datepicker").datepicker(); 
}); 
</script>
@endsection 