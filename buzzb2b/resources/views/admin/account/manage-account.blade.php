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
<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
<div class="panel panel-default">
	<div class="panel-body">

		<div class="row">

			<div class="col-xs-4">

				<div class="pull-left">
					<img src="{{ URL::asset('jacopo_admin/images/'.\Auth::guard('admin')->user()->image) }}" class="img-rounded img-responsive">

					<div style="text-align: center; margin-top: 10px;">

						<a href="{!! URL::route('admin_profile_photo') !!}" class="btn btn-default hover" >Manage Profile Photo</a>
					
					</div>
				</div>
			</div>
			<div class="col-xs-8">

				<h4>{{$user->email}}<br><small>{{$user->first_name}} {{$user->last_name}}</small></h4>

				<ul class="list-unstyled" style="margin-top:16px; margin-bottom:20px;">
					<li style="margin-top:6px;"><a href="{!! URL::route('admin_edit_detail') !!}" class="hover">Edit Details</a></li>
					<li style="margin-top:6px;"><a href="{!! URL::route('admin_edit_password') !!}" class="manage2 hover">Change Password</a></li>
					<li style="margin-top:6px;"><a href="{!! URL::route('admin_manage_address') !!}" class="hover">Manage Addresses</a></li>
					<li style="margin-top:6px;"><a href="{!! URL::route('admin_manage_phone') !!}" class="hover">Manage Phone Numbers</a></li>
					<li style="margin-top:6px;"><a href="{!! URL::route('admin_logout') !!}" class="hover">Sign Out</a>	</li>
				</ul>

			</div>
		</div>
	</div>
</div>
</div>



@endsection