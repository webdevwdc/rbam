@extends('admin.layouts.base-2cols')
@section('title', 'Settings : Financial Details')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> Settings</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

<div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12">
						{{-- messages section start--}}
						@include('admin.includes.settings_tab')
						{{-- messages section end--}}
						    
						<h4>Cash Barter Account</h4>
					</div>	
				</div>	
	
				{!! Form::open(array('route'=>['admin_settings_store'], 'id'=>'', 'class'=>'form-validate','method'=>'post')) !!}				
				<div class="group_1">
				

					<div class="row">
						
<div class="col-md-8">						
<div class="form-group">
	{{ Form::label('minimum_cba_deposite', 'Minimum CBA Deposit', ['class' => 'col-sm-4 control-label']) }}
	<div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">$</span>
			    {{ Form::text('minimum_cba_deposite', $minimum_cba_deposite, ['class' => 'form-control', 'placeholder' => '(Example: 50.00 or 50)']) }}
		    </div> (eg: '50' or '50.0')
	    </div>
</div>
   
</div>
</div>
    
<div class="row">
	<div class="col-md-12">
		<h4>Default Barter Transaction Fees</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
    <!-- input: Member Purchase Fee -->
    <div class="form-group">
	    {{ Form::label('member_purchase_fee', 'Member Purchase Fee (%)', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('member_purchase_fee', $member_purchase_fee, ['class' => 'form-control', 'placeholder' => "(Example: '10' or '10.0')"]) }}
		    </div> (eg: '10' or '10.0')
	    </div>
    </div>
    
    <!-- input: Member Sale Fee -->
    <div class="form-group">
	    {{ Form::label('member_sale_fee', 'Member Sale Fee ', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('member_sale_fee', $member_sale_fee, ['class' => 'form-control', 'placeholder' => "(Example: '10' or '10.0')"]) }}
		    </div> (eg: '10' or '10.0')
	    </div>
    </div>
    
       
    </div>
</div>


<div class="row">
	<div class="col-md-12">
		<h4>Default Member Referral Commission Rates</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
    
    <div class="form-group">
	    {{ Form::label('member_referral_purchase_commission', 'Member Referral Purchase Commission', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('member_referral_purchase_commission', $member_referral_purchase_commission, ['class' => 'form-control', 'placeholder' => "(Example: '10' or '10.0')"]) }}
		    </div> (eg: '10' or '10.0')
	    </div>
    </div>
    
    <div class="form-group">
	    {{ Form::label('member_referral_sale_commission', 'Member Referral Sale Commission', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('member_referral_sale_commission', $member_referral_sale_commission, ['class' => 'form-control', 'placeholder' => "(Example: '10' or '10.0')"]) }}
		    </div> (eg: '10' or '10.0')
	    </div>
    </div>
	
    </div>
</div>						
					

<div class="row">
	<div class="col-md-12">
		<h4>Default Member Salesperson Commission Rates</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
	
	<div class="form-group">
	    {{ Form::label('member_salesperson_purchase_commission', 'Member Salesperson Purchase Commission', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('member_salesperson_purchase_commission', $member_salesperson_purchase_commission, ['class' => 'form-control', 'placeholder' => "(Example: '10' or '10.0')"]) }}
		    </div> (eg: '10' or '10.0')
	    </div>
	</div>    
	
	<div class="form-group">
	    {{ Form::label('member_salesperson_sale_commission', 'Member Salesperson Sale Commission', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('member_salesperson_sale_commission', $member_salesperson_sale_commission, ['class' => 'form-control', 'placeholder' => "(Example: '10' or '10.0')"]) }}
		    </div>(eg: '10' or '10.0')
	    </div>
	</div>
	    
	    
    </div>
</div>				
				

<div class="row">
	<div class="col-md-12">
		<h4>Giftcards</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
		    <div class="form-group">
			    {{ Form::label('default_giftcard_commission_rate', 'Default Giftcard Commission Rate', ['class' => 'col-sm-4 control-label']) }}
			    <div class="col-sm-3 col-md-3">
				    <div class="input-group">
					    <span class="input-group-addon">%</span>
					    {{ Form::text('default_giftcard_commission_rate', $default_giftcard_commission_rate, ['class' => 'form-control', 'placeholder' => "(Example: '10' or '10.0')"]) }} 
				    </div> (eg: '10' or '10.0')
			    </div>
		    </div>
	
            <div id="yes_create_new_user_wrap">
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9 col-md-offset-4 col-md-8">
						<div class="checkbox">
							<label>
							{{ Form::checkbox('exchange_uses_gift_cards', 1, $exchange_uses_gift_cards, ['id' => 'exchange_uses_gift_cards']) }} Generate random password and email to user
							</label>
						</div>
						    
						<div class="checkbox">
							<label>
							{{ Form::checkbox('new_member_acdept_gift_cards', 1, true, ['id' => 'new_member_acdept_gift_cards']) }} New members accept gift cards when created
							</label>
						</div>
					</div>
				</div>
	         </div>
    </div>
</div>
    <div class="row"></div>
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_setting_finance') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
			</div>

                </div>
            </div>
      </div>
</div>
    
   
@endsection 