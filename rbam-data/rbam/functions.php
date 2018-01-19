<?php	
	function DisplayRecords($Text_UserName)	
	{
		global $Text_FirstName,$Text_LastName,$CreateUser,$ViewOnly,$UpdateOnly,$ViewSubscribers,$SubmitCustom;
		global $AllowChat,$ViewSLA,$ExistUserAdmin,$RemoveAccess,$UsageHistory,$UACreatedBy;
		global $UAUpdatedBy,$UACreationDate,$UALastUpdateDate,$BusinessMessage,$SetAudit,$AllowTimekeeping;
		global $TimezoneProjects,$DefaultTimezone,$DefaultDateFormat,$ProjectAccounting,$AllowNegativeTimeEntry;
		global $AdvanceForOvertime,$SubmittedTime,$PrimaryApprover,$RecentTimecards,$RetroAdjustments,$MaxDailyLimit;
		global $FlexibleTimeEntry,$EnforceTimeEntry,$EmployeeAliases,$AllowRetroUpdates,$CopyTimesheetEmployees;
		global $CreateTimeSheet,$ApproveTimeSheet,$CreateTimeSheetTeam,$ApproveTimeSheetTeam,$CreateSupervisorTimeSheet;		
		global $TARCreatedBy,$TARUpdatedBy,$TARCreationDate,$TARLastUpdateDate,$AllowPreApproval,$ApproverType;
		global $ApproveDirectReport,$UpadteApprovedTimesheet,$FlyApprovalRequest,$ProjectBasedApproval;
		global $AMCreatedBy,$AMUpdatedBy,$AMCreationDate,$AMLastUpdateDate,$Text_ResourceGroup;
				
				
		$qry = "SELECT cxs_users.*,cxs_resources.*,cxs_resource_groups.RESOURCE_GROUP_NAME,cxs_am_user_admin.*,cxs_am_ta_rules.*,cxs_am_approval_mgmt.*,
			cxs_am_user_admin.CREATED_BY as ua_createdby,cxs_am_user_admin.CREATION_DATE as ua_createddt,
			cxs_am_user_admin.LAST_UPDATED_BY as ua_lastupdatedby,cxs_am_user_admin.LAST_UPDATE_DATE	as ua_lastupdateddt,
			cxs_am_ta_rules.CREATED_BY as ta_createdby,cxs_am_ta_rules.CREATION_DATE	as ta_createddt,
			cxs_am_ta_rules.LAST_UPDATED_BY as ta_lastupdatedby,cxs_am_ta_rules.LAST_UPDATE_DATE	as ta_lastupdateddt,
			cxs_am_approval_mgmt.CREATED_BY as apmgmt_createdby,cxs_am_approval_mgmt.CREATION_DATE	as apmgmt_createddt,
			cxs_am_approval_mgmt.LAST_UPDATED_BY as apmgmt_lastupdatedby,cxs_am_approval_mgmt.LAST_UPDATE_DATE	as apmgmt_lastupdateddt from cxs_users 
		Inner join cxs_resources on cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID
		Inner join cxs_resource_groups on cxs_resource_groups.RESOURCE_GROUP_ID = cxs_resources.RESOURCE_GROUP_ID
		LEFT join cxs_am_user_admin on cxs_am_user_admin.USER_ID = cxs_users.USER_ID
		LEFT join cxs_am_ta_rules on cxs_am_ta_rules.USER_ID = cxs_users.USER_ID	
		LEFT join cxs_am_approval_mgmt on cxs_am_approval_mgmt.USER_ID = cxs_users.USER_ID			
		where cxs_users.USER_NAME = '$Text_UserName'";
		
		/*$qry = "SELECT cxs_users.*,cxs_resources.*,cxs_resource_groups.RESOURCE_GROUP_NAME,cxs_am_user_admin.*,cxs_am_ta_rules.*,cxs_am_approval_mgmt.*,
			cxs_am_user_admin.CREATED_BY as ua_createdby,cxs_am_user_admin.CREATION_DATE	as ua_createddt,
			cxs_am_user_admin.LAST_UPDATED_BY as ua_lastupdatedby,cxs_am_user_admin.LAST_UPDATE_DATE	as ua_lastupdateddt,
			cxs_am_ta_rules.CREATED_BY as ta_createdby,cxs_am_ta_rules.CREATION_DATE	as ta_createddt,
			cxs_am_ta_rules.LAST_UPDATED_BY as ta_lastupdatedby,cxs_am_ta_rules.LAST_UPDATE_DATE	as ta_lastupdateddt,
			cxs_am_approval_mgmt.CREATED_BY as apmgmt_createdby,cxs_am_approval_mgmt.CREATION_DATE	as apmgmt_createddt,
			cxs_am_approval_mgmt.LAST_UPDATED_BY as apmgmt_lastupdatedby,cxs_am_approval_mgmt.LAST_UPDATE_DATE	as apmgmt_lastupdateddt
			from
				cxs_users, cxs_resources, cxs_resource_groups, cxs_am_user_admin, cxs_am_ta_rules, cxs_am_approval_mgmt
			where
				cxs_users.RESOURCE_ID = cxs_resources.RESOURCE_ID
				and
				cxs_resources.RESOURCE_ID = cxs_resource_groups.RESOURCE_GROUP_ID
				and
				cxs_users.USER_ID = cxs_am_user_admin.USER_ID
				and
				cxs_users.USER_ID = cxs_am_ta_rules.USER_ID
				and
				cxs_users.USER_ID = cxs_am_approval_mgmt.USER_ID
				and
				cxs_users.USER_NAME = '$Text_UserName'";*/
				
		
		
		$result = mysql_query($qry);
		$TotalRecords = mysql_num_rows($result);
		while($row=mysql_fetch_array($result))
		{
			$Text_FirstName = $row['FIRST_NAME'];
			$Text_LastName = $row['LAST_NAME'];	
			$Text_ResourceGroup = $row['RESOURCE_GROUP_NAME'];//"test";
			/******User Administration******/
			$CreateUser 	 = $row['CREATE_NEW_USER'];
			$ViewOnly 		 = $row['VIEW_ONLY'];
			$UpdateOnly 	 = $row['UPDATE_ONLY'];
			/******Billing Administration******/
			$ViewSubscribers = $row['VIEW_SUBSCRIBERS'];
			$SubmitCustom	 = $row['SUBMIT_CUSTOM'];
			//$AllowChat		 = $row['ALLOW_CHAT'];
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
			if(!is_null($row['ua_lastupdateddt']))
			{
				$UALastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['ua_lastupdateddt']));
			}	
			/******Time Accounting Rules******/
			$BusinessMessage 	= $row['BIZ_MSG_FLAG'];
			$SetAudit 			= $row['AUDIT_FLAG'];
			$AllowTimekeeping 	= $row['ALLOW_TK_FLAG'];
			$TimezoneProjects 	= $row['ALLOW_TIMEZONE'];
			$DefaultTimezone 	= $row['DEFAULT_TIMEZONE'];
			$DefaultDateFormat 	= $row['DEFAULT_DATE_FORMAT'];
			$ProjectAccounting 	= $row['ENABLE_PA'];
			$AllowNegativeTimeEntry = $row['ALLOW_NEGATIVE'];
			$AdvanceForOvertime 	= $row['ADVANCE_FOR_OVERTIME'];
			$SubmittedTime 		= $row['UPDATE_SUBMITTED'];
			$PrimaryApprover 	= $row['OVERRIDE_PRIMARY'];
			$RecentTimecards 	= $row['RECENT_TIMECARDS'];
			$RetroAdjustments 	= $row['RETRO_ADJUST'];
			$MaxDailyLimit 		= $row['MAX_DAILY_LIMIT'];
			$FlexibleTimeEntry 	= $row['AFT_ENTRY'];
			//$EnforceTimeEntry 	= $row['ENFORCE_TIME_WBS'];
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
			//$FlyApprovalRequest 	= $row['ALLOW_ON_THE_FLY'];
			//$ProjectBasedApproval 	= $row['PROJECT_BASED_APPROVAL'];
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
			
			
			if((!is_null($row['CREATION_DATE'])) && (($row['CREATION_DATE'])!='0000-00-00 00:00:00') )
			{
				$TAMCreationDate = date('m/d/Y', strtotime($row['CREATION_DATE']));	
			}
			if(!is_null($row['LAST_UPDATE_DATE']))
			{
				$TAMLastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['LAST_UPDATE_DATE']));
			}
			
		}
		if ($TotalRecords==0 && TotalRecords1==0)
		{
			$msg = "No Record Found";
		}	
	}
	function DisplayUserAccessDetails($Text_UserName)	
	{
		global $Text_FirstName,$Text_LastName,$CreateUser,$ViewOnly,$UpdateOnly,$ViewSubscribers,$SubmitCustom;
		global $AllowChat,$ViewSLA,$ExistUserAdmin,$RemoveAccess,$UsageHistory,$UACreatedBy;
		global $UAUpdatedBy,$UACreationDate,$UALastUpdateDate,$BusinessMessage,$SetAudit,$AllowTimekeeping;
		global $TimezoneProjects,$DefaultTimezone,$DefaultDateFormat,$ProjectAccounting,$AllowNegativeTimeEntry;
		global $AdvanceForOvertime,$SubmittedTime,$PrimaryApprover,$RecentTimecards,$RetroAdjustments,$MaxDailyLimit;
		global $FlexibleTimeEntry,$EnforceTimeEntry,$EmployeeAliases,$AllowRetroUpdates,$CopyTimesheetEmployees;
		global $CreateTimeSheet,$ApproveTimeSheet,$CreateTimeSheetTeam,$ApproveTimeSheetTeam,$CreateSupervisorTimeSheet;		
		global $TARCreatedBy,$TARUpdatedBy,$TARCreationDate,$TARLastUpdateDate,$AllowPreApproval,$ApproverType;
		global $ApproveDirectReport,$UpadteApprovedTimesheet,$FlyApprovalRequest,$ProjectBasedApproval;
		global $AMCreatedBy,$AMUpdatedBy,$AMCreationDate,$AMLastUpdateDate,$Text_ResourceGroup;
		global $resource_group_id;
				
		/*		
		$qry = "SELECT cxs_users.*,cxs_resources.*,cxs_resource_groups.RESOURCE_GROUP_NAME,cxs_am_user_admin.*,cxs_am_ta_rules.*,cxs_am_approval_mgmt.*,
			cxs_am_user_admin.CREATED_BY as ua_createdby,cxs_am_user_admin.CREATION_DATE as ua_createddt,
			cxs_am_user_admin.LAST_UPDATED_BY as ua_lastupdatedby,cxs_am_user_admin.LAST_UPDATE_DATE	as ua_lastupdateddt,
			cxs_am_ta_rules.CREATED_BY as ta_createdby,cxs_am_ta_rules.CREATION_DATE	as ta_createddt,
			cxs_am_ta_rules.LAST_UPDATED_BY as ta_lastupdatedby,cxs_am_ta_rules.LAST_UPDATE_DATE	as ta_lastupdateddt,
			cxs_am_approval_mgmt.CREATED_BY as apmgmt_createdby,cxs_am_approval_mgmt.CREATION_DATE	as apmgmt_createddt,
			cxs_am_approval_mgmt.LAST_UPDATED_BY as apmgmt_lastupdatedby,cxs_am_approval_mgmt.LAST_UPDATE_DATE	as apmgmt_lastupdateddt from cxs_users 
		Inner join cxs_resources on cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID
		Inner join cxs_resource_groups on cxs_resource_groups.RESOURCE_GROUP_ID = cxs_resources.RESOURCE_GROUP_ID
		LEFT join cxs_am_user_admin on cxs_am_user_admin.USER_ID = cxs_users.USER_ID
		LEFT join cxs_am_ta_rules on cxs_am_ta_rules.USER_ID = cxs_users.USER_ID	
		LEFT join cxs_am_approval_mgmt on cxs_am_approval_mgmt.USER_ID = cxs_users.USER_ID			
		where cxs_users.USER_NAME = '$Text_UserName'";*/
		
		/*$qry = "SELECT cxs_users.*,cxs_resources.*,cxs_resource_groups.RESOURCE_GROUP_NAME,cxs_am_approval_mgmt.*,
			cxs_am_approval_mgmt.CREATED_BY as apmgmt_createdby,cxs_am_approval_mgmt.CREATION_DATE	as apmgmt_createddt,
			cxs_am_approval_mgmt.LAST_UPDATED_BY as apmgmt_lastupdatedby,cxs_am_approval_mgmt.LAST_UPDATE_DATE	as apmgmt_lastupdateddt from cxs_users 
		Inner join cxs_resources on cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID
		Inner join cxs_resource_groups on cxs_resource_groups.RESOURCE_GROUP_ID = cxs_resources.RESOURCE_GROUP_ID
		LEFT join cxs_am_approval_mgmt on cxs_am_approval_mgmt.USER_ID = cxs_users.USER_ID			
		where cxs_users.USER_NAME = '$Text_UserName'";*/
		
		$qry = "SELECT cxs_users.*,cxs_resources.*
			 from cxs_users, cxs_resources
			 where
			cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID
			and
			cxs_users.USER_NAME = '$Text_UserName'";
				
		$result = mysql_query($qry);
		$TotalRecords = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		
		$Text_FirstName = $row['FIRST_NAME'];
		$Text_LastName = $row['LAST_NAME'];
		$resource_group_id = $row['RESOURCE_GROUP_ID'];
			//$Text_ResourceGroup = $row['RESOURCE_GROUP_NAME'];//"test";
			
		if($row['RESOURCE_GROUP_ID']=='0' || $row['RESOURCE_GROUP_ID']=='')
		{
			$qry = "select * from cxs_ta_modules left join cxs_users on cxs_users.USER_ID = cxs_ta_modules.USER_ID where USER_ID = '".$row['USER_ID']."' order by ROWNO";
		}
		else
		{
			$qry = "select * from cxs_ta_modules where cxs_ta_modules.RESOURCE_GROUP_ID = '".$row['RESOURCE_GROUP_ID']."' order by ROWNO";
		}
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
			
			
			if((!is_null($row['CREATION_DATE'])) && (($row['CREATION_DATE'])!='0000-00-00 00:00:00') )
			{
				$TAMCreationDate = date('m/d/Y', strtotime($row['CREATION_DATE']));	
			}
			if(!is_null($row['LAST_UPDATE_DATE']))
			{
				$TAMLastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['LAST_UPDATE_DATE']));
			}
			
		}
		if ($TotalRecords==0 && TotalRecords1==0)
		{
			$msg = "No Record Found";
		}	
	}
	function DisplayResourceGroupAccessDetails($Text_ResourceGroup)	
	{
		global $Text_FirstName,$Text_LastName,$CreateUser,$ViewOnly,$UpdateOnly,$ViewSubscribers,$SubmitCustom;
		global $AllowChat,$ViewSLA,$ExistUserAdmin,$RemoveAccess,$UsageHistory,$UACreatedBy;
		global $UAUpdatedBy,$UACreationDate,$UALastUpdateDate,$BusinessMessage,$SetAudit,$AllowTimekeeping;
		global $TimezoneProjects,$DefaultTimezone,$DefaultDateFormat,$ProjectAccounting,$AllowNegativeTimeEntry;
		global $AdvanceForOvertime,$SubmittedTime,$PrimaryApprover,$RecentTimecards,$RetroAdjustments,$MaxDailyLimit;
		global $FlexibleTimeEntry,$EnforceTimeEntry,$EmployeeAliases,$AllowRetroUpdates,$CopyTimesheetEmployees;
		global $CreateTimeSheet,$ApproveTimeSheet,$CreateTimeSheetTeam,$ApproveTimeSheetTeam,$CreateSupervisorTimeSheet;		
		global $TARCreatedBy,$TARUpdatedBy,$TARCreationDate,$TARLastUpdateDate,$AllowPreApproval,$ApproverType;
		global $ApproveDirectReport,$UpadteApprovedTimesheet,$FlyApprovalRequest,$ProjectBasedApproval;
		global $AMCreatedBy,$AMUpdatedBy,$AMCreationDate,$AMLastUpdateDate,$Text_ResourceGroup;
		global $resource_group_id;
		
		
		$qry = "SELECT cxs_resource_groups.RESOURCE_GROUP_ID,cxs_resource_groups.RESOURCE_GROUP_NAME,cxs_am_approval_mgmt.*,
			cxs_am_approval_mgmt.CREATED_BY as apmgmt_createdby,cxs_am_approval_mgmt.CREATION_DATE as apmgmt_createddt,
			cxs_am_approval_mgmt.LAST_UPDATED_BY as apmgmt_lastupdatedby,cxs_am_approval_mgmt.LAST_UPDATE_DATE	as apmgmt_lastupdateddt from cxs_users 
		LEFT join cxs_am_approval_mgmt on cxs_am_approval_mgmt.USER_ID = cxs_users.USER_ID			
		where cxs_resource_groups.RESOURCE_GROUP_NAME = '$Text_ResourceGroup'";
		
		
		$result = mysql_query($qry);
		$TotalRecords = mysql_num_rows($result);
		while($row=mysql_fetch_array($result))
		{
			$resource_group_id = $row['RESOURCE_GROUP_ID'];
			$Text_ResourceGroup = $row['RESOURCE_GROUP_NAME'];//"test";
		}
		
		$qry = "select * from cxs_ta_modules left join cxs_resource_groups on cxs_resource_groups.RESOURCE_GROUP_ID = cxs_ta_modules.RESOURCE_GROUP_ID where RESOURCE_GROUP_NAME = '$Text_ResourceGroup' order by ROWNO";
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
			
			
			if((!is_null($row['CREATION_DATE'])) && (($row['CREATION_DATE'])!='0000-00-00 00:00:00') )
			{
				$TAMCreationDate = date('m/d/Y', strtotime($row['CREATION_DATE']));	
			}
			if(!is_null($row['LAST_UPDATE_DATE']))
			{
				$TAMLastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['LAST_UPDATE_DATE']));
			}
			
		}
		if ($TotalRecords==0 && TotalRecords1==0)
		{
			$msg = "No Record Found";
		}	
	}
	function DisplayRoleDetails($Text_RoleName)	
	{
		//global $Text_FirstName,$Text_LastName,$CreateUser,$ViewOnly,$UpdateOnly,$ViewSubscribers,$SubmitCustom;
		global $Text_RoleName,$Text_RoleDescription,$CreateUser,$ViewOnly,$UpdateOnly,$ViewSubscribers,$SubmitCustom;
		global $AllowChat,$ViewSLA,$ExistUserAdmin,$RemoveAccess,$UsageHistory,$UACreatedBy;
		global $UAUpdatedBy,$UALastUpdateDate,$BusinessMessage,$SetAudit,$AllowTimekeeping;
		global $TimezoneProjects,$DefaultTimezone,$DefaultDateFormat,$ProjectAccounting,$AllowNegativeTimeEntry;
		global $AdvanceForOvertime,$SubmittedTime,$PrimaryApprover,$RecentTimecards,$RetroAdjustments,$MaxDailyLimit;
		global $FlexibleTimeEntry,$EnforceTimeEntry,$EmployeeAliases,$AllowRetroUpdates,$CopyTimesheetEmployees;
		global $CreateTimeSheet,$ApproveTimeSheet,$CreateTimeSheetTeam,$ApproveTimeSheetTeam,$CreateSupervisorTimeSheet;		
		global $TARCreatedBy,$TARUpdatedBy,$TARLastUpdateDate,$AllowPreApproval,$ApproverType;
		global $CreatedBy,$UpdatedBy,$CreationDate,$LastUpdateDate;
		//global $ApproveDirectReport,$UpadteApprovedTimesheet,$FlyApprovalRequest,$ProjectBasedApproval;
		//global $AMCreatedBy,$AMUpdatedBy,$AMCreationDate,$AMLastUpdateDate,$Text_ResourceGroup;
				
		
		$qry = "SELECT * from cxs_am_roles where ROLE_NAME='".$Text_RoleName."'";
				
		
		
		$result = mysql_query($qry);
		$TotalRecords = mysql_num_rows($result);
		while($row=mysql_fetch_array($result))
		{
			//$Text_FirstName = $row['FIRST_NAME'];
			//$Text_LastName = $row['LAST_NAME'];	
			//$Text_ResourceGroup = $row['RESOURCE_GROUP_NAME'];//"test";
			$Text_RoleDescription = $row['DESCRIPTION'];
			/******User Administration******/
			$CreateUser 	 = $row['CREATE_NEW_USER'];
			$ViewOnly 		 = $row['VIEW_ONLY'];
			$UpdateOnly 	 = $row['UPDATE_ONLY'];
			/******Billing Administration******/
			$ViewSubscribers = $row['VIEW_SUBSCRIBERS'];
			$SubmitCustom	 = $row['SUBMIT_CUSTOM'];
			//$AllowChat		 = $row['ALLOW_CHAT'];
			$ViewSLA		 = $row['VIEW_SLA'];
			$ExistUserAdmin  = $row['EXISTING_USER'];
			$RemoveAccess	 = $row['REMOVE_ACCESS'];
			$UsageHistory	 = $row['USAGE_HISTORY'];
			$CreatedBy  	 = $row['CREATED_BY']; 
			$UpdatedBy 		= $row['LAST_UPDATED_BY'];
			//$UACreationDate 	= $row['ua_createddt'];
		//	$UALastUpdateDate   = $row['ua_lastupdateddt'];
			
			/******Time Accounting Rules******/
			$BusinessMessage 	= $row['BIZ_MSG_FLAG'];
			$SetAudit 			= $row['AUDIT_FLAG'];
			$AllowTimekeeping 	= $row['ALLOW_TK_FLAG'];
			$TimezoneProjects 	= $row['ALLOW_TIMEZONE'];
			$DefaultTimezone 	= $row['DEFAULT_TIMEZONE'];
			$DefaultDateFormat 	= $row['DEFAULT_DATE_FORMAT'];
			$ProjectAccounting 	= $row['ENABLE_PA'];
			$AllowNegativeTimeEntry = $row['ALLOW_NEGATIVE'];
			$AdvanceForOvertime 	= $row['ADVANCE_FOR_OVERTIME'];
			$SubmittedTime 		= $row['UPDATE_SUBMITTED'];
			$PrimaryApprover 	= $row['OVERRIDE_PRIMARY'];
			$RecentTimecards 	= $row['RECENT_TIMECARDS'];
			$RetroAdjustments 	= $row['RETRO_ADJUST'];
			$MaxDailyLimit 		= $row['MAX_DAILY_LIMIT'];
			$FlexibleTimeEntry 	= $row['AFT_ENTRY'];
			//$EnforceTimeEntry 	= $row['ENFORCE_TIME_WBS'];
			$EmployeeAliases 	= $row['CREATE_EMP_ALIAS_FLAG'];
			$AllowRetroUpdates 	= $row['RETRO_PERIOD_NUM'];
			$CopyTimesheetEmployees = $row['ALLOW_COPY'];
			$CreateTimeSheet 	= $row['COPY_ANYONE_TS_FLAG'];
			$ApproveTimeSheet 	= $row['APPROVE_ANYONE_TS'];
			$CreateTimeSheetTeam = $row['CREATE_ANYONE_TS'];
			$ApproveTimeSheetTeam = $row['APPROVE_ANYONE_TS_TEAM'];
			$CreateSupervisorTimeSheet = $row['ALLOW_SUP_TS'];		
			
						
			/******Approval Management******/
			$AllowPreApproval 		= $row['ALLOW_PREAPPROVAL'];
			$ApproverType 			= $row['APPROVER_TYPE_FLAG'];
			$ApproveDirectReport 	= $row['APPROVE_DIRECT_REPORT'];
			$UpadteApprovedTimesheet = $row['ALLOW_UPDATE_APPROVE_TS'];
			//$FlyApprovalRequest 	= $row['ALLOW_ON_THE_FLY'];
			//$ProjectBasedApproval 	= $row['PROJECT_BASED_APPROVAL'];
			
			if((!is_null($row['CREATION_DATE'])) && (($row['CREATION_DATE'])!='0000-00-00') )
			{
				$CreationDate = date('m/d/Y', strtotime($row['CREATION_DATE']));	
			}
			if(!is_null($row['LAST_UPDATE_DATE']))
			{
				$LastUpdateDate = date('m/d/Y  h:i:sa', strtotime($row['LAST_UPDATE_DATE']));
			}
		}
		
		
	}
?>