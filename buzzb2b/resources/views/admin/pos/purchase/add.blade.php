@extends('admin.pos.layouts.base-2cols')
@section('title', 'Make a purchase')
<style type="text/css">
	.purchase{
		height: 39px!important;
	}
</style>
@section('content')
        {{-- messages section start--}}
          @include('admin.pos.includes.messages')
	    {{-- messages section end--}}
	    <div class="hide_purchase">  
	            <div >
                  <span class="barter_amount_blank alert alert-danger" style=" display:none;">The barter amount field is required.</span><br>
                  <span class="member_slug_blank alert alert-danger" style=" display:none;">The merchant member slug field is required.</span><br>
                </div>
            <div class="container-fluid">
				
				<div class="row not-fadered" id="panel-post-purchase">
					
					<div id="panel-post-purchase-form">

						{!! Form::open(['url' => '#']) !!}
						<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
						<div class="test">
						<h1><a href="#">Point of sale</a> &gt; Purchase</h1>
						<h4>Select a Member to purchase from:</h4>
							<div class="form-group" id="form-group-merchant-member-slug">
							   <div class="input-group clearfix">
								{{ Form::select('merchant_member_slug',$members, null, ['class' => 'form-control full-width member_list ','placeholder'=>'None']) }}
							   </div>
							</div>
						
							
							<!-- input: barter_amount -->
							<div class="form-group" id="form-group-barter-amount">
								<div class="input-group clearfix">
									<span class="input-group-addon"><strong>Barter</strong>&nbsp;&nbsp;$</span>
									<input class="form-control input-lg" id="barter_amount" step="any" min="0" name="barter_amount" type="number">
								</div>
							</div>

							<!-- input: tip_amount -->
							<div class="form-group" id="form-group-tip-amount">
								<div class="input-group clearfix">
									<span class="input-group-addon"><strong>Tip</strong>&nbsp;&nbsp;$</span>
									<input class="form-control input-lg tip" id="tip_amount" step="any" min="0" name="tip_amount" type="number">
								</div>
							</div>

							
							<div class="form-group" id="form-group-notes">
								<div class="input-group clearfix">
									<span class="input-group-addon"><strong>MEMO</strong></span>
									<input class="form-control input-lg" id="notes" name="notes" type="text">
								</div>
							</div>

							



							<div class="form-group">
								<div class=" not-fadered">
									<input id="submit-post-purchase" class=" btn-success btn-lg btn-block btn-submit-form admin_purchase" value="Post Purchase" type="button">
								</div> 	
							</div>
						</div>
						

					{!! Form::close() !!}
				</div> 
						
				</div> 
				</div>
			</div>

			<!-- purchase confiramtion section start -->
				<div class="show_purchase_confirmation" style="display:none;">
			 	  <h4>Approved</h4> <span class="confirmation">Confirmation #1111</span>
					You have made purchase <span class="confirmation_message"> from  </span> and will recieve a confirmation email shortly.
					<h4>
					Barter: T$ <span class="tip_barter_value"></span><br>
					Tip: T$ <span class="tip_amount_value"></span>
					</h4>
					<div>
						<div class="col-md-6">
						        <a href="{{route('pos-purchase')}}" class="btn btn-default btn-lg btn-block" style="margin-top:30px; height: 44px;">
								     Make A Purchase
					            </a>	
						</div>

						<div class="col-md-6">
							 <a href="{{route('admin_dashboard')}}" class="btn btn-default btn-lg btn-block" style="margin-top:30px; height: 44px;">
								Go To Dashboard
					        </a>
						</div>
		
	                </div>
		        </div>

			<script type="text/javascript">
				$(document).ready(function(){
				$('.admin_purchase').click(function(){
		              var barter_amount = $('#barter_amount').val();
		              var member_slug = $('.member_list').val();
		              var tip = $('#tip_amount').val();
		              var memo = $('.memo').val();
		               if (barter_amount=='') {
	                     $('.barter_amount_blank').css('display','block');
		               }else{
		               	$('.barter_amount_blank').css('display','none');
		               }
		              if (member_slug=='') {
	                     $('.member_slug_blank').css('display','block');
		               }else{
		               	$('.member_slug_blank').css('display','none');
		               }
		             if(barter_amount > 0 && member_slug >0 ){
	                      $.ajax({
	                       	type:'POST',
	                       	url:'{{route('save-pos-purchase')}}',
	                       	data:{'barter_amount':barter_amount,'merchant_member_slug':member_slug,'tip_amount':tip,'notes':memo,'_token':$('#token').val()},
	                       	beforeSend: function() {
				              $(".loader").show();
				            },
	                       	success:function(data){
	                       		if(data){
	                       		 $('.confirmation').html('Confirmation #'+data.transactions);
	                       		 $('.confirmation_message').html('from '+data.name);
	                       		 $('.hide_purchase').css('display','none');
	                       		 $('.show_purchase_confirmation').css('display','block');
	                       		 $('.tip_amount_value').text(data.tip);
	                       		 $('.tip_barter_value').text(data.barter);
	                       		 $(".loader").hide();
	                       		}
	                       	}
	                       });
		             }
				});
			});		
			</script>
@endsection