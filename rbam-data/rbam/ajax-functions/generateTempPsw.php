<?php
include('../conn.php');

$user_email = $_POST['user_email'];
    

$sql = "SELECT * FROM cxs_users WHERE USER_NAME ='".$user_email."'";
$res=mysql_query($sql);
$numRows = mysql_num_rows($res);

if($numRows>0)
{
    $row = mysql_fetch_array($res);
    $new_psw = random_password(8);
    $sql_upd="update cxs_users
	   set
		  ENC_KEY='".GetPassword($new_psw)."',
		  TEMP_PASSWORD='Y'
	   where
		  USER_ID='".$row['USER_ID']."'";
    
    if(mysql_query($sql_upd))
    {
	   
	   /************* Email sending code *************/
	   
	   $from_name='Coexsys Time Accounting'; //Website Name
	   $from_email='admin@testrbam.com'; //Admin Email
	   $to=$user_email;
		
		
	   $subject = "Temporary password generate";

	   $cc="";
	
	   include "../email/tempPasswordGenerate.php"; //email design with content included
		
	   $headers  = "MIME-Version: 1.0\r\n";
    	   $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	   $headers .= "From: $from_name < $from_email >\r\n";
		
	   mail($to, $subject, $message, $headers);
	   
	   /************************************************/
	   
	   echo "1|Temporary password has been generated.Please check your inbox.";
	   
    }
    else
    {
	   echo "0|Please try after some time.";
    }
}
else
{
    echo "0|The provided email address is not registered.";
}

//GetPassword();
//echo $user_email."-".random_password(8);
function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
?>