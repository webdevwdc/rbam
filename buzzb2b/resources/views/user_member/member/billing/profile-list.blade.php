@extends('user_member.member.layouts.base-2cols')
@section('content')
<div class="row">
	 <div class="col-md-12">
        {{-- messages section start--}}
        @include('member.includes.messages')
	{{-- messages section end--}}	 
	    	<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
			    <li @if(in_array(Route::current()->getName(), array('billing'))) {{ "class=active" }} @endif>
			    	<a href="{{route('billing')}}">Dashboard</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('member-load-cba'))) {{ "class=active" }} @endif>
				     	<a href="{{route('load-cba')}}">Load CBA</a>
				</li>

			    <li class="active">
				     	<a href='{{route('payment-profile')}}'>Payment Profiles</a>
				</li>
			</ul>
	    </div>
</div>
<div>&nbsp;</div>
<div class="row">
	<div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
	<div class="col-lg-2 col-md-3 col-sm-3">
		<a href="{{route('payment-profile-add')}}" class="btn btn-info" title="Add New"><i class="fa fa-plus"></i> Add New</a>
	</div>
</div>	
		
<div class="group_1">
	<div class="row">
	  <div class="col-md-12">
		@if($lists->count())
		  <table class="table table-hover">
		  <thead>
			  <tr>
				    <th class="hidden-xs">Payment Account</th>
				    <th class="hidden-xs">Billing Address</th>
				    <th>Action</th>
			  </tr>
			</thead>
	  <tbody>

		@foreach($lists as $record)
		  <tr>
			<td class="hidden-xs">
			{{ $record->first_name }} {{ $record->lsst_name }}<br/>
			{{ app('App\Http\Controllers\Member\BillingController')->ccMasking(\Crypt::decryptString($record->credit_card)) }}<br/>
			Expiration: {{ $record->expiry_month }}/{{$record->expiry_year}}
			</td>
				<td class="hidden-xs">
				 {{ $record->paymentAddress[0]->address1 }} <br/>
				 {{ $record->paymentAddress[0]->address2 }}<br/>
				 {{ $record->paymentAddress[0]->city }}<br/>
				 {{ $record->paymentAddress[0]->state->name }}, {{ $record->paymentAddress[0]->zip }}
				</td>
			<td>
			@if($record->paymentAddress[0]->is_default=='No')
			<a href="{!! URL::route('payment_profile_address_make_default', ['id' => $record->id])!!}" class="btn btn-primary" title="Make Default">Make Default</a>
			@else
			<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
			@endif
			 </td>

		  </tr>
	  </tbody>
		@endforeach
	  </table>
	  @else
		  <span class="text-warning"><h5>No results found.</h5></span>
	  @endif
	  </div>
  </div>
						    
 </div>

<script>
	
	
	
</script>
@endsection