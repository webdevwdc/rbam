$(document).ready(function(){
	// loadTimePicker();
	var counter = 0;
	function createHtml()
	{


		var html = '';
		html+= '<div class="row">';
		html+= '					<div class="col-md-2">';
		html+= '							<div class="form-group">';

		html+= '								<input class="form-control required basicExample" id="" placeholder="Start Time" name="start_time[]" type="text" value=""> <input name="id[]" type="hidden" value="">';
		html+= '							</div>';
		html+= '						</div>';

		html+= '						<div class="col-md-2">'
		html+= '							<div class="form-group">';
		html+= '																<input class="form-control required golferscls" id="" placeholder="Golfers" name="golfers[]" type="text" value="">';
		html+= '							</div>';
		html+= '						</div>';
		html+= '						<div class="col-md-2">';		
		html+= '							<div class="form-group">';
		html+= '																<input class="form-control required pricecls" id="price'+counter+'" placeholder="Price" name="price[]" type="text" value="">';
		html+= '							</div>';
		html+= '						</div>';
		html+= '						<div class="col-md-1">';
		html+= '							<div class="form-group">';
		html+= '																<input class="field checkboxdeal" id="checkboxdeal'+counter+'" data-val = "'+counter+'" name="agree" type="checkbox" value="1">';
		html+= '							</div>';
		html+= '						</div>';
		html+= '						<div class="col-md-2">';		
		html+= '							<div class="form-group">';
		html+= '																<input class="form-control required dealpricecls" id="deal_price'+counter+'" placeholder="Deal Price" name="deal_price[]" type="text" value="">';
		html+= '							</div>';
		html+= '						</div>';

		html+= '						<div class="col-md-2">';
		html+= '							<div class="form-group">';
		html+= '																<select class="form-control required statuscls" id="status" name="status[]"><option value="" selected="selected">Select</option><option value="Active">Active</option><option value="Inactive" >Inactive</option></select>';
		html+= '							</div>';
		html+= '						</div>';

		html+= '						<div class="col-md-1">';
		html+= '							<div class="form-group">';
		html+= '								<button class="btn removebtn" data-counter="'+counter+'" type="button">Remove</button>';
		html+= '							</div>';
		html+= '						</div>';
		html+= '					</div>';

		return html;
	}

	$('.addmorebtn').click(function(){

		counter = counter + 1;
		var addHtml = createHtml(counter);

		$('.addmorediv').append("<div id='countdiv"+counter+"'>"+addHtml+"</div>");
		loadTimePicker();
	});

	$(document).on("click", ".removebtn", function(){

		$("#countdiv" + $(this).attr('data-counter')).remove();

	});


	$(document).on("click", ".deletebtn", function(){
		var rr = confirm("Are you sure ?");
		if (rr == true) {
			var divrow = ".divrow"+$(this).data('delid');
			var dltId = $(this).data('delid');

			$.ajax({
				url: BASE_URL+'golfcourse/golf_delete',
				type: 'POST',
				data: {"_token":CSRF_TOKEN,"dltId": dltId},
				success : function(response)
				{

					var data = $.parseJSON(response);

					if (data.result == true) {
						$(divrow).html('');
					}else{
						alert("Sorry you can not be delete thid record.");
					}

				}
			}); 
		}

	});	


	$( "#golf_tee_time_store" ).submit(function( event ) {
		var timearry = [];
		var submitflag = [];
		$('#messagesshowdiv').html('');
		
		$('.basicExample').each(function(){
			var str = $(this).val();
			if(jQuery.inArray( $(this).val(), timearry )!== -1){
				submitflag.push('false');
			}else if(str.trim() === ''){
				submitflag.push('false1');
			}else{
				timearry.push($(this).val());
				submitflag.push('true');
			}
		});
		$('.golferscls').each(function(){
			var str = $(this).val();
			if(str.trim() === ''){
				submitflag.push('false2');
			}
		});		
		$('.pricecls').each(function(){
			var str = $(this).val();
			if(str.trim() === ''){
				submitflag.push('false3');
			}
		});
		$('.dealpricecls').each(function(){
			var str = $(this).val();
			if(str.trim() === ''){
				submitflag.push('false4');
			}
		});
		$('.statuscls').each(function(){
			var str = $(this).val();
			if(str.trim() === ''){
				submitflag.push('false5');
			}
		});		
		
		
		
		if(jQuery.inArray( 'false', submitflag )!== -1){
			$('.custmsg').html('Start Time can not be same');
			$('.starttimediv').show();
			return false;
		}else if (jQuery.inArray( 'false1', submitflag )!== -1) {
			$('.custmsg').html('Start Time field can not be blank');
			$('.starttimediv').show();
			return false;
		}else if (jQuery.inArray( 'false2', submitflag )!== -1) {
			$('.custmsg').html('Golfers field can not be blank');
			$('.starttimediv').show();
			return false;
		}else if (jQuery.inArray( 'false3', submitflag )!== -1) {
			$('.custmsg').html('Price field can not be blank');
			$('.starttimediv').show();
			return false;
		}else if (jQuery.inArray( 'false4', submitflag )!== -1) {
			$('.custmsg').html('Deal Price field can not be blank');
			$('.starttimediv').show();
			return false;
		}else if (jQuery.inArray( 'false5', submitflag )!== -1) {
			$('.custmsg').html('Status field can not be blank');
			$('.starttimediv').show();
			return false;
		}
		else{
			$('.starttimediv').hide();
			return true;
		}
	});

});


$(document).on("click", "input[type=checkbox]", function(){
//alert($(this).data('val'));
if ( this.checked ) {
	var counter = $(this).data('val');
	$('#deal_price'+counter).val($('#price'+counter).val());
	$('#dealpriceid'+counter).val($('#priceid'+counter).val());
}else{
	var counter = $(this).data('val');
	$('#deal_price'+counter).val("");
	$('#dealpriceid'+counter).val("");
}
});

/*function loadTimePicker() {
		$('.basicExample').timepicker();
	}*/
