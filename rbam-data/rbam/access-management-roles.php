<?php ob_start ();
session_start();
include("conn.php");
check_login();
	include 'searchusers.php';
	include 'searchroles.php';
	include 'searchresourcegroups.php';
	include ("functions.php");
	$PageName = "access-management-roles.php";
	$LoginUserId = $_SESSION['user_id'];
	$TimeAccountingRow = 22; // Time Accounting Modules - total rows
	$msg = "";
	//global $Text_LastName ;
	

	
	$EXISTING_USER_permission = getRoleAccessStatusByUser('EXISTING_USER',$_SESSION['user_id']);
	
	if(isset($_POST['isRefresh']) && $_POST['isRefresh']=='Y')
	{
		$Text_RoleName="";
		$Text_ResourceGroup="";
		$Text_UserName="";
		header("location:access-management-roles.php");
	}
	
	
	
if (isset($_POST['cmdSaveRolePermission'] ))
{

	$Text_RoleName = isset($_POST['Text_RoleName'] )? $_POST['Text_RoleName']: false;
	/******User Administration******/
	$Check_CreateUser = isset($_POST['Check_CreateUser'] )? $_POST['Check_CreateUser']: false;
	$Check_ViewOnly = isset($_POST['Check_ViewOnly'] )? $_POST['Check_ViewOnly']: false;
	$Check_UpdateOnly = isset($_POST['Check_UpdateOnly'] )? $_POST['Check_UpdateOnly']: false;	
	/******Billing Administration******/
	$Check_ViewSubscribers = isset($_POST['Check_ViewSubscribers'] )? $_POST['Check_ViewSubscribers']: false;
	$Check_SubmitCustomization = isset($_POST['Check_SubmitCustomization'] )? $_POST['Check_SubmitCustomization']: false;
	//$Check_AllowChat = isset($_POST['Check_AllowChat'] )? $_POST['Check_AllowChat']: false;
	$Check_ViewSLA = isset($_POST['Check_ViewSLA'] )? $_POST['Check_ViewSLA']: false;
	$Check_ExistUserAdmin = isset($_POST['Check_ExistUserAdmin'] )? $_POST['Check_ExistUserAdmin']: false;
	$Check_RemoveAccess = isset($_POST['Check_RemoveAccess'] )? $_POST['Check_RemoveAccess']: false;
	$Check_UsageHistory = isset($_POST['Check_UsageHistory'] )? $_POST['Check_UsageHistory']: false;
		
	/******Time Accounting Rules******/
	$Check_BusinessMessage = isset($_POST['Check_BusinessMessage'] )? $_POST['Check_BusinessMessage']: false;
	$Check_SetAudit = isset($_POST['Check_SetAudit'] )? $_POST['Check_SetAudit']: false;
	$Check_AllowTimekeeping = isset($_POST['Check_AllowTimekeeping'] )? $_POST['Check_AllowTimekeeping']: false;
	$Check_TimezoneProjects = isset($_POST['Check_TimezoneProjects'] )? $_POST['Check_TimezoneProjects']: false;
	$Combo_DefaultTimezone = isset($_POST['Combo_DefaultTimezone'] )? $_POST['Combo_DefaultTimezone']: false;
	$Combo_DefaultDateFormat = isset($_POST['Combo_DefaultDateFormat'] )? $_POST['Combo_DefaultDateFormat']: false;
	$Check_ProjectAccounting = isset($_POST['Check_ProjectAccounting'] )? $_POST['Check_ProjectAccounting']: false;
	$Check_AllowNegativeTimeEntry = isset($_POST['Check_AllowNegativeTimeEntry'] )? $_POST['Check_AllowNegativeTimeEntry']: false;
	$Check_AdvanceForOvertime = isset($_POST['Check_AdvanceForOvertime'] )? $_POST['Check_AdvanceForOvertime']: false;
	$Check_SubmittedTime = isset($_POST['Check_SubmittedTime'] )? $_POST['Check_SubmittedTime']: false;
	$Check_PrimaryApprover = isset($_POST['Check_PrimaryApprover'] )? $_POST['Check_PrimaryApprover']: false;
	
	$Text_RecentTimecards = isset($_POST['Text_RecentTimecards'] )? $_POST['Text_RecentTimecards']: false;
	$Check_RetroAdjustments = isset($_POST['Check_RetroAdjustments'] )? $_POST['Check_RetroAdjustments']: false;
	$Text_MaxDailyLimit = isset($_POST['Text_MaxDailyLimit'] )? $_POST['Text_MaxDailyLimit']: false;
	$Check_FlexibleTimeEntry = isset($_POST['Check_FlexibleTimeEntry'] )? $_POST['Check_FlexibleTimeEntry']: false;
	//$Check_EnforceTimeEntry = isset($_POST['Check_EnforceTimeEntry'] )? $_POST['Check_EnforceTimeEntry']: false;
	//$Check_EmployeeAliases = isset($_POST['Check_EmployeeAliases'] )? $_POST['Check_EmployeeAliases']: false;
	$Text_AllowRetroUpdates = isset($_POST['Text_AllowRetroUpdates'] )? $_POST['Text_AllowRetroUpdates']: false;
	$Check_CopyTimesheetEmployees = isset($_POST['Check_CopyTimesheetEmployees'] )? $_POST['Check_CopyTimesheetEmployees']: false;
	
	/******Approval Rules******/
	$Check_CreateTimeSheet = isset($_POST['Check_CreateTimeSheet'] )? $_POST['Check_CreateTimeSheet']: false;
	$Check_ApproveTimeSheet = isset($_POST['Check_ApproveTimeSheet'] )? $_POST['Check_ApproveTimeSheet']: false;
	$Check_CreateTimeSheetTeam = isset($_POST['Check_CreateTimeSheetTeam'] )? $_POST['Check_CreateTimeSheetTeam']: false;
	$Check_ApproveTimeSheetTeam = isset($_POST['Check_ApproveTimeSheetTeam'] )? $_POST['Check_ApproveTimeSheetTeam']: false;
	$Check_CreateSupervisorTimeSheet = isset($_POST['Check_CreateSupervisorTimeSheet'] )? $_POST['Check_CreateSupervisorTimeSheet']: false;
	$Check_AllowPreApproval = isset($_POST['Check_AllowPreApproval'] )? $_POST['Check_AllowPreApproval']: false;
	
	/******Approval Management******/
	//$Check_AllowPreApproval = isset($_POST['Check_AllowPreApproval'] )? $_POST['Check_AllowPreApproval']: false;
	$Check_ApproverType = isset($_POST['Check_ApproverType'] )? $_POST['Check_ApproverType']: false;
	$Check_ApproveDirectReport = isset($_POST['Check_ApproveDirectReport'] )? $_POST['Check_ApproveDirectReport']: false;
	$Check_UpadteApprovedTimesheet = isset($_POST['Check_UpadteApprovedTimesheet'] )? $_POST['Check_UpadteApprovedTimesheet']: false;
	//$Check_FlyApprovalRequest = isset($_POST['Check_FlyApprovalRequest'] )? $_POST['Check_FlyApprovalRequest']: false;
	//$Check_ProjectBasedApproval = isset($_POST['Check_ProjectBasedApproval'] )? $_POST['Check_ProjectBasedApproval']: false;
	
	
	/******User Administration*****/
		//$noofrecords = 0;
		//$qry = "Select * from cxs_am_roles where ROLE_ID = $RoleID";
		//$result = mysql_query($qry);
		//$noofrecords = mysql_num_rows($result);
		//$insArr['ROLE_ID'] = $RoleID;

		$insArr['CREATE_NEW_USER'] = ($Check_CreateUser==1)?"Y":"N";
		$insArr['VIEW_ONLY'] 		= ($Check_ViewOnly==1)?"Y":"N";
		$insArr['UPDATE_ONLY'] 		= ($Check_UpdateOnly==1)?"Y":"N";
		$insArr['VIEW_SUBSCRIBERS'] = ($Check_ViewSubscribers==1)?"Y":"N";
		$insArr['SUBMIT_CUSTOM'] 	= ($Check_SubmitCustomization==1)?"Y":"N";
		//$insArr['ALLOW_CHAT'] 		= ($Check_AllowChat==1)?"Y":"N";
		$insArr['VIEW_SLA'] 		= ($Check_ViewSLA==1)?"Y":"N";
		$insArr['EXISTING_USER'] 	= ($Check_ExistUserAdmin==1)?"Y":"N";
		$insArr['REMOVE_ACCESS'] 	= ($Check_RemoveAccess==1)?"Y":"N";
		$insArr['USAGE_HISTORY'] 	= ($Check_UsageHistory==1)?"Y":"N";
		
		
		/******Time Accounting Rules*****/
		
		$insArr['BIZ_MSG_FLAG'] 		= ($Check_BusinessMessage==1)?"Y":"N";
		$insArr['AUDIT_FLAG'] 			= ($Check_SetAudit==1)?"Y":"N";
		$insArr['ALLOW_TK_FLAG'] 		= ($Check_AllowTimekeeping==1)?"Y":"N";
		$insArr['ALLOW_TIMEZONE'] 		= ($Check_TimezoneProjects==1)?"Y":"N";
		$insArr['DEFAULT_TIMEZONE'] 	= $Combo_DefaultTimezone;		
		$insArr['DEFAULT_DATE_FORMAT'] 	= $Combo_DefaultDateFormat;
		$insArr['ENABLE_PA'] 			= ($Check_ProjectAccounting==1)?"Y":"N";
		$insArr['ALLOW_NEGATIVE'] 		= ($Check_AllowNegativeTimeEntry==1)?"Y":"N";
		$insArr['ADVANCE_FOR_OVERTIME'] = ($Check_AdvanceForOvertime==1)?"Y":"N";
		$insArr['UPDATE_SUBMITTED'] 	= ($Check_SubmittedTime==1)?"Y":"N";
		$insArr['OVERRIDE_PRIMARY'] 	= ($Check_PrimaryApprover==1)?"Y":"N";
		$insArr['RECENT_TIMECARDS'] 	= $Text_RecentTimecards;
		$insArr['RETRO_ADJUST'] 		= ($Check_RetroAdjustments==1)?"Y":"N";
		$insArr['MAX_DAILY_LIMIT'] 		= $Text_MaxDailyLimit;
		$insArr['AFT_ENTRY'] 			= ($Check_FlexibleTimeEntry==1)?"Y":"N";
		//$insArr['ENFORCE_TIME_WBS'] 	= ($Check_EnforceTimeEntry==1)?"Y":"N";
		//$insArr['CREATE_EMP_ALIAS_FLAG'] = ($Check_EmployeeAliases==1)?"Y":"N";
		$insArr['RETRO_PERIOD_NUM'] 	= $Text_AllowRetroUpdates;
		$insArr['ALLOW_COPY'] 			= ($Check_CopyTimesheetEmployees==1)?"Y":"N";
		/******Time Approval Rules*****/
		$insArr['COPY_ANYONE_TS_FLAG'] 	= ($Check_CreateTimeSheet==1)?"Y":"N";
		$insArr['APPROVE_ANYONE_TS'] 	= ($Check_ApproveTimeSheet==1)?"Y":"N";
		$insArr['CREATE_ANYONE_TS'] 	= ($Check_CreateTimeSheetTeam==1)?"Y":"N";
		$insArr['APPROVE_ANYONE_TS_TEAM']= ($Check_ApproveTimeSheetTeam==1)?"Y":"N";
		$insArr['ALLOW_SUP_TS'] 		= ($Check_CreateSupervisorTimeSheet==1)?"Y":"N";
		$insArr['ALLOW_PREAPPROVAL'] 		= ($Check_AllowPreApproval==1)?"Y":"N";
		$insArr['LAST_UPDATED_BY']		= $LoginUserId;
		
	if(isset($_POST['checkbox_create_role']) && $_POST['checkbox_create_role']=='create')
	{
		
		$insArr['ROLE_NAME'] = trim($_POST['New_RoleName']);
		$insArr['DESCRIPTION'] = trim($_POST['New_RoleDescription']);
		$insArr['CREATED_BY'] = $LoginUserId;
		$insArr['CREATION_DATE'] = date("Y-m-d");
		
		insertdata("cxs_am_roles",$insArr);
		
		DisplayRoleDetails(trim($_POST['New_RoleName']));
	}
	else
	{
		$RoleID = getvalue("cxs_am_roles","ROLE_ID","where ROLE_NAME='$Text_RoleName'");
		if($RoleID!='')
		{
		
	
			updatedata("cxs_am_roles",$insArr,"Where ROLE_ID = $RoleID");
		
		
			DisplayRoleDetails($Text_RoleName);
		}
		else
		{
			$msg = "No Record Found For Save";
		}
	}
		
}	

if (isset($_POST['cmdSavePermission'] ))
{
	
	$hdnSearchField = $_POST['hdn_searchField'];
	
	if($_POST['Text_ResourceGroup']!='' && !isset($_POST['Text_UserName']))
	{
		
		$Text_ResourceGroup = isset($_POST['Text_ResourceGroup'] )? $_POST['Text_ResourceGroup']: false;	
	
		$RESOURCE_GROUP_ID = getvalue("cxs_resource_groups","RESOURCE_GROUP_ID","where RESOURCE_GROUP_NAME='$Text_ResourceGroup'");
		if($RESOURCE_GROUP_ID!='')
		{			
			$qry2 = "Delete from cxs_ta_modules where RESOURCE_GROUP_ID = $RESOURCE_GROUP_ID";
			$result2 = mysql_query($qry2);	
			
			for ($i = 1; $i <= $TimeAccountingRow; $i++)  
			{	
				$RowId = isset($_POST["Row$i"] )? $_POST["Row$i"]: false;				
				$Create = isset($_POST["Check_Create$i"] )? $_POST["Check_Create$i"]: false;
				$Update = isset($_POST["Check_Update$i"] )? $_POST["Check_Update$i"]: false;
				$View = isset($_POST["Check_View$i"] )? $_POST["Check_View$i"]: false;
				$Audit = isset($_POST["Check_Audit$i"] )? $_POST["Check_Audit$i"]: false;
			
				if($Create == "1" || $Update == "1" || $View=="1" || $Audit=="1")
				{
					unset ($insArr);
					$insArr['RESOURCE_GROUP_ID']		= $RESOURCE_GROUP_ID;
					$insArr['MODULE_NAME'] 	= $RowId;
					$insArr['CREATE_PRIV'] 	= ($Create==1)?"Y":"N";
					$insArr['UPDATE_PRIV'] 	= ($Update==1)?"Y":"N";
					$insArr['VIEW_PRIV'] 	= ($View==1)?"Y":"N";
					$insArr['ENABLE_AUDIT'] = ($Audit==1)?"Y":"N";
					$insArr['ROWNO'] = $i;
					$insArr['CREATION_DATE']	= date('Y-m-d H:i:s'); 
					$insArr['CREATED_BY']		= $LoginUserId;
					$insArr['LAST_UPDATED_BY']	= $LoginUserId;
					insertdata("cxs_ta_modules",$insArr);	
				}
			}
		
			DisplayResourceGroupAccessDetails($Text_ResourceGroup);
		}
		else
		{
			$msg = "No Record Found For Save";
		}
	}
		
	if($hdnSearchField!='ResourceGroup' && $_POST['Text_UserName']!='' && !isset($_POST['Text_ResourceGroup']))
	{
		
		$Text_UserName = isset($_POST['Text_UserName'] )? $_POST['Text_UserName']: false;
	
	
		$UserID = getvalue("cxs_users","USER_ID","where USER_NAME='$Text_UserName'");
		
		if($UserID!='')
		{
			$qry2 = "Delete from cxs_ta_modules where USER_ID = $UserID";
			$result2 = mysql_query($qry2);	
			
		
			for ($i = 1; $i <= $TimeAccountingRow; $i++)  
			{	
				$RowId = isset($_POST["Row$i"] )? $_POST["Row$i"]: false;				
				$Create = isset($_POST["Check_Create$i"] )? $_POST["Check_Create$i"]: false;
				$Update = isset($_POST["Check_Update$i"] )? $_POST["Check_Update$i"]: false;
				$View = isset($_POST["Check_View$i"] )? $_POST["Check_View$i"]: false;
				$Audit = isset($_POST["Check_Audit$i"] )? $_POST["Check_Audit$i"]: false;
			
				if($Create == "1" || $Update == "1" || $View=="1" || $Audit=="1")
				{
					unset ($insArr);
					$insArr['USER_ID']		= $UserID;
					$insArr['MODULE_NAME'] 	= $RowId;
					$insArr['CREATE_PRIV'] 	= ($Create==1)?"Y":"N";
					$insArr['UPDATE_PRIV'] 	= ($Update==1)?"Y":"N";
					$insArr['VIEW_PRIV'] 	= ($View==1)?"Y":"N";
					$insArr['ENABLE_AUDIT'] = ($Audit==1)?"Y":"N";
					$insArr['ROWNO'] = $i;
					$insArr['CREATION_DATE']	= date('Y-m-d H:i:s'); 
					$insArr['CREATED_BY']		= $LoginUserId;
					$insArr['LAST_UPDATED_BY']	= $LoginUserId;
					insertdata("cxs_ta_modules",$insArr);
					
				}
			}
		
			DisplayUserAccessDetails($Text_UserName);
		}
		else
		{
			$msg = "No Record Found For Save";
		}
	}
	
}

//$Text_FirstName = "test name";
	

if (isset($_POST['cmdFindRoles'] ))
{
	
	$SearchField = $_POST['hdn_searchField'];
	$Text_ResourceGroup = isset($_POST['Text_ResourceGroup'])? $_POST['Text_ResourceGroup']: false;
	$Text_UserName = isset($_POST['Text_UserName'])? $_POST['Text_UserName']: false;
	$Text_FirstName = isset($_POST['Text_FirstName'])? $_POST['Text_FirstName']: false;
	$Text_LastName = isset($_POST['Text_LastName'])? $_POST['Text_LastName']: false;
	if(isset($_POST['Text_ResourceGroup']) && $_POST['Text_ResourceGroup']!='')
	{
		DisplayResourceGroupAccessDetails($Text_ResourceGroup);
	}
	if(isset($_POST['Text_UserName']) && $_POST['Text_UserName']!='')
	{
		DisplayUserAccessDetails($Text_UserName);
	}
	
}

if(isset($_POST['cmdFindUserAccess']))
{
	$Text_RoleName = isset($_POST['Text_RoleName'])? $_POST['Text_RoleName']: false;
	$SearchField = $_POST['hdn_searchFld'];
	
	DisplayRoleDetails($Text_RoleName);
}
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Coexsys Time Accounting</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- font-awasome-->
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- custom-css -->
  <link href="css/style.css" rel="stylesheet">
  <script type="text/javascript" ><?php //include 'searchusers.php'; ?></script>
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>-->
   
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
.requirefieldcls{	background-color: #fff99c;	}
</style>
</head>

<script type="text/javascript" >
	function chkfld()
	{
		//alert($("#hdn_searchField").val());
		if(document.getElementById("Text_UserName").value == "" && document.getElementById("Text_ResourceGroup").value == "")
		{
			alert("All the search field cannot be empty.11");
			//document.getElementById("Text_UserName").focus();
			return false;
		}
		if(document.getElementById("Text_MaxDailyLimit").value!="")
		{
			var MaxDailyLimit = document.getElementById("Text_MaxDailyLimit").value;
			MaxDailyLimit = parseInt(MaxDailyLimit);
			if (MaxDailyLimit > 24)
			{
				alert("Must not exceed the 24.");
				document.getElementById("Text_MaxDailyLimit").focus();
				//document.getElementById(id).focus();
				return false;
			}
		}
	}
	function chkRoleSearch()
	{
		if($("#checkbox_create_role").is(':checked'))
		{
			if(document.getElementById("New_RoleName").value == "" )
			{
				alert("Please Enter Role Name");
				document.getElementById("New_RoleName").focus();
				return false;
			}
			else if(document.getElementById("New_RoleDescription").value == "" )
			{
				alert("Please Enter Role Description");
				document.getElementById("New_RoleDescription").focus();
				return false;
			}
		}
		else
		{
			if(document.getElementById("Text_RoleName").value == "" )
			{
				alert("Please Enter Role Name");
				document.getElementById("Text_RoleName").focus();
				return false;
			}
		}
		
		
	}
	function SaveRecords_Validations()
	{
		
	}
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "Access Management Roles";		
		var s2 = "<?php echo $PageName; ?>";				
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
	}
	function onlyNos(e, t)
	{
		try {
			if (window.event) {
				var charCode = window.event.keyCode;
			}
			else if (e) {
				var charCode = e.which;
			}
			else { return true; }
			if (charCode > 31 && (charCode != 46) &&((charCode < 48 || charCode > 57)))															
			{
				return false;
			}
			return true;
		}
		catch (err) {
			alert(err.Description);
		}
	}
	function SearchPopUp(search_by)
	{	
		$('#SearchUsers').modal();
		$('#SearchUsers').find('.srchFld').css('display','none');
		
		$('#SearchUsers').find('#sec_'+search_by).css('display','block');
		
		$('#SearchUsers').find('#search_by_field_name').val(search_by);
	}
	function SearchRolePopUp(search_by)
	{	
		$('#SearchRoles').modal();
		$('#SearchRoles').find('.srchFld').css('display','none');
		
		$('#SearchRoles').find('#sec_'+search_by).css('display','block');
		
		$('#SearchRoles').find('#search_by_field_name').val(search_by);
	}
	function SearchResourceGroupPopUp(search_by)
	{	
		$('#SearchResourceGroups').modal();
		//$('#SearchResourceGroups').find('.srchFld').css('display','none');
		
		//$('#SearchResourceGroups').find('#sec_'+search_by).css('display','block');
		
		$('#SearchResourceGroups').find('#search_by_field_nm').val(search_by);
	}
	/*$('#SearchUsers').on('hidden.bs.modal', function (e) {
		alert('Modal Closed');
	});
	$('#SearchUsers').on('hidden', function () {
		alert('Modal Closed');
	});*/
	/*$('.popover-dismiss').popover({
		trigger: 'focus'
	});*/
	
</script>

<!DOCTYPE html>

<body>
  
    <?php include("header.php"); ?>
	<section class="md-bg">
      <div class="container-fluid">
		<div class="row">
          <div class="brd-crmb">
			<ul>
              <li> <a href="#"> Users And Roles </a></li>
              <li> <a href="access-management.php"> Access Management </a></li>
              <li> <a href="#"> Manage Permissions </a></li>
            </ul>
          </div>
          
		  <div class="dash-strip">
            <div class="fleft cr-user">
              <a href="index.php">
                <button type="button" class="btn btn-primary dash" autofocus> Dashboard </button>
              </a>
            </div>
            <div class="fright">										
				<?php
					$qry = "select * from cxs_users_favorites where USER_ID = $LoginUserId and PAGE_NAME ='$PageName'";
					$result=mysql_query	($qry);
					$TotalRecords = mysql_num_rows($result);
					if($TotalRecords == 0)
					{
						$s_Style = "";
					}
					else
					{
						$s_Style = "background-color: #000;";
					}
					?>
					<button type="button" id="cmdFavorites" name="cmdFavorites" onclick = "CheckFavoriteData();" class="btn btn-warning fav-ico" style = "<?php echo $s_Style;?>"> <i class="fa fa-star"></i></button>
					
					<form id="refreshPage" action="" method="POST">
					<input type="hidden" id="isRefresh" name="isRefresh" value="N">
					</form>
			  </div>
          </div>
          
		  <div class="cont-box ">
            <div class="pge-hd">
              <h2 class="sec-title"> <label id="Label_Title"> Access Management Roles </label> </h2>
            </div>
            <div>
			  <div class="fright cr-user">
                <a href="assign-app-adminstrator.php">
                  <button type="button" class="btn btn-primary btn-style"> Application Administrator </button>
                </a>
              </div>
			  <div class="text-center">
				<span ><font color="red"><h4> <?php echo $msg; ?><h5></font></span>
			  </div>
            </div>
				<!-- Search Bar -->
				
				<div class="search-bx search-bx2">
				  
				</div>

				<!-- Accordian -->
				<div class="col-md-12">
				  <div class="row tab-edit">
					<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Manage Roles</a></li>
    <li><a href="#tabs-2">Modules & Approval Rules</a></li>
  </ul>
  <div id="tabs-1">
	<form action="" method="post"id="Form1" name="Form1" onsubmit = "return chkRoleSearch()">
		<input type="hidden" id="hdn_searchFld" name="hdn_searchFld" value="">
		<div class="search-bx search-bx2 clearfix">
				  <div class="cus-form-cont row">
					
					<div class="col-sm-2 form-group" id="Sec_exist_rolename">
					  <label> Role Name </label>
					  <input type="text" id="Text_RoleName" name="Text_RoleName" value="<?php echo $Text_RoleName; ?>" class="form-control" placeholder="" maxlength="25" onclick="SearchRolePopUp('RoleName')">
					  
					</div>
					
					<div class="col-sm-3 form-group" id="Sec_exist_roledesc">
					  <label> Role Description </label>
					  <input type="text" id="Text_RoleDescription" name="Text_RoleDescription" value = "<?php echo $Text_RoleDescription; ?>" class="form-control" placeholder="" maxlength="25" oninput="this.value=this.value.toUpperCase()" onclick="SearchRolePopUp('RoleDescription')">
					</div>
					
					<div class="col-sm-2 form-group" id="Sec_New_rolename" style="display: none;">
					  <label> Role Name </label>
					  <input type="text" id="New_RoleName" name="New_RoleName" value="" class="form-control requirefieldcls" placeholder="" maxlength="25">
					  
					</div>
					
					<div class="col-sm-3 form-group" id="Sec_New_roledesc" style="display: none;">
					  <label> Role Description </label>
					  <input type="text" id="New_RoleDescription" name="New_RoleDescription" value = "" class="form-control requirefieldcls" placeholder="" maxlength="25" oninput="this.value=this.value.toUpperCase()">
					</div>
													
										
					<div class="col-sm-2 form-group ">						
					  <button type="submit" id="cmdFindUserAccess" name="cmdFindUserAccess" class="btn btn-primary btn-style2 w100" > <i class="fa fa-search" aria-hidden="true"></i> Find Roles </button>
					</div>
					<div class="col-sm-2 form-group ">
						
						<label class="create_chk">
						<input type="checkbox" id="checkbox_create_role" name="checkbox_create_role" value="create">Create Role
						</label>
					</div>
					<div class="col-sm-2 form-group " id="Sec_new_role_btn" style="display: none;">						
					  <button type="button" id="cmdSaveNewRole" name="cmdSaveNewRole" class="btn btn-primary btn-style2 w100" > Create Roles </button>
					</div>
				  </div>
				</div>

    <?php include("view-role-access-details.php"); ?>
    
    <button <?php if($EXISTING_USER_permission=='Y'){ ?>type="submit" id="cmdSaveRolePermission" name="cmdSaveRolePermission"<?php }else{ ?>disabled="disabled"<?php } ?> class="btn btn-primary btn-style" onclick="" > Save </button>
	</form>
  </div>
  <div id="tabs-2">
	<form action="" method="post" id="Form2" name="Form2" onsubmit = "return chkfld()">
				<input type="hidden" id="hdn_searchField" name="hdn_searchField" value="<?php echo $SearchField; ?>">
					<div class="search-bx search-bx2 clearfix">
				  <div class="cus-form-cont row">
					<?php
						echo $SearchedFieldName;
					?>
					<div class="col-sm-2 form-group">
					  <label> Resource Group </label>
					  <input type="text" id="Text_ResourceGroup" name="Text_ResourceGroup" value="<?php echo $Text_ResourceGroup; ?>" class="form-control" placeholder="" maxlength="25" onclick="SearchResourceGroupPopUp('ResourceGroup')" <?php if($Text_ResourceGroup=='' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>>
					  
					</div>
					
					<div class="col-sm-2 form-group">
					  <label> User Name </label>
					  <input type="hidden" id="h_userid" name="h_userid">
					  <input type="text" id="Text_UserName" name="Text_UserName" value = "<?php echo $Text_UserName; ?>" class="form-control" placeholder="" maxlength="25" oninput="this.value=this.value.toUpperCase()" onclick="SearchPopUp('UserName')" <?php if($Text_ResourceGroup!='' && $Text_UserName==''){ ?>disabled="disabled"<?php } ?>>
					</div>
					
					<div class="col-sm-2 form-group">
					  <label> First Name </label>
					  <input type="text" id="Text_FirstName" name="Text_FirstName" value="<?php echo $Text_FirstName; ?>" class="form-control" placeholder="" maxlength="40" onclick="SearchPopUp('FirstName')" <?php if($Text_ResourceGroup!='' && $Text_UserName==''){ ?>disabled="disabled"<?php } ?>>
					</div>
					
					<div class="col-sm-2 form-group">
					  <label> Last Name </label>
					  <input type="text" id="Text_LastName" name="Text_LastName"  value = "<?php echo $Text_LastName; ?>" class="form-control" placeholder="" maxlength="40" onclick ="SearchPopUp('LastName')" <?php if($Text_ResourceGroup!='' && $Text_UserName==''){ ?>disabled="disabled"<?php } ?>>
					</div>
					
					<div class="col-sm-2 form-group ">						
					  <button type="submit" id="cmdFindRoles" name="cmdFindRoles" class="btn btn-primary btn-style2 w100" > <i class="fa fa-search" aria-hidden="true"></i> Find Users </button>
					</div>
					<div class="col-sm-2 form-group ">	
					<button type="button" id="cmdRefresh" name="cmdRefresh" class="btn btn-primary btn-style2" <?php if($Text_UserName=='' && $Text_ResourceGroup==''){ ?> disabled="disabled"<?php } ?>><i class="fa fa-refresh" aria-hidden="true"></i>Reset</button>
					</div>
				  </div>
				</div>

    <?php include("view-user-access-details.php"); ?>
    <?php if($EXISTING_USER_permission=='Y'){ ?>
    <button type="submit" id="cmdSavePermission" name="cmdSavePermission" class="btn btn-primary btn-style" onclick = "SaveRecords_Validations" <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?> > Save </button>
    <?php }else{ ?>
    <button disabled="disabled" class="btn btn-primary btn-style" onclick = "SaveRecords_Validations" > Save </button>
    <?php } ?>
	</form>
  </div>
</div>
					<?php //include("view-role-details.php"); ?>	
							  
				<!-- end -->
				  </div>
				</div>
			
          </div>
        </div>
	  </div>	  
	</section>
<script>
function makeRequest(url,data)
{
	var http_request = false;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/xml');
						// See note below about this line
					}
				} else if (window.ActiveXObject) { // IE
					try {
						http_request = new ActiveXObject("Msxml2.XMLHTTP");
					} catch (e) {
						try {
							http_request = new ActiveXObject("Microsoft.XMLHTTP");
						} catch (e) {}
					}
				}

				if (!http_request) {
					alert('Giving up :( Cannot create an XMLHTTP instance');
					return false;
				}
				http_request.onreadystatechange = function() { alertContents(http_request); };
				http_request.open('POST', url, true);
				http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				http_request.send(data);
}

function alertContents(http_request)
{
	if (http_request.readyState == 4)
	{
		if (http_request.status == 200)
		{
			if (KEY == "message")
			{
				//document.getElementById("message").innerHTML = http_request.responseText;
				if (document.getElementById("message").innerHTML == "")
				{
					document.getElementById("h_IsDuplicateEntry").value = "";
				}
				else
				{
					document.getElementById("h_IsDuplicateEntry").value = "y";
					document.getElementById("txtLeadName").focus();
					document.getElementById("message").style.display="block";
					return false;
				}
			}
					
			if(KEY == "CheckFavoriteData")
			{
						var s1 = http_request.responseText;	
						s1=s1.trim();				
						str = s1;
						var n;
						n = str.lastIndexOf("No");					
						if (n>=0)//(s1=="No")
						{
							document.getElementById("cmdFavorites").style.backgroundColor = "#f0ad4e";
							s1 = str.substring(0,n);											
						}
						else
						{
							document.getElementById("cmdFavorites").style.backgroundColor = "#000";						
						}					
						document.getElementById("favorite_list").innerHTML = s1;
			}
		}
		else
		{
			document.getElementById(KEY).innerHTML = "";
			alert('There was a problem with the request.');
		}
	}
}	
		
$(document).ready(function(){
	//alert("here");
	
	$( "#tabs" ).tabs({
		<?php if($Text_ResourceGroup!='' || $Text_UserName!=''){ ?>
		active: 1
		<?php } ?>
		});
	
	//document.getElementById("Modal_ViewRoleDetails").style.display = 'block';
	
	setTimeout(function(){
			 if ($("#hdn_searchField").val()!='') {
				    $("#hdn_searchField").val('');
			 }
	   }, 5000);
		
});
$( "#cmdRefresh" ).click(function() {
	$("input[type=text], textarea").val("");
	$("input").removeAttr("disabled");
	$("input:checkbox").removeAttr("checked");
});
$("#checkbox_create_role").change(function() {
	if($(this).is(':checked'))
	{
		$("#Sec_New_rolename").css('display','block');
		$("#Sec_New_roledesc").css('display','block');
		$("#Sec_new_role_btn").css('display','block');
		
		$("#Sec_exist_rolename").css('display','none');
		$("#Sec_exist_roledesc").css('display','none');
		$("#cmdFindUserAccess").attr("disabled", true);
		
	}
	else
	{
		$("#Sec_New_rolename").css('display','none');
		$("#Sec_New_roledesc").css('display','none');
		$("#Sec_new_role_btn").css('display','none');
		
		$("#Sec_exist_rolename").css('display','block');
		$("#Sec_exist_roledesc").css('display','block');
		$("#cmdFindUserAccess").removeAttr("disabled");
		
	}
});
$("#cmdSaveNewRole").click(function(){
	
	$("#cmdSaveRolePermission").click();
	//$("#Form1").submit();
});
	</script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="js/jquery.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>
</html>