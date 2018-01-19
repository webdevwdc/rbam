<?php ob_start ();
session_start();
include('conn.php');

if($_REQUEST['REQUEST'] == "UserCheck")
{
	$UserName = $_REQUEST['UserName'];			
	$Query = "SELECT * FROM cxs_users WHERE USER_NAME ='$UserName'";
	if($Query != '')	
	{
		$Result = mysql_query($Query);
		$result_row = mysql_num_rows($Result);
		if($result_row != 0){
			echo 'This Username Is Taken, Please Enter A Different Username.';
		}
		else{
			echo '';
		}
	}
}

if($_REQUEST['REQUEST'] == "SingleUserRecord")
{
	$UserId = $_REQUEST['UserId'];
	
	$QueryUser = "SELECT cxs_users.USER_ID,cxs_users.USER_NAME,cxs_users.ENC_KEY,cxs_users.RESET_DAYS,cxs_resources.RESOURCE_ID,cxs_users.START_DATE,cxs_users.END_DATE,cxs_users.PWD_RULE_CODE,
	cxs_application_assignments.APPLICATION_ROLE_ID,cxs_application_roles.APPLICATION_ROLE_ID,cxs_application_assignments.ROLE_START_DATE,cxs_application_assignments.ROLE_END_DATE 
	FROM cxs_users LEFT JOIN cxs_application_assignments ON cxs_users.RESOURCE_ID = cxs_application_assignments.ASSIGNMENT_ID
	LEFT JOIN cxs_resources ON cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID LEFT JOIN cxs_application_roles ON cxs_application_roles.APPLICATION_ROLE_ID = cxs_users.RESOURCE_ID
	WHERE cxs_users.USER_ID = '$UserId'";	
	$ResultUser = mysql_query($QueryUser);
	while($row=mysql_fetch_array($ResultUser))
	{
		$UserId			= $row['USER_ID'];
		$UserName 		= $row['USER_NAME'];
		$Password 		= $row['ENC_KEY'];
		$ResetDays 		= $row['RESET_DAYS'];
		//$ResourceName	= $row['RESOURCE_NAME'];
		$ResourceId		= $row['RESOURCE_ID'];
	//	$StartDate		= $row['START_DATE'];
	//	$EndDate 		= $row['END_DATE'];
		$PasswordRule 	= $row['PWD_RULE_CODE'];
		$RoleId			= $row['APPLICATION_ROLE_ID'];
		$RoleStartDate	= $row['ROLE_START_DATE'];
		$RoleEndDate 	= $row['ROLE_END_DATE'];		
		
		if((!is_null($row['START_DATE'])) && (($row['START_DATE'])!='0000-00-00') )
		{			
			$StartDate = date('m/d/Y', strtotime($row['START_DATE']));
		}
		else
		{
			$StartDate ='';
		}
		if((!is_null($row['END_DATE'])) && (($row['END_DATE'])!='0000-00-00'))
		{			
			$EndDate = date('m/d/Y', strtotime($row['END_DATE']));			
		}		
		else
		{
			$EndDate = "";
		}			
echo	$FinalRecord = "$UserName|$Password|$ResetDays|$ResourceId|$StartDate|$EndDate|$PasswordRule|$RoleId|$RoleStartDate|$RoleEndDate|"; 
//echo	$FinalRecord = "$ResourceId"; 
	}
}

if($_REQUEST['REQUEST'] == "ResourceAddressRecord"){
	$resId = $_REQUEST['res_addr_id'];	
	$sql = "SELECT * FROM cxs_resource_address WHERE ADDRESS_RESOURCE_ID = '".$resId."'";
	
	$Result = mysql_query($sql);
	$row=mysql_fetch_array($Result);
	
		$ADDRESS1		= $row['ADDRESS1'];
		$ADDRESS2		= $row['ADDRESS2'];
		$ADDRESS3		= $row['ADDRESS3'];
		$CITY 		= $row['CITY'];
		$STATE 		= $row['STATE'];
		$COUNTRY 		= $row['COUNTRY'];
		$POSTAL_CODE	= $row['POSTAL_CODE'];
		$PRIMARY_FLAG 	= $row['PRIMARY_FLAG'];
		$ACTIVE_FLAG	= $row['ACTIVE_FLAG'];
		
	   //echo $ADDRESS1.'|'.$ADDRESS2.'|'.$ADDRESS3.'|'.$CITY.'|'.$STATE.'|'.$COUNTRY.'|'.$POSTAL_CODE.'|'.$PRIMARY_FLAG.'|'.$ACTIVE_FLAG;
	   echo "$ADDRESS1|$ADDRESS2|$ADDRESS3|$CITY|$STATE|$COUNTRY|$POSTAL_CODE|$PRIMARY_FLAG|$ACTIVE_FLAG";
}

if($_REQUEST['REQUEST'] == "ResourceCheck")
{
	//$ApplicationRoleId = $_REQUEST['ApplicationRoleId'];
	$ResourceName = $_REQUEST['ResourceName'];
	$ResourceName = str_replace("'","''",$ResourceName);	
	
	$QueryResources = "SELECT * FROM cxs_resources WHERE (cxs_resources.FIRST_NAME like'%$ResourceName%' or cxs_resources.LAST_NAME like'%$ResourceName%')";
	$ResultResources = mysql_query($QueryResources);
	$result_row_Std = mysql_num_rows($ResultResources);
	
	if($result_row_Std != 0)
	{
		echo 'Resource Name Not Exist';
	}
	else
	{
		echo '';
	}
}

if($_REQUEST['REQUEST'] == "SearchResourceNameData")
{
	$ResourceName = $_REQUEST['ResourceName'];
	$ResourceName = str_replace("'","''",$ResourceName);	
	
	$ResourceName_Result = "";
	$QueryResources = "SELECT * FROM cxs_resources WHERE (cxs_resources.FIRST_NAME like'%$ResourceName%' or cxs_resources.LAST_NAME like'%$ResourceName%') order by FIRST_NAME,LAST_NAME";
	$ResultResources = mysql_query($QueryResources);
	$ResultRows = mysql_num_rows($ResultResources);
	if($ResultRows > 0)
	{
		echo $ResourceName_Result1 = "<ul class='list-unstyled' id='resource-list'>";
	}
	while($row = mysql_fetch_array($ResultResources))
	{
		$ResourceId = $row['RESOURCE_ID'];
		$ResourceNameResult =  $row['FIRST_NAME'].' '.$row['LAST_NAME'];		
		?>
		<li  style="cursor:pointer"onChange="ResetResourceDiv();" onClick="SelectedResourceName('<?php echo $ResourceNameResult; ?>',<?php echo $ResourceId; ?>);"><?php echo $ResourceNameResult; ?></li>
<?php	
	}
	if($ResultRows > 0)
	{
	?>
		</ul>
<?php }
	}
	
/*
	if($_REQUEST['REQUEST'] == "FindEditResourceId")
	{
		$ResourceName = $_REQUEST['ResourceName'];	
		$pos = strpos($ResourceName,' ');
		$FirstName = substr($ResourceName,0,$pos);		
		$LastName = substr($ResourceName,$pos+1);
		
		$FirstName = str_replace("'","''",$FirstName);
		$LastName = str_replace("'","''",$LastName);
		
		echo$getUserId = getvalue("cxs_resources","RESOURCE_ID","where FIRST_NAME = '$FirstName' and LAST_NAME = '$LastName'");
	}
*/	

	if($_REQUEST['REQUEST'] == "ExportUsrAdministration")
	{
		$UserId = $_REQUEST['qry'];	
		$Sortby = $_REQUEST['sortby'];	
		$s = $UserId;
		do
		{
			$pos = strpos($s,"|");
			$s1 = trim(substr($s, 0, $pos));  //id
			$s2 = $s2."USER_ID=$s1 or ";
			$s = substr($s, $pos+1);
			
		}while($s.length>0);			
	$s2=substr( $s2, 0, -3 );
	
	$Export_data = "";
	$Export_data = "User Name, Resource Name, Resource Id, Start Date Active, End Date Active, Active User  \r\n";
					
	 $ExportQuery = "SELECT concat(cxs_resources.FIRST_NAME,' ',cxs_resources.LAST_NAME) as RESOURCE_NAME,cxs_users.* FROM 
		cxs_users INNER JOIN cxs_resources ON cxs_users.RESOURCE_ID = cxs_resources.RESOURCE_ID WHERE $s2 $Sortby";
	$ResultExport = mysql_query($ExportQuery);
		
	while($row = mysql_fetch_array($ResultExport))
	{
		$UserName 		= $row['USER_NAME'];
		$ResourceName 	= $row['RESOURCE_NAME'];
		$ResourceId 	= $row['RESOURCE_ID'];
		//$StartDate		= $row['START_DATE'];
		//$EndDate 		= $row['END_DATE'];
		$CurrentDate = date('m/d/Y');
		if((!is_null($row['START_DATE'])) && (($row['START_DATE'])!='0000-00-00') )
		{			
			$StartDate = date('m/d/Y', strtotime($row['START_DATE']));
		}
		else
		{
			$StartDate ='';
		}
		
		if((!is_null($row['END_DATE'])) && (($row['END_DATE'])!='0000-00-00'))
		{			
			$EndDate = date('m/d/Y', strtotime($row['END_DATE']));										
			if($CurrentDate > $EndDate)
			{
				$ActiveUser = "Inactive";
			}
			else
			{
				$ActiveUser = "Active";
			}
		}
		else
		{
			$EndDate ='';
			$ActiveUser = "Active";
		}
	
		$Export_data .= "$row[USER_NAME], $row[RESOURCE_NAME], $row[RESOURCE_ID], $StartDate, $EndDate, $ActiveUser \r\n";
	}	
	$_SESSION['User_Administration_Export'] = $Export_data;
}

if($_REQUEST['REQUEST'] == "ExportAssignApplicationAdministrators")
{
	   $APP_ADM_IDs = $_REQUEST['qry'];
	   $Sortby = $_REQUEST['sortby'];
	   
	   $ids = explode("|",$APP_ADM_IDs);
	   $app_adm_ids = implode(",",$ids);
	   $ex_qry = "cxs_am_app_admin.APP_ADM_ID in(".$app_adm_ids.") ";
	   
	   
	
	   $Export_data = "";
	   $Export_data = "Application,User Name,First Name,Last Name,Start Date,End Date  \r\n";	
	   //$ExportQuery = "select cxs_am_app_admin.*,cxs_resources.FIRST_NAME, cxs_resources.LAST_NAME,cxs_users.USER_NAME from cxs_am_app_admin inner join cxs_users on cxs_users.USER_ID = cxs_am_app_admin.USER_ID inner join cxs_resources on cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID  WHERE $ex_qry $Sortby ";
				    
	   $ExportQuery = "select cxs_am_app_admin.*,sys_applications.NAME,cxs_resources.FIRST_NAME, cxs_resources.LAST_NAME,cxs_users.USER_NAME
	   from
			 cxs_am_app_admin, cxs_users,cxs_resources,sys_applications
	   where
			 cxs_am_app_admin.USER_ID = cxs_users.USER_ID
			 and
			 cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID
			 and
			 cxs_am_app_admin.APPLICATION_ID = sys_applications.APPLICATION_ID
			 and
			 $ex_qry $Sortby ";
				    
	   $ResultExport = mysql_query($ExportQuery);		
	   while($row = mysql_fetch_array($ResultExport))
	   {
			//$UserName 	= $row['USER_NAME'];
			//$ResourceName 	= $row['RESOURCE_NAME'];
			//$DBRowNo = $row['ROWNO'];
			
			$UserName	= $row['USER_NAME'];
			$FirstName	= $row['FIRST_NAME'];
			$LastName	= $row['LAST_NAME'];
			$ApplicationName = $row['NAME'];															
			if((!is_null($row['START_DATE_ACTIVE'])) && (($row['START_DATE_ACTIVE'])!='0000-00-00') )
			{
				$StartDateActive = date('m/d/Y', strtotime($row['START_DATE_ACTIVE']));	
			}
			if((!is_null($row['END_DATE_ACTIVE'])) && (($row['END_DATE_ACTIVE'])!='0000-00-00') )
			{
				$EndDateActive = date('m/d/Y', strtotime($row['END_DATE_ACTIVE']));	
			}
			$Export_data .= "$ApplicationName, $UserName, $FirstName, $LastName, $StartDateActive, $EndDateActive \r\n";		
	   }
		echo "Write data: ".$Export_data;
	   $_SESSION['assign_applications'] = $Export_data;
	
	}

	if($_REQUEST['REQUEST'] == "ExportCurrentSubscriber")
	{
		$UserId = $_REQUEST['qry'];	
		$Sortby = $_REQUEST['sortby'];	
		$s = $UserId;
		do
		{
			$pos = strpos($s,"|");
			$s1 = trim(substr($s, 0, $pos));  //id
			$s2 = $s2."cxs_subscribers.SUBSCRIBER_ID=$s1 or ";
			$s = substr($s, $pos+1);
			
		}while($s.length>0);			
	$s2=substr( $s2, 0, -3 );
	
	
	$ids = explode("|",$UserId);
	$sb_ids = implode(",",$ids);
	$ex_qry = "cxs_subscribers.SUBSCRIBER_ID in(".$sb_ids.") ";
	
	$Export_data = "";
	$Export_data = "Subscriber Name,User Name, Start Date Active, End Date Active, Monthly Biling \r\n";
					
	 $ExportQuery = "SELECT cxs_subscribers.*,cxs_users.USER_NAME FROM cxs_subscribers
					Left JOIN cxs_users ON cxs_users.USER_ID = cxs_subscribers.USER_ID WHERE $ex_qry $Sortby";
	$ResultExport = mysql_query($ExportQuery);
		
	while($row = mysql_fetch_array($ResultExport))
	{
		$UserName 		= $row['USER_NAME'];
		$SubscriberName 	= $row['FIRST_NAME'].' '.$row['LAST_NAME'];		
		$StartDate		= $row['START_DATE'];
		$EndDate 		= $row['END_DATE'];
		$MonthlyBilling 	= "$0";		
		if((!is_null($row['START_DATE'])) && (($row['START_DATE'])!='0000-00-00') )
		{			
			$StartDate = date('m/d/Y', strtotime($row['START_DATE']));
		}
		else
		{
			$StartDate ='';
		}
		
		if((!is_null($row['END_DATE'])) && (($row['END_DATE'])!='0000-00-00'))
		{			
			$EndDate = date('m/d/Y', strtotime($row['END_DATE']));
		}
		else
		{
			$EndDate ='';			
		}
		$Export_data .= "$SubscriberName,$UserName, $StartDate, $EndDate, $MonthlyBilling \r\n";
	}	
		$_SESSION['current_subsciber_export'] = $Export_data;
	}

	if($_REQUEST['REQUEST'] == "FavoritesList")
	{
		$LoginUserId = "1";
		$FeatureName = $_REQUEST['FeatureName'];
		$PageName = $_REQUEST['PageName'];		
		$list = "";
		$IsExistData="";
		$qry = "select * from cxs_users_favorites where USER_ID = $LoginUserId and PAGE_NAME ='$PageName' and MODULE_NAME = '$ModuleName'";
		$result=mysql_query	($qry);
		$TotalRecords = mysql_fetch_array($result);
		if($TotalRecords>0)
		{
			$qry1 ="Delete from cxs_users_favorites where USER_ID = $LoginUserId and PAGE_NAME ='$PageName' and MODULE_NAME = '$ModuleName'";
			mysql_query($qry1);			
			$IsExistData = "No";
		}
		else
		{
			$insArr = array();
			$insArr['USER_ID']=$LoginUserId;
			$insArr['FEATURE_NAME']=$FeatureName;
			$insArr['PAGE_NAME']=$PageName;		
			$insArr['MODULE_NAME']=$ModuleName;	
			insertdata("cxs_users_favorites",$insArr);				
		}
		
		$qry = "select * from cxs_users_favorites where USER_ID = $LoginUserId and MODULE_NAME = '$ModuleName' order by FEATURE_NAME";
		$result=mysql_query	($qry);
		
		while($row = mysql_fetch_array($result))
		{
			$PAGE_NAME = $row['PAGE_NAME'];
			$FEATURE_NAME = $row['FEATURE_NAME'];
			$list .= "<li><a href='$PAGE_NAME'> $FEATURE_NAME </a></li>";   	
		}
		echo $list.$IsExistData;
	}

if($_REQUEST['REQUEST'] == "SingleSubscriberRecord")
{
	$SubscriberId = $_REQUEST['SubscriberId'];
	
	$selectQuery = "Select cxs_subscribers.*,cxs_users.USER_NAME  from cxs_subscribers left join cxs_users on cxs_users.USER_ID = cxs_subscribers.USER_ID WHERE cxs_subscribers.SUBSCRIBER_ID = '$SubscriberId'";
	$Result = mysql_query($selectQuery);
	while($row=mysql_fetch_array($Result))
	{
		$UserName 		= $row['USER_NAME'];
		$FirstName 		= $row['FIRST_NAME'];
		$LastName 		= $row['LAST_NAME'];				
		if((!is_null($row['START_DATE'])) && (($row['START_DATE'])!='0000-00-00') )
		{			
			$StartDate = date('m/d/Y', strtotime($row['START_DATE']));
		}
		else
		{
			$StartDate ='';
		}
		if((!is_null($row['END_DATE'])) && (($row['END_DATE'])!='0000-00-00'))
		{			
			$EndDate = date('m/d/Y', strtotime($row['END_DATE']));			
		}		
		else
		{
			$EndDate = "";
		}			

	}
	echo	$FinalRecord = "$FirstName|$LastName|$StartDate|$EndDate|$UserName|"; 
}


if($_REQUEST['REQUEST'] == "SingleSubscriberRecord")
{
	
}

if($_REQUEST['REQUEST'] == "ExportCommonWord")
{
	   $C_Word_Id = $_REQUEST['qry'];	
	   $Sortby = $_REQUEST['sortby'];	
	   $s = $C_Word_Id;
	   do
	   {
			$pos = strpos($s,"|");
			$s1 = trim(substr($s, 0, $pos));  //id
			$s2 = $s2."cxs_common_words.COMMON_WORD_ID=$s1 or ";
			$s = substr($s, $pos+1);
			
	   }while($s.length>0);			
	   $s2=substr( $s2, 0, -3 );
		
	   $ids = explode("|",$C_Word_Id);
	   $c_ids = implode(",",$ids);
	   $ex_qry = "cxs_common_words.COMMON_WORD_ID in(".$c_ids.") ";
	
	   $Export_data = "";
	   $Export_data = "WORD NAME,ACTIVE FLAG \r\n";
					
	   $ExportQuery = "SELECT * FROM cxs_common_words WHERE $ex_qry $Sortby";
	   //echo $ExportQuery;
	   $ResultExport = mysql_query($ExportQuery);
		
	   while($row = mysql_fetch_array($ResultExport))
	   {
			$WORD_NAME 		= $row['WORD_NAME'];
			if($row['ACTIVE_FLAG']=='1')
			{
				$ACTIVE_FLAG 	= 'Yes';
			}
			else
			{
				$ACTIVE_FLAG 	= 'No';
			}
			
			$Export_data .= "$WORD_NAME,$ACTIVE_FLAG \r\n";
	   }	
	   $_SESSION['current_commonword_export'] = $Export_data;
}
	
	   if($_REQUEST['REQUEST'] == "ExportWBS")
	   {
			 
	   $WBS_ID = $_REQUEST['ID'];
		$row_Id = $_REQUEST['qry'];	
		$Sortby = $_REQUEST['sortby'];	
		
		$ids = explode("|",$row_Id);
		
		$ex_qry = "cxs_wbs.WBS_ID=".$WBS_ID;
	
		$Export_data = "";
		$Export_data = "SEGMENT,DISPLAY VALUE,DESCRIPTION,ROLLUP,ACTIVE FLAG,IN USE \r\n";
					
		$ExportQuery = "SELECT * FROM cxs_wbs WHERE $ex_qry $Sortby";
		
		$ResultExport = mysql_query($ExportQuery);
		
		$row = mysql_fetch_array($ResultExport);
		
		foreach($ids as $id)
		{
			$SEGMENT = $row['SEGMENT'.$id];
			$DISPLAY_VALUE = $row['DISPLAY_VALUE'.$id];
			$DESCRIPTION = $row['DESCRIPTION'.$id];
			
			if($row['ROLLUP'.$id]=='Y'){	$ROLLUP 	= 'Yes'; }else{ $ROLLUP 	= 'No'; }
			if($row['ACTIVE_FLAG'.$id]=='Y'){	$ACTIVE_FLAG 	= 'Yes'; }else{ $ACTIVE_FLAG 	= 'No'; }
			if($row['IN_USE'.$id]=='Y'){	$IN_USE 	= 'Yes'; }else{ $IN_USE 	= 'No'; }
			
			$Export_data .= "$SEGMENT,$DISPLAY_VALUE,$DESCRIPTION,$ROLLUP,$ACTIVE_FLAG,$IN_USE \r\n";
						
		}	
		$_SESSION['wbs_structure_export'] = $Export_data;
	   }


	if($_REQUEST['REQUEST'] == "ExportResourceAddress")
	{
		$res_addr_Id = $_REQUEST['qry'];	
		$Sortby = $_REQUEST['sortby'];	
				
		$ids = explode("|",$res_addr_Id);
		$c_ids = implode(",",$ids);
		$ex_qry = "cxs_resource_address.ADDRESS_RESOURCE_ID in(".$c_ids.") ";
	
		$Export_data = "";
		$Export_data = "ADDRESS1,ADDRESS2,ADDRESS3,CITY,ZIP,STATE,COUNTRY,PRIMARY FLAG,ACTIVE FLAG \r\n";
					
		$ExportQuery = "SELECT * FROM cxs_resource_address WHERE $ex_qry $Sortby";
		//echo $ExportQuery;
		$ResultExport = mysql_query($ExportQuery);
		
		while($row = mysql_fetch_array($ResultExport))
		{
			$ADDRESS1 	= $row['ADDRESS1'];
			$ADDRESS2 	= $row['ADDRESS2'];
			$ADDRESS3 	= $row['ADDRESS3'];
			$CITY 		= $row['CITY'];
			$POSTAL_CODE	= $row['POSTAL_CODE'];
			$STATE 		= $row['STATE'];
			$COUNTRY 		= $row['COUNTRY'];
			
			
			if($row['PRIMARY_FLAG']=='Y'){	$PRIMARY_FLAG 	= 'Yes';	}else{	$PRIMARY_FLAG 	= 'No';	}
			if($row['ACTIVE_FLAG']=='Y'){		$ACTIVE_FLAG 	= 'Yes';	}else{	$ACTIVE_FLAG 	= 'No';	}
			
			$Export_data .= "$ADDRESS1,$ADDRESS2,$ADDRESS3,$CITY,$POSTAL_CODE,$STATE,$COUNTRY,$PRIMARY_FLAG,$ACTIVE_FLAG \r\n";
		}	
		$_SESSION['current_resource_address'] = $Export_data;
	}
	
?>