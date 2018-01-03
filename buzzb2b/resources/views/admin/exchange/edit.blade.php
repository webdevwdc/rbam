@extends('admin.layouts.base-2cols')
@section('title', 'Exchange Edit')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i> Edit Exchange</h3>
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
			<h4>Exchange Details</h4>
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_exchange_update_action', $details->id], 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
				<div class="group_1">

					<div class="row">
						<div class="col-md-12">		
							<div class="form-group">
								{!! Form::label('partner_exchange','Partner Exchange') !!}
								{!! Form::select('partner_exchange_id',$exchangeList, $partnerExchangeID,array('class' => 'form-control required','id'=>'','placeholder'=>'Partner Exchange')) !!}
							</div>
						</div>
					</div>
				

					<div class="row">
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('city_name','City Name *') !!}
								{!! Form::text('city_name',$details->city_name,array('class' => 'form-control required','id'=>'','placeholder'=>'Bartertech/Houston')) !!}
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('name','Name *') !!}
								{!! Form::text('name',$details->name,array('class' => 'form-control required','id'=>'','placeholder'=>'713Trade')) !!}
							</div>
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