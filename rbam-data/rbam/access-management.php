<?php ob_start();
session_start();
include("conn.php");
check_login();
include 'find.php';	
?>
<?php
	//global $OnlyME;
	$PageName = "access-management.php";	
	$sort =  isset( $_GET['sort'] )? $_GET['sort']:'desc';
	$OrderBY = "";
	$FieldName = "";
	
	$OrderBY = "asc";
	$FieldName = "USER_NAME";
	$Sorts = "";	
	$Sorts = isset( $_POST['h_field_order'] )? $_POST['h_field_order']: $sort;
	$FileName = isset( $_POST['h_field_name'] )? $_POST['h_field_name']: $FieldName;
	$s_Query = isset( $_POST['h_query'] )? $_POST['h_query']: "";	
	$s_Query = str_replace("\\","",$s_Query);
	if ($Sorts == 'asc')
	{
   	 $OrderBY = " desc";
   	 $FieldName = $FileName;
	}
	if ($Sorts == 'desc')
	{
		 $OrderBY = " asc";
		 $FieldName = $FileName;
	}

	$SQueryOrderBy = " order by $FieldName $OrderBY";
	$record_per_page=$RecordsPerPage;
   
	if (isset($_GET["page"])) 
	{ 
		$page  = $_GET["page"]; 
	} 
	else 
	{
		$page=1;
	} 
	$start_from = ($page-1) *  $record_per_page; 
	
?>
<script type="text/javascript" >
	function DataSort(str1,str2)
	{
		var str3;

		document.getElementById('h_field_name').value = str1;
		document.getElementById('h_field_order').value = str2;

		Access_Management.submit();
	}
	function SearchData()
	{
		document.getElementById('h_field_name').value = '';
		document.getElementById('h_field_order').value = '';
		
		Access_Management.submit();
	}
	function ViewRole1(UserName)
	{
		KEY = "SingleRoleView";
		document.getElementById("h_field_username").value = UserName;	
		makeRequest("ajax_userdata.php","REQUEST=SingleApplicationRole&UserName=" + UserName);
//		location.href="access-management.php?uname="+UserName;		
	}
	function ViewRole(UserName)
	{
		
		$.ajax({
			type: 'POST',	
			url: 'ajax_userdata.php',        
			data: ({uname:UserName}),
			dataType: 'json',        
			success: function(response)
			{  
				var myJSON = JSON.stringify(response);			
				var newArray = JSON.parse(myJSON);				
				clearViewRoleData();
				$('#Modal_ViewRoleDetails').modal();
				
				$('#Modal_ViewRoleDetails').find("#myModalLabel").html(" Role Details - "+UserName);
				
				if (newArray.CreateUser=="Y")
				{
					document.getElementById("Check_CreateUser").checked = true;
				}	
				if (newArray.ViewOnly=="Y")
				{
					document.getElementById("Check_ViewOnly").checked = true;
				}
				if (newArray.UpdateOnly=="Y")
				{
					document.getElementById("Check_UpdateOnly").checked = true;
				}
				if (newArray.ViewSubscribers=="Y")
				{
					document.getElementById("Check_ViewSubscribers").checked = true;
				}	
				if (newArray.SubmitCustom=="Y")
				{
					document.getElementById("Check_SubmitCustomization").checked = true;
				}
				/*if (newArray.AllowChat=="Y")
				{
					document.getElementById("Check_AllowChat").checked = true;
				}*/	
				if (newArray.ViewSLA=="Y")
				{
					document.getElementById("Check_ViewSLA").checked = true;
				}
				if (newArray.ExistUserAdmin=="Y")
				{
					document.getElementById("Check_ExistUserAdmin").checked = true;
				}	
				if (newArray.RemoveAccess=="Y")
				{
					document.getElementById("Check_RemoveAccess").checked = true;
				}	
				if (newArray.UsageHistory=="Y")
				{
					document.getElementById("Check_UsageHistory").checked = true;
				}
				
				//Heading 2
				if (newArray.BusinessMessage=="Y")
				{
					document.getElementById("Check_BusinessMessage").checked = true;
				}	
				if (newArray.SetAudit=="Y")
				{
					document.getElementById("Check_SetAudit").checked = true;
				}
				if (newArray.AllowTimekeeping=="Y")
				{
					//document.getElementById("Check_AllowTimekeeping").checked = true;
				}
				if (newArray.TimezoneProjects=="Y")
				{
					//document.getElementById("Check_TimezoneProjects").checked = true;
				}	
				if (newArray.ProjectAccounting=="Y")
				{
					//document.getElementById("Check_ProjectAccounting").checked = true;
				}
				if (newArray.AllowNegativeTimeEntry=="Y")
				{
					document.getElementById("Check_AllowNegativeTimeEntry").checked = true;
				}	
				if (newArray.AdvanceForOvertime=="Y")
				{
					document.getElementById("Check_AdvanceForOvertime").checked = true;
				}
				if (newArray.SubmittedTime=="Y")
				{
					document.getElementById("Check_SubmittedTime").checked = true;
				}	
				if (newArray.PrimaryApprover=="Y")
				{
					document.getElementById("Check_PrimaryApprover").checked = true;
				}	
				if (newArray.RecentTimecards=="Y")
				{
					document.getElementById("Text_RecentTimecards").checked = true;
				}
				if (newArray.RetroAdjustments=="Y")
				{
					document.getElementById("Check_RetroAdjustments").checked = true;
				}
				
				if (newArray.MaxDailyLimit=="Y")
				{
					document.getElementById("Text_MaxDailyLimit").checked = true;
				}	
				if (newArray.FlexibleTimeEntry=="Y")
				{
					document.getElementById("Check_FlexibleTimeEntry").checked = true;
				}
				/*if (newArray.EnforceTimeEntry=="Y")
				{
					document.getElementById("Check_EnforceTimeEntry").checked = true;
				}*/	
				/*if (newArray.EmployeeAliases=="Y")
				{
					document.getElementById("Check_EmployeeAliases").checked = true;
				}*/					
				if (newArray.CopyTimesheetEmployees=="Y")
				{
					document.getElementById("Check_CopyTimesheetEmployees").checked = true;
				}
				document.getElementById("Text_RecentTimecards").value = newArray.RecentTimecards;
				document.getElementById("Text_MaxDailyLimit").value = newArray.MaxDailyLimit;
				document.getElementById("Text_AllowRetroUpdates").value = newArray.AllowRetroUpdates;
				
				//Heading3	
				if (newArray.CreateTimeSheet=="Y")
				{
					document.getElementById("Check_CreateTimeSheet").checked = true;
				}	
				if (newArray.ApproveTimeSheet=="Y")
				{
					document.getElementById("Check_ApproveTimeSheet").checked = true;
				}
				if (newArray.CreateTimeSheetTeam=="Y")
				{
					document.getElementById("Check_CreateTimeSheetTeam").checked = true;
				}
				if (newArray.ApproveTimeSheetTeam=="Y")
				{
					document.getElementById("Check_ApproveTimeSheetTeam").checked = true;
				}	
				if (newArray.CreateSupervisorTimeSheet=="Y")
				{
					document.getElementById("Check_CreateSupervisorTimeSheet").checked = true;
				}
				
				//Heading4
				var s1="";
				var s2="";
				var s3="";
				var s4="";
				var j = newArray.TotalRecords1;
				
				for(i=1;i<=j;i++)
				{
					s1="";
					s2="";
					s3="";
					s4="";
					
					if (i==1)	{s1=newArray.CreatePriv1; s2=newArray.UpdatePriv1; s3=newArray.ViewPriv1; s4=newArray.EnableAudit1;}
					else if (i==2)	{s1=newArray.CreatePriv2; s2=newArray.UpdatePriv2; s3=newArray.ViewPriv2; s4=newArray.EnableAudit2;}
					else if (i==3)	{s1=newArray.CreatePriv3; s2=newArray.UpdatePriv3; s3=newArray.ViewPriv3; s4=newArray.EnableAudit3;}
					else if (i==4)	{s1=newArray.CreatePriv4; s2=newArray.UpdatePriv4; s3=newArray.ViewPriv4; s4=newArray.EnableAudit4;}
					else if (i==5)	{s1=newArray.CreatePriv5; s2=newArray.UpdatePriv5; s3=newArray.ViewPriv5; s4=newArray.EnableAudit5;}
					else if (i==6)	{s1=newArray.CreatePriv6; s2=newArray.UpdatePriv6; s3=newArray.ViewPriv6; s4=newArray.EnableAudit6;}
					else if (i==7)	{s1=newArray.CreatePriv7; s2=newArray.UpdatePriv7; s3=newArray.ViewPriv7; s4=newArray.EnableAudit7;}
					else if (i==8)	{s1=newArray.CreatePriv8; s2=newArray.UpdatePriv8; s3=newArray.ViewPriv8; s4=newArray.EnableAudit8;}
					else if (i==9)	{s1=newArray.CreatePriv9; s2=newArray.UpdatePriv9; s3=newArray.ViewPriv9; s4=newArray.EnableAudit9;}
					else if (i==10)	{s1=newArray.CreatePriv10; s2=newArray.UpdatePriv10; s3=newArray.ViewPriv10; s4=newArray.EnableAudit10;}
					else if (i==11)	{s1=newArray.CreatePriv11; s2=newArray.UpdatePriv11; s3=newArray.ViewPriv11; s4=newArray.EnableAudit11;}
					else if (i==12)	{s1=newArray.CreatePriv12; s2=newArray.UpdatePriv12; s3=newArray.ViewPriv12; s4=newArray.EnableAudit12;}
					else if (i==13)	{s1=newArray.CreatePriv13; s2=newArray.UpdatePriv13; s3=newArray.ViewPriv13; s4=newArray.EnableAudit13;}					
					else if (i==14)	{s1=newArray.CreatePriv14; s2=newArray.UpdatePriv14; s3=newArray.ViewPriv14; s4=newArray.EnableAudit14;}					
					if (s1=="Y")
					{
						document.getElementById("Check_Create"+i).checked = true;
					}	
					if (s2=="Y")
					{
						document.getElementById("Check_Update"+i).checked = true;
					}	
					if (s3=="Y")
					{
						document.getElementById("Check_View"+i).checked = true;
					}	
					if (s4=="Y")
					{
						document.getElementById("Check_Audit"+i).checked = true;
					}	
				}
				var t1,t2,t3,t4,MyTitle;
				
				t1=newArray.CreatedByName;
				t2=newArray.UpdatedByName;
				t3=newArray.UACreationDate;
				t4=newArray.UALastUpdateDate;
				MyTitle = "Created By:"+t1+"<br>  Updated By:"+t2+"<br>  Creation Date:"+t3+" <br>  Last Update Date:"+t4;
				document.getElementById("btn_heading1").setAttribute('data-content',MyTitle);
				
				t1=newArray.TARCreatedByName;
				t2=newArray.TARUpdatedByName;
				t3=newArray.TARCreationDate;
				t4=newArray.TARLastUpdateDate;
				MyTitle = "Created By:"+t1+"<br>  Updated By:"+t2+"<br>  Creation Date:"+t3+" <br>  Last Update Date:"+t4;
				document.getElementById("btn_heading2").setAttribute('data-content',MyTitle);				
				document.getElementById("btn_heading3").setAttribute('data-content',MyTitle);
				
				
				t1=newArray.TAMCreatedBy;
				t2=newArray.TAMUpdatedBy ;
				t3=newArray.TAMCreationDate;
				t4="";//newArray.TAMLastUpdateDate;
				MyTitle = "Created By:"+t1+"<br>  Updated By:"+t2+"<br>  Creation Date:"+t3+" <br>  Last Update Date:"+t4;
				document.getElementById("btn_heading4").setAttribute('data-content',MyTitle);
				
				t1="";//newArray.CreatedByName;
				t2="";//newArray.UpdatedByName;
				t3="";//newArray.UACreationDate;
				t4="";//newArray.UALastUpdateDate;
				MyTitle = "Created By:"+t1+"<br>  Updated By:"+t2+"<br>  Creation Date:"+t3+" <br>  Last Update Date:"+t4;
				document.getElementById("btn_heading5").setAttribute('data-content',MyTitle);
				
				t1="";//newArray.CreatedByName;
				t2="";//newArray.UpdatedByName;
				t3="";//newArray.UACreationDate;
				t4="";//newArray.UALastUpdateDate;
				MyTitle = "Created By:"+t1+"<br>  Updated By:"+t2+"<br>  Creation Date:"+t3+" <br>  Last Update Date:"+t4;
				document.getElementById("btn_heading6").setAttribute('data-content',MyTitle);
			
			}
		});
	}
	
	function clearViewRoleData()
	{
		document.getElementById("Check_CreateUser").checked = false;
		document.getElementById("Check_ViewOnly").checked = false;
		document.getElementById("Check_UpdateOnly").checked = false;
		document.getElementById("Check_ViewSubscribers").checked = false;
		document.getElementById("Check_SubmitCustomization").checked = false;
		//document.getElementById("Check_AllowChat").checked = false;
		document.getElementById("Check_ViewSLA").checked = false;
		document.getElementById("Check_ExistUserAdmin").checked = false;
		//document.getElementById("Check_RemoveAccess").checked = false;
		document.getElementById("Check_UsageHistory").checked = false;
		
		document.getElementById("Check_CreateUser").disabled = true;
		document.getElementById("Check_ViewOnly").disabled = true;
		document.getElementById("Check_UpdateOnly").disabled = true;
		document.getElementById("Check_ViewSubscribers").disabled = true;
		document.getElementById("Check_SubmitCustomization").disabled = true;
		//document.getElementById("Check_AllowChat").disabled = true;
		document.getElementById("Check_ViewSLA").disabled = true;
		document.getElementById("Check_ExistUserAdmin").disabled = true;
		//document.getElementById("Check_RemoveAccess").disabled = true;
		document.getElementById("Check_UsageHistory").disabled = true;
		
		//Heading2
		document.getElementById("Check_BusinessMessage").checked = false;
		document.getElementById("Check_SetAudit").checked = false;		
		//document.getElementById("Check_AllowTimekeeping").checked = false;		
		//document.getElementById("Check_TimezoneProjects").checked = false;		
		//document.getElementById("Check_ProjectAccounting").checked = false;		
		document.getElementById("Check_AllowNegativeTimeEntry").checked = false;		
		document.getElementById("Check_AdvanceForOvertime").checked = false;		
		document.getElementById("Check_SubmittedTime").checked = false;		
		document.getElementById("Check_PrimaryApprover").checked = false;		
		document.getElementById("Text_RecentTimecards").checked = false;		
		document.getElementById("Check_RetroAdjustments").checked = false;		
		document.getElementById("Text_MaxDailyLimit").checked = false;		
		document.getElementById("Check_FlexibleTimeEntry").checked = false;		
		//document.getElementById("Check_EnforceTimeEntry").checked = false;		
		//document.getElementById("Check_EmployeeAliases").checked = false;		
		document.getElementById("Check_CopyTimesheetEmployees").checked = false;		
		document.getElementById("Text_RecentTimecards").value = "";
		document.getElementById("Text_MaxDailyLimit").value = "";
		document.getElementById("Text_AllowRetroUpdates").value = "";
		
		document.getElementById("Check_BusinessMessage").disabled = true;
		document.getElementById("Check_SetAudit").disabled = true;		
		//document.getElementById("Check_AllowTimekeeping").disabled = true;		
		//document.getElementById("Check_TimezoneProjects").disabled = true;		
		//document.getElementById("Check_ProjectAccounting").disabled = true;		
		document.getElementById("Check_AllowNegativeTimeEntry").disabled = true;		
		document.getElementById("Check_AdvanceForOvertime").disabled = true;		
		document.getElementById("Check_SubmittedTime").disabled = true;		
		document.getElementById("Check_PrimaryApprover").disabled = true;		
		document.getElementById("Text_RecentTimecards").disabled = true;		
		document.getElementById("Check_RetroAdjustments").disabled = true;		
		document.getElementById("Text_MaxDailyLimit").disabled = true;		
		document.getElementById("Check_FlexibleTimeEntry").disabled = true;		
		//document.getElementById("Check_EnforceTimeEntry").disabled = true;		
		//document.getElementById("Check_EmployeeAliases").disabled = true;		
		document.getElementById("Check_CopyTimesheetEmployees").disabled = true;		
		document.getElementById("Text_RecentTimecards").disabled = true;
		document.getElementById("Text_MaxDailyLimit").disabled = true;
		document.getElementById("Text_AllowRetroUpdates").disabled = true;
		
		
		//Heading3		
		document.getElementById("Check_CreateTimeSheet").checked = false;		
		document.getElementById("Check_ApproveTimeSheet").checked = false;		
		document.getElementById("Check_CreateTimeSheetTeam").checked = false;		
		document.getElementById("Check_ApproveTimeSheetTeam").checked = false;		
		document.getElementById("Check_CreateSupervisorTimeSheet").checked = false;	
		
		document.getElementById("Check_CreateTimeSheet").disabled = true;	
		document.getElementById("Check_ApproveTimeSheet").disabled = true;	
		document.getElementById("Check_CreateTimeSheetTeam").disabled = true;	
			
		//Heading4
		
		var rows = [1,2,6,7,9,10,13,14,15,16,17,18,19,20,21];
		
		var j =0;//= 13;
		j = $("#Heading4_Table tbody tr").length;
		
		//for(i=1;i<=j;i++)
		for (i = 0; i < rows.length; i++) 
		{
			document.getElementById("Check_Create"+rows[i]).checked = false;
			document.getElementById("Check_Update"+rows[i]).checked = false;
			document.getElementById("Check_View"+rows[i]).checked = false;
			document.getElementById("Check_Audit"+rows[i]).checked = false;
			
			document.getElementById("Check_Create"+rows[i]).disabled = true;	
			document.getElementById("Check_Update"+rows[i]).disabled = true;	
			document.getElementById("Check_View"+rows[i]).disabled = true;	
			document.getElementById("Check_Audit"+rows[i]).disabled = true;
		}
		
		//Heading6
		
		document.getElementById("Check_AllowPreApproval").checked = false;	
		document.getElementById("Check_ApproveDirectReport").checked = false;
		document.getElementById("Check_UpadteApprovedTimesheet").checked = false;
		//document.getElementById("Check_FlyApprovalRequest").checked = false;
		//document.getElementById("Check_ProjectBasedApproval").checked = false;
		
		document.getElementById("Text_TempApproverName").value = "";
		
		document.getElementById("Check_AllowPreApproval").disabled = true;
		document.getElementById("Check_ApproveDirectReport").disabled = true;
		document.getElementById("Check_UpadteApprovedTimesheet").disabled = true;
		//document.getElementById("Check_FlyApprovalRequest").disabled = true;
		//document.getElementById("Check_ProjectBasedApproval").disabled = true;
		
		j=0;
		j = $("#Heading6_Table1 tbody tr").length;
		for(i=1;i<=j;i++)
		{	
			document.getElementById("Combo_ApproverName"+i).disabled = true;
			document.getElementById("Combo_ApproverType"+i).disabled = true;
		}	
		
		document.getElementById("Text_TempApproverName").disabled = true;
		j=0;
		j = $("#Heading6_Table2 tbody tr").length;
		for(i=1;i<=j;i++)
		{	
			document.getElementById("Combo_PeriodId"+i).disabled = true;
			//document.getElementById("Combo_AliasName"+i).disabled = true;
			document.getElementById("Check_ActiveFlag"+i).disabled = true;			
		}
	}
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
				if (KEY == "SingleRoleView")
				{
					myValues = http_request.responseText;
					alert(myValues);					
				//	$('#Modal_ViewRoleDetails').modal();			
					
				}
				else if(KEY == "CheckFavoriteData")
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
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "Access Management";		
		var s2 = "<?php echo$PageName; ?>"; 
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
	}	
	function RefreshData()
	{
		Access_Management.submit();
	}
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title> Coexsys Time Accounting </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- font-awasome-->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- custom-css -->
    <link href="css/style.css" rel="stylesheet">
	
	
	
	
</head>

<body>
	
	
    <?php include("header.php"); ?>
	
	
	<!--View Role modals start -->
	<input type="hidden" id="h_field_username" name="h_field_username" value="">
	 <div class="modal fade bs-example-modal-lg custom-modal" id = "Modal_ViewRoleDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
		<div class="modal-dialog modal-lg cus-modal-lg" role="document" style = "min-width: 950px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title " id="myModalLabel"> Role Details </h4>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="row tab-edit">		
							<?php 							
								include("view-role-details.php");								
							?>
						</div>
					</div>
				</div>
				<div class="clear-both"></div>
			</div>
		</div>		
	</div>
    <!--View Role modals end -->	
	
	<section class="md-bg">
      <div class="container-fluid">
        <div class="row">
          <div class="brd-crmb">
            <ul>
              <li> <a href="#"> Users And Roles </a></li>
              <li> <a href="#"> Access Management </a></li>
            </ul>
          </div>
          <div class="dash-strip">
            <div class="fleft cr-user">
              <button type="button" class="btn btn-primary dash" onclick="window.location.href='index.php'"> Dashboard </button>
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
					<button type="button" id = "cmdFind" name = "cmdFind"  class="btn btn-primary btn-style2" data-toggle="modal" data-target="#FindPopup"> <i class="fa fa-search" aria-hidden="true"></i> Find </button>
					<button type="button" id = "cmdRefresh" name = "cmdRefresh"class="btn btn-primary btn-style2" onclick="RefreshData()" ><i class="fa fa-refresh" aria-hidden="true"></i>Refresh</button>
			</div>
          </div>
          
		  <div class="cont-box">
            <div class="pge-hd">
              <h2 class="sec-title"> <label id="Label_Title"> Access Management </label> </h2>
			  
            </div>
            <div>
              <div class="fleft two">
				<a href="downloaddata.php?r=access_management" class="btn-style btn" target="_blank">Export</a>
              </div>
              <div class="fright cr-user">
                <a href="access-management-roles.php">
                  <button type="button" class="btn btn-primary btn-style"> Manage Permissions </button>
				</a>
                <!-- data-toggle="modal" data-target=".bs-example-modal-lg" -->
					
              </div>
              <?php
					$msg = "";
					$selectUserQuery = "SELECT cxs_users.*,cxs_am_app_admin.USER_ID as expr_userid FROM cxs_users left JOIN cxs_am_app_admin ON cxs_am_app_admin.USER_ID = cxs_users.USER_ID WHERE 1=1 $s_Query  $SQueryOrderBy";						
					$selectQueryForPages  = $selectUserQuery;
					$selectUserQuery = $selectUserQuery." limit $start_from , $record_per_page";
					$RunUserQuery=mysql_query($selectUserQuery);
					$StdNumRows = mysql_num_rows($RunUserQuery);
					if($StdNumRows==0)
					{
						$msg = "No Record Found";
					}
				
				?>
				<span  class="text-center" style = "color:red";> <h4><?php echo $msg; ?></h4></span>
			  <form class="form" id="Access_Management" name="Access_Management" action="" method="POST">
				<div class="data-bx">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
						  <th width="20%"> 
							<?php if($Sorts == 'desc' && $FileName == 'USER_NAME') { ?>
								<span style="">
									User Name 
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('USER_NAME','asc');"></i>
								</span>
							<?php } else { ?>
								<span style="">
									User Name 
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('USER_NAME','desc');"></i>
								</span>
							<?php } ?>
                          </th>
						  
                                            
						  <th width="20%">
						    <?php if($Sorts == 'desc' && $FileName == 'START_DATE') { ?>
								<span style="">
									Start Date 
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('START_DATE','asc');"></i>
								</span>
							<?php } else { ?>
								<span style="">
									Start Date 
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('START_DATE','desc');"></i>
								</span>
							<?php } ?>
						  </th>
							
						  <th width="20%">
							<?php if($Sorts == 'desc' && $FileName == 'END_DATE') { ?>
								<span style="">
									End Date 
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('END_DATE','asc');"></i>
								</span>
							<?php } else { ?>
								<span style="">
									End Date 
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('END_DATE','desc');"></i>
								</span>
							<?php } ?>
						  </th>
										
						  <th >Application Administrator </th>
                          <th width="10%"> Actions </th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php
						$s_data = "";
						$s_data = "User Name,Start Date,End Date,Application Administrator \r\n";
						$selectUserQuery = "SELECT cxs_users.*,cxs_am_app_admin.USER_ID as expr_userid FROM cxs_users left JOIN cxs_am_app_admin ON cxs_am_app_admin.USER_ID = cxs_users.USER_ID WHERE 1=1 $s_Query  $SQueryOrderBy";
						//$selectUserQuery = "SELECT * from cxs_users order by USER_NAME";
						$selectQueryForPages  = $selectUserQuery;
						$selectUserQuery = $selectUserQuery." limit $start_from , $record_per_page";
						$RunUserQuery=mysql_query($selectUserQuery);
						$StdNumRows = mysql_num_rows($RunUserQuery);
						
						while($rows=mysql_fetch_array($RunUserQuery))
						{	
							$UserId = $rows['USER_ID'];	
							$UserName = $rows['USER_NAME'];							
							$Expr_UserID  = $rows['expr_userid'];
							$Flag_AppAdministrator="";
							if($Expr_UserID!="")
							{
								$Flag_AppAdministrator="Yes";
							}
							else
							{
								$Flag_AppAdministrator="No";
							}
							if((!is_null($rows['START_DATE'])) && (($rows['START_DATE'])!='0000-00-00') )
							{			
								$StartDate = date('m/d/Y', strtotime($rows['START_DATE']));
							}
							else
							{
								$StartDate ='';
							}
							if((!is_null($rows['END_DATE'])) && (($rows['END_DATE'])!='0000-00-00'))
							{			
								$EndDate = date('m/d/Y', strtotime($rows['END_DATE']));										
							}
							else
							{
								$EndDate ='';
							}
							$CreationDate 	= date('m/d/Y ', strtotime($rows['DATE_CREATED']));
							$CreatedBy		= $rows['CREATED_BY'];										
							$LastUpdate		= date('m/d/Y h:i:sa', strtotime($rows['LAST_UPDATE_DATE']));
							$UpdatedBy		= $rows['LAST_UPDATED_BY'];																																			
							$CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $CreatedBy");
							$UpdatedByName 	= getvalue("cxs_users","USER_NAME", "where USER_ID = $UpdatedBy");							
									 	
					?>
						<tr ondblclick="ViewRole('<?php echo $UserName; ?>')">
							<td> <?php echo $UserName; ?> </td>
							<td> <?php echo $StartDate; ?> </td>
							<td> <?php echo $EndDate; ?></td>
							<td> <?php echo $Flag_AppAdministrator;?> </td>
							<td>
							  <ul class="action-bx">
								<li class="dropdown">
								  <a href="#" class="dropdown-toggle action-drop" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-caret-down"></i></a>
								  <ul class="dropdown-menu ac-custom">
									<li title = 'Creation Date: <?php  echo $CreationDate; ?>&#013; Created By: <?php echo $CreatedByName; ?> &#013 Last Update Date : <?php  echo $LastUpdate; ?>&#013; Updated By: <?php echo $UpdatedByName; ?>'>
										<a href="javascript:ViewRole('<?php echo $UserName; ?>')"> <i class="fa fa-eye"></i> View Role Details</a>		
									</li>
								  </ul>
								</li>
							  </ul>
							</td>
						  </tr>
				<?php   
						$s_data .= "$UserName, $StartDate, $EndDate, $Flag_AppAdministrator \r\n";
						} 
						$_SESSION['Access_Management_Permissions'] = $s_data;
						//DisplayRecords("AAAA");
						?>
                      </tbody>
                    </table>
                  </div>
                </div>
				<input type="hidden" id="h_field_name" name="h_field_name" value="<?php echo $FileName; ?>">
				<input type="hidden" id="h_field_order" name="h_field_order" value="<?php echo $Sorts; ?>">
				<input type = "hidden" id="h_query" name="h_query" value=""/>
				<input type = "hidden" id="h_pagename" name="h_pagename" value="<?php echo $PageName; ?>"/>
              </form>
			  
			  <!-- pagination start-->
              <div class="pagination-bx">
                <div class="bs-example">
                  <ul class="pagination">
                    <?php 
							
						//$selectQueryForPages=$selectQueryForPages;															
						$RunDepQuery=mysql_query($selectQueryForPages);															
						$num_records = mysql_num_rows($RunDepQuery);
						$total_pages= ceil($num_records/$record_per_page);															
					
					if (($page-1)==0){ ?>                 
						<li class="disabled">
							<a rel="0" href="#"> «</a>
						</li> 
					<?php  } else{  ?>
						<li class="">
							<a rel="0" href="?page=<?php echo ($page-1); ?>&sort=<?php echo $Sorts; ?>">«</a>
						</li>
					<?php  } 
					
					for($i=1;$i<=$total_pages;$i++){ ?>
						<li class="<?php echo ($page==$i)?'active':''; ?>"><a class="<?php echo ($page==$i)?'current':''; ?>" style = "<?php if($page==$i){echo 'background-color: #337ab7';} ?>" href="?page=<?php echo $i;?>&sort=<?php echo $Sorts; ?>"><?php echo $i; ?></a></li>
					<?php } 
					if (($page+1)>$total_pages){   ?>  
						<li class="disabled"><a href="#">»</a></li>  
					<?php  }else{    ?>       
						<li class=""><a href="?page=<?php echo ($page+1); ?>&sort=<?php echo $Sorts; ?>">»</a></li>  
					<?php } ?>
					
                  </ul>
                </div>
              </div>
              <!-- pagination end -->
            </div>
          </div>
        </div>
      </div>
	
	  
<!--	<div class="modal fade bs-example-modal-lg custom-modal" id = "Modal_ViewRoleDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg cus-modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title " id="myModalLabel"> Role Details </h4>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="row tab-edit">		
							<?php 							
															
							?>
						</div>
					</div>
				</div>
			  <div class="clear-both"></div>
			</div>
		</div>		
	</div>-->
    </section>

    <footer>

    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>