@extends('member.layouts.base-2cols')
@section('title', 'Add Referral')
@section('content')
    
<div class="row">
    <div class="col-md-12">

        {{-- messages section start--}}
        @include('member.includes.messages')
		{{-- messages section end--}}
	
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-12">
						<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : Referrals</h3>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-12 col-xs-12">
				
				    <div class="row">
						<div class="col-md-12">
							<h4>Refer someone</h4>
						</div>
						<p>When you refer a member to 337LA, you'll earn 20% of their cash barter fees as they spend. If you can think of someone who would be interested in trade let them know! We'll send them a referral link in an email with your personal touch, or a short text message.</p>
						<h4>Please give us a little info about the person you are referring. We'll need either an email address, a mobile phone number, or both.</h4>
				    </div>

					{!! Form::open(array('route'=>['referral_store'], 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
						<div class="group_1">
							<div class="col-xs-12">
								<!-- input: email -->
								<div class="form-group">
									<label for="email" class="col-sm-3 col-md-4 col-lg-4 control-label">Email Address *</label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										{{ Form::email('email_address', null, array('class' => 'form-control required')) }}
									</div>
								</div>
							
								<!-- input: firstname -->
								<div class="form-group">
									<label for="mobile_number" class="col-sm-3 col-md-4 col-lg-4 control-label">Mobile Phone Number</label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										<input class="form-control" name="mobile_number" id="first_name" type="text">
									</div>
								</div>
							
								<!-- input: lastname -->
								<div class="form-group">
									<label for="full_name" class="col-sm-3 col-md-4 col-lg-4 control-label">Full Name *</label>
									<div class="col-sm-7 col-md-5 col-lg-4">
										{{ Form::text('full_name', null, array('class' => 'form-control required')) }}
									</div>
								</div>
							
<!-- checkbox: email_user_after (defaults to unchecked) -->
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-8">
										<div class="checkbox">
											<label>
												<input id="informed" name="informed" value="1" type="checkbox"> I have already informed this person that a representative from {{ Session::get('EXCHANGE_CITY_NAME') }} will be contacting them (optional)
											</label>
										</div>
									</div>
								</div>
							</div>
								<div class="form-group">
									<label for="password" class="col-sm-3 col-md-4 col-lg-4 control-label">Personal Message (optional)</label>
									<div class="col-sm-7 col-md-5 col-lg-4">
									        <textarea class="form-control" name="personal_message"></textarea>
									</div>
								</div>
							
								
								<script>
								$(document).ready(function() {
									$("#phone_number").mask("(999) 999-9999");
								});
								</script>
							
							
								
						

							{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
							<a href="{{ URL::route('admin_user') }}" class="btn btn-info pull-right">Back</a>
						</div>
							    
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection 