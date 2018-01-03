@extends('user_member.member.layouts.base-2cols')
@section('title', 'Load Cba')
@section('content')
<div class="row">
	 <div class="col-md-12">
        {{-- messages section start--}}
        @include('member.includes.messages')
	{{-- messages section end--}}	 
	    	<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
			    <li @if(in_array(Route::current()->getName(), array('member-billing'))) {{ "class=active" }} @endif>
			    	<a href="{{route('billing')}}">Dashboard</a>
			    </li>

			    <li class="active">
				     	<a href="{{route('load-cba')}}">Load CBA</a>
				</li>

			    <li>
				     	<a href="{{ route('payment-profile') }}">Payment Profiles</a>
				</li>
			</ul>
	    </div>
</div>
<div>&nbsp;</div>
<div class="row">
	<div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
	<div class="col-lg-2 col-md-3 col-sm-3">
		<a href="{{route('payment-profile-add')}}" class="btn btn-info" title="Add New"><i class="fa fa-plus"></i> Add New</a>
	</div>
</div>
@if($cardlist)
	
	
{!! Form::open(array('route'=>'load-cba-redirect', 'id'=>'paymentForm', 'class'=>'form-validate','method'=>'get')) !!}

<div class="group_1">
								    
	<div class="row">
	<div class="col-md-8">
		

	<div class="form-group">
		<label class="col-sm-4 control-label">Select Billing Profile</label>
		<div class="col-sm-6">
			{{ Form::select('profile',$cardlist,'',['id'=>'profile','class'=>'form-control required'])}}
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
		{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green","id"=>'submit_load')) !!}
		<a href="{{ route('billing') }}" class="btn btn-info pull-right">Back</a>
 </div>
{!! Form::close() !!}
@endif
	
@endsection

@section('footer_scripts')
	<script>
	$(document).ready(function(){
		$("#paymentForm").submit(function(e) { 
			if ($(this).valid()) {
				if(confirm('You are about to submit a payment. Are you sure you want to do this?')){
					return true;
				}else{
					return false;
				}
			}
		});
		

	})
	</script>
@endsection