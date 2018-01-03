@extends('user_member.user.layouts.base-2cols')
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
	  {{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}
	</div>
       {{-- messages section start--}}
        @include('admin.includes.messages')
	    {{-- messages section end--}}
	<div class="row col-sm-6 col-sm-offset-3">
		<div class="panel-body">
		<div class="col-md-6">
			{{ Form::open(['route'=>'user-image', 'files'=>'true']) }}
	    
			@if(!empty(\Auth::guard('web')->user()->image))
			
			<img src="{{ URL::asset('/upload/members/'.\Auth::guard('web')->user()->image) }}">
			 {{ Form::file('image', ['class' => 'image-field']) }}
			@else
			 <img src="{{ URL::asset('upload/user.png') }}" style="height: 69px;
			     margin-left: 54px;">
			     {{ Form::file('image', ['class' => 'image-field']) }}
			@endif
			<button type="submit" class="btn btn-success">upload</button>
			{{ Form::close() }}
		</div>
		<div class="col-md-6">
			<div class="manage" >
				<a href="{{route('user_details')}}" class="hover">Edit Details</a>
				<a href="{{route('change-password')}}" class="manage2 hover">Change Password</a>
				<a href="{{route('user-address')}}" class="hover">Manage Addresses</a>
				<a href="{{route('user-phone')}}" class="hover">Manage Phone Numbers</a>
				<a href="{!! URL::route('member_logout') !!}" class="hover">Sign Out</a>	
			</div>
		</div>
	</div>
    </div>
</div>
@endsection