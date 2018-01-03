@extends('admin.layouts.base-2cols')
@section('title', 'Edit Staff')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> Edit Staff</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
			
			{{-- messages section start--}}
			@include('admin.includes.settings_tab')
			{{-- messages section end--}}
			    
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_setting_staffs_update',$details->user_id], 'id'=>'', 'class'=>'','method'=>'post')) !!}				
				<div class="group_1">
				
					    
					    
					    

					    
<div class="col-md-8">

    <div class="row">

	    <div class="col-xs-12">
		    
		    <h2 class="col-sm-offset-2 col-md-offset-3">{{ $details->user->first_name }} {{ $details->user->last_name }}</h2>

		    <h6 class="col-sm-offset-2 col-md-offset-3"><strong>{{ $details->user->email }}</strong></h6>

	    </div> <!-- .col-xs-12 -->

    </div> <!-- .row -->

<div class="row">

<!-- checkbox: primary -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="primary" id="primary" value="1" {{  ($details->primary) ? 'checked' : '' }} {{ ( ! $details->primary) ? '' : 'disabled' }}> Primary Contact
				<span class="help-block">Primary contacts have access to all features and their contact information will appear in the directory. Every member must have one and only one primary contact.</span>
			</label>
		</div>
	</div>
</div>

<!-- checkbox: admin -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="admin" id="admin" value="1" {{ ( $details->primary || $details->is_exchange_admin ) ? 'checked' : '' }} {{ ($details->primary) ? 'disabled' : '' }}> Exchange Admin
				<span class="help-block">Exchange Admin users have access to most exchange-features. They may assign or remove permissions from other users.</span>
			</label>
		</div>
	</div>
</div>

<!-- checkbox: is_member_admin -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="is_member_admin" id="is_member_admin" value="1" {{ ($details->is_member_admin || $details->is_exchange_admin || $details->primary) ? 'checked' : '' }} {{ ( $details->primary || $details->is_exchange_admin ) ? 'disabled' : '' }}> Member Admin
				<span class="help-block">Member Admin users have access to exchange member information. They may modify member information.</span>
			</label>
		</div>
	</div>
</div>

<!-- checkbox: can_view_accounting -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="can_view_accounting" id="can_view_accounting" value="1" {{ ( $details->can_view_accounting || $details->is_exchange_admin || $details->primary) ? 'checked' : '' }} {{ ( $details->primary || $details->is_exchange_admin ) ? 'disabled' : '' }}> Can View Accounting
				<span class="help-block">These users have access to exchange accounting information.</span>
			</label>
		</div>
	</div>
</div>

<!-- checkbox: is_salesperson -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="is_salesperson" id="is_salesperson" value="1" {{ ( $details->is_salesperson || $details->is_exchange_admin || $details->primary) ? 'checked' : '' }} {{ ( $details->primary || $details->is_exchange_admin ) ? 'disabled' : '' }}> Salesperson
			</label>
		</div>
	</div>
</div>    
    
	
   </div>
 </div>				
				

 <div class="row"></div>					    
					
				    
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_setting_staffs') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
    
<script>
	$(document).ready(function(){
		
		$('#edit-user-form').submit(function() {
			$('#primary').removeAttr("disabled");
		});

		$('#primary').change(function() {
			toggleCheckboxes($(this).is(':checked'), true);
		});

		$('#admin').change(function() {
			toggleCheckboxes($(this).is(':checked'), false);
		});

		function toggleCheckboxes(checkState, adminToo) {
			if (adminToo) {
				$('#admin').prop('disabled', checkState).prop('checked', checkState);
			}
			$('#is_salesperson').prop('disabled', checkState).prop('checked', checkState);
			$('#is_member_admin').prop('disabled', checkState).prop('checked', checkState);
			$('#can_view_accounting').prop('disabled', checkState).prop('checked', checkState);
		}
	});
</script>
    
@endsection 