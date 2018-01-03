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
    </div>
		    <div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12"><!-- password_confirmation text field -->
					<h4>Phone Number Details</h4>
					</div>	
				</div>	
				 <div class="row"></div>
				{!! Form::open(['route'=>['users-save-phone'], 'class'=>'form-validate_','method'=>'post']) !!}		
				 <input type='hidden' name="user_id" value="{{$member->id}}">
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
				
				</form>
			</div>
		</div>
@endsection