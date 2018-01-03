@extends('landing_view_page.layouts')
@section('title','Gift Card Balance')
@section('content')
@if(Session::has('success'))
<div class="gift_card_balance">
	<div class="component-giftcard-check-balance">

		  <img src="{{url('landing_page/images/logo.png')}}" alt="" width="150" height="100">
		  <h3>Your gift card balance is</h3>
		
		 <p style="color: red;font-size: 14px;">$ {{ Session::get('success') }}</p>
		
		<a href="{{route('giftcard_balance')}}" class="btn btn-lg btn-primary btn-block">Check another balance</a>
	</div>
</div>

@else

<div class="gift_card_balance Check">
	<div class="component-giftcard-check-balance">

		 <img src="{{url('landing_page/images/logo.png')}}" alt="" width="150" height="100">

		<h3>Check your balance</h3>

		<p>Please enter your gift card number below</p>
		@if(Session::has('error'))
		 <p style="color: red;font-size: 14px;">{{ Session::get('error') }}</p>
		@endif
		<form class="form-check-giftcard-balance" role="form" method="POST" action="{{route('giftcard_balance_check')}}">
		{{csrf_field()}}
		<label for="inputCardNumber" class="sr-only">Card Number</label>
		<input id="inputCardNumber" class="form-control" name="card_number" value="" required="" autofocus="" type="text">
		 @if($errors->has('card_number')) <p style="color: red;font-size: 14px;">{{ $errors->first('card_number') }}</p> @endif
		<button class="btn btn-lg btn-primary btn-block" type="submit">Check Balance</button>
		</form>

		
	</div>
</div>
@endif
@endsection