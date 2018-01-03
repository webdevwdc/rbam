@extends('admin.layouts.base-2cols')
@section('title', 'Phone Number Edit')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i> Edit Phone Number</h3>
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
			<h4>Phone Number Details</h4>
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_phone_update', $details->id], 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
				<div class="group_1">
				

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('phone_number','Phone Number *') !!}
								{!! Form::text('phone_number',$details->number,array('class' => 'form-control required','id'=>'','placeholder'=>'713Trade')) !!}
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('phone_type','Phone Type *') !!}
								{!! Form::select('phone_type',\App\PhoneType::where('status','Active')->pluck('name','id'),$details->phone_type_id,['class'=>'form-control required'])!!}
							</div>
						</div>
					</div>
					    
				</div>	
				
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_manage_phone') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
    
@endsection 