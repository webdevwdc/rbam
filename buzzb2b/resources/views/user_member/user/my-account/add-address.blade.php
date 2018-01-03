@extends('user_member.user.layouts.base-2cols')
@section('title','Add Address')
@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{Auth::user()->email}}</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

            <div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12">
						<h4>Address Details</h4>
					</div>	
				</div>	
	
				{!! Form::open(['route'=>['user-save-address'],'class'=>'form-validate']) !!}				
				<div class="group_1">
				
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group">
								{!! Form::label('address1','Address 1 *') !!}
								{!! Form::text('address1','',array('class' => 'form-control required','id'=>'')) !!}
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('address2','Address 2 ') !!}
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
					    
					<div class="row">

						
				     </div>
				    
					{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
					<a href="{{ URL::route('user-address') }}" class="btn btn-info pull-right">Back</a>
					{!! Form::close() !!}
			    </div>

             </div>
            </div>
      </div>
</div>
@endsection