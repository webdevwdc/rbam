@extends('admin.pos.layouts.base-2cols')
@section('title', 'Make a sale')
@section('content')
<div class="container-fluid">
				
				<div class="row flip-container vertical" id="panel-card-lookup">
					
					<div class="flipper">
						{{-- messages section start--}}
						@include('admin.includes.messages')
						{{-- messages section end--}}
						<div id="panel-card-lookup-form" class="front">

							<h1><a href="#">Point of sale</a> &gt; Sale</h1>

							<h4>Enter a bartercard or giftcard number:</h4>

							<form method="POST" action="{{route('search-bartercard-sale')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<!-- input: card_number -->
							<div class="form-group" id="form-group-card-number">
								<label class="sr-only" for="card_number">Card Number</label>
								<div class="input-group">
									<div class="input-group-addon">
									<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
									<input class="form-control input-lg focus"  name="card_number" value="" type="text">
								</div>
							</div>

							<button type="submit" id="submit-card-lookup" class="btn btn-default btn-lg btn-submit-form">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
							</button>
							
							<button type="button" id="submit-card-lookup-spinner" href="#" class="btn btn-default btn-lg btn-submit-form disabled hidden" role="button"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" aria-hidden="true"></span></button>

							<a href="https://pos.bartertech.net/sale" id="reset-card-lookup" class="btn btn-default btn-lg btn-reset-form disabled"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>

							</form>

						</div> 
						
						<div id="panel-card-lookup-response" class="back"></div>

					</div>
				</div>

			</div>
@endsection