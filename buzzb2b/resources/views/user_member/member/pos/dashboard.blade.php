@extends('user_member.member.pos.layouts.base-2cols')
@section('title', 'POS')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-3">
			<a href="{{route('sale-pos')}}" class="btn btn-success btn-lg btn-block" style="margin-top:30px; height: 44px;">
			Make A Sale
			</a>
			<a href="{{route('purchase-view')}}" class="btn btn-default btn-lg btn-block" style="margin-top:30px; height: 44px;">
			Make A Purchase
            </a>		
		</div>
	</div>
</div>
@endsection