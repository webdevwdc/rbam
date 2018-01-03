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
			     <li @if(in_array(Route::current()->getName(), array('users-address'))) {{ "class=active" }} @endif>
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
								<th>Member Address</th>
								<th>Default</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($addresses))
							@foreach($addresses as $address)
							<tr>
							<td>{{$address->address1}}</td>
							<td>
								@if($address->is_default == 'Yes')
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								@else
								<i class="fa fa-minus" aria-hidden="true"></i>
								@endif
							</td>
							<td>
								@if($address->is_default == 'No')
	                            <a href="{{route('users-delete-address',[$address->id])}}" onclick="return confirm('Are you want to delete this phone?')" class="btn btn-danger">
	                             Delete
	                            </a>
							    @endif
								</td>
							</tr>
							@endforeach
							@else
							<tr>
								<td>No Addresses Found</td>
							</tr>
							@endif
						</tbody>
					</table>
				</div> 
			  </div>
		  </div>
</div>
		<div style="width: 97px;float: right;">
		   <a href="{{route('users-create-address',[$member->id])}}" class="btn btn-success btn-block">New Address</a>
		</div>
@endsection