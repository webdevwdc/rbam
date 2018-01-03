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
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_edit',$details->id) }}">Details</a></li>       
								<li role="presentation" class="active"><a href="{{ URL::route('admin_user_image',$details->id) }}">Profile</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_member_associations_edit',$details->id) }}">Member Associations</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_exchange_associations_edit',$details->id) }}">Exchange Associations</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_address_edit',$details->id) }}">Addresses</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_phone_edit',$details->id) }}">Phones</a></li>
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
										{!! Form::open(array('route'=>array('admin_user_image',$details->id),'method'=>'post','id'=>'updateImage', 'class'=>"form-horizontal", 'files'=>'true','runat'=>'server')) !!}
											{{Form::hidden('action','ProcessImage')}}
										
											<!-- input: file -->
											<div class="col-xs-12" style="margin:20px;">
												<p><strong>User Avatar</strong></p>
												<div style="text-align: left;">
													@if($details->image != '' && file_exists(public_path('upload/user_image/thumb/'.$details->image)))
														<img src="{{ asset('upload/user_image/thumb/'.$details->image) }}" height="150" width="175" id="blah">
													@else
														<img src="{{ asset('images/man.png') }}" class="img-rounded img-responsive" id="blah">
													@endif
													<input type="hidden" name="old_image" value="{{ $details->image }}">
													<div id="errordiv" style="color:red;"></div>
													<div style="margin-top: 10px;">
														<input type="file" name="image" id="imgInp">
														<script>
															function readURL(input) {
																if (input.files && input.files[0]) {
																	var reader = new FileReader();
																	reader.onload = function (e) {
																		$('#blah').attr('src', e.target.result);
																	}
																	reader.readAsDataURL(input.files[0]);
																}
															}
															$("#imgInp").change(function(){
																var fileExtension = ['jpeg','jpg','png'];
																if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
																	$('#errordiv').html("Only formats are allowed : "+fileExtension.join(', '));
																	return false;
																}
																else{
																	$('#errordiv').html('');
																	readURL(this);	
																}
															});
														</script>
													</div>
												</div>
											</div>
											
											<input class="btn btn-info pull-left green" value="Upload" type="submit">
											<a class="btn btn-info pull-left" href="{{ URL::route('admin_user')}}">Cancel</a>
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
@endsection 