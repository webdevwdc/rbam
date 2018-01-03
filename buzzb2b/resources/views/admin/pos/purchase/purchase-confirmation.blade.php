@extends('admin.pos.layouts.base-2cols')
@section('content')
<h4>Approved</h4> Confirmation #{{$transactions->id}}
You have made purchase from webskitters and will recieve a confirmation email shortly.
<h4>
Barter: T$ @if(!empty($input['barter_amount'])) {{$input['barter_amount']}} @else 0 @endif

Tip: T$ @if(!empty($input['tip_amount'])) {{$input['tip_amount']}} @else 0 @endif
</h4>
<div>
	<div class="col-md-6">
	        <a href="{{route('pos-purchase')}}" class="btn btn-default btn-lg btn-block" style="margin-top:30px; height: 44px;">
			Make A Purchase
            </a>	
	</div>

	<div class="col-md-6">
		 <a href="{{route('pos-purchase')}}" class="btn btn-default btn-lg btn-block" style="margin-top:30px; height: 44px;">
			Go To Dashboard
        </a>
	</div>
	
</div>

@endsection
