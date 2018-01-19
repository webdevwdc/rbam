<?php ob_start ();
	include("conn.php");	
	include 'searchusers.php'; 
	$PageName = "access-management-roles.php";
	$LoginUserId = 1;
	$msg = "";
	//global $Text_LastName ;
	
if (isset($_POST['cmdSavePermission'] ))
{
	$Text_UserName = isset($_POST['Text_UserName'] )? $_POST['Text_UserName']: false;
	/******User Administration******/
	$Check_CreateUser = isset($_POST['Check_CreateUser'] )? $_POST['Check_CreateUser']: false;
	$Check_ViewOnly = isset($_POST['Check_ViewOnly'] )? $_POST['Check_ViewOnly']: false;
	$Check_UpdateOnly = isset($_POST['Check_UpdateOnly'] )? $_POST['Check_UpdateOnly']: false;
	
	/******Billing Administration******/
	$Check_ViewSubscribers = isset($_POST['Check_ViewSubscribers'] )? $_POST['Check_ViewSubscribers']: false;
	$Check_SubmitCustomization = isset($_POST['Check_SubmitCustomization'] )? $_POST['Check_SubmitCustomization']: false;
	$Check_AllowChat = isset($_POST['Check_AllowChat'] )? $_POST['Check_AllowChat']: false;
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
	$Check_AllowBudgetdHours = isset($_POST['Check_AllowBudgetdHours'] )? $_POST['Check_AllowBudgetdHours']: false;
	$Check_SubmittedTime = isset($_POST['Check_SubmittedTime'] )? $_POST['Check_SubmittedTime']: false;
	$Check_PrimaryApprover = isset($_POST['Check_PrimaryApprover'] )? $_POST['Check_PrimaryApprover']: false;
	$Text_RecentTimecards = isset($_POST['Text_RecentTimecards'] )? $_POST['Text_RecentTimecards']: false;
	$Check_RetroAdjustments = isset($_POST['Check_RetroAdjustments'] )? $_POST['Check_RetroAdjustments']: false;
	$Text_MaxDailyLimit = isset($_POST['Text_MaxDailyLimit'] )? $_POST['Text_MaxDailyLimit']: false;
	$Check_FlexibleTimeEntry = isset($_POST['Check_FlexibleTimeEntry'] )? $_POST['Check_FlexibleTimeEntry']: false;
	$Check_EnforceTimeEntry = isset($_POST['Check_EnforceTimeEntry'] )? $_POST['Check_EnforceTimeEntry']: false;
	$Check_EmployeeAliases = isset($_POST['Check_EmployeeAliases'] )? $_POST['Check_EmployeeAliases']: false;
	$Text_AllowRetroUpdates = isset($_POST['Text_AllowRetroUpdates'] )? $_POST['Text_AllowRetroUpdates']: false;
	$Check_CopyTimesheetEmployees = isset($_POST['Check_CopyTimesheetEmployees'] )? $_POST['Check_CopyTimesheetEmployees']: false;
	$Check_CreateTimeSheet = isset($_POST['Check_CreateTimeSheet'] )? $_POST['Check_CreateTimeSheet']: false;
	$Check_ApproveTimeSheet = isset($_POST['Check_ApproveTimeSheet'] )? $_POST['Check_ApproveTimeSheet']: false;
	$Check_CreateTimeSheetTeam = isset($_POST['Check_CreateTimeSheetTeam'] )? $_POST['Check_CreateTimeSheetTeam']: false;
	$Check_ApproveTimeSheetTeam = isset($_POST['Check_ApproveTimeSheetTeam'] )? $_POST['Check_ApproveTimeSheetTeam']: false;
	$Check_CreateSupervisorTimeSheet = isset($_POST['Check_CreateSupervisorTimeSheet'] )? $_POST['Check_CreateSupervisorTimeSheet']: false;
	
	/******Approval Management******/
	$Check_AllowPreApproval = isset($_POST['Check_AllowPreApproval'] )? $_POST['Check_AllowPreApproval']: false;
	$Check_ApproverType = isset($_POST['Check_ApproverType'] )? $_POST['Check_ApproverType']: false;
	$Check_ApproveDirectReport = isset($_POST['Check_ApproveDirectReport'] )? $_POST['Check_ApproveDirectReport']: false;
	$Check_UpadteApprovedTimesheet = isset($_POST['Check_UpadteApprovedTimesheet'] )? $_POST['Check_UpadteApprovedTimesheet']: false;
	$Check_FlyApprovalRequest = isset($_POST['Check_FlyApprovalRequest'] )? $_POST['Check_FlyApprovalRequest']: false;
	$Check_ProjectBasedApproval = isset($_POST['Check_ProjectBasedApproval'] )? $_POST['Check_ProjectBasedApproval']: false;
	
	
	$UserID = getvalue("cxs_users","USER_ID","where USER_NAME='$Text_UserName'");
	if($UserID!='')
	{
		$noofrecords = 0;
		$qry = "Select * from cxs_am_user_admin  where USER_ID = $UserID";
		$result = mysql_query($qry);
		$noofrecords = mysql_num_rows($result);
		$insArr['USER_ID'] = $UserID;

		$insArr['CREATE_NEW_USER'] = ($Check_CreateUser==1)?"Y":"N";
		$insArr['VIEW_ONLY'] 		= ($Check_ViewOnly==1)?"Y":"N";
		$insArr['UPDATE_ONLY'] 		= ($Check_UpdateOnly==1)?"Y":"N";
		$insArr['VIEW_SUBSCRIBERS'] = ($Check_ViewSubscribers==1)?"Y":"N";
		$insArr['SUBMIT_CUSTOM'] 	= ($Check_SubmitCustomization==1)?"Y":"N";
		$insArr['ALLOW_CHAT'] 		= ($Check_AllowChat==1)?"Y":"N";
		$insArr['VIEW_SLA'] 		= ($Check_ViewSLA==1)?"Y":"N";
		$insArr['EXISTING_USER'] 	= ($Check_ExistUserAdmin==1)?"Y":"N";
		$insArr['REMOVE_ACCESS'] 	= ($Check_RemoveAccess==1)?"Y":"N";
		$insArr['USAGE_HISTORY'] 	= ($Check_UsageHistory==1)?"Y":"N";
		
		$insArr['LAST_UPDATED_BY']	= $LoginUserId;
		if($noofrecords==0)
		{
			$insArr['CREATION_DATE']	= date('Y-m-d H:i:s'); 
			$insArr['CREATED_BY']		= $LoginUserId;
			insertdata("cxs_am_user_admin",$insArr);	
		}
		else
		{
			updatedata("cxs_am_user_admin",$insArr,"Where USER_ID = $UserID");
		}
		/******Time Accounting Rules*****/
		$norecords = 0;
		$qry1 = "Select * from cxs_am_ta_rules where USER_ID = $UserID";
		$result1 = mysql_query($qry1);
		$norecords = mysql_num_rows($result1);
		unset ($insArr);
		$insArr['USER_ID']				= $UserID;
		$insArr['BIZ_MSG_FLAG'] 		= ($Check_BusinessMessage==1)?"Y":"N";
		$insArr['AUDIT_FLAG'] 			= ($Check_SetAudit==1)?"Y":"N";
		$insArr['ALLOW_TK_FLAG'] 		= ($Check_AllowTimekeeping==1)?"Y":"N";
		$insArr['ALLOW_TIMEZONE'] 		= ($Check_TimezoneProjects==1)?"Y":"N";
		$insArr['DEFAULT_TIMEZONE'] 	= $Combo_DefaultTimezone;		
		$insArr['DEFAULT_DATE_FORMAT'] 	= $Combo_DefaultDateFormat;
		$insArr['ENABLE_PA'] 			= ($Check_ProjectAccounting==1)?"Y":"N";
		$insArr['ALLOW_NEGATIVE'] 		= ($Check_AllowNegativeTimeEntry==1)?"Y":"N";
		$insArr['DISPLAY_BUDGET'] 		= ($Check_AllowBudgetdHours==1)?"Y":"N";
		$insArr['UPDATE_SUBMITTED'] 	= ($Check_SubmittedTime==1)?"Y":"N";
		$insArr['OVERRIDE_PRIMARY'] 	= ($Check_PrimaryApprover==1)?"Y":"N";
		$insArr['RECENT_TIMECARDS'] 	= $Text_RecentTimecards;
		$insArr['RETRO_ADJUST'] 		= ($Check_RetroAdjustments==1)?"Y":"N";
		$insArr['MAX_DAILY_LIMIT'] 		= $Text_MaxDailyLimit;
		$insArr['AFT_ENTRY'] 			= ($Check_FlexibleTimeEntry==1)?"Y":"N";
		$insArr['ENFORCE_TIME_WBS'] 	= ($Check_EnforceTimeEntry==1)?"Y":"N";
		$insArr['CREATE_EMP_ALIAS_FLAG'] = ($Check_EmployeeAliases==1)?"Y":"N";
		$insArr['RETRO_PERIOD_NUM'] 	= $Text_AllowRetroUpdates;
		$insArr['ALLOW_COPY'] 			= ($Check_CopyTimesheetEmployees==1)?"Y":"N";
		$insArr['COPY_ANYONE_TS_FLAG'] 	= ($Check_CreateTimeSheet==1)?"Y":"N";
		$insArr['APPROVE_ANYONE_TS'] 	= ($Check_ApproveTimeSheet==1)?"Y":"N";
		$insArr['CREATE_ANYONE_TS'] 	= ($Check_CreateTimeSheetTeam==1)?"Y":"N";
		$insArr['APPROVE_ANYONE_TS_TEAM']= ($Check_ApproveTimeSheetTeam==1)?"Y":"N";
		$insArr['ALLOW_SUP_TS'] 		= ($Check_CreateSupervisorTimeSheet==1)?"Y":"N";
		$insArr['LAST_UPDATED_BY']		= $LoginUserId;
		
		if($norecords==0)
		{
			$insArr['CREATION_DATE']	= date('Y-m-d H:i:s'); 
			$insArr['CREATED_BY']		= $LoginUserId;
			insertdata("cxs_am_ta_rules",$insArr);	
		}
		else
		{
			updatedata("cxs_am_ta_rules",$insArr,"Where USER_ID = $UserID");
		}
		
		/******Time Accounting Modules******/	
		$qry2 = "Delete from cxs_ta_modules where USER_ID = $UserID";
		$result2 = mysql_query($qry2);	
		unset ($insArr);
		for ($i = 1; $i <= 13; $i++) 
		{	
			$RowId = isset($_POST["Row$i"] )? $_POST["Row$i"]: false;				
			$Create = isset($_POST["Check_Create$i"] )? $_POST["Check_Create$i"]: false;
			$Update = isset($_POST["Check_Update$i"] )? $_POST["Check_Update$i"]: false;
			$View = isset($_POST["Check_View$i"] )? $_POST["Check_View$i"]: false;
			$Audit = isset($_POST["Check_Audit$i"] )? $_POST["Check_Audit$i"]: false;
		
			if($Create == "" && $Update == "" && $View=="" && $Audit=="")
			{
				
			}
			else
			{
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
		
		/******Approval Management******/
		unset ($insArr);
		for ($i = 1; $i <= 5; $i++) 
		{
			
			$norecords = 0;
			$qry1 = "Select * from cxs_am_approval_mgmt where USER_ID = $UserID AND ROWNO = $i";
			$result1 = mysql_query($qry1);
			$norecords = mysql_num_rows($result1);
			unset ($insArr);

			$RowId = isset($_POST["Row$i"] )? $_POST["Row$i"]: false;				
			$ApproverName = isset($_POST["Combo_ApproverName$i"] )? $_POST["Combo_ApproverName$i"]: false;
			$ApproverType = isset($_POST["Combo_ApproverType$i"] )? $_POST["Combo_ApproverType$i"]: false;
					
			if($ApproverName == "" && $ApproverType =="")
			{
				
			}
			else
			{
				$insArr['USER_ID']			    	= $UserID;
				$insArr['ALLOW_PREAPPROVAL'] 		= ($Check_AllowPreApproval==1)?"Y":"N";
				$insArr['APPROVER_TYPE_FLAG'] 		= ($Check_ApproverType==1)?"Y":"N";
				$insArr['APPROVE_DIRECT_REPORT'] 	= ($Check_ApproveDirectReport==1)?"Y":"N";
				$insArr['ALLOW_UPDATE_APPROVE_TS'] 	= ($Check_UpadteApprovedTimesheet==1)?"Y":"N";
				$insArr['ALLOW_ON_THE_FLY'] 		= ($Check_FlyApprovalRequest==1)?"Y":"N";
				$insArr['PROJECT_BASED_APPROVAL'] 	= ($Check_ProjectBasedApproval==1)?"Y":"N";
				$insArr['REFERENCE_APPROVER_ID'] 	= $ApproverName;
				$insArr['APPROVER_TYPE'] 		 	= $ApproverType;
				
				$insArr['LAST_UPDATED_BY']			= $LoginUserId;
				$insArr['ROWNO'] 					= $i;
				
				if($norecords==0)
				{
					$insArr['CREATION_DATE']	= date('Y-m-d H:i:s'); 
					$insArr['CREATED_BY']		= $LoginUserId;
					insertdata("cxs_am_approval_mgmt",$insArr);	
				}
				else
				{
					//$insArr['LAST_UPDATED_BY']	= $LoginUserId;
					updatedata("cxs_am_approval_mgmt",$insArr,"Where USER_ID = $UserID AND ROWNO = $i");
				}
			}
		}
		
		/******Temporary Approver******/
		unset ($insArr);
		for ($i = 1; $i <= 6; $i++) 
		{	
			$norecords = 0;
			$qry1 = "Select * from cxs_temp_approver where USER_ID = $UserID AND ROWNO = $i";
			$result1 = mysql_query($qry1);
			$norecords = mysql_num_rows($result1);
			unset ($insArr);
		
			$RowId = isset($_POST["TempAppRow$i"] )? $_POST["TempAppRow$i"]: false;				
			$PeriodId = isset($_POST["Combo_PeriodId$i"] )? $_POST["Combo_PeriodId$i"]: false;
			$AliasName = isset($_POST["Combo_AliasName$i"] )? $_POST["Combo_AliasName$i"]: false;
			$ActiveFlag = isset($_POST["Check_ActiveFlag$i"] )? $_POST["Check_ActiveFlag$i"]: false;
			
			if($PeriodId == "" && $AliasName =="")
			{
				
			}
			else
			{
				$insArr['USER_ID']		= $UserID;
				$insArr['PERIOD_ID'] 	= $PeriodId;
				$insArr['ALIAS_ID'] 	= $AliasName;
				$insArr['ACTIVE_FLAG'] 	= ($ActiveFlag==1)?"Y":"N";
				
				$insArr['LAST_UPDATED_BY']	= $LoginUserId;
		 		$insArr['ROWNO'] 			= $i;
				
				if($norecords==0)
				{
					$insArr['CREATION_DATE']	= date('Y-m-d H:i:s'); 
					$insArr['CREATED_BY']		= $LoginUserId;
					insertdata("cxs_temp_approver",$insArr);	
				}
				else
				{
				//	$insArr['LAST_UPDATED_BY']	= $LoginUserId;
					updatedata("cxs_temp_approver",$insArr,"Where USER_ID = $UserID AND ROWNO = $i");
				}
			}
		}
		DisplayRecords($Text_UserName);
	}
	else
	{
		$msg = "No Record Found For Save";
	}
}

//$Text_FirstName = "test name";
	function DisplayRecords($Text_UserName)	
	{
		global $Text_FirstName,$Text_LastName,$CreateUser,$ViewOnly,$UpdateOnly,$ViewSubscribers,$SubmitCustom;
		global $AllowChat,$ViewSLA,$ExistUserAdmin,$RemoveAccess,$UsageHistory,$UACreatedBy;
		global $UAUpdatedBy,$UACreationDate,$UALastUpdateDate,$BusinessMessage,$SetAudit,$AllowTimekeeping;
		global $TimezoneProjects,$DefaultTimezone,$DefaultDateFormat,$ProjectAccounting,$AllowNegativeTimeEntry;
		global $AllowBudgetdHours,$SubmittedTime,$PrimaryApprover,$RecentTimecards,$RetroAdjustments,$MaxDailyLimit;
		global $FlexibleTimeEntry,$EnforceTimeEntry,$EmployeeAliases,$AllowRetroUpdates,$CopyTimesheetEmployees;
		global $CreateTimeSheet,$ApproveTimeSheet,$CreateTimeSheetTeam,$ApproveTimeSheetTeam,$CreateSupervisorTimeSheet;		
		global $TARCreatedBy,$TARUpdatedBy,$TARCreationDate,$TARLastUpdateDate,$AllowPreApproval,$ApproverType;
		global $ApproveDirectReport,$UpadteApprovedTimesheet,$FlyApprovalRequest,$ProjectBasedApproval;
		global $AMCreatedBy,$AMUpdatedBy,$AMCreationDate,$AMLastUpdateDate;
			
		$qry = "SELECT cxs_users.*,cxs_resources.*,cxs_am_user_admin.*,cxs_am_ta_rules.*,cxs_am_approval_mgmt.*,
			cxs_am_user_admin.CREATED_BY as ua_createdby,cxs_am_user_admin.CREATION_DATE	as ua_createddt,
			cxs_am_user_admin.LAST_UPDATED_BY as ua_lastupdatedby,cxs_am_user_admin.LAST_UPDATE_DATE	as ua_lastupdateddt,
			cxs_am_ta_rules.CREATED_BY as ta_createdby,cxs_am_ta_rules.CREATION_DATE	as ta_createddt,
			cxs_am_ta_rules.LAST_UPDATED_BY as ta_lastupdatedby,cxs_am_ta_rules.LAST_UPDATE_DATE	as ta_lastupdateddt,
			cxs_am_approval_mgmt.CREATED_BY as apmgmt_createdby,cxs_am_approval_mgmt.CREATION_DATE	as apmgmt_createddt,
			cxs_am_approval_mgmt.LAST_UPDATED_BY as apmgmt_lastupdatedby,cxs_am_approval_mgmt.LAST_UPDATE_DATE	as apmgmt_lastupdateddt from cxs_users 
		Inner join cxs_resources on cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID  
		LEFT join cxs_am_user_admin on cxs_am_user_admin.USER_ID = cxs_users.USER_ID
		LEFT join cxs_am_ta_rules on cxs_am_ta_rules.USER_ID = cxs_users.USER_ID	
		LEFT join cxs_am_approval_mgmt on cxs_am_approval_mgmt.USER_ID = cxs_users.USER_ID			
		where USER_NAME = '$Text_UserName'";
		
		$result = mysql_query($qry);
		$TotalRecords = mysql_num_rows($result);
		while($row=mysql_fetch_array($result))
		{
			$Text_FirstName = $row['FIRST_NAME'];
			$Text_LastName = $row['LAST_NAME'];	
			/******User Administration******/
			$CreateUser 	 = $row['CREATE_NEW_USER'];
			$ViewOnly 		 = $row['VIEW_ONLY'];
			$UpdateOnly 	 = $row['UPDATE_ONLY'];
			/******Billing Administration******/
			$ViewSubscribers = $row['VIEW_SUBSCRIBERS'];
			$SubmitCustom	 = $row['SUBMIT_CUSTOM'];
			$AllowChat		 = $row['ALLOW_CHAT'];
			$ViewSLA		 = $row['VIEW_SLA'];
			$ExistUserAdmin  = $row['EXISTING_USER'];
			$RemoveAccess	 = $row['REMOVE_ACCESS'];
			$UsageHistory	 = $row['USAGE_HISTORY'];
			$UACreatedBy  	 = $row['ua_createdby'];
			$UAUpdatedBy 		= $row['ua_lastupdatedby'];
			//$UACreationDate 	= $row['ua_createddt'];
		//	$UALastUpdateDate   = $row['ua_lastupdateddt'];
			if((!is_null($row['ua_createddt'])) && (($row['ua_createddt'])!='0000-00-00 00:00:00') )
			{
				$UACreationDate = date('m/d/Y', strtotime($row['ua_createddt']));	
			}
			$UALastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['ua_lastupdateddt']));																	
			/******Time Accounting Rules******/
			$BusinessMessage 	= $row['BIZ_MSG_FLAG'];
			$SetAudit 			= $row['AUDIT_FLAG'];
			$AllowTimekeeping 	= $row['ALLOW_TK_FLAG'];
			$TimezoneProjects 	= $row['ALLOW_TIMEZONE'];
			$DefaultTimezone 	= $row['DEFAULT_TIMEZONE'];
			$DefaultDateFormat 	= $row['DEFAULT_DATE_FORMAT'];
			$ProjectAccounting 	= $row['ENABLE_PA'];
			$AllowNegativeTimeEntry = $row['ALLOW_NEGATIVE'];
			$AllowBudgetdHours 	= $row['DISPLAY_BUDGET'];
			$SubmittedTime 		= $row['UPDATE_SUBMITTED'];
			$PrimaryApprover 	= $row['OVERRIDE_PRIMARY'];
			$RecentTimecards 	= $row['RECENT_TIMECARDS'];
			$RetroAdjustments 	= $row['RETRO_ADJUST'];
			$MaxDailyLimit 		= $row['MAX_DAILY_LIMIT'];
			$FlexibleTimeEntry 	= $row['AFT_ENTRY'];
			$EnforceTimeEntry 	= $row['ENFORCE_TIME_WBS'];
			$EmployeeAliases 	= $row['CREATE_EMP_ALIAS_FLAG'];
			$AllowRetroUpdates 	= $row['RETRO_PERIOD_NUM'];
			$CopyTimesheetEmployees = $row['ALLOW_COPY'];
			$CreateTimeSheet 	= $row['COPY_ANYONE_TS_FLAG'];
			$ApproveTimeSheet 	= $row['APPROVE_ANYONE_TS'];
			$CreateTimeSheetTeam = $row['CREATE_ANYONE_TS'];
			$ApproveTimeSheetTeam = $row['APPROVE_ANYONE_TS_TEAM'];
			$CreateSupervisorTimeSheet = $row['ALLOW_SUP_TS'];		
			$TARCreatedBy  		= $row['ta_createdby'];
			$TARUpdatedBy 		= $row['ta_lastupdatedby'];
			$TARCreationDate 	= $row['ta_createddt'];
			$TARLastUpdateDate 	= $row['ta_lastupdateddt'];

			/******Approval Management******/
			$AllowPreApproval 		= $row['ALLOW_PREAPPROVAL'];
			$ApproverType 			= $row['APPROVER_TYPE_FLAG'];
			$ApproveDirectReport 	= $row['APPROVE_DIRECT_REPORT'];
			$UpadteApprovedTimesheet = $row['ALLOW_UPDATE_APPROVE_TS'];
			$FlyApprovalRequest 	= $row['ALLOW_ON_THE_FLY'];
			$ProjectBasedApproval 	= $row['PROJECT_BASED_APPROVAL'];
			$AMCreatedBy  		= $row['apmgmt_createdby'];
			$AMUpdatedBy 		= $row['apmgmt_lastupdatedby'];
			$AMCreationDate 	= $row['apmgmt_createddt'];
			$AMLastUpdateDate 	= $row['apmgmt_lastupdateddt'];
		}
		
		$qry = "select * from cxs_ta_modules left join  cxs_users on cxs_users.USER_ID = cxs_ta_modules.USER_ID where  USER_NAME = '$Text_UserName' order by ROWNO";
		$result = mysql_query($qry);
		$TotalRecords1 = mysql_num_rows($result);
		while($row = mysql_fetch_array($result))
		{
			$DBRowNo = $row['ROWNO'];
			
			global ${ModuleName.$DBRowNo};
			global ${CreatePriv.$DBRowNo};
			global ${UpdatePriv.$DBRowNo};
			global ${ViewPriv.$DBRowNo} ;
			global ${EnableAudit.$DBRowNo};			
			global $TAMCreatedBy;
			global $TAMUpdatedBy;
			global $TAMCreationDate;
			global $TAMLastUpdateDate;
			
			${ModuleName.$DBRowNo} = $row['MODULE_NAME'];
			${CreatePriv.$DBRowNo} = $row['CREATE_PRIV'];			
			${UpdatePriv.$DBRowNo} = $row['UPDATE_PRIV'];
			${ViewPriv.$DBRowNo} = $row['VIEW_PRIV'];
			${EnableAudit.$DBRowNo} = $row['ENABLE_AUDIT'];
			
			$TAMCreatedBy  		= $row['USER_NAME'];
			$TAMUpdatedBy 		= $row['USER_NAME'];
			$TAMCreationDate 	= $row['CREATION_DATE'];
			$TAMLastUpdateDate 	= $row['LAST_UPDATE_DATE'];
		}
		if ($TotalRecords==0 && TotalRecords1==0)
		{
			$msg = "No Record Found";
		}
		
	}

if (isset($_POST['cmdFindRoles'] ))
{
	
	$Text_UserName = isset($_POST['Text_UserName'] )? $_POST['Text_UserName']: false;		
	DisplayRecords($Text_UserName);	
}

?>

<script type="text/javascript" >
	function chkfld()
	{
		
		if(document.getElementById("Text_UserName").value == "" )
		{
			alert("Please Enter User Name");
			document.getElementById("Text_UserName").focus();
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
	function SearchPopUp()
	{	
		$('#SearchUsers').modal();		
	}
	$('.popover-dismiss').popover({
		trigger: 'focus'
	})
</script>

<!DOCTYPE html>
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
</head>

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
						<button type="button" id = "cmdFavorites" name = "cmdFavorites" onclick = "CheckFavoriteData();" class="btn btn-warning fav-ico" style = "<?php echo $s_Style;?>"> <i class="fa fa-star"></i></button>
				  </div>
          </div>
          
		  <div class="cont-box ">
            <div class="pge-hd">
              <h2 class="sec-title"> Access Management Roles </h2>
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
			
			<form action="" method="post"id="Form1" name="Form1" onsubmit = "return chkfld()">
				<!-- Search Bar -->
				<div class="search-bx search-bx2">
				  <div class="cus-form-cont">
					
					<div class="col-sm-3 form-group">
					  <label> User Name </label>
					  <input type="text" id="Text_UserName" name="Text_UserName"value = "<?php echo $Text_UserName; ?>" class="form-control" placeholder="" maxlength="25" oninput="this.value=this.value.toUpperCase()" onclick="SearchPopUp()">
					</div>
					
					<div class="col-sm-3 form-group">
					  <label> First Name </label>
					  <input type="text" id="Text_FirstName" name="Text_FirstName" value = "<?php echo $Text_FirstName; ?>" class="form-control" placeholder="" maxlength="40" onclick ="SearchPopUp()">
					</div>
					
					<div class="col-sm-3 form-group">
					  <label> Last Name </label>
					  <input type="text" id="Text_LastName" name="Text_LastName"  value = "<?php echo $Text_LastName; ?>" class="form-control" placeholder="" maxlength="40" onclick ="SearchPopUp()">
					</div>
					
					<div class="col-sm-3 form-group ">						
					  <button type="submit" id = "cmdFindRoles" name = "cmdFindRoles" class="btn btn-primary btn-style2 w100" > <i class="fa fa-search" aria-hidden="true"></i> Find Roles </button>
					</div>
				  </div>
				</div>

				<!-- Accordian -->
				<div class="col-md-12">
				  <div class="row tab-edit">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
						  <h4 class="panel-title"> 
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> User Administration <i class="fa fa-plus"></i> </a> 
							<span class="over-eyecont">
								<?php
									$CreatedByName = "";
									$UpdatedByName = "";
									if($UACreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $UACreatedBy");
									if($UAUpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $UAUpdatedBy");
								?>
							  <button type="button" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover"  data-html="true"  data-placement="left" data-content="
								Created By:  <?php  echo $CreatedByName; ?><br>
								Updated By:  <?php  echo $UpdatedByName; ?><br>Creation Date: <?php  echo $UACreationDate; ?><br>Last Update Date: <?php  echo $UALastUpdateDate; ?> "> 
								<i class=" fa fa-eye"></i> 
							  </button>
							</span> 
						  </h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
					  <!--  -->
						<div class="col-md-12">
						  <h2 class="f-sec-hd"> User Administration </h2>
						</div>
						<div class="col-md-12">
						  <div class="row">
							<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_CreateUser" name="Check_CreateUser" <?php if($CreateUser == "Y"){ ?> checked="checked" <?php } ?>  value="1">Create New Users </label>
							</div>
								
							<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_ViewOnly" name="Check_ViewOnly" <?php if($ViewOnly == "Y"){ ?> checked="checked" <?php } ?> value="1">View Only </label>
							</div>
							
							<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_UpdateOnly" name="Check_UpdateOnly" <?php if($UpdateOnly == "Y"){ ?> checked="checked" <?php } ?> value="1">Update Only </label>
							</div>
						  </div>
						</div>
						<!-- -->
						<div class="col-md-12">
						  <h2 class="f-sec-hd"> Billing Administration </h2>
						</div>
						<div class="col-md-12">
						  <div class="row">
							<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_ViewSubscribers" name="Check_ViewSubscribers" <?php if($ViewSubscribers == "Y"){ ?> checked="checked" <?php } ?> value="1">View Subscribers </label>
							</div>
								
							<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_SubmitCustomization" name="Check_SubmitCustomization" <?php if($SubmitCustom == "Y"){ ?> checked="checked" <?php } ?> value="1">Submit Customization </label>
							</div>
								
							<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_AllowChat" name="Check_AllowChat" <?php if($AllowChat == "Y"){ ?> checked="checked" <?php } ?> value="1">Allow Chat </label>
							</div>
								
							<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_ViewSLA" name="Check_ViewSLA" <?php if($ViewSLA == "Y"){ ?> checked="checked" <?php } ?> value="1">View SLA </label>
							</div>
								
							<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_ExistUserAdmin" name="Check_ExistUserAdmin" <?php if($ExistUserAdmin == "Y"){ ?> checked="checked" <?php } ?> value="1">Existing User Admin </label>
							</div>
								
							<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_RemoveAccess" name="Check_RemoveAccess" <?php if($RemoveAccess == "Y"){ ?> checked="checked" <?php } ?> value="1">Remove Access </label>
							</div>
								
							<div class="checkbox col-md-4">
							  <label><input type="checkbox" id="Check_UsageHistory" name="Check_UsageHistory" <?php if($UsageHistory == "Y"){ ?> checked="checked" <?php } ?> value="1">Usage History </label>
							</div>
						  </div>
						</div>
					  </div>
					</div>
					  </div>
					  <!-- -->
					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
						  <h4 class="panel-title"> 
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Time Accounting Rules <i class="fa fa-plus"></i></a>
							<span class="over-eyecont">
								<?php
									$CreatedByName = "";
									$UpdatedByName = "";
									if($TARCreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $TARCreatedBy");
									if($TARUpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $TARUpdatedBy");
								?>
							  <button type="button" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
								Created By:  <?php  echo $CreatedByName; ?><br>
								Updated By:  <?php  echo $UpdatedByName; ?><br>
								Creation Date: <?php  echo $TARCreationDate; ?><br>
								Last Update Date: <?php  echo $TARLastUpdateDate; ?> "> 
								<i class=" fa fa-eye"></i> 
							  </button>
							</span>
						  </h4>
						</div>
						
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						  <div class="panel-body">
							<div class="col-md-12">
							  <h2 class="f-sec-hd"> Time Accounting Rules </h2>
							</div>
							<div class="col-md-12">
							  <div class="data-bx">
								<div class="table-responsive time-acc-bx ">
								  <table class="table table-bordered">
								<thead>
								  <tr>
									<th width="90%"> Prefrences </th>
									<th width="10%"> User </th>
								  </tr>
								</thead>
								<tbody>
								  <tr>
									<td> Enable Business Messages </td>
									<td><input type="checkbox" id="Check_BusinessMessage" name="Check_BusinessMessage" <?php if($BusinessMessage == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
									  
								  <tr>
									<td> Set Audit On </td>
									<td><input type="checkbox" id="Check_SetAudit" name="Check_SetAudit" <?php if($SetAudit == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
									  
								  <tr>
									<td> Allow Timekeeping </td>
									<td><input type="checkbox" id="Check_AllowTimekeeping" name="Check_AllowTimekeeping" <?php if($AllowTimekeeping == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
									  
								  <tr>
									<td> Use Timezone from Projects </td>
									<td><input type="checkbox" id="Check_TimezoneProjects" name="Check_TimezoneProjects" <?php if($TimezoneProjects == "Y"){ ?> checked="checked" <?php } ?> value="1" disabled></td>
								  </tr>
								  
								  <tr>
									<td> Default Timezone </td>
									<td>
									  <select id="Combo_DefaultTimezone" name="Combo_DefaultTimezone" class="form-control">
										<option value="Option 1"></option>										
									  </select>
									</td>
								  </tr>
									  
								  <tr>
									<td> Default Date Format </td>
									<td>
									  <select id="Combo_DefaultDateFormat" name="Combo_DefaultDateFormat" value="<?php echo $DefaultDateFormat; ?>" class="form-control">
										<option value="mm/dd/yyyy">mm/dd/yyyy</option>
										<option value="dd/mm/yyyy">dd/mm/yyyy</option>
										<option value="yyyy/mm/dd">yyyy/mm/dd</option>
									  </select>
									</td>
								  </tr>
									  
								  <tr>
									<td> Enable Project Accounting </td>
									<td><input type="checkbox" id="Check_ProjectAccounting" name="Check_ProjectAccounting" <?php if($ProjectAccounting == "Y"){ ?> checked="checked" <?php } ?>  value="1" disabled></td>
								  </tr>
								  
								  <tr>
									<td> Allow Negative Time Entry </td>
									<td><input type="checkbox" id="Check_AllowNegativeTimeEntry" name="Check_AllowNegativeTimeEntry" <?php if($AllowNegativeTimeEntry == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
								  
								  <tr>
									<td> Display Budgetd Hours </td>
									<td><input type="checkbox" id="Check_AllowBudgetdHours" name="Check_AllowBudgetdHours" <?php if($AllowBudgetdHours == "Y"){ ?> checked="checked" <?php } ?> value="1" disabled></td>
								  </tr>
								  
								  <tr>
									<td> Update Hours on Submitted Time </td>
									<td><input type="checkbox" id="Check_SubmittedTime" name="Check_SubmittedTime" <?php if($SubmittedTime == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
								  
								  <tr>
									<td> Override Primary Approver </td>
									<td><input type="checkbox" id="Check_PrimaryApprover" name="Check_PrimaryApprover" <?php if($PrimaryApprover == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
								  
								  <tr>
									<td> Number of Recent Timecards to Display </td>
									<td><input type="text" id="Text_RecentTimecards" name="Text_RecentTimecards" class="form-control" value="<?php echo $RecentTimecards; ?>" placeholder="" maxlength="2" onkeypress="return onlyNos(event,this);"></td>
								  </tr>
									  
								  <tr>
									<td> Allow RetroAdjustments </td>
									<td><input type="checkbox" id="Check_RetroAdjustments" name="Check_RetroAdjustments" <?php if($RetroAdjustments == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
									  
								  <tr>
									<td> Maximum Daily Limit </td>
									<td><input type="text" id="Text_MaxDailyLimit" name="Text_MaxDailyLimit" class="form-control" value="<?php echo ($MaxDailyLimit=="")?"24":$MaxDailyLimit; ?>" placeholder="" maxlength="2" onkeypress="return onlyNos(event,this);"></td>
								  </tr>
									  
								  <tr>
									<td> Allow Flexible Time Entry </td>
									<td><input type="checkbox" id="Check_FlexibleTimeEntry" name="Check_FlexibleTimeEntry" <?php if($FlexibleTimeEntry == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
									  
								  <tr>
									<td> Enforce Time Entry for Optional Project WBS Segments </td>
									<td><input type="checkbox" id="Check_EnforceTimeEntry" name="Check_EnforceTimeEntry" <?php if($EnforceTimeEntry == "Y"){ ?> checked="checked" <?php } ?> value="1" disabled></td>
								  </tr>
									  
								  <tr>
									<td> Create Employee Aliases </td>
									<td><input type="checkbox" id="Check_EmployeeAliases" name="Check_EmployeeAliases" <?php if($EmployeeAliases == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
								  
								  <tr>
									<td> Number of Periods allow for Retro Updates </td>
									<td><input type="text" id="Text_AllowRetroUpdates" name="Text_AllowRetroUpdates" class="form-control" value="<?php echo $AllowRetroUpdates; ?>" placeholder="" maxlength="2" onkeypress="return onlyNos(event,this);"></td>
								  </tr>
								  
								  <tr>
									<td> Allow Copy TimeSheet between Employees </td>
									<td><input type="checkbox" id="Check_CopyTimesheetEmployees" name="Check_CopyTimesheetEmployees" <?php if($CopyTimesheetEmployees == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
								  </tr>
								</tbody>
							  </table>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
						  <h4 class="panel-title"> 
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Time Approval	Rules <i class="fa fa-plus"></i> </a>
							<span class="over-eyecont">
								<?php
									$CreatedByName = "";
									$UpdatedByName = "";
									if($TARCreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $TARCreatedBy");
									if($TARUpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $TARUpdatedBy");
								?>
							  <button type="button" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
							    Created By:  <?php  echo $CreatedByName; ?><br>
								Updated By:  <?php  echo $UpdatedByName; ?><br>
								Creation Date: <?php  echo $TARCreationDate; ?><br>
								Last Update Date: <?php  echo $TARLastUpdateDate; ?>"> 
								<i class=" fa fa-eye"></i> 
							  </button>
							</span> 
						  </h4>
						</div>
						
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						  <div class="panel-body">
						  <!-- -->
							<div class="col-md-12">
							  <h2 class="f-sec-hd"> Time Approval Rules </h2>
							</div>
							<div class="col-md-12">
							  <div class="row">
								
								<div class="checkbox col-md-4">
								  <label><input type="checkbox" id="Check_CreateTimeSheet" name="Check_CreateTimeSheet" <?php if($CreateTimeSheet == "Y"){ ?> checked="checked" <?php } ?> value="1">Create Anyone's TimeSheet </label>
								</div>
								
								<div class="checkbox col-md-4">
								  <label><input type="checkbox" id="Check_ApproveTimeSheet" name="Check_ApproveTimeSheet" <?php if($ApproveTimeSheet == "Y"){ ?> checked="checked" <?php } ?> value="1">Approve Anyone's TimeSheet </label>
								</div>
								
								<div class="checkbox col-md-4">
								  <label><input type="checkbox" id="Check_CreateTimeSheetTeam" name="Check_CreateTimeSheetTeam" <?php if($CreateTimeSheetTeam == "Y"){ ?> checked="checked" <?php } ?> value="1">Create Anyone's TimeSheet in a Team </label>
								</div>
								
								<div class="checkbox col-md-4">
								  <label><input type="checkbox" id="Check_ApproveTimeSheetTeam" name="Check_ApproveTimeSheetTeam" <?php if($ApproveTimeSheetTeam == "Y"){ ?> checked="checked" <?php } ?> value="1" disabled>Approve Anyone's TimeSheet in a Team </label>
								</div>
								
								<div class="checkbox col-md-4">
								  <label><input type="checkbox" id="Check_CreateSupervisorTimeSheet" name="Check_CreateSupervisorTimeSheet" <?php if($CreateSupervisorTimeSheet == "Y"){ ?> checked="checked" <?php } ?> value="1" disabled>Allow Supervisor to Create TimeSheet </label>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					  <!-- -->

					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFour">
						  <h4 class="panel-title"> 
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Time Accounting Modules <i class="fa fa-plus"></i> </a>
							<span class="over-eyecont"> 								
							  <button type="button" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
							    Created By:  <?php  echo $TAMCreatedBy; ?><br>								
								Updated By:  <?php  echo $TAMUpdatedBy; ?><br>
								Creation Date: <?php  echo $TAMCreationDate; ?><br>
								Last Update Date: <?php  echo $TAMLastUpdateDate; ?>"> 
								<i class=" fa fa-eye"></i> 
							  </button>
							</span> 
						  </h4>
						</div>
						
						<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
						  <div class="panel-body">
						  <!-- -->
							<div class="col-md-12">
							  <h2 class="f-sec-hd"> Time Accounting Modules </h2>
							</div>
						  
						  <div class="col-md-12">
							<div class="data-bx">
							  <div class="table-responsive td-center">
								<table class="table table-bordered">
								  <thead>
									<tr>
									  <th width="60%"> Modules </a></th>
									  <th width="10%"> Create Record </th>
									  <th width="10%"> Update </th>
									  <th width="10%"> View </th>
									  <th width="10%"> Enable Audit </th>
									</tr>
								  </thead>
								  <tbody>
									<tr>
									  <td>Time Management Policy<input type="hidden" id="Row1" name="Row1" value="Time Management Policy"></td>
									  <td><input type="checkbox" id="Check_Create1" name="Check_Create1" value="1" <?php if($CreatePriv1 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Update1" name="Check_Update1" value="1"  <?php if($UpdatePriv1 == "Y"){ ?> checked="checked" <?php } ?>  ></td>
									  <td><input type="checkbox" id="Check_View1" name="Check_View1" value="1"  <?php if($ViewPriv1 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit1" name="Check_Audit1" value="1" <?php if($EnableAudit1 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									</tr>
								  
									<tr>
									  <td>Holiday Calenders<input type="hidden" id="Row2" name="Row2" value="Holiday Calenders"></td>
									  <td><input type="checkbox" id="Check_Create2" name="Check_Create2" <?php if($CreatePriv2 == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
									  <td><input type="checkbox" id="Check_Update2" name="Check_Update2" value="1" <?php if($UpdatePriv2 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View2" name="Check_View2" value="1" <?php if($ViewPriv2 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit2" name="Check_Audit2" value="1" <?php if($EnableAudit2 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>Work Plans<input type="hidden" id="Row3" name="Row3" value="Work Plans"></td>
									  <td><input type="checkbox" id="Check_Create3" name="Check_Create3" <?php if($CreatePriv3 == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
									  <td><input type="checkbox" id="Check_Update3" name="Check_Update3" value="1"<?php if($UpdatePriv3 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View3" name="Check_View3" value="1" <?php if($ViewPriv3 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit3" name="Check_Audit3" value="1" <?php if($EnableAudit3 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>Rotation Plans<input type="hidden" id="Row4" name="Row4" value="Rotation Plans"></td>
									  <td><input type="checkbox" id="Check_Create4" name="Check_Create4" value="1" <?php if($CreatePriv4 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Update4" name="Check_Update4" value="1" <?php if($UpdatePriv4 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View4" name="Check_View4" value="1" <?php if($ViewPriv4 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit4" name="Check_Audit4" value="1" <?php if($EnableAudit4 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>RetroAdjustments<input type="hidden" id="Row5" name="Row5" value="RetroAdjustments"></td>
									  <td><input type="checkbox" id="Check_Create5" name="Check_Create5" value="1" <?php if($CreatePriv5 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Update5" name="Check_Update5" value="1" <?php if($UpdatePriv5 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View5" name="Check_View5" value="1" <?php if($ViewPriv5 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit5" name="Check_Audit5" value="1" <?php if($EnableAudit5 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>Time Entry<input type="hidden" id="Row6" name="Row6" value="Time Entry"></td>
									  <td><input type="checkbox" id="Check_Create6" name="Check_Create6"  value="1" <?php if($CreatePriv6 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_Update6" name="Check_Update6" value="1" <?php if($UpdatePriv6 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View6" name="Check_View6" value="1" <?php if($ViewPriv6 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit6" name="Check_Audit6" value="1" <?php if($EnableAudit6 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>Global Aliases<input type="hidden" id="Row7" name="Row7" value="Global Aliases"></td>
									  <td><input type="checkbox" id="Check_Create7" name="Check_Create7"  value="1" <?php if($CreatePriv7 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Update7" name="Check_Update7" value="1" <?php if($UpdatePriv7 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View7" name="Check_View7" value="1" <?php if($ViewPriv7 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit7" name="Check_Audit7" value="1" <?php if($EnableAudit7 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>PreApproved Time Entry<input type="hidden" id="Row8" name="Row8" value="PreApproved Time Entry"></td>
									  <td><input type="checkbox" id="Check_Create8" name="Check_Create8"  value="1" <?php if($CreatePriv8 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Update8" name="Check_Update8" value="1" <?php if($UpdatePriv8 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View8" name="Check_View8" value="1" <?php if($ViewPriv8 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit8" name="Check_Audit8" value="1" <?php if($EnableAudit8 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>Search TimeSheets<input type="hidden" id="Row9" name="Row9" value="Search TimeSheets"></td>
									  <td><input type="checkbox" id="Check_Create9" name="Check_Create9"  value="1" <?php if($CreatePriv9 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Update9" name="Check_Update9" value="1" <?php if($UpdatePriv9 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View9" name="Check_View9" value="1" <?php if($ViewPriv9 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit9" name="Check_Audit9" value="1" <?php if($EnableAudit9 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>Create Personal Aliases<input type="hidden" id="Row10" name="Row10" value="Create Personal Aliases"></td>
									  <td><input type="checkbox" id="Check_Create10" name="Check_Create10"  value="1" <?php if($CreatePriv10 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Update10" name="Check_Update10" value="1" <?php if($UpdatePriv10 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View10" name="Check_View10" value="1" <?php if($ViewPriv10 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit10" name="Check_Audit10" value="1" <?php if($EnableAudit10 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>Projects and Programs Access<input type="hidden" id="Row11" name="Row11" value="Projects and Programs Access"></td>
									  <td><input type="checkbox" id="Check_Create11" name="Check_Create11"  value="1" <?php if($CreatePriv11 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_Update11" name="Check_Update11" value="1" <?php if($UpdatePriv11 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View11" name="Check_View11" value="1" <?php if($ViewPriv11 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit11" name="Check_Audit11" value="1" <?php if($EnableAudit11 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>Time Profile Assignment<input type="hidden" id="Row12" name="Row12" value="Time Profile Assignment"></td>
									  <td><input type="checkbox" id="Check_Create12" name="Check_Create12"  value="1" <?php if($CreatePriv12 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Update12" name="Check_Update12" value="1" <?php if($UpdatePriv12 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View12" name="Check_View12" value="1" <?php if($ViewPriv12 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit12" name="Check_Audit12" value="1" <?php if($EnableAudit12 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  
									<tr>
									  <td>PreApproval Rules<input type="hidden" id="Row13" name="Row13" value="PreApproval Rules"></td>
									  <td><input type="checkbox" id="Check_Create13" name="Check_Create13"  value="1" <?php if($CreatePriv13 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Update13" name="Check_Update13" value="1" <?php if($UpdatePriv13 == "Y"){ ?> checked="checked" <?php } ?> ></td>
									  <td><input type="checkbox" id="Check_View13" name="Check_View13" value="1" <?php if($ViewPriv13 == "Y"){ ?> checked="checked" <?php } ?>></td>
									  <td><input type="checkbox" id="Check_Audit13" name="Check_Audit13" value="1" <?php if($EnableAudit13 == "Y"){ ?> checked="checked" <?php } ?>></td>
									</tr>
								  </tbody>
								</table>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
					<!-- -->
				  
					<div class="panel panel-default">
					  <div class="panel-heading" role="tab" id="headingFive">
						<h4 class="panel-title"> 
						  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> Personal Aliases <i class="fa fa-plus"></i> </a>
						  <span class="over-eyecont">
							<?php
									if($PACreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $PACreatedBy");
									if($PAUpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $PAUpdatedBy");
								?>
							<button type="button" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
							    Created By:  <?php  echo $CreatedByName; ?><br>
								Updated By:  <?php  echo $UpdatedByName; ?><br>
								Creation Date: <?php  echo $PACreationDate; ?> <br>
								Last Update Date: <?php  echo $PALastUpdateDate; ?>">
								<i class=" fa fa-eye"></i> 
							  </button>
						  </span>
						</h4>
					  </div>
					
					  <div id="collapseFive" class="panel-collapse collapse disable-bg" role="tabpanel" aria-labelledby="headingFive">
						<div class="panel-body">
						<!-- -->
						  <div class="col-md-12">
							<div class="data-bx data-bx-center">
							  <div class="table-responsive">
								<table class="table table-bordered">
								  <thead>
									<tr>
									  <th width="20%"> Alias Name </a></th>
									  <th width="20%"> Description </th>
									  <th width="40%"> Department </th>
									  <th width="20%"> Project WBS </th>
									  <th width="5%"> Active </th>
									</tr>
								  </thead>
								  <tbody>
									<?php
										$PersonalAliasesRecords="N";
										if($Text_UserName!='')
										{
											
											$i=1;
											$qry = "select * from cxs_am_personal_alias inner join cxs_users on cxs_users.USER_ID = cxs_am_personal_alias.USER_ID where cxs_users.USER_NAME = '$Text_UserName'";
										
											$result = mysql_query($qry);
											$TotalRecords1 = mysql_num_rows($result);
										while($row = mysql_fetch_array($result))
										{
											$PersonalAliasesRecords="Y";
											$Disp_AliasName = $row['ALIAS_NAME'];
											$Disp_Description = $row['DESCRIPTION'];
											$Disp_Department = $row['DEPARTMENT'];
											$Disp_ProjectWBS= $row['WBS_COMBINATION_ID'];
											$Disp_ActiveFlag= $row['ACTIVE_FLAG'];
											$IsChecked = ($Disp_ActiveFlag=="Y"?"checked":"");
											
									?>
									<tr>
									  <td><?php echo $Disp_AliasName; ?> </td>
									  <td> <?php echo $Disp_Description; ?></td>
									  <td> <?php echo $Disp_Department; ?></td>
									  <td> <?php echo $Disp_ProjectWBS; ?></td>									 							 
									  <td><input type="checkbox" id="Check_Active" name="Check_Active" value="1" <?php echo $IsChecked; ?> disabled></td>
									</tr>
								<!--	<tr>
									  <td><?php echo $Disp_AliasName; ?> </td>
									  <td><input type="text" id="<?php echo "Text_AliasName$i" ?>" name="<?php echo "Text_AliasName$i" ?>" class="form-control" placeholder="  " maxlength="2" disabled="" value = "<?php echo $Disp_AliasName;?>"></td>
									  <td><input type="text" id="Text_Description" name="Text_Description" class="form-control" placeholder="  " maxlength="2" disabled="" value = "<?php echo $Disp_AliasName;?>"></td>
									  <td><input type="text" id="Text_Department" name="Text_Department" class="form-control" placeholder="  " maxlength="2" disabled="" value = "<?php echo $Disp_AliasName;?>"></td>
									  <td><input type="checkbox" id="Check_Active" name="Check_Active" value="" disabled=""></td>
									</tr> -->
									<?php 
											$i=$i+1;
											}
										}	
										if ($PersonalAliasesRecords=="N")
										{
											for($i=1;$i<=5;$i++)
											{
											  echo "<tr>";
											  echo "  <td></td>";
											  echo "<td></td>";
											  echo "<td></td>";
											  echo "<td></td>";								 							 
											  echo '<td><input type="checkbox" id="Check_Active" name="Check_Active" value="1" disabled></td>';
											echo "</tr>";
											}
										}
										?>
							<!--	  <tr>
									<td> Dummy Text </td>
									<td><input type="text" class="form-control" placeholder="  " maxlength="2" disabled=""></td>
									<td><input type="text" class="form-control" placeholder="  " maxlength="2" disabled=""></td>
									<td><input type="text" class="form-control" placeholder="  " maxlength="2" disabled=""></td>
									<td><input type="checkbox" value="" disabled=""></td>
								  </tr>
								  
								  <tr>
									<td> Dummy Text </td>
									<td><input type="text" class="form-control" placeholder="  " maxlength="2" disabled=""></td>
									<td><input type="text" class="form-control" placeholder="  " maxlength="2" disabled=""></td>
									<td><input type="text" class="form-control" placeholder="  " maxlength="2" disabled=""></td>
									<td><input type="checkbox" value="" disabled=""></td>
								  </tr>
								  
								  <tr>
									<td> Dummy Text </td>
									<td><input type="text" class="form-control" placeholder="  " maxlength="2" disabled=""></td>
									<td><input type="text" class="form-control" placeholder="  " maxlength="2" disabled=""></td>
									<td><input type="text" class="form-control" placeholder="  " maxlength="2" disabled=""></td>
									<td><input type="checkbox" value="" disabled=""></td>
								  </tr>-->
								</tbody>
							  </table>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>

				  <!-- -->
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingSix">
					  <h4 class="panel-title"> 
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix"> Approval Management <i class="fa fa-plus"></i> </a>
						<span class="over-eyecont">
							<?php
									if($AMCreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $AMCreatedBy");
									if($AMUpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $AMUpdatedBy");
								?>
						   <button type="button"  class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
								Created By:  <?php  echo $CreatedByName; ?><br>
								Updated By:  <?php  echo $UpdatedByName; ?><br>
								Creation Date: <?php  echo $AMCreationDate; ?><br>
								Last Update Date: <?php  echo $AMLastUpdateDate; ?>"> 
							<i class=" fa fa-eye"></i> 
						  </button>
						</span>
					  </h4>
					</div>
					
					<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
					  <div class="panel-body">
					  <!-- -->
						<div class="col-md-12">
						  <div class="row">
							<div class="checkbox col-md-6 col-sm-6">
							  <label><input type="checkbox" id="Check_AllowPreApproval" name="Check_AllowPreApproval" <?php if($AllowPreApproval == "Y"){ ?> checked="checked" <?php } ?> value="1">Allow PreApproval </label>
							</div>
						<!--	<div class="checkbox col-md-6 col-sm-6 md-right-only">
							  <label><input type="checkbox" id="Check_ApproverType" name="Check_ApproverType" <?php //if($ApproverType == "Y"){ ?> checked="checked" <?php// } ?> value="1">Approver Type </label>
							</div> -->
						  </div>
						</div>
						
						<div class="col-md-12 mar-top20">
						  <div class="table-responsive time-acc-bx only-inp-center bder-none">
							<table class="table small-tb">
							  <thead>
								<tr>
								  <th width="60%"> Approver Name </th>
								  <th width="40%"> Approver Type</th>
								</tr>
							  </thead>
							  <tbody>
								<tr id="Row1" name="Row1">
								  <td>									
									<select id="Combo_ApproverName1" name="Combo_ApproverName1" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td>
									<select id="Combo_ApproverType1" name="Combo_ApproverType1" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								</tr>
								
								<tr id="Row2" name="Row2">
								  <td>
									<select id="Combo_ApproverName2" name="Combo_ApproverName2" class="form-control">
									  <option value="">Select</option>									
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td>
									<select id="Combo_ApproverType2" name="Combo_ApproverType2" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								</tr>
								
								<tr id="Row3" name="Row3">
								  <td>
									<select id="Combo_ApproverName3" name="Combo_ApproverName3" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td>
									<select id="Combo_ApproverType3" name="Combo_ApproverType3" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								</tr>
								
								<tr id="Row4" name="Row4">
								  <td>
									<select id="Combo_ApproverName4" name="Combo_ApproverName4" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td>
									<select id="Combo_ApproverType4" name="Combo_ApproverType4" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								</tr>
								
								<tr id="Row5" name="Row5">
								  <td>
									<select id="Combo_ApproverName5" name="Combo_ApproverName5" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td>
									<select id="Combo_ApproverType5" name="Combo_ApproverType5" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								</tr>
							  </tbody>
							</table>
						  </div>
						</div>
						
						<div class="col-md-12 mar-btm20">
						  <div class="row">
							<div class="checkbox col-md-6 col-sm-6">
							  <label><input type="checkbox" id="Check_ApproveDirectReport" name="Check_ApproveDirectReport" <?php if($ApproveDirectReport == "Y"){ ?> checked="checked" <?php } ?> value="1">Approve Direct Report of Other Approvers </label>
							</div>
						  
							<div class="checkbox col-md-6 col-sm-6 ">
							  <label><input type="checkbox" id="Check_UpadteApprovedTimesheet" name="Check_UpadteApprovedTimesheet" <?php if($UpadteApprovedTimesheet == "Y"){ ?> checked="checked" <?php } ?> value="1">Allow Update to Approved TimeSheet </label>
							</div>
						  
							<div class="checkbox col-md-6 col-sm-6 ">
							  <label><input type="checkbox" id="Check_FlyApprovalRequest" name="Check_FlyApprovalRequest" <?php if($FlyApprovalRequest == "Y"){ ?> checked="checked" <?php } ?> value="1">Allow on the fly Approval Request </label>
							</div>
						  
							<div class="checkbox col-md-6 col-sm-6 ">
							  <label><input type="checkbox" id="Check_ProjectBasedApproval" name="Check_ProjectBasedApproval" <?php if($ProjectBasedApproval == "Y"){ ?> checked="checked" <?php } ?> value="1" disabled>Project Based Approval Only </label>
							</div>
						  </div>
						</div>
					  
						<div class="col-md-12 ">
						  <h2 class="f-sec-hd mar-top20"> Temporary Approver </h2>
						  <div class="form-horizontal mar-top20">
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-2 control-label">Name </label>
							  <div class="col-sm-8">
								<input type="text" class="form-control" id="Text_TempApproverName" name="Text_TempApproverName" placeholder="" maxlength="40">
							  </div>
							</div>
						  </div>
						
						  <div class="table-responsive time-acc-bx only-inp-center mar-top20 bder-none">
							<table class="table small-tb">
							  <thead>
								<tr>
								  <th width="50%"> Period ID </th>
								  <th width="10%"></th>
								  <th width="20%"> Alias Name </th>
								  <th width="20%" class="text-center"> Active Flag </th>
								</tr>
							  </thead>
							  <tbody>
								<tr id="TempAppRow1" name="TempAppRow1">
								  <td>
									<select id="Combo_PeriodId1" name="Combo_PeriodId1" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td></td>
								  <td>
									<select id="Combo_AliasName1" name="Combo_AliasName1" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td class="centr"><input type="checkbox" id="Check_ActiveFlag1" name="Check_ActiveFlag1" value="1"></td>
								</tr>
							  
								<tr id="TempAppRow2" name="TempAppRow2">
								  <td>
									<select id="Combo_PeriodId2" name="Combo_PeriodId2" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td></td>
								  <td>
									<select id="Combo_AliasName2" name="Combo_AliasName2" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td class="centr"><input type="checkbox" id="Check_ActiveFlag2" name="Check_ActiveFlag2" value="1"></td>
								</tr>
							  
								<tr id="TempAppRow3" name="TempAppRow3">
								  <td>
									<select id="Combo_PeriodId3" name="Combo_PeriodId3" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td></td>
								  <td>
									<select id="Combo_AliasName3" name="Combo_AliasName3" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td class="centr"><input type="checkbox" id="Check_ActiveFlag3" name="Check_ActiveFlag3" value="1"></td>
								</tr>
							  
								<tr id="TempAppRow4" name="TempAppRow4">
								  <td>
									<select id="Combo_PeriodId4" name="Combo_PeriodId4" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td></td>
								  <td>
									<select id="Combo_AliasName4" name="Combo_AliasName4" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td class="centr"><input type="checkbox" id="Check_ActiveFlag4" name="Check_ActiveFlag4" value="1"></td>
								</tr>
							  
								<tr id="TempAppRow5" name="TempAppRow5">
								  <td>
									<select id="Combo_PeriodId5" name="Combo_PeriodId5" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td></td>
								  <td>
									<select id="Combo_AliasName5" name="Combo_AliasName5" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td class="centr"><input type="checkbox" id="Check_ActiveFlag5" name="Check_ActiveFlag5" value="1"></td>
								</tr>
							  
								<tr id="TempAppRow6" name="TempAppRow6">
								  <td>
									<select id="Combo_PeriodId6" name="Combo_PeriodId6" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td></td>
								  <td>
									<select id="Combo_AliasName6" name="Combo_AliasName6" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Option 1</option>
									  <option value="2">Option 2</option>
									</select>
								  </td>
								  <td class="centr"><input type="checkbox" id="Check_ActiveFlag6" name="Check_ActiveFlag6" value="1"></td>
								</tr>
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
				<button type="submit"  id = "cmdSavePermission" name = "cmdSavePermission" class="btn btn-primary btn-style" onclick = "SaveRecords_Validations" > Save </button>			  
				<!-- end -->
				  </div>
				</div>
			</form>
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
	</script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>