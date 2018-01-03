@extends('user_member.member.layouts.base-2cols')
@section('title', 'Cashier Listing')
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
				<div class="table-responsive">
					@if(!empty($cashiers))
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
								   @if($cashier->user_id != 0)
									   {{$cashier->first_name. ' '.$cashier->last_name}}
								   @else
									   {{$cashier->nickname}}
								   @endif
								</td>
								<td>
								   @if($cashier->user_id != 0)
								   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								   @else
								   <i class="fa fa-minus" aria-hidden="true"></i>
								   @endif
								</td>
								<!--<td>
								   @if($cashier->member_id==0)
								   <a href="" onclick="return confirm('Are you want to delete this phone?')" class="btn btn-danger">
									Delete
								   @endif
								</td>-->
							</tr>
							@endforeach
							@else
							<tr>
							  <td>
							  	Looks like you have no cashiers! 
							  	Cashiers allow you to tag your sales to a specific cashier. 
							  	Add or create one now 
							  	<a href="{{route('create_cashier_setting')}}" style="color:cadetblue;font-size:medium;">Add Cashier</a>
							  </td> 
						    </tr>
						     @endif
					</table>

				</div> 
			</div>
		</div>
</div>
<div style="width: 97px;float: right;">
   <a href="{{route('create_cashier_setting')}}" class="btn btn-success btn-block">Add Cashier</a>
</div>
@endsection