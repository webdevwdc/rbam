@extends('admin.layouts.base-2cols')
@section('title', 'Phone Number Add')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> Phone</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
		
			@include('admin.includes.member_edit_tab')
			<h4>Phone Number Details</h4>
		</div>	
	</div>	
	
				{!! Form::open(array('route' => ['admin_member_phone_store', $member->id], 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
				<div class="group_1">
				
					<div class="row">
						
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('phone_number','Phone Number *') !!}
								{!! Form::text('phone_number','',array('class' => 'form-control required','id'=>'','placeholder'=>'Enter phone number')) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('phone_type','Phone Type *') !!}
								{!! Form::select('phone_type',\App\PhoneType::where('status','Active')->pluck('name','id'),null,['class'=>'form-control required'])!!}
							</div>
						</div>
						    
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('is_primary','Is Primary') !!}
								{!! Form::select('is_primary',['Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control required'])!!}
							</div>
						</div>
						
					</div>	
						
				</div>	
				    
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_member_phone', $member->id) }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
    
@endsection 