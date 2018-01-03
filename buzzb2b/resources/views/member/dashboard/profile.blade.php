@extends('admin.layouts.base-2cols')
@section('title', 'Change Password')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i> {{ $details->email }}</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
<!--                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <a href="#" class="btn btn-info pull-right"><i class="fa fa-user"></i> Edit Owner Profile</a>
                    </div>
                </div>
-->
<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
			<h4>Change Password</h4>
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_password_update'], 'id'=>'change_password', 'class'=>'form-validate','method'=>'post')) !!}				
				<div class="group_1">
				
					<div class="row">
						<div class="col-md-6">		
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
				<a href="{{ URL::route('admin_dashboard') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
    
@endsection 