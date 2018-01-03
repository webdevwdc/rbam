@extends('user_member.member.layouts.base-2cols')
@section('title', 'Transactions')
@section('content')

 <style type="text/css">
 
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
							    <p><strong>T{{ $barterBalance}}</strong></p>
						</div>
						
						<div class="col-md-6">
							<h4>CBA Balance</h4>
							<p><strong>T{{ $cbaBalance}}</strong></p>
						</div>
						    
				    </div>


				</div>
			</div>
	</div>
	<div>
      {!! Form::open(array('route'=>['member_transaction'], 'id'=>'search', 'class'=>'form-validate_')) !!}
       <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="account">
           {{ Form::select('day', ['this_week'=>'This Week','this_month'=>'Last 30 days','three_months'=>'Last 3 months','six_months'=>'Last 6 months','one_year'=>'1 year','All'=>'Forever','10'=>'Date Range'], null, ['class' => 'field day']) }}
           
           {{ Form::select('type', ['All'=>'All Types','sales'=>'Sales','purchases'=>'Purchases','cba-deposits'=>'CBA Deposits','member-cba-withdrawals'=>'CBA Withdrawals'], null, ['class' => 'day field type']) }}

           {{ Form::select('user', [1=>'All Members'], null, ['class' => 'field user']) }}
        </div>
       {!! Form::close() !!}
      </div>
      @if(!is_null($records) && count($records) > 0)
      <table class="table table-hover">
            <thead>
              <tr>
                <th>Date</th>
                <th>Type</th>
                <th>To</th>
                <th>From</th>
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
            
            @foreach($records as $eachRecord)
            <tr>
              <td>{{$eachRecord->created_at->format('m-d-Y')}}</td>
              <td>{{ ucfirst(str_replace('-',' ', $eachRecord->transaction->transactionTypeData->name)) }}</td>

              @if($eachRecord->transaction->merchant_member_id == 0)
                <td></td>
              @else
                <td>{{$eachRecord->transaction->customerToUser->name}}</td>
              @endif

              @if($eachRecord->transaction->merchant_member_id == 0)
                <td></td>
              @else
                <td>{{$eachRecord->transaction->customerFromUser->name}}</td>
              @endif

              <td>{{$eachRecord->amount/100}}</td>
              <td>
                @if($eachRecord->account_code==4030 || $eachRecord->account_code==7030)
                  {{$eachRecord->amount/100}}
                 @else
                 --
                 @endif
              </td>
              <td>
                @if($eachRecord->account_code == 7040 || $eachRecord->account_code == 3020 || $eachRecord->account_code == 4040 || $eachRecord->account_code == 7010 )
                {{ $eachRecord->amount/100 }}
                @else
                --
                @endif
              </td>
              <td>
                @if($eachRecord->account_code == 4020 || $eachRecord->account_code == 4080 || $eachRecord->account_code == 4010)
                {{ $eachRecord->amount/100 }}
                @else
                --
                @endif
              </td>
              <td> 
               @if($eachRecord->member_id==0)
                 {{$eachRecord->amount / 100}}
               @else
                 --
                @endif
              </td>
              <td>
                 @if($eachRecord->account_code==4120 || $eachRecord->account_code==3020 || $eachRecord->account_code==7040 || $eachRecord->account_code==4120)
                 {{$eachRecord->amount / 100}}
                 @else
                 - -
                 @endif
              </td>
              <td>{{$eachRecord->notes}}</td>
              
              
            </tr>
            @endforeach
            </tbody>
                  <div class="paginator">
                       {{ $records->appends(['from' => $start_date,'to'=>$end_date])->render() }}   
                  </div>
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