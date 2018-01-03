@extends('user_member.member.layouts.base-2cols')
@section('title', 'Billing')
@section('content')
<style type="text/css">
 .balance{
 	font-size: 18px;
    color: black;
 }
 .referral{
 	margin: 0 0 10px;
    font-size: 24px;
    font-weight: 600;
 }
</style>
<div class="row">
    <div class="col-md-12">
    	<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
		    <li @if(in_array(Route::current()->getName(), array('billing'))) {{ "class=active" }} @endif>
		    	<a href="{{route('billing')}}">Dashboard</a>
		    </li>

		    <li @if(in_array(Route::current()->getName(), array(''))) {{ "class=active" }} @endif>
			     	<a href="{{route('load-cba')}}">Load CBA</a>
			</li>

		    <li @if(in_array(Route::current()->getName(), array(''))) {{ "class=active" }} @endif>
			     	<a href="{{ route('payment-profile') }}">Payment Profiles</a>
			</li>
		</ul>
    </div>
    
    <!-- main content starts -->
    <div class='border'>
	    <div class="col-md-4 bill" style="border-right:thin solid #B3B3B3;height: 71px;">
	      <h5 class="balance">Current Balance </h5>
	      <p class="referral">{{$cbabalance}}</p>
	      <a href="{{route('load-cba')}}" class="btn btn-primary">Load CBA</a>


	    </div>
	    <div class="col-md-4 bill" style="border-right:thin solid #B3B3B3;height: 71px;">
	    	<h5 class="balance">Payment Profile </h5>
	    	<p style="font-weight: 800;margin-left:181px;margin-top:-29px;color:cadetblue;">
	    		<a href="{{ route('payment-profile') }}" style="color:cadetblue;">Manage</a>
	    	</p>
	    </div>

	    <div class="col-md-4 bill">
	      <h5 class="balance">Referral Commission</h5>
	      <p class="referral">${{$referral}}</p>
	      earned over lifetime
	    </div>
    <!-- end main content -->
    </div>


</div>
@endsection