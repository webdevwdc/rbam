@extends('user_member.member.pos.layouts.base-2cols')
@section('content')
<h4>Approved</h4> Confirmation #{{$transaction_id}}
You have made purchase from webskitters and will recieve a confirmation email shortly.
<h4>
Barter: T$ @if(!empty($barter_amount)) {{$barter_amount}} @else 0 @endif

Tip: T$ @if(!empty($tip_amount)) {{$tip_amount}} @else 0 @endif
</h4>
<div>
	<div class="col-md-5">
	        
            <button class="btn btn-success btn-lg btn-block" id="make_sale" style="margin-top:30px; height: 44px;">Make a sale</button>	
	</div>

	<div class="col-md-5">
        <button class="btn btn-default btn-lg btn-block" style="margin-top:30px; height: 44px;" id="dashboard_redirect">Go To Dashboard</button>	
	</div>

	<div class="col-md-2">
		 <a href="#" onclick="myFunction();" class="btn btn-primary btn-lg btn-block" style="margin-top:30px; height: 44px;">
			Print Reciept
        </a>
	</div>
	
</div>
<script>
function myFunction() {
    window.print();
}

$("#make_sale").click(function(){
	window.location.href = '{{route('sale-pos')}}';
});

$("#dashboard_redirect").click(function(){
	window.location.href = '{{route('purchase-view')}}';
});
</script>
@endsection
