@extends('user_member.user.layouts.base-2cols')
@section('title','Phone List')
@section('content')
<div class="row">    

      <div class="col-md-12">
		        {{-- messages section start--}}
		        @include('admin.includes.messages')
			    {{-- messages section end--}}
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i>{{Auth::user()->email}}</h3>
                    </div>
                    <div class="panel-body">
                       
                        <div class="col-md-12 col-xs-12">
							<div class="row">
								<div class="col-md-12"><!-- password_confirmation text field -->
								<h4>Phone Number Details</h4>
								</div>	
							</div>	
				 			<div class="row"></div>
				{!! Form::open(['route'=>['user-save-phone'], 'class'=>'form-validate_','method'=>'post']) !!}
				<div class="group_1">
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group">
								<label for="phone_number">Phone Number *</label>
								<input class="form-control required" id="" placeholder="Enter phone number" name="phone_number" type="text" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="phone_type">Phone Type *</label>
								<select class="form-control required" id="phone_type" name="phone_type"><option value="1">Office</option><option value="2">Mobile</option></select>
							</div>
						</div>
						    
						<div class="col-md-6">
							<div class="form-group">
								<label for="is_primary">Is Primary</label>
								<select class="form-control required" id="is_primary" name="is_primary"><option value="Yes">Yes</option><option value="No">No</option></select>
							</div>
						</div>
					</div>
				</div>
				<input class="btn btn-info pull-right green" type="submit" value="Save">	
				{!! Form::close() !!} 
			      </div>
                 </div>
               </div>
	        </div>
        </div>
@endsection