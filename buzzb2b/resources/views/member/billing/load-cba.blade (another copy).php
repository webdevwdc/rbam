@extends('member.layouts.base-2cols')
@section('content')
<div class="row">
	 <div class="col-md-12">
        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}	 
	    	<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
			    <li @if(in_array(Route::current()->getName(), array('billing'))) {{ "class=active" }} @endif>
			    	<a href="{{route('billing')}}">Dashboard</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('member-load-cba'))) {{ "class=active" }} @endif>
				     	<a href="{{route('member-load-cba')}}">Load CBA</a>
				</li>

			    <li @if(in_array(Route::current()->getName(), array(''))) {{ "class=active" }} @endif>
				     	<a href='{{route('member-payment-profile')}}'>Payment Profiles</a>
				</li>
			</ul>
	    </div>
</div>
<div>&nbsp;</div>
	
{!! Form::open(array('route'=>'member-load-cba-insert', 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
<div class="group_1">
								    
	<div class="row">
	<div class="col-md-8">
	
<!--	<div class="form-group">
		{{ Form::label('standby', 'Standby', ['class' => 'col-sm-4 control-label']) }}
		<div class="col-sm-6">
			{{ Form::select('standby',['0'=>'Active and ready to trade','1'=>'On Standby'],'',['class'=>'form-control required'])}}
		</div>
	</div>-->	
	<div class="form-group">
		<label class="col-sm-4 control-label">Payment Method</label>
		<div class="col-sm-6">
			{{ Form::select('payment_method',['credit_card'=>'Credit Card'],'',['class'=>'form-control required'])}}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label">Credit Card Number</label>
		<div class="col-sm-6">
			{{ Form::text('card_number', '', ['class' => 'form-control required', 'placeholder' => '']) }}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label">CVV Code</label>
		<div class="col-sm-6">
			{{ Form::text('cvv_code', '', ['class' => 'form-control required', 'placeholder' => '']) }}
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-4 control-label">Expiration Month</label>
		<div class="col-sm-6">
		     {{ Form::selectRange('expiration_month', 1, 12) }}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label">Expiration Year</label>
		<div class="col-sm-6">
		     {{ Form::selectRange('expiration_year', date('Y'), date('Y')+15) }}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label">First Name</label>
		<div class="col-sm-6">
			{{ Form::text('first_name', '', ['class' => 'form-control required', 'placeholder' => '']) }}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label">Last Name</label>
		<div class="col-sm-6">
			{{ Form::text('last_name', '', ['class' => 'form-control required', 'placeholder' => '']) }}
		</div>
	</div>
		@php
		   $isdefault = 0;
		@endphp
		@foreach($address as $adrs)
			@php
				$addressArr[$adrs->id] = $adrs->address1.', '.$adrs->address2.', '.$adrs->city.', '.$adrs->state->name.', '.$adrs->zip;
				if($adrs->is_default=='Yes'){
					$isdefault = $adrs->id;
				}
			@endphp
		@endforeach
			@php
				$addressArr['create_new'] = 'Create New Address';
			@endphp			

	<div class="form-group">
		<label class="col-sm-4 control-label">Billing Address</label>
		<div class="col-sm-6">
			{{ Form::select('billing_address',$addressArr,$isdefault,['id'=>'billing_address','class'=>'form-control required'])}}
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


	<div class="form-group">
		<label class="col-sm-4 control-label">Deposit Amount</label>
		<div class="col-sm-6">
			{{ Form::number('deposit_amount', '', ['class' => 'form-control required', 'placeholder' => '']) }}
		</div>
	</div>		

	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<div class="checkbox">
				<label>
					{{ Form::checkbox('terms_condition', 1, false, ['id' => 'terms_condition','class'=>'required']) }} I agree to the terms and conditions.
				</label>
			</div>
		</div>
	</div>
	
	</div>
	</div>
	    
	    
	<div class="row"></div>	
		{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
		<a href="{{ URL::route('admin_member') }}" class="btn btn-info pull-right">Back</a>
 </div>
{!! Form::close() !!}
<script>
	
	function refreshNewAddressWrap() {

		if ($('#billing_address option:selected').text() == "Create New Address") {
	    	$('#yes_create_new_address_wrap').show();
			} else {
			$('#yes_create_new_address_wrap').hide();
		}

	}

	refreshNewAddressWrap();
	
	$('#billing_address').change(function () {
		refreshNewAddressWrap();
	});	
	
</script>
@endsection