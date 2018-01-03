@extends('member.layouts.base-2cols')
@section('title', 'Member Setting')
@section('content')
<div class="row">
		  <div class="col-md-12">
		  	
			<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
			    <li @if(in_array(Route::current()->getName(), array('member-setting'))) {{ "class=active" }} @endif>
			    	<a href="{{route('member-setting')}}">Directory Settings</a>
			    </li>
			    <li @if(in_array(Route::current()->getName(), array('users-setting'))) {{ "class=active" }} @endif>
			    	<a href="{{route('users-setting',[$member->id])}}">Users</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('users-address'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-address',[$member->id])}}">Addresses</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('users-phone'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-phone',[$member->id])}}">Phones</a>
			    </li>
			    
			    <li @if(in_array(Route::current()->getName(), array('users-cashiers'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-cashiers',[$member->id])}}">Cashiers</a>
			    </li>
			</ul>
			
			@include('admin.includes.messages')
			{{ Form::open(array('route' => ['save-logo',$member->id],'files'=>'true')) }}
			 <div class="col-sm-6" style="margin-top: 64px;">
		        <label>Member Logo</label>
		        <input type="file" name="member_logo" id="imgInp">
		        <div id="errordiv" style="color:red;"></div>
                <br><br>
                @if(!empty($image))
				<img src="{{url('/upload/members/'.$image->filename)}}" class="img-rounded img-responsive" id="curimg" height="150" width="175">
                @else
				<img src="http://hirewd.com/images/blank.png" class="img-rounded img-responsive" id="curimg" height="150" width="175">
	        	@endif
	        <div>
	        	{{ Form::submit('Change Logo',['style'=>'float: right;margin-right: 330px;margin-top: 15px;width: 110px;height: 29px;background-color: green;']) }}
	        </div>
	        </div>
	        
	        {{ Form::close() }}


	        {{ Form::open(array('route' => ['update',$member->id])) }}
	        @if(!empty($member))
			{{ Form::model($member) }}
			@endif
	        <div class="col-sm-6 memebr" style="margin-top: 97px;">
		        <label>Website Url:</label>
		        {{ Form::text('website_url',null,array('style' => 'width: 372px;height: 37px;')) }}
	        </div>

	        <div class="col-sm-6 memebr" style="margin-top:50px;">
		        <label>Status:</label>
		       {{ Form::select('is_active_salesperson', [1=>'Active Memebr', 2=>'On Standby'], null, ['style' => 'width: 372px;height: 37px;']) }}
	        </div>

	        <div>
	        	{{ Form::submit('Update Settings',['style'=>'float: right;margin-right: 235px;margin-top: 15px;width: 110px;height: 29px;background-color: green;']) }}
	        </div>  
		    {{ Form::close() }}
		  </div>
		</div>
@endsection