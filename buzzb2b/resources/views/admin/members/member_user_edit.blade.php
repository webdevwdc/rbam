@extends('admin.layouts.base-2cols')
@section('title', 'Member User')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> Edit Member User</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12"><!-- password_confirmation text field -->
		
			@include('admin.includes.member_edit_tab')
		</div>	
	</div>	
	
				{!! Form::open(array('route'=>['admin_member_user_update',$details->id], 'id'=>'', 'class'=>'','method'=>'post')) !!}				
				<div class="group_1">
				
					    
					    
					    

					    
<div class="col-md-8">

    <div class="row">

	    <div class="col-xs-12">
		    
		    <h2 class="col-sm-offset-2 col-md-offset-3">{{ $details->user[0]->first_name }} {{ $details->user[0]->last_name }}</h2>

		    <h6 class="col-sm-offset-2 col-md-offset-3"><strong>{{ $details->user[0]->email }}</strong></h6>

	    </div> <!-- .col-xs-12 -->

    </div> <!-- .row -->

<div class="row">

<!-- checkbox: primary -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="primary" id="primary" value="1" {{ ( $details->user[0]->pivot->primary) ? 'checked' : '' }} {{ ( ! $details->user[0]->pivot->primary ) ? '' : 'disabled' }}> Primary Contact
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
				<input type="checkbox" name="admin" id="admin" value="1" {{ (  $details->user[0]->pivot->primary || $details->user[0]->pivot->admin ) ? 'checked' : '' }} {{ ($details->user[0]->pivot->primary) ? 'disabled' : '' }}> Admin
				<span class="help-block">Admin users have access to all features. They may assign or remove permissions from other users.</span>
			</label>
		</div>
	</div>
</div>

<!-- checkbox: can_access_billing -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="can_access_billing" id="can_access_billing" value="1" {{ ( $details->user[0]->pivot->primary || $details->user[0]->pivot->admin || $details->user[0]->pivot->can_access_billing ) ? 'checked' : '' }} {{ ( $details->user[0]->pivot->primary || $details->user[0]->pivot->admin ) ? 'disabled' : '' }}> Billing Access
				<span class="help-block">Users with billing access may fund the member's CBA account by charging existing payment profiles and may add new payment profiles.</span>
			</label>
		</div>
	</div>
</div>

<!-- checkbox: can_pos_sell -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="can_pos_sell" id="can_pos_sell" value="1" {{ (  $details->user[0]->pivot->primary || $details->user[0]->pivot->admin || $details->user[0]->pivot->can_pos_sell ) ? 'checked' : '' }} {{ ( $details->user[0]->pivot->primary || $details->user[0]->pivot->admin ) ? 'disabled' : '' }}> Sales Access
				<span class="help-block">Users with sales access can accept bartercard sales on behalf of the member.</span>
			</label>
		</div>
	</div>
</div>

<!-- checkbox: can_pos_purchase -->
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
		<div class="checkbox">
			<label>
				<input type="checkbox" name="can_pos_purchase" id="can_pos_purchase" value="1" {{ ( $details->user[0]->pivot->primary || $details->user[0]->pivot->admin || $details->user[0]->pivot->can_pos_purchase ) ? 'checked' : '' }} {{ ( $details->user[0]->pivot->primary || $details->user[0]->pivot->admin ) ? 'disabled' : '' }}> Purchase Access
				<span class="help-block">Users with purchase access can make member-to-member barter purchases on behalf of the member.</span>
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	{{ Form::label('monthly_trade_limit', 'Monthly Trade Limit', ['class' => 'col-sm-3 col-md-4 col-lg-4 control-label']) }}
	<div class="input-group col-sm-5 col-md-4 col-lg-3">
		<span class="input-group-addon">$</span>
		{{ Form::text('monthly_trade_limit', (($details->user[0]->pivot->monthly_trade_limit)? $details->user[0]->pivot->monthly_trade_limit: '0.00'), ['class' => 'form-control']) }}
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
			$('#can_access_billing').prop('disabled', checkState).prop('checked', checkState);
			$('#can_pos_sell').prop('disabled', checkState).prop('checked', checkState);
			$('#can_pos_purchase').prop('disabled', checkState).prop('checked', checkState);
		}
	});
</script>
    
@endsection 