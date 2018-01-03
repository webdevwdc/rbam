@extends('admin.layouts.base-2cols')
@section('title', 'Issue Gift Cards')
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
					<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> {{ Session::get('EXCHANGE_CITY_NAME') }} : Gift Cards / Issue To Member</h3>
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
							{{ Form::open(['route'=>['save-giftcard'],'method'=>'post']) }}
							<div class="col-md-8">
								<div class="form-group">
								{{ Form::label('create_new_address', 'Member', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
								<div class="col-sm-5 col-md-4 col-lg-5">
								{{ Form::select('member_id',$members,null, ['class' => 'form-control','placeholder'=>'Select a Member']) }}
								</div>
								</div>
							</div>

							<div class="col-md-8">
								<div class="form-group">
								{{ Form::label('create_new_address', 'Gift Card *', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
									<div class="col-sm-5 col-md-4 col-lg-5">
										{{ Form::text('card_number', null, ['class' => 'form-control']) }}
									</div>
								</div>
							</div>

							<div class="col-md-8">
								<div class="form-group">
								{{ Form::label('create_new_address', 'Amount *', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
									<div class="col-sm-5 col-md-4 col-lg-5">
										<div class="input-group">
											<span class="input-group-addon">$</span>
											{{ Form::text('amount', null, ['class' => 'form-control']) }}
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-8">
								<div class="form-group">
								{{ Form::label('create_new_address', 'Notes', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
								<div class="col-sm-5 col-md-4 col-lg-5">
								{{ Form::text('notes', null, ['class' => 'form-control']) }}
								</div>
								</div>
							</div>
						<div class="row"></div>
						{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
			            <a href="{{ URL::route('admin-user-gift-card-details') }}" class="btn btn-info pull-right">Back</a>
						{{ Form::close() }}
						</div>
					</div>
			</div>
		</div>
	</div>
</div>


@endsection