@extends('admin.layouts.base-2cols')
@section('title', 'Exchange Edit')
@section('content')
<div class="row">
	<div class="col-xs-12" style="margin-bottom: 20px;">
		<ul class="nav nav-pills sub-pills exchange-users-edit-sub-pills">
			<li role="presentation" class="active"><a href="{{ URL::route('admin_user_edit',$details->id) }}">Details</a></li>
			<li role="presentation" class=""><a href="#">Profile</a></li>
			<li role="presentation" class=""><a href="#">Member Associations</a></li>
			<li role="presentation" class=""><a href="#">Exchange Associations</a></li>
			<li role="presentation" class=""><a href="{{ URL::route('admin_user_address_edit',$details->id) }}">Addresses</a></li>
			<li role="presentation" class=""><a href="{{ URL::route('admin_user_phone_edit',$details->id) }}">Phones</a></li>
		</ul>
	</div>
	<div class="col-xs-12" style="padding:0px 20px;">
		<div class="row scorecard">
			<div class="row">
				<div class="col-xs-12">
					<form method="POST" action="http://exchange.dedicatedresource.net/user/2489/details" accept-charset="UTF-8" class="form-horizontal"><input name="_token" value="8ZvqNgTQVDpBa03J6XYpNTI88EBKpfjrqSg5kw1p" type="hidden">
					
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
								<input class="form-control" name="firstname" value="{{ $details->first_name }}" id="firstname" type="text">
							</div>
						</div>
					
						<!-- input: lastname -->
						<div class="form-group">
							<label for="lastname" class="col-sm-3 col-md-4 col-lg-4 control-label">Last Name</label>
							<div class="col-sm-9 col-md-6 col-lg-5">
								<input class="form-control" name="lastname" value="{{ $details->last_name }}" id="lastname" type="text">
							</div>
						</div>
					</form>
				</div> <!-- .col-xs-12 -->
			</div> <!-- .row -->
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-sm-offset-2 col-md-4 col-md-offset-2 col-lg-4 col-lg-offset-2" style="margin-top: 20px;">
					<a href="{{ URL::route('admin_user') }}" class="btn btn-default btn-block">Back to Users</a>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<input class="col-xs-12 col-sm-4 col-md-4 col-lg-4 btn btn-success btn-block" style="margin-top: 20px;" value="Save" type="submit">
				</div>
			</div> <!-- .row -->
		</div>
	</div>
</div>    
@endsection 