<?php
//session_start();

$hostname="103.21.58.4";
$username="mis";
$password="mis_2015@";
$dbname="synchronweb_applisoft";

$hostname = 'localhost';
$username = 'laravel';
$password = 'l1nux';
$dbname = 'rbam-db';

$user_session_id = session_id();
$ipaddress = getenv('REMOTE_ADDR');

//$conn = mysql_connect("$db1_host", "$db1_user", "$db1_pass") or die(mysql_error()) ;
$conn = mysql_connect("$hostname","$username", "$password") or die("Data not connected".mysql_errno());
mysql_select_db("$dbname",$conn) or die(mysql_error());

$ModuleName = "Access Management";

function add_security($val)		// RETURN VALUE WITH SECURITY
{
	return mysql_real_escape_string($val);
}
function insertdata($table,$data)	// FUNCTION TO INSERT NEW RECORD IN SPECIFIED TABLE
{
	$qry="INSERT INTO ".$table." set ";
	foreach($data as $fld=>$val)
	{
		$qry.= $fld."='".add_security($val)."',";
	}
	$qry=substr($qry,0,-1);
	
	$result_insert = mysql_query($qry);
}


function updatedata($table,$data, $wherecondition)	// FUNCTION TO UPDATE RECORD IN SPECIFIED TABLE
{
	$qry="Update ".$table." set ";
	foreach($data as $fld=>$val)
	{
		$qry.= $fld."='".add_security($val)."',";
	}
	$qry=substr($qry,0,-1);
	$qry = $qry . $wherecondition;
	//exit;
	
	$result_insert = mysql_query($qry);
	

}
function getvalue($table,$fieldname, $wherecondition)	// FUNCTION TO GET RECORD IN SPECIFIED TABLE
{	
	$qry="Select $fieldname from ".$table." ".$wherecondition;
	$result = mysql_query($qry) or die(mysql_error($conn));
	while($linedetail=mysql_fetch_array($result))
	{
		$valueResult = $linedetail[$fieldname];			
	}		
	return $valueResult;
}
function getProfileImg($id)	// FUNCTION TO GET RECORD IN SPECIFIED TABLE
{	
	$qry="Select PHOTO from cxs_users where USER_ID=".$id;
	$result = mysql_query($qry) or die(mysql_error($conn));
	while($linedetail=mysql_fetch_array($result))
	{
			 if($linedetail['PHOTO']=='')
			 {
				    $valueResult = "img/default_profile_img.jpg";
			 }
			 else
			 {
				    $valueResult = "img/uploads/user_images/".$id."/".$linedetail['PHOTO'];
				    if (!file_exists($valueResult)) {
						  $valueResult = "img/default_profile_img.jpg";
				    }
			 }
			 
	}		
	return $valueResult;
}
function GetPassword($s)
{
	$l = strlen($s);
	$s1 = "";
	$s2 = "";
	$s3 = "";
	$s4 = "";
	for ($i=0; $i <= $l-1; $i++ )
	{
		$s1 = substr($s, $i, 1);
		$s2 = ord($s1);
		$s3 = ($s2 ^ 153);
		$s4 = $s4 . chr($s3);
	}
	return "$s4";
}

if(isset($_COOKIE["LogUserId"]))	
{
	$_SESSION["LogUserId"] = $_COOKIE["LogUserId"];
	$_SESSION["LogUserName"] = $_COOKIE["LogUserName"]; 
	
}
//$UserLoginId = $_SESSION['CustomerId'];

$RecordsPerPage = 5;

function getSettingVal($field_name)
{
	   $sql_ss = "select $field_name from cxs_site_settings where SITE_SETTINGS_ID='1'";
	   $res_ss = mysql_query($sql_ss);
	   $row_ss = mysql_fetch_array($res_ss);
	   
	   return $row_ss[0];
}


function check_login(){

	   if($_SESSION['reset-password']=='Y')
	   {
			 header('location:reset-password.php');
	   }
	   
	   if(!isset($_SESSION['user_data']) || !isset($_SESSION['user_id'])){
   
			 $_SESSION['redirect_page']=$_SERVER['REQUEST_URI'];

			 header('location:login.php');
	   }
}

function getRoleAccessStatusByUser($field_name,$user_id)
{
	
	$sql_ss = "select $field_name from cxs_users,cxs_am_roles where cxs_users.ROLE_ID = cxs_am_roles.ROLE_ID and USER_ID='".$user_id."'";
	$res_ss = mysql_query($sql_ss);
	$row_ss = mysql_fetch_array($res_ss);
	   
	return $row_ss[0];
}

function getTimeAccountingModuleStatusByUser($field_name,$module_name,$user_id)
{
	   $sql_chk="select cxs_resources.RESOURCE_GROUP_ID as RESOURCE_GROUP_ID from cxs_users,cxs_resources where cxs_users.RESOURCE_ID = cxs_resources.RESOURCE_ID and USER_ID='".$user_id."'";
	   $res_chk=mysql_query($sql_chk);
	   $row_chk=mysql_fetch_array($res_chk);
	   
	   if($row_chk['RESOURCE_GROUP_ID']=='0')
	   {
			 $sql="select $field_name from cxs_ta_modules where USER_ID='".$user_id."' and MODULE_NAME='".$module_name."'";
			 $res = mysql_query($sql);
			 if(mysql_num_rows($res)>0)
			 {
			 	 $row = mysql_fetch_array($res);
			 	 return $row[0];
			 }
			 else
			 {
			 	 return 'N';
			 }	 
	   }
	   else
	   {
			 $sql="select $field_name from cxs_ta_modules where RESOURCE_GROUP_ID='".$row_chk['RESOURCE_GROUP_ID']."' and MODULE_NAME='".$module_name."'";
			 $res = mysql_query($sql);
			 if(mysql_num_rows($res)>0)
			 {
			 	 $row = mysql_fetch_array($res);
			 	 return $row[0];
			 }
			 else
			 {
			 	 return 'N';
			 }	
	   }	   
	   
}
?>