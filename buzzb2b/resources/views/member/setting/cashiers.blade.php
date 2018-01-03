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
	</div>
	  <div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					@if(count($cashiers))
					<table class="table table-hover">
						<thead>
							<tr>
							<th>Name</th>
							<th>Authorised User</th>
							</tr>
						</thead>
						    @foreach($cashiers as $cashier)
							<tr>
                             <td>
                             	@if($cashier->member_id!=0)
                             	{{$cashier->first_name}} {{$cashier->last_name}}
                             	@else
                             	{{$cashier->nickname}}
                             	@endif
                             </td>
                             <td>
                             	@if($cashier->member_id!=0)
                             	<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                             	@else
                             	<i class="fa fa-minus" aria-hidden="true"></i>
                             	@endif
                             </td>
                             <td>
                             	@if($cashier->member_id==0)
                             	<a href="" onclick="return confirm('Are you want to delete this phone?')" class="btn btn-danger">
	                             Delete
                             	@endif
                             </td>
							</tr>
							@endforeach
							@else
							<tr>
							  <td>
							  	Looks like you have no cashiers! 
							  	Cashiers allow you to tag your sales to a specific cashier. 
							  	Add or create one now 
							  	<a href="{{route('users-create-cashiers',[$member->id])}}" style="color:cadetblue;font-size:medium;">Add Cashier</a>
							  </td> 
						    </tr>
						     @endif
					</table>

				</div> 
			</div>
		</div>
</div>
<div style="width: 97px;float: right;">
   <a href="{{route('users-create-cashiers',[$member->id])}}" class="btn btn-success btn-block">Add Cashier</a>
</div>
@endsection