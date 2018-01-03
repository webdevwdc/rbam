@extends('admin.layouts.base-2cols')
@section('title', 'Dashboard')
@section('content')

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <h3><i class="fa fa-dashboard"></i>&nbsp;{{ Session::get('EXCHANGE_CITY_NAME') }} :  Dashboard</h3>
      <hr/>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">

	    <a href="{{ URL::route('admin_edit_detail') }}">  
	    <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-user icon-large"></i> <span class="text-large margin-left-15"></span>
            <br/>Edit Personal Details</div>
	    </a>
	    <a href="{{ URL::route('admin_edit_password') }}"> 
	    <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-lock icon-large" aria-hidden="true"></i> <span class="text-large margin-left-15"></span>
            <br/>Change Password</div>
	    </a>
	    <a href="{{ URL::route('admin_manage_address') }}"> 
	    <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-map-marker icon-large"></i> <span class="text-large margin-left-15"></span>
            <br/>Manage Address</div>
	    </a>
	    <a href="{{ URL::route('admin_manage_phone') }}"> 
	    <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-life-ring icon-large"></i> <span class="text-large margin-left-15"></span>
            <br/>Change Phone Number</div>
	    </a>
	    <a href="{{ URL::route('admin_profile_photo') }}"> 
	    <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-file-image-o icon-large"></i> <span class="text-large margin-left-15"></span>
            <br/>Profile Photo</div>
	    </a>
	      
  </div>

</div>
    
@endsection 