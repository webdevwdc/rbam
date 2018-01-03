$(document).ready(function(){
    
	// vh support
	var detect_cssVhVwSupport = function(hw){
			var dv = document.createElement("div");
			var div = document.body.appendChild(dv);
			var dm = (hw =="vw"?"width":"height");
			var wm = (hw=="vw"?"innerWidth":"innerHeight");
				div.style[dm] = "100"+hw;
				var elem_dm = parseInt(getComputedStyle(div, null)[dm],10);
				var win_dm = window[wm];
				dv.parentNode.removeChild( dv );
				if((!!elem_dm ==false ) && elem_dm!= win_dm){
					return false;
				}else{
					return true;
				};
		};

		if(detect_cssVhVwSupport("vh")===false){
			$(".login_main").height($(window).innerHeight());
		};
//	$('#time').datetimepicker({
//        format: 'HH:mm:ss'
//    });
	
    	$(".form-validate").validate({
            rules: {
	      password_confirmation: {
		  required: true,
		  equalTo: "#password"
              }
            }
        });
	
	$("#country_id").change(function(){
		var countryId = $(this).val();
		
		$.ajax({
			url: BASE_URL+'golfcourse/get_province',
			type: 'POST',
			data:{"_token":CSRF_TOKEN, "country_id":countryId},
			success : function(response){
				if(response) {
					$("#state_province_id").html(response);
				}else{
					$("#state_province_id").html('<option value="" selected="selected">Select Province</option>');
				}
			}
		});
		
	});
	$("#state_province_id").change(function(){
		var province_id = $(this).val();
		
		$.ajax({
			url: BASE_URL+'golfcourse/get_destination',
			type: 'POST',
			data:{"_token":CSRF_TOKEN, "state_province_id":province_id},
			success : function(response){
				
				if(response) {
					$("#destination_id").html(response);
				}else{
					$("#destination_id").html('<option value="" selected="selected">Select Destination</option>');
				}
			}
		});
		
	});
	$("#user_email_address").blur(function(){
		var userEmail = $(this).val();
		$.ajax({
			url: BASE_URL+'user/check_user_email',
			type: 'POST',
			data:{"_token":CSRF_TOKEN, "user_email":userEmail},
			success : function(response){
				if(response == 1) {
					alert('Email is already exist, please choose another email.');
					$("#user_email_address").val('');
				}
			}
		});
	});
	
	
	$("#change_password").validate({
        rules: {
            old_password:{
                required: true,
                minlength: 6
            },
            new_password: {
					required: true,
					minlength: 6
				},
            confirm_password: {
					required: true,
					minlength: 6,
					equalTo: "#new_password"
				},
        },
        messages: {
            old_password:{
                required: "Please provide your old password",
                minlength: "Your password must be at least 6 characters long"
            },
            new_password: {
					required: "Please provide a new password",
					minlength: "Your password must be at least 6 characters long"
				},
				confirm_password: {
					required: "Please confirm your new password",
					minlength: "Your password must be at least 6 characters long",
					equalTo: "Please enter the same password as above"
				}
        }
        
    });
        
    $(".issue_bartercard").click(function(){
        $('#member_id').val('');
        $('#user_id').val('');
        $('#barter_card').val('');
        $("#msg-section").html('');
        memberid = $(this).attr('data-member-id');
        userid = $(this).attr('data-user-id');
        $('#member_id').val(memberid);
        $('#user_id').val(userid);
        $("#issuebartercard").modal('show');
    });
    
    $('#btn_issue_bartercard').click(function(){
        memberid = $('#member_id').val();
        userid = $('#user_id').val();
        bartercard = $('#barter_card').val();
        $.ajax({
                url: BASE_URL+'issue-bartercard',
                type: 'POST',
                data:{"_token":CSRF_TOKEN, "member_id":memberid, "user_id":userid, "barter_card":bartercard},
                success : function(response){  
                        if(response==1) { 
                        	$("#issuebartercard").modal('hide');
                        	window.location.reload(true);
                        }else if(response==2){
                                $("#msg-section").html('<div style="color:red">Please enter a card number</div>');
                        }else{
                        		$("#msg-section").html('<div style="color:red">Invalid Card number</div>');
                        }
                }
        });        
        
    });
        
});