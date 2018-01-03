@extends('user_member.member.layouts.base-2cols')
@section('title', 'Setting')
@section('content')
<div class="row">
		  <div class="col-md-12">
		  	
			<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
			    <li @if(in_array(Route::current()->getName(), array('member_setting'))) {{ "class=active" }} @endif>
			    	<a href="{{route('member_setting')}}">Directory Settings</a>
			    </li>
			    <li @if(in_array(Route::current()->getName(), array('users_setting'))) {{ "class=active" }} @endif>
			    	<a href="{{route('users_setting')}}">Users</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('address_setting'))) {{ "class=active" }} @endif>
			     	<a href="{{route('address_setting')}}">Addresses</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('phone_setting'))) {{ "class=active" }} @endif>
			     	<a href="{{route('phone_setting')}}">Phones</a>
			    </li>
			    
			    <li @if(in_array(Route::current()->getName(), array('cashier_setting'))) {{ "class=active" }} @endif>
			     	<a href="{{route('cashier_setting')}}">Cashiers</a>
			    </li>
			</ul>
          </div>
          @include('admin.includes.messages')
          <div class="panel panel-info">
			
			<div style="text-align: center;">
				    @if(Session::has('succmsg'))
					<span style="color:green">{{ Session::get('succmsg') }}</span>
				    @endif
				    @if(Session::has('errmsg'))
					<span style="color:red">{{ Session::get('errmsg') }}</span>
				    @endif			
		        </div>
		
			<div class="panel-body">
				
	<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Email</th>
								<th>Name</th>
								<th>Primary Contact</th>
								<th>Admin </th>
								<th>Billing Access </th>
								<th>Sales Access  </th>
								<th>Purchase Access </th>	
								<th>Monthly Trade Limit </th>
						                <!--<th>&nbsp;</th>-->
							</tr>
						</thead>
						<tbody>
							@if(!empty($member_user))
							@foreach($member_user as $member_user)
							<tr>
							<td><a href="#">{{$member_user->email}}</a></td>
							<td>{{$member_user->first_name}} {{$member_user->last_name}}</td>
							<td>
								@if($member_user->primary == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($member_user->admin == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($member_user->can_access_billing == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($member_user->can_pos_sell == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($member_user->can_pos_purchase == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($member_user->monthly_trade_limit == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								{{$member_user->monthly_trade_limit}}
								@endif
							</td>
									
						        <td>
							
							        @if(Session::get('USER_ID') != $member_user->id)
							         <a href="{{route('users_delete',[$member_user->id])}}" onclick="return confirm('Are you want to delete this?')" class="btn btn-danger">Delete</a>
						                @elseif($member_user->primary != 1)
						                 <a href="{{route('users_delete',[$member_user->id])}}" onclick="return confirm('Are you want to delete this?')" class="btn btn-danger disabled">Delete</a>
								@else	
								  <a href="{{route('users_delete',[$member_user->id])}}" onclick="return confirm('Are you want to delete this?')" class="btn btn-danger disabled">Delete</a>		  
						                @endif
							</td>
									
							</tr>
							@endforeach
							@endif
							
						</tbody>
					</table>
				</div> 
			</div>
		</div>
			</div>

		</div> 
</div>
<div style="width: 97px;float: right;">
   <a href="{{route('users_create')}}" class="btn btn-success btn-block">Add User</a>
</div>
@endsection