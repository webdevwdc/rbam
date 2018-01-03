@extends('user_member.member.layouts.base-2cols')
@section('title', 'Load Cba')
@section('content')
<style type="text/css">
 .balance{
 	font-size: 18px;
    color: black;
 }
 .referral{
 	margin: 0 0 10px;
    font-size: 24px;
    font-weight: 600;
 }
 .new-address{
 	display: none;
 }
</style>
<div class="row">
	 <div class="col-md-12">
	    	<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
			    <li @if(in_array(Route::current()->getName(), array('billing'))) {{ "class=active" }} @endif>
			    	<a href="{{route('billing')}}">Dashboard</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('load-cba'))) {{ "class=active" }} @endif>
				     	<a href="{{route('load-cba')}}">Load CBA</a>
				</li>

			    <li @if(in_array(Route::current()->getName(), array(''))) {{ "class=active" }} @endif>
				     	<a href='#'>Payment Profiles</a>
				</li>
			</ul>
	    </div>
	    <!-- main section start -->
	    <div class="col-xs-11" style="margin-bottom:30px;">
			<h5 class="text-center">Deposit funds into your Cash Barter Account (CBA) in order to make future barter transactions. Complete the form below and your payment method will be charged and saved.</h5>
		</div>
	<div class="col-md-12 col-xs-12">
	{!! Form::open(array('route'=>['save_users_create'],'id'=>'','class'=>'form-validate_','method'=>'post'))!!}
	<div class="group_1">
									    
		<div class="row">
								
			<div class="col-md-8">						

				<div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Payment Method</label>
					<div class="col-sm-7 col-md-5 col-lg-4">
						<select name="payment_type">
							<option value="1">Credit Card</option>
						</select>
					</div>
				</div>

				<!-- input: firstname -->
				<div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Credit Card Number</label>
					<div class="col-sm-5 col-md-4 col-lg-4">
						{{ Form::text('cc_number', null, ['class' => 'form-control']) }}
					</div>
				</div>

				<!-- input: lastname -->
				<div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>CVV Code</label>
					<div class="col-sm-5 col-md-4 col-lg-4">
						{{ Form::text('cc_cvv', null, ['class' => 'form-control']) }}
					</div>
				</div>
				<div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Expiration Month</label>
					<div class="col-sm-5 col-md-4 col-lg-4">
						<!-- {{ Form::select('number', [1=>'01', 2=>'02', 3=>'03',4=>'04', 5=>'05', 6=>'06'], null, ['class' => 'field']) }} -->
			          <select name="cc_exp_month">
			            @for($val=01;$val<=12;$val++)
							<option value="{{$val}}">{{$val}}</option>
			            @endfor
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Expiration Year</label>
					<div class="col-sm-5 col-md-4 col-lg-4">
			          <select name="cc_exp_year">
			            @for($val=2016;$val<=2030;$val++)
							<option value="{{$val}}">{{$val}}</option>
			            @endfor
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>First Name</label>
					<div class="col-sm-5 col-md-4 col-lg-4">
			        {{Form::text('first_name',null,['class' => 'form-control'])}}
					</div>
				</div>

				<div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Last Name</label>
					<div class="col-sm-5 col-md-4 col-lg-4">
			        {{Form::text('last_name',null,['class' => 'form-control'])}}
					</div>
				</div>

				<div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Billing Addreess</label>
					<div class="col-sm-7 col-md-5 col-lg-4">
						<select name="address_id" onchange="Address();">
						    @if(!empty($address))
							<option class="default_address" value="1">{{$address->address1}}</option>
							@endif
							<option class="default_address" value="2">Create New Address</option>
						</select>
					</div>
				</div>

				<!-- create new address when the default address is not available -->
				<div class="new-address">
					<div class="form-group">
						<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Street Address</label>
						<div class="col-sm-7 col-md-5 col-lg-4">
							{{Form::text('address1',null,['class'=>'form-control'])}}
						</div>
					</div>

					<div class="form-group">
						<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Suite / Unit</label>
						<div class="col-sm-7 col-md-5 col-lg-4">
							{{Form::text('address2',null,['class'=>'form-control'])}}
						</div>
				    </div>

				    <div class="form-group">
						<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>City</label>
						<div class="col-sm-7 col-md-5 col-lg-4">
							{{Form::text('city',null,['class'=>'form-control'])}}
						</div>
				    </div>

				    <div class="form-group">
						<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>State</label>
						<div class="col-sm-7 col-md-5 col-lg-4">
							{{Form::select('state_id',[1,2,3],null,['class'=>'form-control'])}}
						</div>
				    </div>

				    <div class="form-group">
						<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Zip/Postal Code</label>
						<div class="col-sm-7 col-md-5 col-lg-4">
						   {{Form::text('zip',null,['class'=>'form-control'])}}	
						</div>
				    </div>


				</div>
				<!-- end new address -->

				<div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>Deposit Amount</label>
					<div class="col-sm-7 col-md-5 col-lg-4">
						{{Form::text('deposit_amount',null,['class'=>'form-control'])}}
					</div>
				</div>
                <div class="form-group">
					<label class ='col-sm-3 col-md-4 col-lg-4 control-label'>
					  I agree to the terms and conditions.
					</label>
					<div class="col-sm-7 col-md-5 col-lg-4">
                      {{ Form::checkbox('agree_terms') }} 
                </div>
				</div>
			     <div class="visa">
			       <img src="{{asset('/upload/visa_mastercard_logo.png')}}" style="width: 140px;margin-left: 267px;">
		          </div>
			</div>
		</div>
		   
		    
		 <div class="row"></div>
						    
		{!! Form::Button('Save', array("class"=>"btn btn-info pull-right green")) !!}
		{!! Form::close() !!}
	</div>
	    
	</div>
</div>
<!-- address change  -->
<script type="text/javascript">
	function Address(){
		var val = $('.default_address:selected').val();
		if(val==2){
          $('.new-address').css("display", "block");
		}else{
           $('.new-address').css("display", "none");
		}
	}
</script>
@endsection