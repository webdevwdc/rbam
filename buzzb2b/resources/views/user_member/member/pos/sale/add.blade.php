@extends('user_member.member.pos.layouts.base-2cols')
@section('title', 'Make a sale')
@section('content')
<style type="text/css">
	.kbw-signature { width: 400px; height: 200px; }
</style>
<div class="container-fluid">
				
				<div class="row not-fadered" id="panel-post-purchase">
					
					<div id="panel-post-purchase-form">

						
						{!! Form::open(['route' => 'save-member-bartercard','method'=>'post','id'=>'sale-form']) !!}
					    <input type="hidden" name="_token" value="{{csrf_token()}}">


						<div class="test" >
						<h4>Make a sale to :</h4>
						<div class="row top-sec">
							<div class="col-xs-2">
								<img style="width:100%;" src="http://buzzb2b.dedicatedresource.net/jacopo_admin/images/avatar.png"/>
							</div>
							<div class="col-xs-8">	
								{{$details->membername}}
								<input type="hidden" name="member_id" value="{{$details->memberid}}">
								{{$details->exchange_name}}
							</div>
						</div>
							
							<!-- input: barter_amount -->
							<div class="form-group" id="form-group-barter-amount">
								<div class="input-group clearfix">
									<span class="input-group-addon"><strong>BARTER</strong>&nbsp;&nbsp;$</span>
									<input class="form-control input-lg" class="barter_amount" id="barter_amount" step="any" min="0" name="barter_amount" type="number">
								</div>
							</div>

							<!-- input: tip_amount -->
							<div class="form-group" id="form-group-tip-amount">
								<div class="input-group clearfix">
									<span class="input-group-addon"><strong>TIP</strong>&nbsp;&nbsp;$</span>
									<input class="form-control input-lg" id="tip_amount" step="any" min="0" name="tip_amount" type="number">
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
					               <input id="submit-post-sale" class="btn btn-primary btn-lg btn-block btn-submit-form  sale" value="Post Sale" type="button">
								</div> 	
							</div>
						</div>

					<input type="hidden" name="form_post" value="1">
					{!! Form::close() !!}
				</div> 
						
				</div> 
				<div id="test kbw-signature"></div>
				

			</div>

		<script type="text/javascript">
			$(document).ready(function(){
				$('.sale').click(function(){
					var barter_amount = $('#barter_amount').val();
					
                  if(barter_amount==''){
                    $('#barter_amount').css('border-color','red');
                  }else{
                  	$('#sale-form').submit();
                  }
               
				});

				$('.barter_amount').keypress(function(e){
	              if(e.which ==1){
	                  $(this).css('background-color','#FFF');
	              }
	            });
			})
		</script>

@endsection