@extends('admin.layouts.base-2cols')
@section('title', 'Member User')
@section('content')
    
<div class="row">
    <div class="col-md-12">

        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> {{ Session::get('EXCHANGE_CITY_NAME') }} : Add Member User</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12">
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_member_user_store',$memberid], 'id'=>'', 'class'=>'form-validate_','method'=>'post')) !!}				
				<div class="group_1">
								    
					<div class="row">
						
<div class="col-md-8">						

<div class="form-group">
	{{ Form::label('email', 'Email', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
	<div class="col-sm-7 col-md-5 col-lg-4">
		{{ Form::email('email', null, ['class' => 'form-control']) }}
	</div>
</div>

<!-- input: firstname -->
<div class="form-group">
	{{ Form::label('firstname', 'First Name', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
	<div class="col-sm-5 col-md-4 col-lg-3">
		{{ Form::text('firstname', null, ['class' => 'form-control']) }}
	</div>
</div>

<!-- input: lastname -->
<div class="form-group">
	{{ Form::label('lastname', 'Last Name', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
	<div class="col-sm-5 col-md-4 col-lg-3">
		{{ Form::text('lastname', null, ['class' => 'form-control']) }}
	</div>
</div>

<!-- input: password -->
<div class="form-group">
	{{ Form::label('password', 'Password', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
	<div class="col-sm-5 col-md-4 col-lg-3">
		<input class="form-control" name="password" type="password" id="password">
	</div>
</div>

<!-- input: password_confirmation -->
<div class="form-group">
	{{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
	<div class="col-sm-5 col-md-4 col-lg-3">
		<input class="form-control" name="password_confirmation" type="password" id="password_confirmation">
	</div>
</div>
    
 	<!-- checkbox: admin -->
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9 col-md-offset-4 col-md-8">
			<div class="checkbox">
				<label>
				{{ Form::checkbox('admin', 1, false, ['id' => 'admin']) }} Make this user a member admin
				</label>
			</div>
		</div>
	</div>

	<!-- input: monthly_trade_limit -->
	<div class="form-group">
		{{ Form::label('monthly_trade_limit', 'Monthly Trade Limit', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-5 col-md-4 col-lg-3">
			<div class="input-group">
				<span class="input-group-addon">$</span>
				{{ Form::text('monthly_trade_limit', null, ['class' => 'form-control', 'placeholder' => 'optional']) }}
			</div>
		</div>
	</div>

	<!-- select: create_new_address -->
	<div class="form-group">
		{{ Form::label('create_new_address', 'Please Select', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-5 col-md-4 col-lg-3">
			{{ Form::select('create_new_address', [0 => 'Use Member Address', 1 => 'Create New Address'], null, ['class' => 'form-control']) }}
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
			<div class="col-sm-6 col-md-5 col-lg-4">
				{{ Form::text('address2', null, ['class' => 'form-control', 'placeholder' => 'optional']) }}
			</div>
		</div>
		
		<!-- input: city -->
		<div class="form-group">
			{{ Form::label('city', 'City', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-6 col-md-5 col-lg-4">
				{{ Form::text('city', null, ['class' => 'form-control']) }}
			</div>
		</div>
		<!-- select: state_id (ids) -->
		<div class="form-group">
			{{ Form::label('state_id', 'State', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-3 col-md-2 col-lg-3">
				{{ Form::select('state_id', $stateSelectionList, null, ['class' => 'form-control']) }}
			</div>
		</div>
		<!-- input: zip -->
		<div class="form-group">
			{{ Form::label('zip', 'Zip/Postal Code', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-3 col-md-2 col-lg-2">
				{{ Form::text('zip', null, ['class' => 'form-control']) }}
			</div>
		</div>	    

	</div>

	<div id="no_create_new_address_wrap">
		<div class="form-group">
			<label class="col-sm-3 col-md-4 col-lg-4 control-label"></label>
			<div class="col-sm-5 col-md-4 col-lg-3">
				@if($defaultAddress)
				{{ $defaultAddress->address1 }} {{ $defaultAddress->address2 }}<br/>
				{{ $defaultAddress->city }}, {{ $defaultAddress->state->name }}, {{ $defaultAddress->zip }}
				@endif
			</div>
		</div>
	</div>	    

	<!-- select: create_new_phone -->
	<div class="form-group">
		{{ Form::label('create_new_phone', 'Please Select', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-5 col-md-4 col-lg-3">
			{{ Form::select('create_new_phone', [0 => 'Use Member Phone', 1 => 'Create New Phone'], null, ['class' => 'form-control']) }}
		</div>
	</div>	    
	<div id="yes_create_new_phone_wrap">
		<div class="form-group">
			{{ Form::label('phone_type_id', 'Type', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-5 col-md-4 col-lg-3">
				{{ Form::select('phone_type_id', $phonetypeSelectionList, null, ['class' => 'form-control']) }}
			</div>
		</div>
		
		<!-- input: phone_number -->
		<div class="form-group">
			{{ Form::label('phone_number', 'Primary Contact Number', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
			<div class="col-sm-5 col-md-4 col-lg-3">
				{{ Form::text('phone_number', null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>    
	<div id="no_create_new_phone_wrap">
		<div class="form-group">
			<label class="col-sm-3 col-md-4 col-lg-4 control-label"></label>
			<div class="col-sm-5 col-md-4 col-lg-3">
				{{ $defaultPhone->number }}
			</div>
		</div>
	</div>

    
    </div>
</div>
    
 <div class="row"></div>
    

		
				    
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_member') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
    
<script>
	// function refreshPasswordFields() {

	// 	if( $('#generate_pw').is(':checked')) {
	// 		$('#password').prop('disabled', true);
	// 		$('#password').val('');
 //    		$('#password_confirmation').prop('disabled', true);
	// 		$('#password_confirmation').val('');
	// 	} else {
	// 		$('#password').prop('disabled', false);
 //    		$('#password_confirmation').prop('disabled', false);
	// 	}

	// }

	// refreshPasswordFields();

	// $('#generate_pw').click(function() {
	// 	refreshPasswordFields();
	// });
	
	$(document).ready(function() {
	   $("#phone_number").mask("(999) 999-9999");
	});
	
	function refreshNewAddressWrap() {

		if ($('#create_new_address option:selected').text() == "Create New Address") {
	    	$('#no_create_new_address_wrap').hide();
	    	$('#yes_create_new_address_wrap').show();
	    } else if ($('#create_new_address option:selected').text() == "Use Member Address") {
	        $('#no_create_new_address_wrap').show();
	        $('#yes_create_new_address_wrap').hide();
		}

	}

	refreshNewAddressWrap();

	$('#create_new_address').change(function () {
    	refreshNewAddressWrap();
    });

    function refreshNewPhoneWrap() {

		if ($('#create_new_phone option:selected').text() == "Create New Phone") {
	    	$('#no_create_new_phone_wrap').hide();
	    	$('#yes_create_new_phone_wrap').show();
	    } else if ($('#create_new_phone option:selected').text() == "Use Member Phone") {
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