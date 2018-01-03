@extends('admin.layouts.base-2cols')
@section('title', 'Account Details')
@section('content')
<style type="text/css">
 .hover{
    color: #295FA6;
}
.modal-title{
font-size: 18px;
font-weight: 500;
}
.account{
margin-top: 16px;
margin-left: 31px;
}
.field{
	height: 32px;
    width: 186px;
}
.hover{
  cursor: pointer; cursor: hand;
}
</style>
<div class="row">
    <div class="col-md-12">

        {{-- messages section start--}}
        @include('admin.includes.messages')
	    {{-- messages section end--}}
	
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : Account Details</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
            	<div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12"><!-- password_confirmation text field -->
						@include('admin.includes.member_edit_tab')
					</div>	
				</div>
			</div>

	<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12">
		</div>	
	</div>
	<div class="panel panel-info">

		<div class="panel-body">

			<div class="row">
				<div class="col-md-12">

					<table class="table table-hover">
						<thead>
							<tr>
								<th>Barter Balance  
								<a class="hover" data-toggle="modal" data-target="#myModal">Debit</a> | 
								<a class="hover" data-toggle="modal" data-target="#CreditmyModal">Credit</a> 
								</th>
								<th>CBA Balance
									<a class="hover" data-toggle="modal" data-target="#CbaDebitmyModal">Debit</a> | 
								  <a class="hover" data-toggle='modal' data-target="#CbaCreditmyModal">Credit</a>
								</th>
								<th>Referral Commissions</th>
								<th>Available Barter Credit</th>
								<th><a href="{{route('admin_user_edit_financial_details',$member->id)}}" class="hover">Manage</a></th>
							</tr>
						</thead>
						<tbody>
            
            @if(!empty($member))
						<tr>
              <td>T$ {{ $member->account }}</td>
              <td>T$ {{ $member->cba_account }}</td>
              <td>N/A</td>
              <td>
                @if($member->credit_limit >0)
                T$ {{ $member->credit_limit }}
                @else
                T$ 0.00
                @endif
              </td>
	       <td>&nbsp;</td>
						</tr>
            @endif
						</tbody>

					</table>
          Spending Power: @if($member->credit_limit >0) T$ {{ $member->credit_limit }} @else T$ 0.00 @endif
				</div>
			</div>
      <div>
      {!! Form::open(array('route'=>['admin_edit_user_account_details',$member->id], 'id'=>'search', 'class'=>'form-validate_')) !!}
       <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="account">
            {{ Form::select('day', ['this_week'=>'This Week','this_month'=>'Last 30 days','three_months'=>'Last 3 months','six_months'=>'Last 6 months','one_year'=>'1 year','All'=>'Forever'], null, ['class' => 'field day']) }}

            {{ Form::select('type', ['All'=>'All Types', 'sales' => 'Sales', 'purchase' => 'Purchase', 'cba_deposit' =>'CBA Deposit','cba_withdraw' =>'CBA Withdrawals','referral-bonues' =>'Referral Bonues', 'sales-commissions' => 'Sales Commissions', 'credits' => 'Credits'], null, ['class' => 'day field type']) }}

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
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
            
            @foreach($search as $account)
            <tr>
              <td>{{$account->created_at->format('m-d-Y')}}</td>
              <td>
                @if($account->type_id==25)
                Sale
                @endif
              </td>
              <td>
               {{Auth::guard('admin')->user()->first_name}} {{Auth::guard('admin')->user()->last_name}}
              </td>
              <td>
                @if($account->amount >0)
                {{$account->amount / 100}}
                @else
                --
                @endif
              </td>
              <td>
                @if($account->account_code == 7010)
                  {{$account->amount / 100}}
                @endif
              </td>
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
              <td>
               <!-- {{ $account->amount * 4 / 100 }} -->
               N / A
              </td>
              <td>
                @if($account->account_code ==7040)
                 {{$account->amount / 100}}
                @endif
              </td>
              <td>{{$account->notes}}</td>
              <td>
                <a href="{{route('admin-delete-transaction',[Crypt::encrypt($account->id)])}}" class="btn btn-info pull-right" onclick="return confirm('Are you want to delete this Transaction?')">Delete</a>
              </td>
            </tr>
            @endforeach
            </tbody>
                <div class="paginator">
                       {{ $search->appends(['from' => $start_date,'to'=>$end_date])->render() }}   
                </div>
            @else
          <div style="margin-top: 20px;text-align: center;font-weight: 600;">No transactions match this criteria.</div>
          </table>
         @endif

	</div>

	</div>
	</div>
  </div>
 </div>
</div>
<!-- Debit modal start for burter account -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Debit Member Barter Account</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('route'=>['create-user-barter-accounts',$member->id], 'id'=>'', 'class'=>'form-validate_','method'=>'post')) !!}
      	<div>
      		<label>Debit Amount</label>
            {{ Form::number('amount', null, array('class' => 'field','min'=>0)) }}
      	</div>

      	<div class="account">
      		<label>Account</label>
           {{ Form::select('account', [1=>'Exchange Debit'], null, ['class' => 'field']) }}
      	</div>

      	<div class="account">
      		<label>Note</label>
           {{ Form::text('notes', null, array('class' => 'field')) }}
      	</div>
      
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-default">Debit Account</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>
<!-- modal start for credit burter account -->
<div id="CreditmyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Credit Member Barter Account</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('route'=>['create-user-barter-accounts',$member->id], 'id'=>'', 'class'=>'form-validate_','method'=>'post')) !!}
        <div>
          <label>Credit Amount</label>
            {{ Form::number('amount', null, array('class' => 'field','min'=>0)) }}
        </div>

        <div class="account">
          <label>Account</label>
           {{ Form::select('account', [2=>'Exchange Credit'], null, ['class' => 'field']) }}
        </div>

        <div class="account">
          <label>Note</label>
           {{ Form::text('notes', null, array('class' => 'field')) }}
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" >Credit Account</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>
<!-- modal for debit cba account -->
<div id="CbaDebitmyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Debit Member CBA Account</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('route'=>['create-user-cba-accounts',$member->id], 'id'=>'', 'class'=>'form-validate_','method'=>'post')) !!}
        <div>
          <label>Debit Amount</label>
            {{ Form::number('amount', null, array('class' => 'field','min'=>0)) }}
        </div>

        <div class="account">
          <label>Account</label>
           {{ Form::select('account', [3=>'Member Withdrawal'], null, ['class' => 'field']) }}
        </div>

        <div class="account">
          <label>Note</label>
           {{ Form::text('notes', null, array('class' => 'field')) }}
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default">Debit Account</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>
<!-- modal for credit cba account -->
<div id="CbaCreditmyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Credit Member CBA Account</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('route'=>['create-user-cba-accounts',$member->id], 'class'=>'form-validate_','method'=>'post')) !!}
        <div>
          <label>Credit Amount</label>
            {{ Form::number('amount', null, array('class' => 'field','min'=>0)) }}
        </div>

        <div class="account">
          <label>Account</label>
           {{ Form::select('account', [4=>'Direct Payment',5=>'Exchange Credit'], null, ['class' => 'field']) }}
        </div>

        <div class="account">
          <label>Note</label>
           {{ Form::text('notes', null, array('class' => 'field')) }}
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" >Credit Account</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
<!-- search for user account details -->
<script type="text/javascript">
$(document).ready(function(){
    $('.day').change(function(){
    $('#search').submit();
  });
});

</script>
@endsection