@extends('admin.pos.layouts.base-2cols')
@section('title', 'POS')
@section('content')
<div class="panel panel-info">

	<div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }}</h3>
                    </div>
                </div>
            </div>
		
	<div class="row">
		<div class="col-md-4 col-md-offset-3">
			<a href="{{route('pos-sale')}}" class="btn btn-success btn-lg btn-block" style="margin-top:30px; height: 44px;">
			Make A Sale
			</a>
			<a href="{{route('pos-purchase')}}" class="btn btn-default btn-lg btn-block" style="margin-top:30px; height: 44px;">
			Make A Purchase
            </a>		
		</div>
	</div>
</div>
@endsection