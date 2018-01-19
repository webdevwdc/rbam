<?php ob_start();
include('conn.php');

if($_REQUEST['REQUEST'] == "SearchUsers")
{
	//$GroupName = $_REQUEST['GroupName'];
	$UserName = $_REQUEST['UserName'];
	$FirstName = $_REQUEST['FirstName'];
	$LastName = $_REQUEST['LastName'];
	$searched_field = isset($_REQUEST['SearchField'])?$_REQUEST['SearchField']:'';
	$s_query = "";
	/*if($GroupName!='')
	{
		$s_query .= " and cxs_resource_groups.RESOURCE_GROUP_NAME like'%$GroupName%' ";
		
	}*/
	if($UserName!='')
	{
		$s_query .= " and cxs_users.USER_NAME like'%$UserName%' ";
		
	}
	if($FirstName!='')
	{
		$s_query .= "and cxs_resources.FIRST_NAME like'%$FirstName%' ";
		
	}
	if($LastName!='')
	{
		$s_query .= "and cxs_resources.LAST_NAME like'%$LastName%' ";
		
	}	

	/*
	 *commented on 15-12-2017 12.57PM
	 *
	 *$sql = "SELECT cxs_users.USER_ID,cxs_users.USER_NAME,cxs_resources.FIRST_NAME,cxs_resources.LAST_NAME FROM cxs_users
		Inner JOIN cxs_resources on cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID 
		where 1=1  $s_query";*/
		
	/*
	 *commented on 04-01-2018 03.23PM for seperate the resource group as per requirement
	 *
	 *$sql="SELECT
		cxs_users.USER_ID,cxs_users.USER_NAME,
		cxs_resources.FIRST_NAME,
		cxs_resources.LAST_NAME,
		cxs_resource_groups.RESOURCE_GROUP_NAME
	FROM
		cxs_users, cxs_resources, cxs_resource_groups
	where
		cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID
		and
		cxs_resource_groups.RESOURCE_GROUP_ID=cxs_resources.RESOURCE_GROUP_ID
		$s_query";*/
		
	$sql="SELECT
		cxs_users.USER_ID,cxs_users.USER_NAME,
		cxs_resources.FIRST_NAME,
		cxs_resources.LAST_NAME,
		cxs_resources.RESOURCE_GROUP_ID
	FROM
		cxs_users, cxs_resources
	where
		cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID
		$s_query";
	
	$result = mysql_query($sql);	
	while($row=mysql_fetch_array($result))
	{
		$SearchUserId 	  =  $row['USER_ID'];
		$SearchUserName	  =  $row['USER_NAME'];		
		$SearchFirstName  =  $row['FIRST_NAME'];		
		$SearchLastName   =  $row['LAST_NAME'];
		$SearchResourceGroupID = $row['RESOURCE_GROUP_ID'];
		//$SearchResourceGroup = $row['RESOURCE_GROUP_NAME'];
	
	?>
		<tr style="cursor:pointer" onClick="SelectedUserName('<?php echo $SearchUserName; ?>','<?php echo $SearchFirstName; ?>','<?php echo $SearchLastName; ?>',<?php echo $SearchUserId; ?>,'<?php echo $searched_field; ?>',<?php echo $SearchResourceGroupID; ?>);">
			<td><?php echo $SearchUserName; ?></td> 
			<td><?php echo $SearchFirstName; ?> </td> 
			<td> <?php echo $SearchLastName; ?>  </td>
		</tr>
<?php	
	}	
}

if($_REQUEST['REQUEST'] == "SearchRoles")
{
	$RoleName = $_REQUEST['RoleName'];
	$RoleDescription = $_REQUEST['RoleDescription'];
		
	$searched_field = $_REQUEST['SearchField'];
	

	$s_query = "";
	if($RoleName!='')
	{
		$s_query .= " and cxs_am_roles.ROLE_NAME like'%$RoleName%' ";
	}
			
	$sql="SELECT
		cxs_am_roles.ROLE_ID,cxs_am_roles.ROLE_NAME,cxs_am_roles.DESCRIPTION
	FROM
		cxs_am_roles";
		
	
	$result = mysql_query($sql);	
	while($row=mysql_fetch_array($result))
	{
		$SearchRoleId 	  =  $row['ROLE_ID'];
		$SearchRoleName  =  $row['ROLE_NAME'];
		$SearchRoleDescription  =  $row['DESCRIPTION'];
		
	?>
		<tr style="cursor:pointer" onClick="SelectedRoleName('<?php echo $SearchRoleName; ?>','<?php echo $SearchRoleDescription; ?>',<?php echo $SearchRoleId; ?>,'<?php echo $searched_field; ?>');">
			<td><?php echo $SearchRoleName; ?></td>
			<td><?php echo $SearchRoleDescription; ?></td>
		</tr>
<?php	
	}
}
if($_REQUEST['REQUEST'] == "SearchResourceGroups")
{
	$ResGroup = $_REQUEST['ResGroup'];
			
	$searched_field = $_REQUEST['SearchField'];
	

	$s_query = "";
	if($ResGroup!='')
	{
		$s_query .= " and cxs_resource_groups.RESOURCE_GROUP_NAME like'%$ResGroup%' ";
	}
			
	$sql="SELECT
		cxs_resource_groups.RESOURCE_GROUP_ID,cxs_resource_groups.RESOURCE_GROUP_NAME,cxs_resource_groups.DESCRIPTION
	FROM
		cxs_resource_groups";
		
	
	$result = mysql_query($sql);	
	while($row=mysql_fetch_array($result))
	{
		$SearchResGrpId 	  =  $row['RESOURCE_GROUP_ID'];
		$SearchResGrpName  =  $row['RESOURCE_GROUP_NAME'];
		$SearchResGrpDescription  =  $row['DESCRIPTION'];
		
	?>
		<tr style="cursor:pointer" onClick="SelectedResGroupName('<?php echo $SearchResGrpId; ?>','<?php echo $SearchResGrpName; ?>','<?php echo $SearchResGrpDescription; ?>','<?php echo $searched_field; ?>');">
			<td><?php echo $SearchResGrpName; ?></td>
			<td><?php echo $SearchResGrpDescription; ?></td>
		</tr>
<?php	
	}
	
}
if($_REQUEST['REQUEST'] == "FindData")
{
	$UserName = $_REQUEST['UserName'];
	$FirstName = $_REQUEST['FirstName'];
	$LastName = $_REQUEST['LastName'];
	$StartDate = $_REQUEST['StartDate'];
	$EndDate = $_REQUEST['EndDate'];
	$PageName = $_REQUEST['PageName'];
	$AppAdmin = $_REQUEST['AppAdmin'];
	$ApplicationId = $_REQUEST['ApplicationId'];
	$SubscriberName = $_REQUEST['SubscriberName'];
	
	$s_query = "";
	if($PageName=="users-administration.php" || $PageName=="assign-app-adminstrator.php")
	{
		if($UserName!='')
		{
			$s_query .= " and cxs_users.USER_NAME like'%$UserName%' ";
		}
		if($FirstName!='')
		{
			$s_query .= "and cxs_resources.FIRST_NAME like'%$FirstName%' ";
		}
		if($LastName!='')
		{
			$s_query .= "and cxs_resources.LAST_NAME like'%$LastName%' ";
		}
		if($PageName=="users-administration.php")	
		{
			if($StartDate!='')
			{
				$StartDate = date("Y/m/d", strtotime($StartDate));	
				$s_query .= "and cxs_users.START_DATE >='$StartDate' ";
			}
			if($EndDate!='')
			{
				
				$EndDate = date("Y/m/d", strtotime($EndDate));	
				$s_query .= "and cxs_users.END_DATE <='$EndDate' and cxs_users.END_DATE != '0000-00-00' ";
			}
		}
		
		else if($PageName=="assign-app-adminstrator.php")	
		{
			if($StartDate!='')
			{
				$StartDate = date("Y/m/d", strtotime($StartDate));	
				$s_query .= "and cxs_am_app_admin.START_DATE_ACTIVE >='$StartDate' ";
			}
			if($EndDate!='')
			{
				$EndDate = date("Y/m/d", strtotime($EndDate));	
				$s_query .= "and cxs_am_app_admin.END_DATE_ACTIVE <='$EndDate'  and cxs_am_app_admin.END_DATE != '0000-00-00'";
			}
			if($ApplicationId!='')
			{
				$s_query .= "and cxs_am_app_admin.APPLICATION_ID =$ApplicationId";
			}
		}
	}
	else if($PageName=="access-management.php")
	{
		if($UserName!='')
		{
			$s_query .= " and cxs_users.USER_NAME like'%$UserName%' ";
		}		
		if($StartDate!='')
		{
			$StartDate = date("Y/m/d", strtotime($StartDate));	
			$s_query .= "and cxs_users.START_DATE >='$StartDate' ";
		}
		if($EndDate!='')
		{
			$EndDate = date("Y/m/d", strtotime($EndDate));	
			$s_query .= "and cxs_users.END_DATE <='$EndDate' and cxs_users.END_DATE != '0000-00-00'";
		}
		if($AppAdmin!='')
		{
			if($AppAdmin=="Yes")
			{
				$s_query .= " and cxs_am_app_admin.USER_ID > 0";
			}
			else
			{
				$s_query .= " and cxs_am_app_admin.USER_ID is null";
			}
		}
	}	
	else if($PageName=="current-subscriber.php")
	{
		if($UserName!='')
		{
			$s_query .= " and cxs_users.USER_NAME like'%$UserName%' ";
		}		
		if($StartDate!='')
		{
			$StartDate = date("Y/m/d", strtotime($StartDate));	
			$s_query .= "and cxs_subscribers.START_DATE >='$StartDate' ";
		}
		if($EndDate!='')
		{
			$EndDate = date("Y/m/d", strtotime($EndDate));	
			$s_query .= "and cxs_subscribers.END_DATE <='$EndDate' and cxs_subscribers.END_DATE != '0000-00-00' ";
		}
		if($SubscriberName!='')
		{
			$s_query .= " and (cxs_subscribers.FIRST_NAME like '%$SubscriberName%' or cxs_subscribers.LAST_NAME like '%$SubscriberName%')";
		}
	}	
	echo $s_query;
}

if($_REQUEST['REQUEST'] == "FindDataAccountPeriod")
{
	$PeriodName = $_REQUEST['PeriodName'];
	$Year = $_REQUEST['Year'];
	$Status = $_REQUEST['Status'];
	$StartDate = $_REQUEST['StartDate'];
	$EndDate = $_REQUEST['EndDate'];
	
	$s_query = "";
	
	if($PeriodName!='')
	{
		$s_query .= " and cxs_periods.PERIOD_NAME like'%$PeriodName%' ";
	}
	if($Year!='')
	{
		$s_query .= "and cxs_periods.PERIOD_YEAR like'%$Year%' ";
	}
	if($Status!='')
	{
		$s_query .= "and cxs_periods.STATUS like'%$Status%' ";
	}
	
	if($StartDate!='')
	{
		$StartDate = date("Y/m/d", strtotime($StartDate));	
		$s_query .= "and cxs_periods.FROM_PERIOD_DATE >='$StartDate' ";
	}
	if($EndDate!='')
	{
		$EndDate = date("Y/m/d", strtotime($EndDate));	
		$s_query .= "and cxs_periods.TO_PERIOD_DATE <='$EndDate' and cxs_periods.TO_PERIOD_DATE != '0000-00-00' ";
	}
		
	echo $s_query;
}

	
if($_REQUEST['REQUEST'] == "FindDataWBS")
{
	$Criteria = $_REQUEST['Segment1'];
	$startnumber = $_REQUEST['StartNumber'];
	$endnumber = $_REQUEST['EndNumber'];
	if($Criteria!='')
	{
		//$sql = "SELECT * from cxs_wbs where SEGMENT1 like '%$Criteria%' limit $startnumber, $endnumber";
		$sql = "SELECT * from cxs_wbs where SEGMENT1 like '%$Criteria%'";
		$result = mysql_query($sql);	
		while($row=mysql_fetch_array($result))
		{
			$WBSId = $row['WBS_ID'];
			$Segment1 =  $row['SEGMENT1'];
			$Segment2 =  $row['SEGMENT2'];		
			$Segment3 =  $row['SEGMENT3'];		
			$Segment4 =  $row['SEGMENT4'];
			$Segment5 = $row['SEGMENT5'];
			$Segment6 =  $row['SEGMENT6'];
			$Segment7 =  $row['SEGMENT7'];		
			$Segment8 =  $row['SEGMENT8'];		
			$Segment9 =  $row['SEGMENT9'];
			$Segment10 = $row['SEGMENT10'];
			$Segment11 = $row['SEGMENT11'];
			$Segment12 = $row['SEGMENT12'];
			$Segment13 = $row['SEGMENT13'];
			$Segment14 = $row['SEGMENT14'];
			$Segment15 = $row['SEGMENT15'];
		?>
			<tr style="cursor:pointer"  onClick="SelectedWBSProject(<?php echo $WBSId; ?>)">
				<td><?php echo $Segment1; ?></td> 
				<td><?php echo $Segment2; ?></td> 
				<td><?php echo $Segment3; ?> </td> 
				<td> <?php echo $Segment4; ?></td>
				<td> <?php echo $Segment5; ?></td>
				<td> <?php echo $Segment6; ?></td>
				<td> <?php echo $Segment7; ?></td>
				<td> <?php echo $Segment8; ?></td>
				<td> <?php echo $Segment9; ?></td>
				<td> <?php echo $Segment10; ?></td>
				<td> <?php echo $Segment11; ?></td>
				<td> <?php echo $Segment12; ?></td>
				<td> <?php echo $Segment13; ?></td>
				<td> <?php echo $Segment14; ?></td>
				<td> <?php echo $Segment15; ?></td>
			</tr>
	<?php	
		}
		echo "#$sql";
	}
	
}

if($_REQUEST['REQUEST'] == "SelectedWBS")
{
	$SelectedId = $_REQUEST['Id'];
	$s = "";
	if($SelectedId!='')
	{
		$sql = "SELECT * from cxs_wbs where WBS_ID = $SelectedId";
		$result = mysql_query($sql);	
		while($row=mysql_fetch_array($result))
		{
			if($row['SEGMENT1']!='')
			{
				$s = $row['SEGMENT1'];
			}
			if($row['SEGMENT2']!='')
			{
				$s = $s.".".$row['SEGMENT2'];
			}
			if($row['SEGMENT3']!='')
			{
				$s = $s.".".$row['SEGMENT3'];
			}
			if($row['SEGMENT4']!='')
			{
				$s = $s.".".$row['SEGMENT4'];
			}
			if($row['SEGMENT5']!='')
			{
				$s = $s.".".$row['SEGMENT5'];
			}
			if($row['SEGMENT6']!='')
			{
				$s = $s.".".$row['SEGMENT6'];
			}
			if($row['SEGMENT7']!='')
			{
				$s = $s.".".$row['SEGMENT7'];
			}
			if($row['SEGMENT8']!='')
			{
				$s = $s.".".$row['SEGMENT8'];
			}
			if($row['SEGMENT9']!='')
			{
				$s = $s.".".$row['SEGMENT9'];
			}
			if($row['SEGMENT10']!='')
			{
				$s = $s.".".$row['SEGMENT10'];
			}
			if($row['SEGMENT11']!='')
			{
				$s = $s.".".$row['SEGMENT11'];
			}
			if($row['SEGMENT12']!='')
			{
				$s = $s.".".$row['SEGMENT12'];
			}
			if($row['SEGMENT13']!='')
			{
				$s = $s.".".$row['SEGMENT13'];
			}
			if($row['SEGMENT14']!='')
			{
				$s = $s.".".$row['SEGMENT14'];
			}
			if($row['SEGMENT15']!='')
			{
				$s = $s.".".$row['SEGMENT15'];
			}
		}
	}
	echo $s;
}
?>
