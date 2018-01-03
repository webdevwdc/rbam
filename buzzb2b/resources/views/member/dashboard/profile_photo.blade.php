@extends('admin.layouts.base-2cols')
@section('title', 'Profile Picture Update')
@section('content')
 
<div class="row">
    <div class="col-md-12">

        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
        <div class="panel panel-info">
            <div style="text-align: center;">
                @if(Session::has('succmsg'))
                    <span style="color:green">{{ Session::get('succmsg') }}</span>
                @endif
                @if(Session::has('errmsg'))
                    <span style="color:red">{{ Session::get('errmsg') }}</span>
                @endif			
            </div>       
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i> Update Profile Picture</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
<!--                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <a href="#" class="btn btn-info pull-right"><i class="fa fa-user"></i> Edit Owner Profile</a>
                    </div>
                </div>
-->
<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
			<h4>Upload New Profile Picture</h4>
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_profile_photo_update'], 'id'=>'', 'class'=>'form-validate', 'method'=>'post', 'enctype'=>'multipart/form-data')) !!}				
				<div class="group_1">
				

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
                                <input type="file" name="profile_picture">  
							</div>
                            <img src="{{ URL::asset('jacopo_admin/images/'.\Auth::guard('admin')->user()->image) }}" style="height: 69px;
                            margin-left: 1px;">
						</div>
					</div>
					    
				</div>	
				
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_dashboard') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>   
    
@endsection