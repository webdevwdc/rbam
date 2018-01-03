@extends('admin.layouts.base-2cols')
@section('title', 'Edit : User')
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
						<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> User</h3>
					</div>
				</div>
			</div>
			
			<div class="panel-body">
				<div class="col-md-12 col-xs-12">
					<div class="row">
						<div class="col-md-12"><!-- password_confirmation text field -->
							<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_edit',$phoneable_id) }}">Details</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_image',$phoneable_id) }}">Profile</a></li>
								<li role="presentation" class=""><a href="#">Member Associations</a></li>
								<li role="presentation" class=""><a href="#">Exchange Associations</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_address_edit',$phoneable_id) }}">Addresses</a></li>
								<li role="presentation" class="active"><a href="{{ URL::route('admin_user_phone_edit',$phoneable_id) }}">Phones</a></li>
							</ul>						
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-lg-10 col-md-9 col-sm-9" style="padding:20px;"></div>
					<div class="col-lg-2 col-md-3 col-sm-3"></div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="col-xs-12" style="padding:0px 20px;">
							<div class="row scorecard">
								<div class="row">
									<div class="col-xs-12">
										{!! Form::open(array('route'=>array('admin_user_phone_update', $phoneable_id),'method'=>'post','id'=>'updatePhoneForm', 'class' => "form-horizontal")) !!}
											{{Form::hidden('action','ProcessPhone')}}
				
											<!-- select: phone type -->
											<div class="form-group">
												<label for="phone_type_id" class="col-sm-3 col-md-4 col-lg-4 control-label">Type</label>
												<div class="col-sm-5 col-md-4 col-lg-3">
													{!! Form::select('phone_type_id',$phonetype,'',['class'=>'form-control','id'=>'phone_type_id']) !!}
												</div>
											</div>
				
											<!-- input: phone_number -->
											<input type="hidden" id="phone_number" name="phone_number" value="">

											<div class="form-group">
												<label for="phone_number" class="col-sm-3 col-md-4 col-lg-4 control-label">Primary Contact Number</label>
												<div class="col-sm-5 col-md-4 col-lg-3">
													<input class="form-control" name="display_phone_number" id="display_phone_number" autocomplete="off" type="text">
												</div>
											</div>
				
				
											<!-- checkbox: primary -->
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9 col-md-offset-4 col-md-8">
													<div class="checkbox">
														<label>
															<input id="primary" name="primary" value="1" type="checkbox"> User's primary phone
														</label>
													</div>
												</div>
											</div>
											<input class="btn btn-info pull-right green" value="Save" type="submit">
											<a class="btn btn-info pull-right" href="{{ URL::route('admin_user_phone_edit',$phoneable_id)}}">Back</a>
										{!! Form::close() !!}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<input id="number" name="number" value="" style="display: none;">

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