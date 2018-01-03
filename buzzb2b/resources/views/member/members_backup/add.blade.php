@extends('admin.layouts.base-2cols')
@section('title', 'Member Add')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> {{ Session::get('EXCHANGE_CITY_NAME') }} : Member</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
			<!--<h4>Exchange Details</h4>-->
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_member_store'], 'id'=>'', 'class'=>'form-validate_','method'=>'post')) !!}				
				<div class="group_1">
								    
					<div class="row">
						
<div class="col-md-8">						
<!-- input: name -->
<div class="form-group">
	{{ Form::label('name', 'Name', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-6">
		{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'required']) }}
	</div>
</div>

<!-- input: business 1099 name (leave blank if same as name) -->
<div class="form-group">
	{{ Form::label('business_1099_name', 'Business 1099 Name', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-6">
		{{ Form::text('business_1099_name', null, ['class' => 'form-control', 'placeholder' => 'required']) }}
	</div>
</div>

<!-- input: tax_id_number -->
<div class="form-group">
	{{ Form::label('tax_id_number', 'Tax ID Number', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-6">
		{{ Form::text('tax_id_number', null, ['class' => 'form-control', 'placeholder' => 'required']) }}
	</div>
</div>

<!-- input: website -->
<div class="form-group">
	{{ Form::label('website', 'Website', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-6">
		{{ Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'optional']) }}
	</div>
</div>

<!-- checkbox: is_prospect -->
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<div class="checkbox">
			<label>
				{{ Form::checkbox('is_prospect', 1, false, ['id' => 'is_prospect']) }} This member is a prospect
			</label>
		</div>
	</div>
</div>

<!-- checkbox: is_active_salesperson -->
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<div class="checkbox">
			<label>
				{{ Form::checkbox('is_active_salesperson', 1, false, ['id' => 'is_active_salesperson']) }} This member is a salesperson
			</label>
		</div>
	</div>
</div>
   
</div>
</div>
    
<div class="row">
	<div class="col-md-12">
		<h4>Financial</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
    <!-- input: ex_purchase_comm_rate (defaults to exchange default) -->
    <div class="form-group">
	    {{ Form::label('ex_purchase_comm_rate', 'Barter Purchase Fee', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('ex_purchase_comm_rate', 10, ['class' => 'form-control']) }}
		    </div>
	    </div>
    </div>
    
    <!-- input: ex_sale_comm_rate (defaults to exchange default) -->
    <div class="form-group">
	    {{ Form::label('ex_sale_comm_rate', 'Barter Sale Fee', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('ex_sale_comm_rate', 0, ['class' => 'form-control']) }}
		    </div>
	    </div>
    </div>
    
    <!-- input: credit_limit (defaults to 0) -->
    <div class="form-group">
	    {{ Form::label('credit_limit', 'Beginning Credit Limit', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">$</span>
			    {{ Form::text('credit_limit', null, ['class' => 'form-control', 'placeholder' => 'optional']) }}
		    </div>
	    </div>
    </div>    
    </div>
</div>


<div class="row">
	<div class="col-md-12">
		<h4>Member Referral</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
    <!-- select: ref_member_id from this exchange (defaults to none) -->
    <div class="form-group">
	    {{ Form::label('ref_member_id', 'Referring Member', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-6">
		    {{ Form::select('ref_member_id',  $refsSelectionList, null, ['class' => 'form-control']) }}
	    </div>
    </div>
    
    <!-- input: ref_purchase_comm_rate (defaults to exchange default) -->
    <div class="form-group">
	    {{ Form::label('ref_purchase_comm_rate', 'Referred Purchase Commission', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('ref_purchase_comm_rate', 20, ['class' => 'form-control']) }}
		    </div>
	    </div>
    </div>
    
    <!-- input: ref_sale_comm_rate (defaults to exchange default) -->
    <div class="form-group">
	    {{ Form::label('ref_sale_comm_rate', 'Referred Sale Commission', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('ref_sale_comm_rate', 0, ['class' => 'form-control']) }}
		    </div>
	    </div>
    </div>    
    </div>
</div>						
					

<div class="row">
	<div class="col-md-12">
		<h4>Exchange Salesperson Member</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
	<!-- select: salesperson_member_id from this exchange (defaults to none) -->
	<div class="form-group">
		{{ Form::label('salesperson_member_id', 'Salesperson Member', ['class' => 'col-sm-4 control-label']) }}
		<div class="col-sm-6">
			{{ Form::select('salesperson_member_id', $salespersonSelectionList, null, ['class' => 'form-control']) }}
		</div>
	</div>
	
	<!-- input: sales_purchase_comm_rate (defaults to exchange default) -->
	<div class="form-group">
		{{ Form::label('sales_purchase_comm_rate', 'Salesperson Purchase Commission', ['class' => 'col-sm-4 control-label']) }}
		<div class="col-sm-3 col-md-3">
			<div class="input-group">
				<span class="input-group-addon">%</span>
				{{ Form::text('sales_purchase_comm_rate', 0, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>
	
	<!-- input: sales_sale_comm_rate (defaults to exchange default) -->
	<div class="form-group">
		{{ Form::label('sales_sale_comm_rate', 'Salesperson Sale Commission', ['class' => 'col-sm-4 control-label']) }}
		<div class="col-sm-3 col-md-3">
			<div class="input-group">
				<span class="input-group-addon">%</span>
				{{ Form::text('sales_sale_comm_rate', 0, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>    
    </div>
</div>				
				

<div class="row">
	<div class="col-md-12">
		<h4>Exchange Giftcards</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
	    <!-- checkbox: will_accept_gcs -->
	    <div class="form-group">
		    <div class="col-sm-offset-4 col-sm-8">
			    <div class="checkbox">
				    <label>
					    {{ Form::checkbox('will_accept_gcs', 1, true, ['id' => 'will_accept_gcs']) }} This member will accept giftcards
				    </label>
			    </div>
		    </div>
	    </div>
	    
	    <!-- input: giftcard_comm_rate (defaults to exchange default) -->
	    <div class="form-group">
		    {{ Form::label('giftcard_comm_rate', 'Giftcard Sale Commission Rate', ['class' => 'col-sm-4 control-label']) }}
		    <div class="col-sm-3 col-md-3">
			    <div class="input-group">
				    <span class="input-group-addon">%</span>
				    {{ Form::text('giftcard_comm_rate', 10, ['class' => 'form-control']) }}
			    </div>
		    </div>
	    </div>    
    </div>
</div>
    
<div class="row">
	<div class="col-md-12">
		<h4>Administrator Info</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
	<!-- select: create_new_user -->
	<div class="form-group">
		{{ Form::label('create_new_user', 'Please Select', ['class' => 'col-sm-4 control-label']) }}
		<div class="col-sm-5">
			{{ Form::select('create_new_user', [1 => 'Create New User', 0 => 'Select Existing User By Email'], null, ['class' => 'form-control']) }}
		</div>
	</div>
	
	<div class="form-group">
		{{ Form::label('email', 'User Email', ['class' => 'col-sm-4 control-label']) }}
		<div class="col-sm-6">
			{{ Form::email('email', null, ['class' => 'form-control']) }}
		</div>
	</div>

	
	<div id="no_create_new_user_wrap">
	
		<!-- input: lookup_email -->
<!--		<div class="form-group">
			{{ Form::label('email', 'User Email', ['class' => 'col-sm-4 control-label']) }}
			<div class="col-sm-6">
				{{ Form::email('email', null, ['class' => 'form-control']) }}
			</div>
		</div>-->
	</div>
	  
	<div id="yes_create_new_user_wrap">

	<!-- input: email -->
<!--	<div class="form-group">
		{{ Form::label('email', 'Email', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
		<div class="col-sm-7 col-md-5 col-lg-4">
			{{ Form::email('email', null, ['class' => 'form-control']) }}
		</div>
	</div>
-->	
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
	
	<!-- checkbox: generate_pw -->
<!-- 	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9 col-md-offset-4 col-md-8">
			<div class="checkbox">
				<label>
				{{ Form::checkbox('generate_pw', 1, true, ['id' => 'generate_pw']) }} Generate random password and email to user
				</label>
			</div>
		</div>
	</div> -->
	
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

	</div>
	    
	    
	<!-- input: address1 -->
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
	<!-- select: phone type -->
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
	
	<script>
	$(document).ready(function() {
	//   $("#phone_number").mask("(999) 999-9999");
	});
	</script>	    
    
	<!-- input: description -->
	<div class="form-group">
		{{ Form::label('description', 'Short Description', ['class' => 'col-sm-4 control-label']) }}
		<div class="col-sm-6">
			{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4']) }}
		</div>
	</div>
	
	<!-- checkbox: view_on_dir (defaults to unchecked) -->
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<div class="checkbox">
				<label>
					{{ Form::checkbox('view_on_dir', 1, false, ['id' => 'view_on_dir']) }} View this member on the directory
				</label>
			</div>
		</div>
	</div>
    
    </div>
</div>
    
 <div class="row"></div>
    
<!--<div class="row">
	<div class="col-md-12">
		<h4>Financial</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
    </div>
</div>-->
		
				    
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
    
		   //  if( $('#generate_pw').is(':checked')) {
			  //   $('#password').prop('disabled', true);
			  //   $('#password').val('');
		   //  $('#password_confirmation').prop('disabled', true);
			  //   $('#password_confirmation').val('');
		   //  } else {
			  //   $('#password').prop('disabled', false);
		   //  $('#password_confirmation').prop('disabled', false);
		   //  }
    
	    // }
    
	    // refreshPasswordFields();
    
	    // $('#generate_pw').click(function() {
		   //  refreshPasswordFields();
	    // });
		
	$(document).ready(function(){
	
                if ($('#create_new_user option:selected').text() == "Create New User") {
		    $('#yes_create_new_user_wrap').show();
		    $('#no_create_new_user_wrap').hide();
		}else{
		    $('#yes_create_new_user_wrap').hide();
		    $('#no_create_new_user_wrap').show();
		}
		
		$('#create_new_user').change(function () {
			if ($('#create_new_user option:selected').text() == "Create New User") {
				$('#no_create_new_user_wrap').hide();
				$('#yes_create_new_user_wrap').show();
			} else if ($('#create_new_user option:selected').text() == "Select Existing User By Email") {
				$('#no_create_new_user_wrap').show();
				$('#yes_create_new_user_wrap').hide();
			}
		});
	});
</script>
    
@endsection 