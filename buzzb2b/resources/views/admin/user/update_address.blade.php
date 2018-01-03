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
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_edit',$addressable_id) }}">Details</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_image',$addressable_id) }}">Profile</a></li>
								<li role="presentation" class=""><a href="#">Member Associations</a></li>
								<li role="presentation" class=""><a href="#">Exchange Associations</a></li>
								<li role="presentation" class="active"><a href="{{ URL::route('admin_user_address_edit',$addressable_id) }}">Addresses</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_phone_edit',$addressable_id) }}">Phones</a></li>
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
										{!! Form::open(array('route'=>array('admin_user_address_update', $addressable_id),'method'=>'post', 'id'=>'updateAddressForm','class' => "form-horizontal")) !!}
											{{Form::hidden('action','ProcessAddress')}}
											<!-- input: address1 -->
											<div class="form-group">
												<label for="address1" class="col-sm-3 col-md-4 col-lg-4 control-label">Street Address</label>
												<div class="col-sm-9 col-md-6 col-lg-5">
													<input class="form-control" name="address1" id="address1" type="text">
												</div>
											</div>
									
											<!-- input: address2 -->
											<div class="form-group">
												<label for="address2" class="col-sm-3 col-md-4 col-lg-4 control-label">Suite / Unit</label>
												<div class="col-sm-6 col-md-5 col-lg-4">
													<input class="form-control" placeholder="optional" name="address2" id="address2" type="text">
												</div>
											</div>
									
											<!-- input: city -->
											<div class="form-group">
												<label for="city" class="col-sm-3 col-md-4 col-lg-4 control-label">City</label>
												<div class="col-sm-6 col-md-5 col-lg-4">
													<input class="form-control" name="city" id="city" type="text">
												</div>
											</div>
									
											<!-- select: state_id (ids) -->
											<div class="form-group">
												<label for="state_id" class="col-sm-3 col-md-4 col-lg-4 control-label">State</label>
												<div class="col-sm-3 col-md-2 col-lg-2">
													{!! Form::select('state_id',$state,'',['class'=>'form-control','id'=>'state_id']) !!}
												</div>
											</div>
									
											<!-- input: zip -->
											<div class="form-group">
												<label for="zip" class="col-sm-3 col-md-4 col-lg-4 control-label">Zip/Postal Code</label>
												<div class="col-sm-3 col-md-2 col-lg-2">
													<input class="form-control" name="zip" id="zip" type="text">
												</div>
											</div>
									
											<!-- checkbox: default_address -->
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9 col-md-offset-4 col-md-8">
													<div class="checkbox">
														<label>
															<input id="default_address" name="default_address" value="1" type="checkbox"> User's default address
														</label>
													</div>
												</div>
											</div>
											<input class="btn btn-info pull-right green" value="Save" type="submit">
											<a class="btn btn-info pull-right" href="{{ URL::route('admin_user_address_edit',$addressable_id)}}">Back</a>
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