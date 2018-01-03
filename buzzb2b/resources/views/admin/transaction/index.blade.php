@extends('admin.layouts.base-2cols')
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
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-12">
						<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : Transactions</h3>
					</div>
				</div>
			</div>
			
	</div>
	<div>
      {!! Form::open(array('route'=>['admin-search-transcation'], 'id'=>'search', 'class'=>'form-validate_')) !!}
       <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="account">
           {{ Form::select('day', ['this_week'=>'This Week','this_month'=>'Last 30 days','three_months'=>'Last 3 months','six_months'=>'Last 6 months','one_year'=>'1 year','All'=>'Forever','10'=>'Date Range'], null, ['class' => 'field day']) }}
           
           {{ Form::select('type', [
           'All'=>'All Types',
           4040=>'Member Barter',
           'cba-deposits'=>'Member CBA Deposits',
           'member-cba-withdrawals'=>'Member CBA Withdrawals',
           'giftcard-barter-beposit'=>'Member Giftcard Issues',
           ], null, ['class' => 'day field type']) }}
           {{ Form::select('user', [1=>'All Members'], null, ['class' => 'field user']) }}
        </div>
       {!! Form::close() !!}
      </div>
      @if(!empty($records) && count($records)>0)
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
                  <th>Unearned Revenue</th><!-- account code 4120 and 3020 -->
                  <th>Notes</th>
                </tr>
              </thead>
              <tbody>
              
              @foreach($records as $account)

              <tr>
               <td>{{$account->created_at->format('d-m-Y')}}</td>
               <td>{{$account->transaction->transactionTypeData->name}}</td>
               <td>
                 @if($account->transaction->merchant_member_id==0)
                  --
                 @else
                 {{$account->transaction->customerToUser->name}}
                 @endif
              </td>
               <td>
                 @if($account->transaction->merchant_member_id==0)
                 --
                 @else
                 {{$account->transaction->customerFromUser->name}}</td>
                 @endif
               <td>{{$account->amount / 100}}</td>
               <td>

                 @if($account->account_code==4030 || $account->account_code==7030)
                  {{$account->amount / 100}}
                 @else
                   --
                 @endif
               </td>
               <td>
                @if($account->account_code==7040 || $account->account_code==3020 || $account->account_code==4040 || $account->account_code==7010)
                  {{$account->amount / 100}}
                 @else
                   --
                 @endif
               </td>
               <td>
                 @if($account->account_code==4020 || $account->account_code==4080 || $account->account_code==4010)
                  {{$account->amount / 100}}
                 @else
                   --
                 @endif
               </td>
               <td>
                @if($account->member_id==0)
                 {{$account->amount / 100}}
                @endif
               </td>
               <td>
                 @if($account->account_code==4120 || $account->account_code==3020 || $account->account_code==7040 || $account->account_code==4120)
                 {{$account->amount / 100}}
                 @else
                 - -
                 @endif
               </td>
               <td>{{$account->notes}}</td>

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
         {!! Form::open(['route' => 'admin-date-search-transcation']) !!}
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