@extends('admin.layouts.base-2cols')
@section('title', 'Phone Type Edit')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i> Edit Phone Type</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

            <div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12">
						<h4>Phone Type Details</h4>
					</div>	
				</div>	
	
				{!! Form::open(array('route'=>['admin_phone_type_update_action', $details->id], 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
				<div class="group_1">
				

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('name','Name *') !!}
								{!! Form::text('name',$details->name,array('class' => 'form-control required','id'=>'','placeholder'=>'Enter phone number type')) !!}
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('status','Status *') !!}
								{!! Form::select('status',['Active'=>'Active','Inactive'=>'Inactive'],$details->status,['class'=>'form-control required'])!!}
							</div>
						</div>
					</div>
					    
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