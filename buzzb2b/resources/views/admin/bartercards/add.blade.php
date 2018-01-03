@extends('admin.layouts.base-2cols')
@section('title','Add BarterCard')
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
					<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> {{ Session::get('EXCHANGE_CITY_NAME') }} : Add BarterCard</h3>
					</div>
				</div>
			</div>
			<div class="panel-body">

			<div class="col-md-12 col-xs-12">
					<div class="row">
					<div class="col-md-12">
					</div>	
					</div>
					<div class="group_1">
						<div class="row">
							{{ Form::open(['route'=>['save-bartercard'],'method'=>'post']) }}
							@if(!empty($cards))
							{{ Form::model($cards) }}
							<input type="hidden" name="edit_card" value="{{$cards->id}}">
							@endif
							<div class="col-md-8">
								<div class="form-group">
								{{ Form::label('create_new_address', 'Card Number *', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
									<div class="col-sm-5 col-md-4 col-lg-5">
										{{ Form::select('number',$cards_details, ['class' => 'form-control']) }}
									</div>
								</div>
							</div>

							<div class="col-md-8">
								<div class="form-group">
								{{ Form::label('create_new_address', 'Status *', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
									<div class="col-sm-5 col-md-4 col-lg-5">
									{{ Form::select('type',[1=>'Active',2=>'Inactive'],null, ['class' => 'form-control']) }}
									</div>
								</div>
							</div>

							
						<div class="row"></div>
						{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
			            <a href="{{ URL::route('bartercard') }}" class="btn btn-info pull-right">Back</a>
						{{ Form::close() }}
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

@endsection