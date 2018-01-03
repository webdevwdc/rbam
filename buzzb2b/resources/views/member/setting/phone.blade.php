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

		    <li @if(in_array(Route::current()->getName(), array('users-phone'))) {{ "class=active" }} @endif>
			    <a href="{{route('users-phone',[$member->id])}}">Phones</a>
			</li>
		    <li @if(in_array(Route::current()->getName(), array('users-cashiers'))) {{ "class=active" }} @endif>
			    <a href="{{route('users-cashiers',[$member->id])}}">Cashiers</a>
			</li>
		</ul>
	</div>
	<div class="row">
			<div class="col-md-12">
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
                            <a href="{{route('users-delete-phone',[$phone->id])}}" onclick="return confirm('Are you want to delete this phone?')" class="btn btn-danger">
	                             Delete
						    @endif
							</td>
							</tr>
						</tbody>
						@endforeach
						@else
						No phone Found
						@endif
					</table>
				</div> 
			</div>
		</div>
</div>
<div style="width: 97px;float: right;">
   <a href="{{route('users-create-phone',[$member->id])}}" class="btn btn-success btn-block">New Phone</a>
</div>
@endsection