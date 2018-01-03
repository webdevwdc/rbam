@extends('admin.layouts.base-2cols')
@section('title','Manage Account')
@section('content')
<style type="text/css">
.manage{
	white-space: pre;
}
.hover{
    color: #295FA6;
}
.move{
	text-align: center;
	font-size: 18px;
	margin-top: 14px;
}
</style>
<div class="div1">
	<div class="move">
		{{$user->email}}
	</div>
	<div class="move">
	{{$user->first_name}} {{$user->last_name}}
	</div>

	<div class="row col-sm-6">
		<div>
		  <img src="{{ URL::asset('jacopo_admin/images/'.\Auth::guard('admin')->user()->image) }}" style="height: 69px;
	      margin-left: 54px;">
		  <a href="{!! URL::route('admin_profile_photo') !!}" class="hover">Manage Profile Photo</a>
	    </div>
		<div class="manage" >
		<a href="{!! URL::route('admin_edit_detail') !!}" class="hover">Edit Details</a>
		<a href="{!! URL::route('admin_edit_password') !!}" class="manage2 hover">Change Password</a>
		<a href="{!! URL::route('admin_manage_address') !!}" class="hover">Manage Addresses</a>
		<a href="{!! URL::route('admin_manage_phone') !!}" class="hover">Manage Phone Numbers</a>
		<a href="{!! URL::route('admin_logout') !!}" class="hover">Sign Out</a>	
		</div>
    </div>
</div>


@endsection