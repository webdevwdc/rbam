<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <meta charset="UTF-8" />
    <script src="https://cdn.worldpay.com/v1/worldpay.js"></script>
  </head>
  <body>
    <form action="http://buzzb2b.dedicatedresource.net/charge" id="paymentForm" method="post">
        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token" id="csrf_token">
      
      <span id="paymentErrors"></span>

      <div class="form-row">
        <label>Name on Card</label>
        <input data-worldpay="name" name="name" type="text" />
      </div>
      <div class="form-row">
        <label>Card Number</label>
        <input data-worldpay="number" size="20" type="text" />
      </div>
      <div class="form-row">
        <label>Expiration (MM/YYYY)</label>
        <input data-worldpay="exp-month" size="2" type="text" />
        <label> / </label>
        <input data-worldpay="exp-year" size="4" type="text" />
      </div>
      <div class="form-row">
        <label>CVC</label>
        <input data-worldpay="cvc" size="4" type="text" />
      </div>

      <input type="submit" value="Place Order" />

    </form>

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
    </script>
  </body>
</html>