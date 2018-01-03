@extends('admin.layouts.base-2cols')
@section('title', 'Member Details')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> {{ Session::get('EXCHANGE_CITY_NAME') }} : Member</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
		
			@include('admin.includes.member_edit_tab')
						
			<!--<h4>Exchange Details</h4>-->
		</div>	
	</div>
	    
	<div>&nbsp;</div>
	
				{!! Form::open(array('route'=>['admin_member_update_details', $member->id ], 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
				<div class="group_1">
								    
					<div class="row">
						
<div class="col-md-8">						
<!-- input: name -->
<div class="form-group">
	{{ Form::label('name', 'Name', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-6">
		{{ Form::text('name', $member->name, ['class' => 'form-control', 'placeholder' => 'required']) }}
	</div>
</div>

<!-- input: business 1099 name (leave blank if same as name) -->
<div class="form-group">
	{{ Form::label('business_1099_name', 'Business 1099 Name', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-6">
		{{ Form::text('business_1099_name', $member->business_1099_name, ['class' => 'form-control', 'placeholder' => 'required']) }}
	</div>
</div>

<!-- input: tax_id_number -->
<div class="form-group">
	{{ Form::label('tax_id_number', 'Tax ID Number', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-6">
		{{ Form::text('tax_id_number', $member->tax_id_number, ['class' => 'form-control', 'placeholder' => 'required']) }}
	</div>
</div>

<!-- input: website -->
<div class="form-group">
	{{ Form::label('website', 'Website', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-6">
		{{ Form::text('website', $member->website_url, ['class' => 'form-control', 'placeholder' => 'optional']) }}
	</div>
</div>
    
<!-- input: status -->
<div class="form-group">
	{{ Form::label('standby', 'Standby', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-6">
		{{ Form::select('standby',['0'=>'Active and ready to trade','1'=>'On Standby'],$member->standby,['class'=>'form-control required'])}}
	</div>
</div>

<!-- checkbox: is_prospect -->
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<div class="checkbox">
			<label>
				{{ Form::checkbox('is_prospect', 1, $prospect, ['id' => 'is_prospect']) }} This member is a prospect
			</label>
		</div>
	</div>
</div>

<!-- checkbox: is_active_salesperson -->
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<div class="checkbox">
			<label>
				{{ Form::checkbox('is_active_salesperson', 1, $salesperson, ['id' => 'is_active_salesperson']) }} This member is a salesperson
			</label>
		</div>
	</div>
</div>
   
</div>
</div>
    
    
 <div class="row"></div>
    

		
				    
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_member') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
    
<script>
	$(document).ready(function(){
		$('#yes_create_new_user_wrap').show();
		$('#no_create_new_user_wrap').hide();

		$('#create_new_user').change(function () {
			if ($('#create_new_user option:selected').text() == "Create New User") {
				$('#no_create_new_user_wrap').hide();
				$('#yes_create_new_user_wrap').show();
			} else if ($('#create_new_user option:selected').text() == "Select Existing User By Email") {
				$('#no_create_new_user_wrap').show();
				$('#yes_create_new_user_wrap').hide();
			}
		});
	});
</script>
    
@endsection 