@extends('user_member.member.layouts.base-2cols')
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
      <h3><i class="fa fa-dashboard"></i> Dashboard</h3>
      <hr/>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="row">
 <div class="col-md-3">
 <div class="cntnDV">
 	<h5 class="balance">Barter Balance</h5>
 	<p class="referral">{{$barter_balance}}</p>
 	<p>{{Auth::guard('web')->user()->first_name}} {{Auth::guard('web')->user()->last_name}}</p>
    <p></p>
    </div>
 </div>

 <div class="col-md-3">
 <div class="cntnDV">
 	<h5 class="balance">CBA Balance </h5>
  @if(Session::get('IS_ADMIN') == 1) 
 	<a href="{{route('billing')}}">
 		<p style="font-weight: 800;color:cadetblue;">Manage</p>
 	</a>
  @endif
	<p class="referral">{{$cbabalance}}</p>
  </div>
 </div>

 <div class="col-md-3" >
 <div class="cntnDV">
 	<h5 class="balance">Referral Commissions</h5>
 	 <p class="referral">{{$referral}}</p>
 	 <p>Sales (Last 30 Days)</p>
 	 <p class="referral">{{$sales}}</p>

 	 <p>Purchases (Last 30 Days)</p>
   <p class="referral">{{$purchase}}</p>
   </div>
 </div>

@if(Session::get('IS_ADMIN') == 1)
 <div class="col-md-3">
 <div class="cntnDV">
 	<h5 class="balance">Available Barter Credit</h5>
 	<p class="referral"></p>
 	<a href="{{route('sale-pos')}}" class="btn btn-info"">Make a sale</a>
 	<a href="{{route('purchase-view')}}" class="btn btn-default">Make a purchase</a>
 	<a href="{{route('load-cba')}}" class="btn btn-primary">Load CBA</a>
  </div>
 </div>
@endif

	</div>      
  </div>

</div>
    
@endsection 