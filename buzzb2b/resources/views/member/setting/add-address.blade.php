@extends('member.layouts.base-2cols')
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

			    <li @if(in_array(Route::current()->getName(), array('users-address','users-create-address'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-address',[$member->id])}}">Addresses</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('users-phone'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-phone',[$member->id])}}">Phones</a>
			    </li>
			    
			    <li @if(in_array(Route::current()->getName(), array('users-cashiers'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-cashiers',[$member->id])}}">Cashiers</a>
			    </li>
			</ul>
			
		{{-- messages section start--}}
		@include('admin.includes.messages')
		{{-- messages section end--}}
    </div>
    <div class="panel panel-info">
            
            <div class="panel-body">

			<div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12"><!-- password_confirmation text field -->
						
						<h4>Address Details</h4>
					</div>	
				</div>	
	
							
				<div class="group_1">
				{!! Form::open(['route'=>['users-save-address'], 'class'=>'form-validate_','method'=>'post']) !!}
				 <input type="hidden" name="user_id" value="{{$member->id}}">
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('address1','Street Address *') !!}
								{!! Form::text('address1','',array('class' => 'form-control required','id'=>'')) !!}
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('address2','Suite / Unit') !!}
								{!! Form::text('address2','',array('class' => 'form-control','id'=>'')) !!}
							</div>
						</div>
					</div>
					    
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('city','City *') !!}
								{!! Form::text('city','',array('class' => 'form-control required','id'=>'')) !!}
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('state','State *') !!}
								{!! Form::select('state',$state,null,['class'=>'form-control required'])!!}
							</div>
						</div>
					</div>
					    
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('zip','Zip/Postal Code *') !!}
								{!! Form::text('zip','',array('class' => 'form-control required','id'=>'')) !!}
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('is_default','Is Default') !!}
								{!! Form::select('is_default',['Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control required'])!!}
							</div>
						</div>
					</div>
					    
					<div class="row"></div>
				    
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
@endsection