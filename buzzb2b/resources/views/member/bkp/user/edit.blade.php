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
								<li role="presentation" class="active"><a href="{{ URL::route('admin_user_edit',$details->id) }}">Details</a></li>       
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_image',$details->id) }}">Profile</a></li>
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
										{!! Form::open(array('route'=>array('admin_user_edit',$details->id),'method'=>'post','id'=>'updateForm', 'class'=>"form-horizontal")) !!}
											{{Form::hidden('action','ProcessUser')}}
										
											<!-- input: email -->
											<div class="form-group">
												<label for="email" class="col-sm-3 col-md-4 col-lg-4 control-label">Email</label>
												<div class="col-sm-9 col-md-6 col-lg-5">
													<input class="form-control" name="email" value="{{ $details->email }}" id="email" type="email">
												</div>
											</div>
										
											<!-- input: firstname -->
											<div class="form-group">
												<label for="firstname" class="col-sm-3 col-md-4 col-lg-4 control-label">First Name</label>
												<div class="col-sm-9 col-md-6 col-lg-5">
													<input class="form-control" name="first_name" value="{{ $details->first_name }}" id="firstname" type="text">
												</div>
											</div>
										
											<!-- input: lastname -->
											<div class="form-group">
												<label for="lastname" class="col-sm-3 col-md-4 col-lg-4 control-label">Last Name</label>
												<div class="col-sm-9 col-md-6 col-lg-5">
													<input class="form-control" name="last_name" value="{{ $details->last_name }}" id="lastname" type="text">
												</div>
											</div>
											<input class="btn btn-info pull-right green" value="Save" type="submit">
											<a class="btn btn-info pull-right" href="{{ URL::route('admin_user')}}">Back</a>
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