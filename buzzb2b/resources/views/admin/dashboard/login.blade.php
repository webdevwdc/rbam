@extends('admin.layouts.login')
@section('title', 'Login')
@section('content')
    
    <div class="container">   
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Login to Bartertech</h3>
					</div>
					  
				       {{-- messages section start--}}
				       @include('admin.includes.messages')
				       {{-- messages section end--}}
	
					<div class="panel-body">
						{!! Form::open(array('class'=>'form form-validate m-t','novalidate'))!!}
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										{!! Form::email('email', '', ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email address', 'autocomplete' => 'off']) !!}
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-lock"></i></span>
										{!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'autocomplete' => 'off']) !!}
									</div>
								</div>
							</div>
						</div>
						{{-- Form::label('remember','Remember me') !!}
						{!! Form::checkbox('remember') --}}
						<input type="submit" value="Login" class="btn btn-info btn-block">
						{!! Form::close() !!}
						<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 margin-top-10">
								{!! link_to_route('admin_forgot_password','Forgot password?') !!}
						   </div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection    