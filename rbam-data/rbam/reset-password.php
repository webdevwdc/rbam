<?php ob_start ();
session_start();
  include("conn.php");
  include ("find.php");
  
  
  
if(!isset($_SESSION['reset-password']) || !isset($_SESSION['user-email']) || (isset($_SESSION['reset-password']) && $_SESSION['reset-password']!='Y') || ((isset($_SESSION['user-email']) && $_SESSION['user-email']==''))){
   
    header('location:index.php');
}
?>

<?php

if(isset($_POST['resetPsw']) && $_POST['resetPsw']=='reset' ){

    $username=isset($_POST['username']) ? $_POST['username'] :'';
    $new_password=isset($_POST['new_password']) ? $_POST['new_password'] :'';
    $conf_password=isset($_POST['conf_password']) ? $_POST['conf_password'] :'';
    


    if(empty($new_password) || empty($conf_password)){

        $error="Password and confirm password required.";
    }
    else if($new_password!=$conf_password)
    {
	   $error="Please enter same password on confirm password.";
    }
    else
    {

	   $sql_upd="update cxs_users
	   set
		  ENC_KEY='".GetPassword($new_password)."',
		  PSW_RESET_DATE='".date("Y-m-d")."',
		  TEMP_PASSWORD='N'
	   where
		  USER_NAME='".$username."'";
		  
        mysql_query($sql_upd);
	   
	   
	   
	   $qry="SELECT * FROM cxs_users where USER_NAME='".$username."'";

        $result = mysql_query($qry) or die(mysql_error($conn));
    
        $row_num = mysql_num_rows($result);

        if($row_num>0){
        
                
            $user_arr = mysql_fetch_array($result);

		  
                $_SESSION['user_data']=$user_arr;
                $_SESSION['user_id'] = $user_arr['USER_ID'];
			 
			 unset($_SESSION['reset-password']);
			 unset($_SESSION['user-email']);
                  
                
                header('location:index.php');
                
            

	   }
     
    }
}
?>   



<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  
  
  <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>

      <link rel="stylesheet" href="css/login_style.css">
   <!--<script src="js1/jquery.js"></script>-->
   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
	   $('#new_password,#conf_password').keypress(function(e) {

		  if ((e.which >= 33 && e.which<=45) || (e.which >= 47 && e.which<=126) || e.which==8 || e.which==0) {
			 return true;
		  }
		  else{
			 return false;
		  }
	   });
	   $('#new_password').keyup(function() {
		  
		  checkPasswordError($(this).val(),$("#reset_psw_err_tooltip"),$("#resetPsw"));
	   });
    });
    function checkPasswordError(password,ele_error_tooltip,btn_submit_ele)
{
    
	   ele_error_tooltip.empty();
	   
	   var valid_frm = 'Y';
	   
	   var minPswLength = <?php echo getSettingVal('MINIMUM_ALLOWED'); ?>;
	   
	   var oneCapLtr = new RegExp('(?=.*[A-Z])');
	   var oneLowrLtr = new RegExp('(?=.*[a-z])');
	   var oneDigit = new RegExp('(?=.*\d)');
	   var oneSplChar = /[!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]/;
	   
	   
	   <?php if(getSettingVal('ALLOW_NUMERIC')=='Y'){ ?>
	   if (password.search(/\d/) == -1) {
			 ele_error_tooltip.append('<span>* The new password must have at least one Numeric Value.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_UPPERCASE')=='Y'){ ?>
	   if (!oneCapLtr.test(password)) {
			 ele_error_tooltip.append('<span>* The new password must have at least one uppercase character.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_LOWERCASE')=='Y'){ ?>
	   if (!oneLowrLtr.test(password)) {
			 ele_error_tooltip.append('<span>* The new password must have at least one lowercase character.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_SPECIALS')=='Y'){ ?>
	   if (!oneSplChar.test(password)) {
			 ele_error_tooltip.append('<span>* The new password must have at least one special character: \':;/?.>,<`~@#$%^&*()_+=-][{}\|</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   if (password.length<minPswLength) {
			 			 
			 ele_error_tooltip.append('<span>* The New Password should contain atleast '+minPswLength+' characters.</span>');
			 valid_frm = 'N';
	   }
	   if (password.length>240) {
			 			 
			 ele_error_tooltip.append('<span>* The New Password should contain maximum 240 characters.</span>');
			 valid_frm = 'N';
	   }
	   <?php if(getSettingVal('ENABLE_COMMON')=='Y'){ ?>
	   comparePswdWithCommonWords(password,$("#reset_psw_used_common_word"));
	   if ($("#reset_psw_used_common_word").val() >= 1) {
			 ele_error_tooltip.append('<span>* You have entered a password that is a very commonly or known word, consecutive alphabets or with consecutive numbers. This is not allowed. Please try different combination that is not common.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   
	   if (valid_frm=='Y') {
			 btn_submit_ele.attr('disabled',false);
	   }
	   else
	   {
			 btn_submit_ele.attr('disabled',true);
	   }
	   	   
}
function comparePswdWithCommonWords(pwd,ele_psw_used_cmn_wrd){
	   
	   var form_data = new FormData();
	   form_data.append("psword", pwd);
	   
	   jQuery.ajax({
			url: "ajax-functions/comparePswdWithCommonWords.php", // point to server-side PHP script 
			dataType: 'text', // what to expect back from the PHP script
			cache: false,
			contentType: false,
			processData: false,
			async: false,
			data: form_data,
			type: 'POST',
			success: function (response) {
				ele_psw_used_cmn_wrd.val(response);
			},
			error: function (response) {
				//$('#fileMsg').html(response); // display error response from the PHP script
			}
	   });
}
function resetPasswordFormValidation()
{
	   var valid_frm = 'Y';
	   
	   var minPswLength = <?php echo getSettingVal('MINIMUM_ALLOWED'); ?>;
	   
	   var oneCapLtr = new RegExp('(?=.*[A-Z])');
	   var oneLowrLtr = new RegExp('(?=.*[a-z])');
	   var oneDigit = new RegExp('(?=.*\d)');
	   var oneSplChar = /[!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]/;
	   
	   var new_Password = $("#new_password");
	   var reentered_Password = $("#conf_password");
	   
	   if ($.trim(new_Password.val())!='') {
			 comparePswdWithCommonWords($.trim(new_Password.val()),$("#reset_psw_used_common_word"));
	   }	   
	   
	   if ($.trim(new_Password.val())=='') {
			 form_element_correct(new_Password);
			 form_element_empty_err(new_Password);
			 valid_frm = 'N';
	   }
	   else if ($.trim(new_Password.val()).length<minPswLength) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The New Password should contain atleast '+minPswLength+' characters.</span>');
			 valid_frm = 'N';
	   }
	   <?php if(getSettingVal('ALLOW_SPECIALS')=='Y'){ ?>
	   else if (!oneSplChar.test($.trim(new_Password.val()))) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The new password must have at least one special character: \':;/?.>,<`~@#$%^&*()_+=-][{}\|"</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_UPPERCASE')=='Y'){ ?>
	   else if (!oneCapLtr.test($.trim(new_Password.val()))) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The new password must have at least one uppercase character.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_LOWERCASE')=='Y'){ ?>
	   else if (!oneLowrLtr.test($.trim(new_Password.val()))) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The new password must have at least one lowercase character.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_NUMERIC')=='Y'){ ?>
	   else if ($.trim(new_Password.val()).search(/\d/) == -1) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The new password must have at least one Numeric Value.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ENABLE_COMMON')=='Y'){ ?>
	   else if ($("#reset_psw_used_common_word").val() >= 1) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">You have entered a password that is a very commonly or known word, consecutive alphabets or with consecutive numbers. This is not allowed. Please try different combination that is not common.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   else
	   {
			 form_element_correct(new_Password);
	   }
			 
	   if ($.trim(reentered_Password.val())==''){
			 form_element_correct(reentered_Password);
			 form_element_empty_err(reentered_Password);
			 valid_frm = 'N';
	   }
	   else
	   {
			 form_element_correct(reentered_Password);
	   }
	   
	   if ($.trim(new_Password.val())!='' && $.trim(reentered_Password.val())!='' && ($.trim(new_Password.val())!=$.trim(reentered_Password.val()))){
			 form_element_correct(reentered_Password);
			 reentered_Password.addClass('error_ele');
			 reentered_Password.after('<span role="alert" class="not-valid-tip">Password not matched.</span>');
			 valid_frm = 'N';
	   }
	   else if ($.trim(new_Password.val())!='' && $.trim(reentered_Password.val())!='') {
			
			 form_element_correct(reentered_Password);
	   }
	   
	   if (valid_frm == 'Y') {
			 return true;
	   }
	   else
	   {
			 return false;
	   }
}
function form_element_empty_err(element)
{
    element.addClass('error_ele');
    element.after('<span role="alert" class="not-valid-tip">The field is required.</span>');
}
function form_element_valid_err(element)
{
    element.addClass('error_ele');
    element.after('<span role="alert" class="not-valid-tip">The field is not valid.</span>');
}
function form_element_correct(element)
{
    element.removeClass('error_ele');
    element.next('span.not-valid-tip').remove();
    //element.nextAll().remove();
}
  </script>
  <style>
.not-valid-tip{ color: #ff0000; }
.error_ele{margin-bottom: 5px;}
#new_psw_err_tooltip,#reset_psw_err_tooltip { position: absolute; z-index: 999; background: #ededed; }
#new_psw_err_tooltip span,#reset_psw_err_tooltip span{ display: block; padding: 12px 12px 0 12px; }
#new_psw_err_tooltip span:last-child,#reset_psw_err_tooltip span:last-child{ padding-bottom: 26px; }
#new_psw_err_tooltip br,#reset_psw_err_tooltip br{ height: 10px; }
  </style>
</head>

<body>

    <div class="wrapper">
    <form class="form-signin" method='post' action='' style="max-width: 675px;" onsubmit="return resetPasswordFormValidation()">
	   <input type="hidden" id="reset_psw_used_common_word" name="reset_psw_used_common_word" value="0">
      <div class='row' > <img style='margin-right:-20px;' class='pull-right' src="img/main_logo.png" /> </div>
	  <div class="row">
	   <div class="col-sm-12">
      <h2 class="form-signin-heading" >Reset your password</h2>
	   </div>
      <input type="hidden" class="form-control" name="username" value="<?php echo $_SESSION['user-email']; ?>" />
	 <div class="col-sm-12 form-group">
      <input type="password" class="form-control" value="" id="new_password" name="new_password"  placeholder="New Password"/>
	 <span id="reset_psw_err_tooltip" style="color: #ff0000;"></span>
	   <span id="CurrentUserId" style = " visibility: hidden;"></span>
	   <span id="CurrentUserPswRule"  style = " visibility: hidden;"></span>
	 </div>
	 <div class="col-sm-12 form-group">
      <input type="password" class="form-control" value="" id="conf_password" name="conf_password"  placeholder="Confirm Password"/>
	 </div>
	 </div>
      <?php if(isset($error)){ ?>
        <p align='center' class='text-danger'><?php //echo $error; ?></p> 
      <?php } ?>
     
      
      <button class="btn btn-lg btn-primary btn-block" id="resetPsw" name='resetPsw' value='reset' type="submit" disabled="disabled">Reset Password</button> 
      
    </form>

  

  </div>
    
  <script src="js/jquery.min.js"></script>

</body>

</html>

