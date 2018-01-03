@extends('user_member.user.layouts.base-2cols')
@section('title','Manage Account')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i>{{Auth::user()->email}}</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

            <div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12">
						<h4>Edit Details</h4>
					</div>	
				</div>	
	
				{!! Form::open(['route'=>['update_details'],'class'=>'form-validate']) !!}
				@if(!empty($user))
				{!! Form::model($user) !!}
				@endif			
				<div class="group_1">
				
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('first_name','First Name: *') !!}
								{!! Form::text('first_name',null,array('class' => 'form-control required','id'=>'','placeholder'=>'First Name')) !!}
							</div>
						</div>
						    
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('last_name','Last Name: *') !!}
								{!! Form::text('last_name',null,array('class' => 'form-control required','id'=>'','placeholder'=>'Last Name')) !!}
							</div>
						</div>
				</div>
				

				</div>	
				
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('user-account') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
@endsection    