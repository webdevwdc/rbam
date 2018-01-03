@extends('admin.layouts.base-2cols')
@section('title', 'Phone Type Add')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> Phone Type</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
			<h4>Phone Type Details</h4>
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_phone_type_store'], 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
				<div class="group_1">
				
					<div class="row">
						
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('name','Name *') !!}
								{!! Form::text('name','',array('class' => 'form-control required','id'=>'','placeholder'=>'Enter phone number type')) !!}
							</div>
						</div>
						<div class="col-md-6">
						    		<div class="form-group">
								{!! Form::label('status','Status *') !!}
								{!! Form::select('status',[''=>'Select','Active'=>'Active','Inactive'=>'Inactive'],null,['class'=>'form-control required'])!!}
							</div>
						</div>
						
					</div>
					    
					<div class="row">
						
						
					<!--<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('status','Status *') !!}
								{!! Form::select('status',[''=>'Select','Active'=>'Active','Inactive'=>'Inactive'],null,['class'=>'form-control required'])!!}
							</div>
						</div>
					</div>-->
					    

						
				</div>	
				
				

					    
					
				    
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_phone_type') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
    
@endsection 