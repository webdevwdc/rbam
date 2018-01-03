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

			    <li @if(in_array(Route::current()->getName(), array('address_setting','address_create'))) {{ "class=active" }} @endif>
			     	<a href="{{route('address_setting')}}">Addresses</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('phone_setting','phone_create'))) {{ "class=active" }} @endif>
			     	<a href="{{route('phone_setting')}}">Phones</a>
			    </li>
			    
			    <li @if(in_array(Route::current()->getName(), array('cashier_setting'))) {{ "class=active" }} @endif>
			     	<a href="{{route('cashier_setting')}}">Cashiers</a>
			    </li>
			</ul>
		{{-- messages section start--}}
		@include('admin.includes.messages')
		{{-- messages section end--}}
    </div>
    <div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12"><!-- password_confirmation text field -->
					<h4>Phone Number Details</h4>
					</div>	
				</div>	
				 <div class="row"></div>
				{!! Form::open(['route'=>['phone_save'], 'class'=>'form-validate_','method'=>'post']) !!}
				<div class="group_1">
					<div class="row">
						
						<div class="col-md-6">		
							<div class="form-group">
								<label for="phone_number">Phone Number *</label>
								<input class="form-control required" id="" placeholder="Enter phone number" name="phone_number" type="text" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="phone_type">Phone Type *</label>
								<select class="form-control required" id="phone_type" name="phone_type"><option value="1">Office</option><option value="2">Mobile</option></select>
							</div>
						</div>
						    
						<div class="col-md-6">
							<div class="form-group">
								<label for="is_primary">Is Primary</label>
								<select class="form-control required" id="is_primary" name="is_primary"><option value="Yes">Yes</option><option value="No">No</option></select>
							</div>
						</div>
						
					</div>	
						
				</div>
				<input class="btn btn-info pull-right green" type="submit" value="Save">	
				{!! Form::close() !!}
			</div>
</div>
			
				

@endsection