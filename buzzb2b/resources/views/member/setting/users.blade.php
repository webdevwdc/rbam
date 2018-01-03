@extends('member.layouts.base-2cols')
@section('content')
<div class="row">
	<div class="col-md-12">
	    <ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
		    <li @if(in_array(Route::current()->getName(), array('member-setting'))) {{ "class=active" }} @endif>
			    	<a href="{{route('member-setting')}}">Directory Settings</a>
			</li>
		    <li @if(in_array(Route::current()->getName(), array('users-setting'))) {{ "class=active" }} @endif>
		    	<a href="{{route('users-setting',[$member->id])}}">Users</a>
		    </li>

		    <li @if(in_array(Route::current()->getName(), array('users-address','users-create-address'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-address',[$member->id])}}">Addresses</a>
			</li>

		    <li @if(in_array(Route::current()->getName(), array('users-phone','users-create-phone'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-phone',[$member->id])}}">Phones</a>
			</li>
		    <li @if(in_array(Route::current()->getName(), array('users-cashiers'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-cashiers',[$member->id])}}">Cashiers</a>
			    </li>
		</ul>
		{{-- messages section start--}}
		@include('admin.includes.messages')
		{{-- messages section end--}}
		
		<div class="panel panel-info">
			
		
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
							</tr>
						</thead>
						<tbody>
							@if(!empty($users))
							@foreach($users as $user)
							<td><a href="{{route('users-edit',$user->id)}}" style="color: #2cafe3;">
							   {{$user->email}}</a>
							</td>
							<td>{{$user->name}}</td>
							<td>
								@if($user->primary == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($user->admin == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($user->can_access_billing == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($user->can_pos_sell == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($user->can_pos_purchase == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
							<td>
								@if($user->monthly_trade_limit == 0)
								<i class="fa fa-minus" aria-hidden="true"></i>
								@else
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@endif
							</td>
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
</div>
<div style="width: 97px;float: right;">
   <a href="{{route('users-create',[$member->id])}}" class="btn btn-success btn-block">New User</a>
</div>
@endsection