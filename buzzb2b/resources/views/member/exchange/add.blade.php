@extends('admin.layouts.base-2cols')
@section('title', 'Exchange Add')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> Exchange</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
			<!--<h4>Exchange Details</h4>-->
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_exchange_store'], 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
				<div class="group_1">
				
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('city_name','City Name *') !!}
								{!! Form::text('city_name','',array('class' => 'form-control required','id'=>'','placeholder'=>'Bartertech/Houston')) !!}
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('name','Name *') !!}
								{!! Form::text('name','',array('class' => 'form-control required','id'=>'','placeholder'=>'713Trade')) !!}
							</div>
						</div>
					</div>
					    
    
					
				    
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_exchange') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>

@endsection 