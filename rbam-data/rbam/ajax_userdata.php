<?php
include('conn.php');
?>
<?php
if(isset($_POST['uname']) && $_POST['uname'] != "" )
{
	$UserName=$_POST['uname'];
	//$data['status']="fail";
	
	$CreateUser 	 = "";
	$ViewOnly 		 = "";
	$UpdateOnly 	 = "";
	$UACreationDate = "";
	$UALastUpdateDate="";
	$TARCreationDate = "";
	$TARLastUpdateDate = "";	
	$AMCreationDate = "";
	$AMLastUpdateDate= "";
	$TAMCreationDate= "";
	$TAMLastUpdateDate= "";
	
		
	$CreatedByName = "";
	$UpdatedByName = "";		
	$TARCreatedByName = "";
	$TARUpdatedByName = "";			
	$TAMCreatedBy = "";
	$TAMUpdatedBy = "";
	$PACreatedByName = "";
	$PAUpdatedByName = "";

	$AMCreatedByName = "";
	$AMUpdatedByName = "";
	
	/*
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
		where USER_NAME = '$UserName'";*/
	
	$qry = "SELECT cxs_users.*,cxs_resources.*,cxs_am_roles.*,cxs_am_approval_mgmt.*,
			cxs_am_roles.CREATED_BY as ua_createdby,cxs_am_roles.CREATION_DATE as ua_createddt,
			cxs_am_roles.LAST_UPDATED_BY as ua_lastupdatedby,cxs_am_roles.LAST_UPDATE_DATE	as ua_lastupdateddt,
			cxs_am_roles.CREATED_BY as ta_createdby,cxs_am_roles.CREATION_DATE	as ta_createddt,
			cxs_am_roles.LAST_UPDATED_BY as ta_lastupdatedby,cxs_am_roles.LAST_UPDATE_DATE	as ta_lastupdateddt,
			cxs_am_approval_mgmt.CREATED_BY as apmgmt_createdby,cxs_am_approval_mgmt.CREATION_DATE	as apmgmt_createddt,
			cxs_am_approval_mgmt.LAST_UPDATED_BY as apmgmt_lastupdatedby,cxs_am_approval_mgmt.LAST_UPDATE_DATE	as apmgmt_lastupdateddt from cxs_users 
		Inner join cxs_resources on cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID  
		LEFT join cxs_am_roles on cxs_am_roles.ROLE_ID = cxs_users.ROLE_ID
		LEFT join cxs_am_approval_mgmt on cxs_am_approval_mgmt.USER_ID = cxs_users.USER_ID			
		where USER_NAME = '$UserName'";
		
		$result = mysql_query($qry);
		$TotalRecords = mysql_num_rows($result);
		while($row=mysql_fetch_array($result))
		{
			
			$Text_FirstName	= $row['FIRST_NAME'];
			$Text_LastName 	= $row['LAST_NAME'];	
			
			/******User Administration******/
			$CreateUser 		= $row['CREATE_NEW_USER'];
			$ViewOnly 		= $row['VIEW_ONLY'];
			$UpdateOnly 		= $row['UPDATE_ONLY'];
			
			/******Billing Administration******/
			$ViewSubscribers	= $row['VIEW_SUBSCRIBERS'];
			$SubmitCustom	 	= $row['SUBMIT_CUSTOM'];
			$AllowChat		= $row['ALLOW_CHAT'];
			$ViewSLA			= $row['VIEW_SLA'];
			$ExistUserAdmin	= $row['EXISTING_USER'];
			$RemoveAccess	 	= $row['REMOVE_ACCESS'];
			$UsageHistory	 	= $row['USAGE_HISTORY'];
			$UACreatedBy  	 	= $row['ua_createdby'];
			$UAUpdatedBy 		= $row['ua_lastupdatedby'];
			
			if((!is_null($row['ua_createddt'])) && (($row['ua_createddt'])!='0000-00-00 00:00:00') )
			{
				$UACreationDate = date('m/d/Y', strtotime($row['ua_createddt']));	
			}
			if(!is_null($row['ua_lastupdateddt']))
			{
				$UALastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['ua_lastupdateddt']));
			}																
			
			/******Time Accounting Rules******/
			$BusinessMessage 			= $row['BIZ_MSG_FLAG'];
			$SetAudit 				= $row['AUDIT_FLAG'];
			$AllowTimekeeping 			= $row['ALLOW_TK_FLAG'];
			$TimezoneProjects 			= $row['ALLOW_TIMEZONE'];
			$DefaultTimezone 			= $row['DEFAULT_TIMEZONE'];
			$DefaultDateFormat 			= $row['DEFAULT_DATE_FORMAT'];
			$ProjectAccounting 			= $row['ENABLE_PA'];
			$AllowNegativeTimeEntry		= $row['ALLOW_NEGATIVE'];
			$AdvanceForOvertime 		= $row['ADVANCE_FOR_OVERTIME'];
			$SubmittedTime 			= $row['UPDATE_SUBMITTED'];
			$PrimaryApprover 			= $row['OVERRIDE_PRIMARY'];
			$RecentTimecards 			= $row['RECENT_TIMECARDS'];
			$RetroAdjustments 			= $row['RETRO_ADJUST'];
			$MaxDailyLimit 			= $row['MAX_DAILY_LIMIT'];
			$FlexibleTimeEntry 			= $row['AFT_ENTRY'];
			$EnforceTimeEntry 			= $row['ENFORCE_TIME_WBS'];
			$EmployeeAliases 			= $row['CREATE_EMP_ALIAS_FLAG'];
			$AllowRetroUpdates 			= $row['RETRO_PERIOD_NUM'];
			$CopyTimesheetEmployees 		= $row['ALLOW_COPY'];
			$CreateTimeSheet 			= $row['COPY_ANYONE_TS_FLAG'];
			$ApproveTimeSheet 			= $row['APPROVE_ANYONE_TS'];
			$CreateTimeSheetTeam 		= $row['CREATE_ANYONE_TS'];
			$ApproveTimeSheetTeam 		= $row['APPROVE_ANYONE_TS_TEAM'];
			$CreateSupervisorTimeSheet	= $row['ALLOW_SUP_TS'];		
			$TARCreatedBy  			= $row['ta_createdby'];
			$TARUpdatedBy 				= $row['ta_lastupdatedby'];			
			if((!is_null($row['ta_createddt'])) && (($row['ta_createddt'])!='0000-00-00 00:00:00') )
			{
				$TARCreationDate = date('m/d/Y', strtotime($row['ta_createddt']));	
			}
			if(!is_null($row['ta_lastupdateddt']))
			{
				$TARLastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['ta_lastupdateddt']));
			}
			
			/******Approval Management******/
			$AllowPreApproval 		= $row['ALLOW_PREAPPROVAL'];
			$ApproverType 			= $row['APPROVER_TYPE_FLAG'];
			$ApproveDirectReport 	= $row['APPROVE_DIRECT_REPORT'];
			$UpadteApprovedTimesheet = $row['ALLOW_UPDATE_APPROVE_TS'];
			$FlyApprovalRequest 	= $row['ALLOW_ON_THE_FLY'];
			$ProjectBasedApproval 	= $row['PROJECT_BASED_APPROVAL'];
			$AMCreatedBy  		= $row['apmgmt_createdby'];
			$AMUpdatedBy 		= $row['apmgmt_lastupdatedby'];			
			if((!is_null($row['apmgmt_createddt'])) && (($row['apmgmt_createddt'])!='0000-00-00 00:00:00') )
			{
				$AMCreationDate = date('m/d/Y', strtotime($row['apmgmt_createddt']));	
			}
			if(!is_null($row['apmgmt_lastupdateddt']))
			{
				$AMLastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['apmgmt_lastupdateddt']));
			}
			
		}
		
		
		$qry = "select * from cxs_ta_modules left join  cxs_users on cxs_users.USER_ID = cxs_ta_modules.USER_ID where  USER_NAME = '$UserName' order by ROWNO";
		$result = mysql_query($qry);
		$TotalRecords1 = mysql_num_rows($result);
		while($row = mysql_fetch_array($result))
		{
			$DBRowNo = $row['ROWNO'];			
			${ModuleName.$DBRowNo}	= $row['MODULE_NAME'];
			${CreatePriv.$DBRowNo}	= $row['CREATE_PRIV'];	
			${UpdatePriv.$DBRowNo}	= $row['UPDATE_PRIV'];
			${ViewPriv.$DBRowNo} 	= $row['VIEW_PRIV'];
			${EnableAudit.$DBRowNo}	= $row['ENABLE_AUDIT'];
			$TAMCreatedBy  		= $row['USER_NAME'];
			$TAMUpdatedBy 			= $row['USER_NAME'];
			
			if((!is_null($row['CREATION_DATE'])) && (($row['CREATION_DATE'])!='0000-00-00 00:00:00') )
			{
				$TAMCreationDate = date('m/d/Y', strtotime($row['CREATION_DATE']));	
			}
			if(!is_null($row['LAST_UPDATE_DATE']))
			{
				$TAMLastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['LAST_UPDATE_DATE']));
			}
		}
				
		if($UACreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $UACreatedBy");
		if($UAUpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $UAUpdatedBy");
		
		if($TARCreatedBy!='') $TARCreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $TARCreatedBy");
		if($TARUpdatedBy!='') $TARUpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $TARUpdatedBy");
		
		if($PACreatedBy!='') $PACreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $PACreatedBy");
		if($PAUpdatedBy!='') $PAUpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $PAUpdatedBy");
		
		if($AMCreatedBy!='') $AMCreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $AMCreatedBy");
		if($AMUpdatedBy!='') $AMUpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $AMUpdatedBy");
												
		$data['status']="success";			
		$data['CreateUser']=$CreateUser;
		$data['ViewOnly']=$ViewOnly;
		$data['UpdateOnly']=$UpdateOnly;
		$data['ViewSubscribers']=$ViewSubscribers;			
		
		$data['SubmitCustom']=$SubmitCustom;
		$data['AllowChat']=$AllowChat;
		$data['ViewSLA']=$ViewSLA;
		$data['ExistUserAdmin']=$ExistUserAdmin;
		$data['RemoveAccess']=$RemoveAccess;
		$data['UsageHistory']=$UsageHistory;
		$data['CreatedByName']=$CreatedByName;
		$data['UpdatedByName']=$UpdatedByName;
		$data['UACreationDate']=$UACreationDate;
		$data['UALastUpdateDate']=$UALastUpdateDate;
		
		//******** Heading2********//
		
		$data['BusinessMessage']=$BusinessMessage;
		$data['SetAudit']=$SetAudit;
		$data['ViewSLA']=$ViewSLA;
		$data['AllowTimekeeping']=$AllowTimekeeping;
		$data['TimezoneProjects']=$TimezoneProjects;
		$data['ProjectAccounting']=$ProjectAccounting;
		$data['AllowNegativeTimeEntry']=$AllowNegativeTimeEntry;
		$data['AdvanceForOvertime']=$AdvanceForOvertime;
		$data['SubmittedTime']=$SubmittedTime;
		$data['PrimaryApprover']=$PrimaryApprover;
		$data['RecentTimecards']=$RecentTimecards; // textbox						
		$data['RecentTimecards']=$RecentTimecards;
		$data['RetroAdjustments']=$RetroAdjustments; 
		$data['MaxDailyLimit']=$MaxDailyLimit;		// textbox
		$data['FlexibleTimeEntry']=$FlexibleTimeEntry;
		$data['EnforceTimeEntry']=$EnforceTimeEntry;
		$data['EmployeeAliases']=$EmployeeAliases;
		$data['AllowRetroUpdates']=$AllowRetroUpdates;// textbox
		$data['CopyTimesheetEmployees']=$CopyTimesheetEmployees;
		
		$data['TARCreatedByName']=$TARCreatedByName;
		$data['TARUpdatedByName']=$TARUpdatedByName;
		$data['TARCreationDate']=$TARCreationDate;
		$data['TARLastUpdateDate']=$TARLastUpdateDate;
		
		//******** Heading3********//
		$data['CreateTimeSheet']=$CreateTimeSheet;
		$data['ApproveTimeSheet']=$ApproveTimeSheet;
		$data['CreateTimeSheetTeam']=$CreateTimeSheetTeam;
		$data['ApproveTimeSheetTeam']=$ApproveTimeSheetTeam;// textbox
		$data['CreateSupervisorTimeSheet']=$CreateSupervisorTimeSheet;
		//******** Heading4********//		
		$data[qry]=$qry;
		$data[TotalRecords1]=14;//$TotalRecords1;
		//for($i=1;$i<=$TotalRecords1;$i++)
		for($i=1;$i<=14;$i++)
		{
			$data[ModuleName.$i]=${ModuleName.$i};
			$data[CreatePriv.$i]=${CreatePriv.$i};
			$data[UpdatePriv.$i]=${UpdatePriv.$i};
			$data[ViewPriv.$i]=${ViewPriv.$i};
			$data[EnableAudit.$i]=${EnableAudit.$i};
		}	
		$data['TAMCreatedBy']=$TAMCreatedBy;
		$data['TAMUpdatedBy']=$TAMUpdatedBy;
		$data['TAMCreationDate']=$TAMCreationDate;
		$data['TAMLastUpdateDate']=$TAMLastUpdateDate; 
		echo json_encode($data);
}

/*
if($_REQUEST['REQUEST'] == "SingleApplicationRole")
{
	$UserName = $_REQUEST['UserName'];	
	//include ("functions.php");
	//DisplayRecords($UserName);	
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
		where USER_NAME = '$UserName'";
		
		$result = mysql_query($qry);
		$TotalRecords = mysql_num_rows($result);
		while($row=mysql_fetch_array($result))
		{
			$Text_FirstName = $row['FIRST_NAME'];
			$Text_LastName = $row['LAST_NAME'];	
			$CreateUser 	 = $row['CREATE_NEW_USER'];
			$ViewOnly 		 = $row['VIEW_ONLY'];
			$UpdateOnly 	 = $row['UPDATE_ONLY'];
		}
		//$returnArr = [$Text_FirstName,$Text_LastName];  
		//echo json_encode($returnArr);
		//echo json_encode(array($CreateUser, $ViewOnly,$UpdateOnly));
		$messages = array();
		$messages['CreateUser'] = $CreateUser;
		$messages['ViewOnly'] = $ViewOnly;
		$messages['UpdateOnly'] = $UpdateOnly;
		echo json_encode($messages);
}*/
?>