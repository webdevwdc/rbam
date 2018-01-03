@extends('user_member.member.layouts.base-2cols')
@section('content')
<div class="row">
	<div class="col-md-12">
	    <ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
			    <li @if(in_array(Route::current()->getName(), array('member_setting'))) {{ "class=active" }} @endif>
			    	<a href="{{route('member_setting')}}">Directory Settings</a>
			    </li>
			    <li @if(in_array(Route::current()->getName(), array('users_setting','users_create'))) {{ "class=active" }} @endif>
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
	<div class="row">
			<div class="col-md-12">
				@include('admin.includes.messages')
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
							<th>Number</th>
							<th>Type</th>
							<th>Primary</th>
							</tr>
						</thead>
						@if(!empty($phones))
						@foreach($phones as $phone)
						<tbody>
							<tr>
							<td>{{$phone->number}}</td>
							<td>
							@if($phone->phone_type_id==1)
							Office
							@endif
							@if($phone->phone_type_id==2)
							Mobile
							@endif
							</td>
							<td>
							@if($phone->is_primary == 'No')
							<i class="fa fa-minus" aria-hidden="true"></i>
							@else
							<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							@endif
							</td>
							<td>
							@if($phone->is_primary == 'No')
                            <a href="{{route('member_phone_delete',[$phone->id])}}" onclick="return confirm('Are you want to delete this phone?')" class="btn btn-danger">
	                             Delete
						    @endif
							</td>
							</tr>
						</tbody>
						@endforeach
						@else
						<tr>
							<td>No phone Found</td>
						</tr>
						
						@endif
					</table>
				</div> 
			</div>
		</div>
</div>
<div style="width: 97px;float: right;">
   <a href="{{route('phone_create')}}" class="btn btn-success btn-block">Add Phone</a>
</div>
@endsection