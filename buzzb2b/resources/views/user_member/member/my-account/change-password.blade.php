@extends('user_member.member.layouts.base-2cols')
@section('title', 'Edit Details')
@section('content')
    
<div class="row">
    <div class="col-md-12">

        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
	<div class="panel panel-info">
	           
	    <div class="panel-body">
	        <div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12"><!-- password_confirmation text field -->
						<h4>Change Password</h4>
					</div>	
				</div>	
		
					{!! Form::open(array('route'=>['change-profile-password-post'],'class'=>'form-validate','method'=>'post')) !!}
					@if(!empty($user))
					{{ Form::model($user) }}
					@endif			
					<div class="group_1">
						<div class="row">
							<div class="col-md-12">		
							<div class="form-group">
								{!! Form::label('Old Password','Old Password: *') !!}
								{!! Form::password('old_password',array('class'=>'form-control','placeholder'=>'Enter your old password'))!!}
							</div>
						</div>
						    
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('new_password','New Password: *') !!}
								{!! Form::password('new_password',array('class'=>'form-control','placeholder'=>'Enter your new password'))!!}
							</div>
						</div>
						    
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('confirm_password','Confirm New Password: *') !!}
								{!! Form::password('confirm_password',array('class'=>'form-control','placeholder'=>'Enter your new password again'))!!}
							</div>
						</div>
						</div>
					</div>
					{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
					<a href="{{ URL::route('my-account') }}" class="btn btn-info pull-right">Back</a>
					{!! Form::close() !!}
			</div>

	    </div>
	</div>
  </div>
</div>
    
@endsection 