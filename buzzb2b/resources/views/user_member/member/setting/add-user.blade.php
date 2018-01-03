@extends('user_member.member.layouts.base-2cols')
@section('title', 'Create User')
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
         

        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
        <div class="panel panel-info">
            
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
			<!--<h4>Exchange Details</h4>-->
		</div>	
	</div>	
	
{!! Form::open(array('route'=>['save_users_create'],'id'=>'','class'=>'form-validate_','method'=>'post'))!!}
<div class="group_1">
								    
<div class="row">
						
<div class="col-md-8">						

	<div class="form-group">
		{{ Form::label('email', 'Email', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-7 col-md-5 col-lg-5">
			{{ Form::email('email', null, ['class' => 'form-control']) }}
		</div>
	</div>

	<!-- input: firstname -->
	<div class="form-group">
		{{ Form::label('firstname', 'First Name', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-5 col-md-4 col-lg-5">
			{{ Form::text('firstname', null, ['class' => 'form-control']) }}
		</div>
	</div>

	<!-- input: lastname -->
	<div class="form-group">
		{{ Form::label('lastname', 'Last Name', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-5 col-md-4 col-lg-5">
			{{ Form::text('lastname', null, ['class' => 'form-control']) }}
		</div>
	</div>

	<!-- input: password -->
	<div class="form-group">
		{{ Form::label('password', 'Password', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-5 col-md-4 col-lg-5">
			<input class="form-control" name="password" type="password" id="password">
		</div>
	</div>

	<!-- input: password_confirmation -->
	<div class="form-group">
		{{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-5 col-md-4 col-lg-5">
			<input class="form-control" name="password_confirmation" type="password" id="password_confirmation">
		</div>
	</div>
	    
	 	<!-- checkbox: admin -->
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-9 col-md-offset-4 col-md-8">
				<div class="checkbox">
					<label>
					{{ Form::checkbox('admin', 1, false, ['id' => 'admin']) }} Make this user an admin
					</label>
				</div>
			</div>
		</div>

		<!-- input: monthly_trade_limit -->
		<div class="form-group">
			{{ Form::label('monthly_trade_limit', 'Monthly Trade Limit', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-5 col-md-4 col-lg-5">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					{{ Form::text('monthly_trade_limit', null, ['class' => 'form-control', 'placeholder' => 'optional']) }}
				</div>
			</div>
		</div>

	<!-- select: create_new_address -->
	<div class="form-group">
		{{ Form::label('create_new_address', 'Please Select', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-5 col-md-4 col-lg-5">
		@if(!empty($defaultAddress))
			{{ Form::select('create_new_address', [0 => $defaultAddress->address1, 1 => 'Create New Address'], null, ['class' => 'form-control']) }}
		@else
        {{ Form::select('create_new_address', [1 => 'Create New Address'], null, ['class' => 'form-control']) }}
		@endif
		</div>
	</div>
	    
	<div id="yes_create_new_address_wrap">
		<div class="form-group">
			{{ Form::label('address1', 'Street Address', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-9 col-md-6 col-lg-5">
				{{ Form::text('address1', null, ['class' => 'form-control']) }}
			</div>
		</div>
		
		<!-- input: address2 -->
		<div class="form-group">
			{{ Form::label('address2', 'Suite / Unit', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-6 col-md-5 col-lg-5">
				{{ Form::text('address2', null, ['class' => 'form-control', 'placeholder' => 'optional']) }}
			</div>
		</div>
		
		<!-- input: city -->
		<div class="form-group">
			{{ Form::label('city', 'City', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-6 col-md-5 col-lg-5">
				{{ Form::text('city', null, ['class' => 'form-control']) }}
			</div>
		</div>
		<!-- select: state_id (ids) -->
		<div class="form-group">
			{{ Form::label('state_id', 'State', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-3 col-md-2 col-lg-5">
				{{ Form::select('state_id', $state, null, ['class' => 'form-control']) }}
			</div>
		</div>
		<!-- input: zip -->
		<div class="form-group">
			{{ Form::label('zip', 'Zip/Postal Code', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-3 col-md-2 col-lg-5">
				{{ Form::text('zip', null, ['class' => 'form-control']) }}
			</div>
		</div>	    

	</div>

	<div id="no_create_new_address_wrap">
		<div class="form-group">
			<label class="col-sm-3 col-md-4 col-lg-4 control-label"></label>
			<div class="col-sm-5 col-md-4 col-lg-3">
				
			</div>
		</div>
	</div>	    

	<!-- select: create_new_phone -->
	<div class="form-group">
		{{ Form::label('create_new_phone', 'Please Select', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-5 col-md-4 col-lg-5">
			{{ Form::select('create_new_phone', [0 => $defaultPhone->number, 1 => 'Create New Phone'], null, ['class' => 'form-control']) }}
		</div>
	</div>	    
	<div id="yes_create_new_phone_wrap">
		<div class="form-group">
			{{ Form::label('phone_type_id', 'Type', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-5 col-md-4 col-lg-5">
				{{ Form::select('phone_type_id', $phonetypeSelectionList, null, ['class' => 'form-control']) }}
			</div>
		</div>
		
		<!-- input: phone_number -->
		<div class="form-group">
			{{ Form::label('phone_number', 'Primary Contact Number', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-5 col-md-4 col-lg-5">
				{{ Form::text('phone_number', null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>    
	<div id="no_create_new_phone_wrap">
		<div class="form-group">
			<label class="col-sm-3 col-md-4 col-lg-4 control-label"></label>
			<div class="col-sm-5 col-md-4 col-lg-3">
				
			</div>
		</div>
	</div>

    
    </div>
</div>
    
 <div class="row"></div>
				    
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="#" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
    
<script>

	
	$(document).ready(function() {
	   $("#phone_number").mask("(999) 999-9999");
	});
	
	function refreshNewAddressWrap() {

	    //if ($('#create_new_address option:selected').text() == "Create New Address") {
	    if ($('#create_new_address option:selected').val() == 0) { 
	     $('#no_create_new_address_wrap').show();
	     $('#yes_create_new_address_wrap').hide();
	    } else if ($('#create_new_address option:selected').val() == 1) {
		$('#no_create_new_address_wrap').hide();
		$('#yes_create_new_address_wrap').show();
	    }

	}

	refreshNewAddressWrap();

	$('#create_new_address').change(function () {
    	refreshNewAddressWrap();
    });

    function refreshNewPhoneWrap() {

	    if ($('#create_new_phone option:selected').val() == 1) {
		$('#no_create_new_phone_wrap').hide();
		$('#yes_create_new_phone_wrap').show();
	    } else if ($('#create_new_phone option:selected').val() == 0) {
	        $('#no_create_new_phone_wrap').show();
	        $('#yes_create_new_phone_wrap').hide();
	    }
    }

	refreshNewPhoneWrap();

	$('#create_new_phone').change(function () {
    	refreshNewPhoneWrap();
    });	
</script> 
@endsection 