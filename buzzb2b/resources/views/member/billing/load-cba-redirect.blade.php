@extends('member.layouts.base-2cols')
@section('content')
<style>
	.loaderdiv{
		display:block;
	}
</style>	
{!! Form::open(array('route'=>'member-load-cba-insert', 'id'=>'paymentForm', 'method'=>'post')) !!}
        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token" id="csrf_token">
      
      <span id="paymentErrors"></span>

      <div class="form-row">
        <input data-worldpay="name" name="name" type="hidden" value="{{ $record->first_name }} {{ $record->last_name }}" />
      </div>
      <div class="form-row">
        <input data-worldpay="number" size="20" type="hidden" value="{{ \Crypt::decryptString($record->credit_card) }}" />
      </div>
      <div class="form-row">
        <input data-worldpay="exp-month" size="2" type="hidden" value="{{ $record->expiry_month }}" />
        <input data-worldpay="exp-year" size="4" type="hidden" value="{{ $record->expiry_year }}"/>
      </div>
      <div class="form-row">
        <input data-worldpay="cvc" size="4" type="hidden" value="{{ $record->cvv }}"/>
      </div>

     <input type="hidden" value="{{ $deposit_amount }}" name="deposit_amount">
	<input type="hidden" value="{{ $profile_id }}" name="profile_id">
      <!-- <input type="submit" value="Place Order" id="submitworldpay" style="display:none"/> -->
     
{!! Form::close() !!}
	

	
@endsection

@section('footer_scripts')
    <script type="text/javascript">
      var form = document.getElementById('paymentForm');

      Worldpay.useOwnForm({
        'clientKey': 'T_C_964f7ad5-7502-47c3-910a-499aee2fa9a1',
        'form': form,
        'reusable': false,
        'callback': function(status, response) {
          document.getElementById('paymentErrors').innerHTML = '';
          if (response.error) {             
            Worldpay.handleError(form, document.getElementById('paymentErrors'), response.error); 
          } else {
            var token = response.token;
            Worldpay.formBuilder(form, 'input', 'hidden', 'token', token);
            form.submit();
          }
        }
      });
	
	$(document).ready(function(){

	   //setTimeout(function(){
	      // $('#submitworldpay').trigger('click');
		//document.getElementById("paymentForm").submit();
	//}, 9000);

    $('#paymentForm').submit();
	});

	 
	 
    </script>	
@endsection