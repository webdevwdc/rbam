<?php ob_start ();
session_start();
  include("conn.php");
  include ("find.php"); 
?>

<?php

if(isset($_POST['login']) && $_POST['login']=='login' ){

    $username=isset($_POST['username']) ? $_POST['username'] :'';
    $password=isset($_POST['password']) ? GetPassword($_POST['password']) :'';


    if(empty($username) || empty($password)){

        $error="Username and Password required.";
    }else{

        $qry="SELECT * FROM cxs_users where USER_NAME='".$username."' && ENC_KEY='".$password."'";
  

        $result = mysql_query($qry) or die(mysql_error($conn));
    
        $row_num = mysql_num_rows($result);

        if($row_num>0){
        
                
            $user_arr = mysql_fetch_array($result);
            
            $now = time(); // or your date as well
            $psw_reset_date = strtotime($user_arr['PSW_RESET_DATE']);
            $datediff = $now - $psw_reset_date;

            $dtDiff = floor($datediff / (60 * 60 * 24));
        
            if($user_arr['TEMP_PASSWORD']=='Y' || $dtDiff>=$user_arr['RESET_DAYS'])
            {
                $_SESSION['reset-password'] = 'Y';
                $_SESSION['user-email'] = $username;
                header('location:reset-password.php');
            }
            else
            {
                unset($_SESSION['reset-password']);
                unset($_SESSION['user-email']);
                if(!empty($_POST["rememberMe"])) {
                    setcookie ("cookie_username",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
                    setcookie ("cookie_password",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
                }else{

                    if(isset($_COOKIE["cookie_username"])){
                        setcookie ("cookie_username","");
                    }
                    if(isset($_COOKIE["cookie_password"])){
                        setcookie ("cookie_password","");
                    }
                }

                $_SESSION['user_data']=$user_arr;
                $_SESSION['user_id'] = $user_arr['USER_ID'];
                  

                if(isset($_SESSION['redirect_page'])){
  
                    header('location:'.$_SESSION['redirect_page']);
                }else{
                    header('location:index.php');
                }
            }

      }else{

         $error="Incorrect Username & Password.";
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
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

  <script>
    function ForgotPasswordPopUp(search_by)
	{	
		$('#ForgotPasswordModal').modal();
		//$('#SearchResourceGroups').find('.srchFld').css('display','none');
		
		//$('#SearchResourceGroups').find('#sec_'+search_by).css('display','block');
		
		//$('#SearchResourceGroups').find('#search_by_field_nm').val(search_by);
	}
    function sendTempPassword()
    {
        var Text_Email = $.trim($("#Text_Email").val());
        if (Text_Email=='') {
            alert('Please enter your email.');
            $("#Text_Email").val('');
            $("#Text_Email").focus();
        }
        else
        {
            
            var form_data = new FormData();
        	  form_data.append("user_email", Text_Email);
            jQuery.ajax({
                url: "ajax-functions/generateTempPsw.php", // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script
                cache: false,
                contentType: false,
                processData: false,
                async: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    var data = response.split('|');
                    alert(data[1]);
                    if (data[0]==1) {
                        $("#ForgotPasswordModal .close").click();
                    }
				
                },
                error: function (response) {
				//$('#fileMsg').html(response); // display error response from the PHP script
                }
        	  });
        }	   
    }
    
  </script>
</head>

<body>

    <div class="wrapper">
    <form class="form-signin" method='post' action=''> 
      <div class='row' > <img style='margin-right:-20px;' class='pull-right' src="img/main_logo.png" /> </div>    
      <h2 class="form-signin-heading" >Sign In</h2>
     
      <input type="text" class="form-control" name="username" value="<?php if(isset($_COOKIE["cookie_username"])) { echo $_COOKIE["cookie_username"]; } ?>" placeholder="Email Address" required="" autofocus="" />
      <input type="password" class="form-control" value="<?php if(isset($_COOKIE["cookie_password"])) { echo $_COOKIE["cookie_password"]; } ?>" name="password"  placeholder="Password" required=""/>
      
       
      <?php if(isset($error)){ ?>
        <p align='center' class='text-danger'><?php echo $error; ?></p> 
      <?php } ?>
     
     

      <label class="checkbox">
        <input type="checkbox" value="remember-me" id="rememberMe" <?php if(isset($_COOKIE["cookie_username"])) { ?> checked <?php } ?>  name="rememberMe">Remember me
      </label>
      <button class="btn btn-lg btn-primary btn-block" name='login' value='login' type="submit">Login</button> 
      <a class='pull-right' id='forget_password' onclick="ForgotPasswordPopUp();" style="cursor: pointer;">Forgot Password</a>  
    </form>

  

  </div>
  <form  method="post" action="" >
	  <div class="modal fade custom-modal" id="ForgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display:none">
		<input type="hidden" id="search_by_field_name" value="">
		<div class="modal-dialog modal-lg cus-modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel"> Forget Password </h4>
			</div>
			<div class="modal-body">
			<!-- field start-->
			  <div class="col-sm-12">
				<div class="cus-form-cont">
					
					<div class="col-sm-12 form-group srchFld">
						<label> Please enter your registered email </label>
						<input type="text" id="Text_Email" name="Text_Email" value = "" class="form-control" placeholder="">
					</div>
								
					
				</div>
				
			  </div>
			<!-- end -->
			</div>
			<div class="clear-both"></div>
			<div class="modal-footer cr-user">
			    <button type="button" id="sendTempPsw" name="sendTempPsw" class="btn btn-primary btn-style" onclick="sendTempPassword()"> Generate Password </button>
			</div>
		  </div>
		</div>
	  </div>
	  
	</form>
  
<script src="js/bootstrap.min.js"></script>
</body>

</html>

