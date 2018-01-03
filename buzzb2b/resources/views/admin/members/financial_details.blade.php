@extends('admin.layouts.base-2cols')
@section('title', 'Financial Details')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : Finance Details</h3>
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
			</div>

<div class="col-md-12 col-xs-12">
	<div class="row">
		<div class="col-md-12">
		</div>	
	</div>	
	
{!! Form::open(array('route'=>['admin-user-update-financial-details', $member->id], 'id'=>'', 'class'=>'form-validate_','method'=>'post')) !!}			
@if(!empty($member))
{{ Form::model($member) }}
@endif
<div class="group_1">
								    
<div class="row">
						

</div>
    
<div class="row">
	<div class="col-md-12">
		<h4>Member Credit</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
    <!-- input: ex_purchase_comm_rate (defaults to exchange default) -->
    <div class="form-group">
	    {{ Form::label('ex_purchase_comm_rate', 'Credit Limit', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-5">
		    <div class="input-group">
			    
			    {{ Form::text('credit_limit', null, ['class' => 'form-control']) }}
		    </div>
	    </div>
    </div>
       
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<h4>Exchange Fees</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
    <div class="form-group">
    	 {{ Form::label('ex_purchase_comm_rate', 'Barter Purchase Fee', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-5">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('ex_purchase_comm_rate', null, ['class' => 'form-control']) }}
		    </div>
	    </div>
    </div>
       
    </div>
</div>

<div class="col-md-8">
    <div class="row">
    <div class="form-group">
    	 {{ Form::label('ex_purchase_comm_rate', 'Barter Sale Fee', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-5">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('ex_sale_comm_rate', null, ['class' => 'form-control']) }}
		    </div>
	    </div>
    </div>
       
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<h4>Member Referral</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
    <div class="form-group">
    	 {{ Form::label('ex_purchase_comm_rate', 'Referring Member', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-5">
		    <div class="input-group">
			   
			    {{ Form::select('ref_member_id',$refsSelectionList,null, ['class' => 'form-control reffering','placeholder'=>'Select a refferal member']) }}
			  
		    </div>
	    </div>
    </div>
       
    </div>
</div>

<div class="col-md-8">
    <div class="row">
    <div class="form-group">
    	 {{ Form::label('ex_purchase_comm_rate', 'Referred Purchase Commission ', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-5">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('ref_purchase_comm_rate', null, ['class' => 'form-control purchase_comm','disabled'=>true]) }}
		    </div>
	    </div>
    </div>
       
    </div>
</div>

<div class="col-md-8">
    <div class="row">
    <div class="form-group">
    	 {{ Form::label('ex_purchase_comm_rate', 'Referred Sale Commission', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-5">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('ref_sale_comm_rate', null, ['class' => 'form-control purchase_comm','disabled'=>true]) }}
		    </div>
	    </div>
    </div>
       
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<h4>Exchange Salesperson</h4>
	</div>	
</div>	
<div class="col-md-8">
    <div class="row">
    <div class="form-group">
    	 {{ Form::label('ex_purchase_comm_rate', 'Exchange Salesperson Member', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-5">
		    <div class="input-group">
			    {{ Form::select('salesperson_member_id',$salespersonSelectionList,null, ['class' => 'form-control sales']) }}
		    </div>
	    </div>
    </div>
       
    </div>
</div>

<div class="col-md-8">
    <div class="row">
    <div class="form-group">
    	 {{ Form::label('ex_purchase_comm_rate', 'Salesperson Purchase Commission', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-5">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('sales_purchase_comm_rate',null, ['class' => 'form-control purchase','disabled'=>'true']) }}
		    </div>
	    </div>
    </div>
       
    </div>
</div>

<div class="col-md-8">
    <div class="row">
    <div class="form-group">
    	 {{ Form::label('ex_purchase_comm_rate', 'Salesperson Sale Commission', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-5">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('sales_sale_comm_rate',null, ['class' => 'form-control purchase','disabled'=>'true']) }}
		    </div>
	    </div>
    </div>
       
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<h4>Exchange Giftcards</h4>
	</div>	
</div>
<!-- checkbox: is_prospect -->
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<div class="checkbox">
			<label>
			{{ Form::checkbox('accept_giftcards', 1, null, ['class' => 'field']) }} This member accepts giftcards
			</label>
		</div>
	</div>
</div>
<div class="col-md-8">
    <div class="row">
    <!-- input: ex_purchase_comm_rate (defaults to exchange default) -->
    <div class="form-group">
	    {{ Form::label('ex_purchase_comm_rate', 'Giftcard Sale Commission Rate', ['class' => 'col-sm-4 control-label']) }}
	    <div class="col-sm-3 col-md-3">
		    <div class="input-group">
			    <span class="input-group-addon">%</span>
			    {{ Form::text('giftcard_comm_rate', null, ['class' => 'form-control']) }}
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
<!-- code for exchange sales person select list -->
<script>
$(document).ready(function(){
	$('.sales').change(function(){
	var sales = $(this).val();
		if(sales!=0){
		$('.purchase').removeAttr("disabled");	
		}else{
		$('.purchase').attr("disabled",'disabled');		
		}
	});
       var sales = $('.sales').val();
		if(sales!=0){
		$('.purchase').removeAttr("disabled");
		}else{
		$('.purchase').attr("disabled",'disabled');
		}
});
</script>

<!-- code for Referring Member drop down list -->
<script type="text/javascript">
$(document).ready(function(){
	$('.reffering').change(function(){
		var refferal = $(this).val();
		if(refferal!=0){
			$('.purchase_comm').removeAttr("disabled");
		}else{
			$('.purchase_comm').attr("disabled",'disabled');
		}
	});

	    var refferal = $('.reffering').val();
		if(refferal!=0){
		$('.purchase_comm').removeAttr("disabled");
		}else{
		$('.purchase_comm').attr("disabled",'disabled');
		}

});
</script>
@endsection
