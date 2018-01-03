@extends('user_member.member.layouts.base-2cols')
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
	                            <a href="{{route('address_delete',[$address->id])}}" onclick="return confirm('Are you want to delete this Address?')" class="btn btn-danger">
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
		   <a href="{{route('address_create')}}" class="btn btn-success btn-block">Add Address</a>
		</div>
@endsection