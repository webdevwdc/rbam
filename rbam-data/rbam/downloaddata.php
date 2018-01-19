<?php ob_start ();
session_start();
include('conn.php');

	$r = "";
	$r = $_GET['r'];
	
	if ($r == "user-administration")
	{
		$filename = "download_user_administration.csv";
		$fp = fopen($filename, "w") or die ("couldn't open");
		fwrite($fp, $_SESSION['User_Administration_Export']);
	}
	elseif ($r == "access_management")
	{
		$filename = "download_access_management.csv";
		$fp = fopen($filename, "w") or die ("couldn't open");
		fwrite($fp, $_SESSION['Access_Management_Permissions']);
	}
	elseif ($r == "assign-app-adminstrator")	
	{
	   
		$filename = "download_assign_app_adminstrator.csv";
		$fp = fopen($filename, "w") or die ("couldn't open");
		//fwrite($fp, $_SESSION['AssignApplication_Administrators_Export']);
		fwrite($fp, $_SESSION['assign_applications']);
	}
	elseif ($r == "current-subscriber")	
	{
		$filename = "download_current_subscriber.csv";
		$fp = fopen($filename, "w") or die ("couldn't open");		
		fwrite($fp, $_SESSION['current_subsciber_export']);
	}
	elseif($r == "current-commonword")
	{
		$filename = "download_current_commonword.csv";
		$fp = fopen($filename, "w") or die ("couldn't open");		
		fwrite($fp, $_SESSION['current_commonword_export']);
	}
	elseif($r == "wbs-structure")
	{
		$filename = "download_wbs_structure.csv";
		$fp = fopen($filename, "w") or die ("couldn't open");		
		fwrite($fp, $_SESSION['wbs_structure_export']);
	}
	elseif($r == "resource-address")
	{
		$filename = "download_resource_address.csv";
		$fp = fopen($filename, "w") or die ("couldn't open");		
		fwrite($fp, $_SESSION['current_resource_address']);
	}
	fclose($fp);
	
?>
<html>
<head>
<title>Download CSV File</title>
</head>
<body>
<script>
	location.href = "<?php echo $filename; ?>";
</script>
</body>
</html>