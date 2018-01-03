@extends('admin.layouts.base-2cols')
@section('title', 'Edit Profile')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i> Edit Profile</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

            <div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12">
						<h4>Admin Details</h4>
					</div>	
				</div>	
	
				{!! Form::open(array('route'=>['admin_profile_update'], 'id'=>'', 'class'=>'','method'=>'post')) !!}				
				<div class="group_1">
				
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('first_name','First Name: *') !!}
								{!! Form::text('first_name',$details->first_name,array('class' => 'form-control required','id'=>'','placeholder'=>'First Name')) !!}
							</div>
						</div>
						    
						<div class="col-md-6">
						    <div class="form-group">
							<img src="{{ URL::asset('upload/admin_pro_pic')."/".$details->image }}">
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