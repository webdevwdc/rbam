@extends('member.layouts.base-2cols')
@section('title', 'Dashboard')
<style type="text/css">
.referral{
 	margin: 0 0 10px;
    font-size: 24px;
    font-weight: 600;
 }
  .balance{
 	font-size: 18px;
    color: black;
 }
</style>
@section('content')

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <h3><i class="fa fa-dashboard"></i>&nbsp; Dashboard</h3>
      <hr/>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">
 <div class="col-md-3" style="border-right:thin solid #B3B3B3;height: 71px;">
 	<h5 class="balance">Barter Balance</h5>
 	<p class="referral">{{$barter_balance}}</p>
 	<p>{{Auth::guard('admin')->user()->first_name}} {{Auth::guard('admin')->user()->last_name}}</p>
  <p>{{Auth::guard('admin')->user()->email}}</p>
  @if(!empty($address))
  <p>{{$address->address1}}</p>
  @endif
  @if(!empty($phone))
  <p>{{$phone->number}}</p>
  @endif
 </div>

 <div class="col-md-3" style="border-right:thin solid #B3B3B3;height: 71px;">
 	<h5 class="balance">CBA Balance </h5> 
 	<a href="{{route('member-billing')}}">
 		<p style="font-weight: 800;margin-left:123px;margin-top:-29px;color:cadetblue;">Manage</p>
 	</a>
	<p class="referral">{{$cbabalance}}</p>
 </div>

 <div class="col-md-3" style="border-right:thin solid #B3B3B3;height:71px;">
 	<h5 class="balance">Referral Commissions</h5>
 	 <p class="referral">{{$referral}}</p>
 	 <p>Sales (Last 30 Days)</p>
 	 <p class="referral">{{$sales}}</p>

 	 <p>Purchases (Last 30 Days)</p>
   <p class="referral">{{$purchase}}</p>
 </div>

 <div class="col-md-3">
 	<h5 class="balance">Available Barter Credit</h5>
 	<p class="referral">{{$barter_available}}</p>
 	<a href="{{route('pos-sale')}}" class="btn btn-info" style="width:160px;margin-left:16px;">Make a sale</a>
 	<a href="{{route('pos-purchase')}}" class="btn btn-default" style="width:160px;margin-left:16px;margin-top: 8px;">Make a purchase</a>
 	<a href="{{route('member-load-cba')}}" class="btn btn-primary" style="width:160px;margin-left:16px;margin-top: 8px;">Load CBA</a>
 </div>
	      
  </div>

</div>
    
@endsection 