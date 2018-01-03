@extends('admin.layouts.base-2cols')
@section('title', 'User Add')
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
						<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : User</h3>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-12 col-xs-12">
					{!! Form::open(array('route'=>['admin_user_store'], 'id'=>'', 'class'=>'form-validate_','method'=>'post')) !!}				
						<div class="group_1">
							<div class="col-xs-12">
								<!-- input: email -->
								<div class="form-group">
									<label for="email" class="col-sm-3 col-md-4 col-lg-4 control-label">
									  Email<span class="requiredFileds">*</span></label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										{{ Form::email('email',null, array('class' => 'form-control','placeholder'=>'Email')) }}
									</div>
								</div>
							
								<!-- input: firstname -->
								<div class="form-group">
									<label for="firstname" class="col-sm-3 col-md-4 col-lg-4 control-label">First Name<span class="requiredFileds">*</span></label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										{{ Form::text('first_name',null, array('class' => 'form-control','placeholder'=>'First Name')) }}
									</div>
								</div>
							
								<!-- input: lastname -->
								<div class="form-group">
									<label for="lastname" class="col-sm-3 col-md-4 col-lg-4 control-label">Last Name<span class="requiredFileds">*</span></label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										{{ Form::text('last_name',null, array('class' => 'form-control','placeholder'=>'Last Name')) }}
									</div>
								</div>
							
								<!-- checkbox: generate_pw -->
								
							
								<!-- input: password -->
								<div class="form-group">
									<label for="password" class="col-sm-3 col-md-4 col-lg-4 control-label">Password<span class="requiredFileds">*</span></label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										
										{{ Form::password('password',null, array('class' => 'form-control','placeholder'=>'Password')) }}
									</div>
								</div>
							
								<!-- input: password_confirmation -->
								<div class="form-group">
									<label for="password_confirmation" class="col-sm-3 col-md-4 col-lg-4 control-label">Confirm Password<span class="requiredFileds">*</span></label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										<input class="form-control" name="password_confirmation" id="password_confirmation" type="password">
									</div>
								</div>
							
								
							
								<!-- input: address1 -->
								<div class="form-group">
									<label for="address1" class="col-sm-3 col-md-4 col-lg-4 control-label">Street Address <span class="requiredFileds">*</span></label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										{{ Form::text('address1',null, array('class' => 'form-control','placeholder'=>'Street Address')) }}
									</div>
								</div>
							
								<!-- input: address2 -->
								<div class="form-group">
									<label for="address2" class="col-sm-3 col-md-4 col-lg-4 control-label">Suite / Unit</label>
									<div class="col-sm-6 col-md-5 col-lg-4">
										{{ Form::text('address2',null, array('class' => 'form-control','placeholder'=>'Suite / Unit')) }}
									</div>
								</div>
							
								<!-- input: city -->
								<div class="form-group">
									<label for="city" class="col-sm-3 col-md-4 col-lg-4 control-label">City</label>
									<div class="col-sm-6 col-md-5 col-lg-4">
										
										{{ Form::text('city',null, array('class' => 'form-control','placeholder'=>'City')) }}
									</div>
								</div>
							
								<!-- select: state_id (ids) -->
								<div class="form-group">
									<label for="state_id" class="col-sm-3 col-md-4 col-lg-4 control-label">State <span class="requiredFileds">*</span></label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										{!! Form::select('state_id',$state,'',['class'=>'form-control','id'=>'state_id']) !!}
									</div>
								</div>
							
							
								<!-- input: zip -->
								<div class="form-group">
									<label for="zip" class="col-sm-3 col-md-4 col-lg-4 control-label">Zip/Postal Code<span class="requiredFileds">*</span></label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										{{Form::text('zip',null,['class'=>'form-control','id'=>'zip'])}}
									</div>
								</div>
							
							
							
								<!-- select: phone type -->
								<div class="form-group">
									<label for="phone_type_id" class="col-sm-3 col-md-4 col-lg-4 control-label">Type</label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										{!! Form::select('phone_type_id',$phonetype,'',['class'=>'form-control','id'=>'phone_type_id']) !!}
									</div>
								</div>
							
								<!-- input: phone_number -->
								<input type="hidden" id="phone_number" name="phone_number" value="">
								<div class="form-group">
									<label for="phone_number" class="col-sm-3 col-md-4 col-lg-4 control-label">Primary Contact Number</label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										<input class="form-control" name="display_phone_number" id="display_phone_number" autocomplete="off" type="text">
									</div>
								</div>							
							
								<!-- checkbox: email_user_after (defaults to unchecked) -->
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-8">
										<div class="checkbox">
											<label>
												<input id="email_user_after" name="email_user_after" value="1" type="checkbox"> Notify this user by email
											</label>
										</div>
									</div>
								</div>

								<!-- <div class="form-group">
									<div class="col-sm-offset-4 col-sm-8">
										<div class="checkbox">
											<label>
												<input id="email_user_after" name="is_admin" value="1" type="checkbox"> Make Admin to this user
											</label>
										</div>
									</div>
								</div> -->
							</div>
						

							{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
							<a href="{{ URL::route('admin_user') }}" class="btn btn-info pull-right">Back</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

<input type="text" name="number" style="display: none;">

<script>

$("input[name='display_phone_number']").on("keyup", function(){
		$("input[name='number']").val(destroyMask(this.value));
	    this.value = createMask($("input[name='number']").val());

	    $('#phone_number').val(destroyMask(this.value));
	})

	function createMask(string){
	  	// console.log(string)
		return string.replace(/(\d{3})(\d{3})(\d{4})/,"($1)-$2-$3");
	}

	function destroyMask(string){
	  // console.log(string)
		return string.replace(/\D/g,'').substring(0, 10);
	}

</script>
@endsection 