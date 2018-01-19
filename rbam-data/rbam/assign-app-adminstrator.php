<?php ob_start ();
session_start();
include("conn.php");
check_login();
	include 'searchusers.php';
	include ("find.php");	
?>
<?php

if(isset($_SESSION['aaa_msg'])){ $aaa_msg=$_SESSION['aaa_msg'];	$_SESSION['aaa_msg']=""; }else{ $aaa_msg=""; }

	$LoginUserId = $_SESSION['user_id'];;
	$PageName = "assign-app-adminstrator.php";
	
	$sort =  isset( $_GET['sort'] )? $_GET['sort']:'desc';
	$OrderBY = "";
	$FieldName = "";
	
	$OrderBY = "asc";
	$FieldName = "FIRST_NAME,LAST_NAME";
	$Sorts = "";
	
	$Sorts = isset( $_POST['h_field_order'] )? $_POST['h_field_order']: $sort;
	$FileName = isset( $_POST['h_field_name'] )? $_POST['h_field_name']: $FieldName;
	$IsUpdate = isset( $_POST['h_field_update'] )? $_POST['h_field_update']: "";
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
	
	
	$aaa_msg = "";
	
	$TotalRows = isset($_REQUEST['h_NumRows'])?$_REQUEST['h_NumRows']:0;
	if (isset($_GET["page"]))
	{
		$page  = $_GET["page"];
	}
	else
	{
		$page=1;
	}
	$start_from = ($page-1) *  $record_per_page;
	
	/*if($s_Query!="")
	{
		$qry = "select cxs_am_app_admin.*,cxs_resources.FIRST_NAME, cxs_resources.LAST_NAME,cxs_users.USER_NAME from cxs_am_app_admin inner join cxs_users on cxs_users.USER_ID = cxs_am_app_admin.USER_ID
				inner join cxs_resources on cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID where 1=1 $s_Query ORDER BY ROWNO ";				
				$result = mysql_query($qry);
				$TotalRecords1 = mysql_num_rows($result);
				if($TotalRecords1==0)
				{
					$msg = "No Record Found";
				}
	}*/
	if($IsUpdate =='Y' && $_POST['update_ids']!='') //when data post with the caption save 	//if (isset($_POST['cmdUpdateSelected'] ))
	{
		
		$ids = explode(",",$_POST['update_ids']);
		
		foreach($ids as $id)
		{
			$updArr = [];			 
			 
			$USER_ID = $_POST['h_userid'.$id];
			$LAST_UPDATED_BY = $LoginUserId;
			$LAST_UPDATE_DATE = date('Y-m-d H:i:s') ;
			$APPLICATION_ID = isset($_POST['Combo_Application'.$id] )? $_POST['Combo_Application'.$id]: false;
			$START_DATE_ACTIVE = date("Y-m-d",strtotime($_POST['Date_Start'.$id]));
			$END_DATE_ACTIVE = date("Y-m-d",strtotime($_POST['Date_End'.$id]));
			 
			$updArr['USER_ID']= trim($USER_ID);
			$updArr['LAST_UPDATED_BY']= trim($LAST_UPDATED_BY);
			$updArr['LAST_UPDATE_DATE']= trim($LAST_UPDATE_DATE);
			$updArr['APPLICATION_ID']= trim($APPLICATION_ID);
			$updArr['START_DATE_ACTIVE']= $START_DATE_ACTIVE;
			$updArr['END_DATE_ACTIVE']= $END_DATE_ACTIVE;
			 
			updatedata("cxs_am_app_admin",$updArr," Where APP_ADM_ID = $id");
			 
		}
		
				
				
	}

$ApplicationArray = array();
$i=1;
$qry = "select * from sys_applications order by NAME"	;
$result = mysql_query($qry);
while($row = mysql_fetch_array($result))
{
	$ApplicationName = $row['NAME'];
	$ApplicationId = $row['APPLICATION_ID'];											
	$ApplicationArray [$i]['Id'] =  $ApplicationId;
	$ApplicationArray [$i]['Name'] =  $ApplicationName;											
	$i=$i+1;
}
function get_sys_application_name($id)
{
	$qry = "select * from sys_applications where APPLICATION_ID='".$id."'";
	$result = mysql_query($qry);
	$row=mysql_fetch_array($result);
	
	return $row['NAME'];
}
function getResourceDetail($id,$field_name)
{
	/*$qry = "select * from cxs_resources where APPLICATION_ID='".$id."'";
	$result = mysql_query($qry);
	$row=mysql_fetch_array($result);
	
	return $row[$field_name];*/
	
}
if(isset($_POST['form_type']) && $_POST['form_type']=='Insert')
{
	
	 $USER_ID = $_POST['h_userid'];
	 $CREATED_BY = $LoginUserId;
	 $CREATION_DATE = date('Y-m-d H:i:s') ;
	 $APPLICATION_ID = $_POST['APPLICATION_ID'];
	 $START_DATE_ACTIVE = date("Y-m-d",strtotime($_POST['DTPicker_StartDate']));
	 $END_DATE_ACTIVE = date("Y-m-d",strtotime($_POST['DTPicker_EndDate']));
	 
	
	$insArr = [];
	
	$insArr['USER_ID']= trim($USER_ID);
	$insArr['CREATED_BY']= trim($CREATED_BY);
	$insArr['CREATION_DATE']= trim($CREATION_DATE);
	$insArr['APPLICATION_ID']= trim($APPLICATION_ID);
	$insArr['START_DATE_ACTIVE']= $START_DATE_ACTIVE;
	$insArr['END_DATE_ACTIVE']= $END_DATE_ACTIVE;
	
		
	
	insertdata("cxs_am_app_admin",$insArr);
	   
	$_SESSION['aaa_msg']='<div class="alert alert-success"><i class="icon-ok"></i> Records inserted successfully.</div>';
	   
	header('Location:assign-app-adminstrator.php');
}
?>

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
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<script src="js1/jquery.js"></script>
	<link href="datepicker/datepicker.css" rel="stylesheet">
	<script src="datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" ><?php //include 'searchusers.php'; ?></script>
	<style>
		.not-valid-tip{	color: #ff0000;position: absolute;	}
	</style>
</head>

<script type="text/javascript" >
	var IsGridDateValid;
	IsGridDateValid = "";
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "Assign App Administrator";		
		var s2 = "<?php echo $PageName; ?>";				
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
	}
	function SearchPopUp(search_by,RowNo)
	{	
		document.getElementById("h_currentRowNo").value = RowNo;		
		$('#SearchUsers').modal();
		
		$('#SearchUsers').find('.srchFld').css('display','none');
		
		$('#SearchUsers').find('#sec_'+search_by).css('display','block');
		
		$('#SearchUsers').find('#search_by_field_name').val(search_by);
	}
	function UpdateValueToTextBox()
	{
		var rowno = document.getElementById("h_currentRowNo").value;
		document.getElementById("Text_UserName"+rowno).value = document.getElementById("Text_UserName").value;		
		document.getElementById("Text_FirstName"+rowno).value = document.getElementById("Text_FirstName").value;		
		document.getElementById("Text_LastName"+rowno).value = document.getElementById("Text_LastName").value;		
	}
	function ExportRecord()
	{
		KEY= "ExportRecord";
		var qry="";
		var qry1="";
		var s1="";
		var s2="";
		var counter = document.getElementById("AssignAppAdmDataTable").rows.length;
		
		var flag_checked="";
		/*for(i=1;i<=counter;i++)
		{
			s2 = document.getElementById("Check_Record"+i).checked;
			if ( s2 == true )
			{
				flag_checked="Y";
				s1 = document.getElementById("h_userid"+i).value;
				s1 = s1.trim();
				qry += s1+"|";
			}
		}*/
		var exportable = [];
		$.each($(".record_chk:checked"), function(){
			exportable.push($(this).val());
			flag_checked="Y";
		});
		qry = exportable.join("|");
		qry1 = '<?php echo $SQueryOrderBy; ?>';
		
		if(flag_checked=="Y")
		{
			makeRequest("ajax.php","REQUEST=ExportAssignApplicationAdministrators&qry="+qry+"&sortby="+qry1);
		}
		else
		{
			alert("Please Select Records For Export");
			document.getElementById("selectall").focus();
		}
	}
function enableEditFields(id)
{
	$("#disp_APPLICATION_"+id).css("display", "none");
	$("#disp_USER_NAME_"+id).css("display", "none");
	$("#disp_FIRST_NAME_"+id).css("display", "none");
	$("#disp_LAST_NAME_"+id).css("display", "none");
	$("#disp_START_DATE_"+id).css("display", "none");
	$("#disp_END_DATE_"+id).css("display", "none");
				
	$("#APPLICATION_ID_"+id).css("display", "block");
	$("#Text_UserName"+id).css("display", "block");
	$("#Text_FirstName"+id).css("display", "block");
	$("#Text_LastName"+id).css("display", "block");
	$("#edit_START_DATE_"+id).css("display", "block");
	$("#edit_END_DATE_"+id).css("display", "block");
}
function disableEditFields(id)
{
	$("#disp_APPLICATION_"+id).css("display", "block");
	$("#disp_USER_NAME_"+id).css("display", "block");
	$("#disp_FIRST_NAME_"+id).css("display", "block");
	$("#disp_LAST_NAME_"+id).css("display", "block");
	$("#disp_START_DATE_"+id).css("display", "block");
	$("#disp_END_DATE_"+id).css("display", "block");
				
	$("#APPLICATION_ID_"+id).css("display", "none");
	$("#Text_UserName"+id).css("display", "none");
	$("#Text_FirstName"+id).css("display", "none");
	$("#Text_LastName"+id).css("display", "none");
	$("#edit_START_DATE_"+id).css("display", "none");
	$("#edit_END_DATE_"+id).css("display", "none");
}
	function EditRecord()
	{
		var counter = document.getElementById("AssignAppAdmDataTable").rows.length;
		document.getElementById("h_NumRows").value = counter;
		var ButtonCaption = document.getElementById("cmdUpdateSelected").innerHTML;
		var flag_updaterecord="";
		var flag_final="";
		
		if (ButtonCaption != "Save")
		{
			 $.each($(".record_chk:checked"), function(){
				
				enableEditFields($(this).val());
							    
				flag_updaterecord = "Y";
			 });
			
			if (flag_updaterecord=="Y")
			{
				document.getElementById("cmdUpdateSelected").innerHTML = "Save";
				$("#cmdExport").attr('disabled',true);
				$("#cmdCancel").attr('disabled',false);
				$("#btnAddNew").attr('disabled',true);				
			}
			else
			{
				alert("Please Select Records For Update");
			}
		}
		for(i=1;i<=counter;i++)
		{
			if (document.getElementById("Check_Record"+i).checked  )
			{
				flag_updaterecord="Y";
				break;
			}
		}
		
		if (flag_updaterecord=="")
		{
			alert("Please Tick Atleast Any Single Record For Update");
			//document.getElementById("Check_Record1")focus();
			return false;
		}
		
		if (ButtonCaption != "Save")
		{
			if (flag_updaterecord=="Y")
			{
				document.getElementById("cmdUpdateSelected").innerHTML = "Save";
			}
		}
		else if (ButtonCaption == "Save")
		{
			document.getElementById('h_field_update').value = 'Y';
			var flag_final="";			
			var EndDateValue="";
			
			var updateable = [];
			var valid=true;
			
			$.each($(".record_chk:checked"),function(){
				
				field_APP_ID = $("#APPLICATION_ID_"+$(this).val());
				field_UserName = $("#Text_UserName"+$(this).val());
				field_FirstName = $("#Text_FirstName"+$(this).val());
				field_LastName = $("#Text_LastName"+$(this).val());
				
				field_StartDate = $("#Date_Start"+$(this).val());
				field_EndDate = $("#Date_End"+$(this).val());
				
				
				if(field_APP_ID.val() == ''){
					form_element_correct(field_APP_ID);
					form_element_empty_err(field_APP_ID);
					valid = false;
				}
				else{
					form_element_correct(field_APP_ID);
				}
				
				if(field_UserName.val() == ''){
					form_element_correct(field_UserName);
					form_element_empty_err(field_UserName);
					valid = false;
				}
				else{
					form_element_correct(field_UserName);
				}
				
				if(field_FirstName.val() == ''){
					form_element_correct(field_FirstName);
					form_element_empty_err(field_FirstName);
					valid = false;
				}
				else{
					form_element_correct(field_FirstName);
				}
				
				if(field_LastName.val() == ''){
					form_element_correct(field_LastName);
					form_element_empty_err(field_LastName);
					valid = false;
				}
				else{
					form_element_correct(field_LastName);
				}
				
				if(field_StartDate.val() == ''){
					form_element_correct(field_StartDate);
					form_element_empty_err(field_StartDate);
					valid = false;
				}
				else{
					form_element_correct(field_StartDate);
				}
				
				if(field_EndDate.val() == ''){
					form_element_correct(field_EndDate);
					form_element_empty_err(field_EndDate);
					valid = false;
				}
				else if (field_StartDate.val() != '' && (Date.parse(field_StartDate.val()) >= Date.parse(field_EndDate.val()))) {
				   
					form_element_correct(field_EndDate);
					field_EndDate.addClass('error_ele');
					field_EndDate.after('<span role="alert" class="not-valid-tip">End date should be greater than Start date.</span>');
					valid = false;
				}
				else{
					form_element_correct($('#DTPicker_EndDate'));
				}
				
				if (valid==true) {
					var flag_final="Y";	
					updateable.push($(this).val());
				}
				
				    
			});
			
			$("#update_ids").val(updateable.join(","));
			
						
			if (flag_final=="") 
			{ 
				flag_final="Y";
			}
			if (flag_final=="Y")
			{	
				AssignAppAdmList.submit();
				
			}
		}
	}

	function chk_validdate(GridCurrentRow)
	{
		var GridStartDate,GridEndDate;
		
		GridStartDate = document.getElementById("Date_Start"+GridCurrentRow).value;
		GridEndDate = document.getElementById("Date_End"+GridCurrentRow).value;			
		if (GridStartDate!='' && GridEndDate!='') // for grid dtpicker
		{
			GridStartDate = new Date($('#Date_Start'+GridCurrentRow).val());
			GridEndDate = new Date($('#Date_End'+GridCurrentRow).val());			
			
			if (GridStartDate > GridEndDate)
			{
				alert("Start Date Must Be Greater Than End Date");
				document.getElementById("Date_End"+GridCurrentRow).focus();
				//document.getElementById("cmdUpdateSelected").disabled = true;				
				IsGridDateValid = "N";
			}
			else
			{
				//document.getElementById("cmdUpdateSelected").disabled = false;
				IsGridDateValid="Y";
			}
		}
	}
	/*$('.popover-dismiss').popover({
		trigger: 'focus'
	})*/
	function RefreshData()
	{
		Form1.submit();
	}


</script>
<body>
    
	<?php include("header.php"); ?>
    
	<section class="md-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="brd-crmb">
                    <ul>
                        <li> <a href="#"> Users And Roles </a></li>
                        <li> <a href="access-management.php"> Access Management </a></li>
                        <li> <a href="access-management-roles.php  "> Manage Permissions </a></li>
                        <li> <a href="#"> Assign Application Administrators</a></li>
                    </ul>
                </div>
                <div class="dash-strip">
                    <div class="fleft cr-user">
                        <a href="index.php"> <button type="button" class="btn btn-primary dash" autofocus> Dashboard </button></a>
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
					<!--	<button type="button" id = "cmdFind" name = "cmdFind"  class="btn btn-primary btn-style2" data-toggle="modal" data-target="#FindPopup"> <i class="fa fa-search" aria-hidden="true"></i> Find </button>
						<button type="button" id = "cmdRefresh" name = "cmdRefresh"class="btn btn-primary btn-style2" onclick="RefreshData()" ><i class="fa fa-refresh" aria-hidden="true"></i>Refresh</button>
					-->
                    </div>
                </div>
			<!--<form name="Form1" id="Form1" method="post">-->
				<div class="cont-box ">
					<div class="pge-hd">
						<h2 class="sec-title"> Assign Application Administrators </h2>
					</div>
					<!--<span  class="text-center" style = "color:red";> <h4><?php //echo $msg; ?></h4></span>-->
					<div class="row">
				    <h4 class="text-center" id="msg_section"><?php echo $aaa_msg; ?></h4>
				    </div>
					<div class="col-md-12">
						<div class="row">
							<div class="fleft two">
								<button type="button" class="btn-style btn" id="cmdUpdateSelected" name="cmdUpdateSelected"  onclick = "EditRecord();"> Update selected </button>
								<button type="button" id="cmdExport" name="cmdExport" class="btn-style btn" onclick= 'ExportRecord();'>Export</button>
								<button type="button" class="btn-style btn" id="cmdCancel" name="cmdCancel" disabled="disabled"> Cancel</button>
							</div>
							
							<div class="fright cr-user">
							<button type="button" id="btnAddNew" class="btn btn-primary btn-style" > Add New </button>
							<button type="button" id="btnSaveNew" class="btn btn-primary btn-style" style="display: none;"> Save </button>
							<!--data-toggle="modal" data-target=".bs-example-modal-lg"  onclick="ClearField()"-->
							</div>
						</div>
					
					<div id="newRecSec" class="row" style="display: none;">
						<form id="addNewForm" name="addNewForm" method="post" action="" onsubmit="validateAddForm();">
							<input type="hidden" id="form_type" name="form_type" value="Insert">
							<input type="hidden" id="h_userid" name="h_userid" value="">
							
							<div class="col-sm-12">
							<div class="cus-form-cont">
								<div class="col-sm-6 form-group">
									<label>Application</label>
									<select class="form-control" id = "APPLICATION_ID" name = "APPLICATION_ID">
										<option value=''> - Select Application- </option>
										<?php	
											$IsSelected = "";
											foreach($ApplicationArray as $row)	
											{
												$ApplicationName = $row['Name'];
												$ApplicationId = $row['Id'];
												if($ApplicationId1==$ApplicationId){
													$IsSelected = "selected";
												}
												else{
													$IsSelected = "";
												}
												echo "<option value='$ApplicationId' $IsSelected>$ApplicationName </option>";
											}													
										?>
									</select>
								</div>
								<div class="col-sm-6 form-group">
									<label> User Name</label>
									<input type="email" class="form-control" id="Text_UserName" name="Text_UserName" placeholder="" oninput="this.value=this.value.toUpperCase()" onfocus ="SearchPopUp('UserName','')">
								</div>
								<div class="col-sm-6 form-group">
									<label> First Name </label>
									<input type="text" id = "Text_FirstName" name = "Text_FirstName" class="form-control requirefieldcls" placeholder="" oninput="this.value=this.value.toUpperCase()" onfocus ="SearchPopUp('FirstName','')">
								</div>
								<div class="col-sm-6 form-group">
									<label> Last Name </label>
									<input type="text" class="form-control requirefieldcls" id = "Text_LastName" name = "Text_LastName" placeholder="" oninput="this.value=this.value.toUpperCase()" onfocus ="SearchPopUp('LastName','')">
								</div>
								<div class="col-sm-6 form-group cus-form-ico">
									<label> Start Date </label>
									<input type="text" class="form-control requirefieldcls" id = "DTPicker_StartDate"  name = "DTPicker_StartDate" placeholder="" maxlength="40" required onchange = "chk_validdate();">
									<span class="inp-icons"><i class="fa fa-calendar"></i></span>
								</div>
								<div class="col-sm-6 form-group cus-form-ico">
									<label> End Date </label>
									<input type="text" class="form-control" id = "DTPicker_EndDate" name = "DTPicker_EndDate" placeholder="" maxlength="40" onchange = "chk_validdate();">
									<span class="inp-icons"><i class="fa fa-calendar"></i></span>
								</div>
								
													
							</div>
						</div>
			</form>
			</div>

			<div class="data-bx">
				<form id="AssignAppAdmList" name="AssignAppAdmList" action="" method="POST">
				<input type="hidden" id="hdn_searchField" name="hdn_searchField">
				<div class="table-responsive">
					<table id='AssignAppAdmDataTable' class="table table-bordered mar-cont">
						<thead>
							<tr>
								<th width="5%" class="check-bx">
									<input type="checkbox" id="selectall"  onchange="checkAll(this)">
								</th>
								<th width="20%"> Application </th>
								<th width="14%"> User Name </th>
								<th width="14%"> First Name </th>
								<th width="14%"> Last Name </th>
								<th width="14%"> Start Date </th>
								<th width="14%"> End Date </th>
								<th width="5%"> </th>
							</tr>
						</thead>
						<tbody>
						<?php
							$selectQuery = "select cxs_am_app_admin.*,cxs_resources.FIRST_NAME, cxs_resources.LAST_NAME,cxs_users.USER_ID,cxs_users.USER_NAME from cxs_am_app_admin inner join cxs_users on cxs_users.USER_ID = cxs_am_app_admin.USER_ID
												inner join cxs_resources on cxs_resources.RESOURCE_ID = cxs_users.RESOURCE_ID where 1=1 $s_Query $SQueryOrderBy ";
							$selectQueryForPages  = $selectQuery;
							$selectQuery = $selectQuery." limit $start_from , $record_per_page";
							$result = mysql_query($selectQuery);
							//$result = mysql_query($qry);
							$TotalRecords = mysql_num_rows($result);
							while($row=mysql_fetch_array($result))
							{
								$DBRowNo = $row['ROWNO'];
								${UserId.$DBRowNo} 		= $row['USER_ID'];
								${UserName.$DBRowNo} 		= $row['USER_NAME'];
								${FirstName.$DBRowNo}		= $row['FIRST_NAME'];
								${LastName.$DBRowNo}		= $row['LAST_NAME'];
								${ApplicationId.$DBRowNo}	= $row['APPLICATION_ID'];													
								//${EndDateActive.$DBRowNo}	= $row['END_DATE_ACTIVE'];
								${CreatedBy.$DBRowNo}  		= $row['CREATED_BY'];													
								${UpdatedBy.$DBRowNo}  		= $row['LAST_UPDATED_BY'];
													
								if((!is_null($row['START_DATE_ACTIVE'])) && (($row['START_DATE_ACTIVE'])!='0000-00-00') )
								{
									${StartDateActive.$DBRowNo} = date('m/d/Y', strtotime($row['START_DATE_ACTIVE']));	
								}
								if((!is_null($row['END_DATE_ACTIVE'])) && (($row['END_DATE_ACTIVE'])!='0000-00-00') )
								{
									${EndDateActive.$DBRowNo} = date('m/d/Y', strtotime($row['END_DATE_ACTIVE']));	
								}
								if((!is_null($row['CREATION_DATE'])) && (($row['CREATION_DATE'])!='0000-00-00') )
								{
									${CreationDate.$DBRowNo} = date('m/d/Y', strtotime($row['CREATION_DATE']));	
								}													
								${LastUpdateDate.$DBRowNo} = date('m/d/Y  h:i:sa', strtotime($row['LAST_UPDATE_DATE']));														
						?>
					<tr>
						<th class="check-bx ">
							<input type="checkbox" id="Check_Record<?php echo $row['APP_ADM_ID']; ?>" name="chkbox_APP_ADM_ID" onclick="checkAll1()" value="<?php echo $row['APP_ADM_ID']; ?>" class="record_chk">
							<input type="hidden" id = "h_AppAssAdmID<?php echo $row['APP_ADM_ID']; ?>" name="h_AppAssAdmID<?php echo $row['APP_ADM_ID']; ?>" value = "<?php echo $row['APP_ADM_ID']; ?>">
						</th>
						<td>
							<div class="form-group">
								
								<span id="disp_APPLICATION_<?php echo $row['APP_ADM_ID']; ?>"><?php echo get_sys_application_name($row['APPLICATION_ID']); ?></span>
								<select class="form-control" id = "APPLICATION_ID_<?php echo $row['APP_ADM_ID']; ?>" name = "Combo_Application<?php echo $row['APP_ADM_ID']; ?>" style="display: none;">
								<option value=''> - Select Application- </option>
								<?php	
									$IsSelected = "";
															
									foreach($ApplicationArray as $row_apl)	
									{
										$ApplicationName = $row_apl['Name'];
										$ApplicationId = $row_apl['Id'];
										if($row['APPLICATION_ID']==$ApplicationId){
											$IsSelected = "selected";
										}
										else{
											$IsSelected = "";
										}
										echo "<option value='$ApplicationId' $IsSelected>$ApplicationName </option>";
									}														
								?>
								</select>
							</div>
						</td>
						<td>
							<div class="form-group">
								<span id="disp_USER_NAME_<?php echo $row['APP_ADM_ID']; ?>"><?php echo $row['USER_NAME']; ?></span>
								<input type="text" id = "Text_UserName<?php echo $row['APP_ADM_ID']; ?>" name = "Text_UserName<?php echo $row['APP_ADM_ID']; ?>" class="form-control" placeholder="" maxlength="25" readonly onfocus ="SearchPopUp('UserName','<?php echo $row['APP_ADM_ID']; ?>')" value = "<?php echo $row['USER_NAME']; ?>" style="display: none;">
								<input type="hidden" id = "h_userid<?php echo $row['APP_ADM_ID']; ?>" name ="h_userid<?php echo $row['APP_ADM_ID']; ?>" value = "<?php echo $row['USER_ID']; ?>">
							</div>
						</td>
						<td>
							<div class="form-group">
								<span id="disp_FIRST_NAME_<?php echo $row['APP_ADM_ID']; ?>"><?php echo $row['FIRST_NAME']; ?></span>
								<input type="text" id = "Text_FirstName<?php echo $row['APP_ADM_ID']; ?>" name = "Text_FirstName<?php echo $row['APP_ADM_ID']; ?>"class="form-control" placeholder="" maxlength="25" readonly onfocus ="SearchPopUp('FirstName','<?php echo $row['APP_ADM_ID']; ?>')" value = "<?php echo $row['FIRST_NAME']; ?>" style="display: none;">
							</div>
						</td>
						<td>
							<div class="form-group">
								<span id="disp_LAST_NAME_<?php echo $row['APP_ADM_ID']; ?>"><?php echo $row['LAST_NAME']; ?></span>
								<input type="text"  id = "Text_LastName<?php echo $row['APP_ADM_ID']; ?>" name = "Text_LastName<?php echo $row['APP_ADM_ID']; ?>" class="form-control" placeholder="" maxlength="25" readonly onfocus ="SearchPopUp('LAST_NAME','<?php echo $row['APP_ADM_ID']; ?>')" value = "<?php echo $row['LAST_NAME']; ?>" style="display: none;">
							</div>
						</td>
						<td>
							<span id="disp_START_DATE_<?php echo $row['APP_ADM_ID']; ?>"><?php echo date("m/d/Y",strtotime($row['START_DATE_ACTIVE'])); ?></span>
							<div class="form-group" style="display: none;" id="edit_START_DATE_<?php echo $row['APP_ADM_ID']; ?>">
								<input type="text"  id = "Date_Start<?php echo $row['APP_ADM_ID']; ?>" name = "Date_Start<?php echo $row['APP_ADM_ID']; ?>" class="form-control small" value = "<?php echo date("m/d/Y",strtotime($row['START_DATE_ACTIVE'])); ?>" style = "font-size:9pt;" >
								<span class="cal-ico-fix"><i class="fa fa-calendar"></i></span>
							</div>
						</td>

						<td>
							<span id="disp_END_DATE_<?php echo $row['APP_ADM_ID']; ?>"><?php echo date("m/d/Y",strtotime($row['END_DATE_ACTIVE'])); ?></span>
							<div class="form-group" style="display: none;" id="edit_END_DATE_<?php echo $row['APP_ADM_ID']; ?>">
								<input type="text"  id="Date_End<?php echo $row['APP_ADM_ID']; ?>" name="Date_End<?php echo $row['APP_ADM_ID']; ?>" class="form-control small" value = "<?php echo date("m/d/Y",strtotime($row['END_DATE_ACTIVE'])); ?>" style = "font-size:9pt;" >
								<span class="cal-ico-fix"><i class="fa fa-calendar"></i></span>
							</div>
						</td>

						<td width="5%"> 
							  <button type="button" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover"  data-html="true"  data-placement="left" data-content="
													Created By:  <?php $CreatedByName = ""; if ($row['CREATED_BY']!='') {$CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = ".$row['CREATED_BY']);} echo $CreatedByName; ?><br>
													Updated By:  <?php $UpdatedByName = ""; if ($row['LAST_UPDATED_BY']!='') {$UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = ".$row['LAST_UPDATED_BY']);}  echo $UpdatedByName; ?><br>
													Creation Date: <?php  echo date("m/d/Y",strtotime($row['CREATION_DATE'])); ?><br>
													Last Update Date: <?php  echo date("m/d/Y",strtotime($row['LAST_UPDATE_DATE'])); ?>"> 
													<i class=" fa fa-eye"></i> 
											  </button> 
						</td>
					</tr>
				<?php } ?>									
										
									</tbody> 
								</table>																	
							</div>
				<input type="hidden" id="h_currentRowNo" name="h_currentRowNo" value="">		
					<input type="hidden" id="h_field_update" name="h_field_update" value="">
					<input type="hidden" id="h_NumRows" name="h_NumRows" value="0"/>
					<input type = "hidden" id="h_query" name="h_query" value=""/>
					<input type = "hidden" id="h_pagename" name="h_pagename" value="<?php echo $PageName; ?>"/>
					<input type="hidden" id="update_ids" name="update_ids" value=""/>
					</form>
						</div>
						<div class="fright cr-user">
						<!--	<button type="submit"  id = "cmdAssignAdmin" name = "cmdAssignAdmin" class="btn btn-primary btn-style"> Assign </button> -->
							<!--<button type="submit" class="btn btn-primary btn-style" data-toggle="modal" data-target=".bs-example-modal-lg"> Assign </button>-->
						</div> 
					</div>
					
					<!-- pagination start-->
                        <div class="pagination-bx">
                            <div class="bs-example">
                                <ul class="pagination">
                                <?php
					$RunDepQuery=mysql_query($selectQueryForPages);
					$num_records = mysql_num_rows($RunDepQuery);
					$total_pages= ceil($num_records/$record_per_page);
									
					if (($page-1)==0){ ?>
										<li class="disabled">
											<a rel="0" href="#">&laquo;</a>
										</li>
							<?php  	} else { ?>
										<li class="">
											<a rel="0" href="?page=<?php echo ($page-1); ?>&sort=<?php echo $Sorts; ?>">&laquo;</a>
										</li>
							<?php 	}
									for($i=1;$i<=$total_pages;$i++){ ?>
										<li class="<?php echo ($page==$i)?'active':''; ?>"><a class="<?php echo ($page==$i)?'current':''; ?>" style = "<?php if($page==$i){echo 'background-color: #337ab7';} ?>" href="?page=<?php echo $i;?>&sort=<?php echo $Sorts; ?>"><?php echo $i; ?></a></li>
							<?php 	}
									if (($page+1)>$total_pages){   ?>
										<li class="disabled"><a href="#">&raquo;</a></li>
							<?php  	} else { ?>
										<li class=""><a href="?page=<?php echo ($page+1); ?>&sort=<?php echo $Sorts; ?>">&raquo;</a></li>
							<?php 	} ?>
      
								</ul>
                            </div>
                        </div>
                        <!-- pagination end -->
				</form>
            </div>
        </div>

    </section>
	<script type="text/javascript">
		
	//var TotalRows = document.getElementById("UserDataTable").rows.length;
	//	TotalRows=TotalRows-1;
		TotalRows = 1;
/*		for (i=1;i<=TotalRows;i++)
		{
			$('#Date_Start'+i).datepicker
			({
				//font-size:10px;
				format:'mm/dd/yyyy',
				defaultDate: '',
				autoclose : true 
			}
			);			
			
			/*$('#Date_End'+i).datepicker
			({
				//font-size:10px;
				format:'mm/dd/yyyy',
				defaultDate: '',
				autoclose : true 
			}/
			);					
		}	*/
		
		for(i=1;i<=8;i++)
		{
			$('#Date_Start'+i).datepicker(
			{
				//format:'DD,  MM d, yyyy',
				format:'mm/dd/yyyy',
				defaultDate: '',
				autoclose : true
			});
			$('#Date_End'+i).datepicker(
			{
				//format:'DD,  MM d, yyyy',
				format:'mm/dd/yyyy',
				defaultDate: '',
				autoclose : true
			});
		}
function checkAll(ele)
	{
		 var checkboxes = document.getElementsByTagName('input');
		 if (ele.checked) {
			 for (var i = 0; i < checkboxes.length; i++) {
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = true;
				 }
			 }
		 } else {
			 for (var i = 0; i < checkboxes.length; i++) {
				 console.log(i)
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = false;
				 }
			 }
			 $.each($(".record_chk"), function(){
				if(!$(this).is(":checked")) {
				    $("#"+$(this).val()+"_4").css("borderColor", "");
				    $("#"+$(this).val()+"_4").css("backgroundColor", "");
				    
				    $("#"+$(this).val()+"_5").css("borderColor", "");
				    $("#"+$(this).val()+"_5").css("backgroundColor", "");
				    HideDatePicker($(this).val());
				}
			 });
			 if ($('.record_chk:checked').length == 0){
				document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
				$("#cmdExport").attr('disabled',false);
				$("#cmdCancel").attr('disabled',true);
				
				flag_checked="N";
			}
		 }
	}
function checkAll1()
{
		var checkboxes = document.getElementsByTagName('input');
		for (var i = 0; i < checkboxes.length; i++)
		{
			if (checkboxes[i].type == 'checkbox')
			{
				if(checkboxes[i].checked == false)
				{
					document.getElementById("selectall").checked =false;
					break;
				}
			}
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
				else if(KEY == "ExportRecord")
				{
					var str = http_request.responseText;										
					window.open('downloaddata.php?r=assign-app-adminstrator', '_blank');					
					//window.location.href = "downloaddata.php?r=user-administration","target='_blank'";					
				}
			}
			else
			{
				document.getElementById(KEY).innerHTML = "";
				alert('There was a problem with the request.');
			}
		}
	}
$('#DTPicker_StartDate').datepicker(
{
	//format:'DD,  MM d, yyyy',
	format:'mm/dd/yyyy',
	defaultDate: '',
	autoclose : true
});
$('#DTPicker_EndDate').datepicker(
{
	//format:'DD,  MM d, yyyy',
	format:'mm/dd/yyyy',
	defaultDate: '',
	autoclose : true
});
$( "#btnAddNew" ).click(function() {
	$("#newRecSec").css("display", "block");
	$("#btnSaveNew").css("display", "block");
	$("#btnAddNew").css("display", "none");
	$("#cmdCancel").removeAttr("disabled");
});

$("#cmdCancel").click(function(){
	//alert('Ok');
	   $.each($(".record_chk"), function(){
			 $(this).prop('checked' , false);
			 
			 disableEditFields($(this).val());
			
	   });
	   if ($('.record_chk:checked').length == 0){
			 $("#selectall").prop('checked' , false);
			 document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
			 $("#cmdExport").attr('disabled',false);
			 $("#cmdCancel").attr('disabled',true);
			 $("#btnAddNew").attr('disabled',false);	
				
			 flag_checked="N";
	   }
	   
	   if ($('#newRecSec').css('display') == 'block') {
		$("#addNewForm").find("input[type=text],[type=email],select").val("");
		$('span.not-valid-tip').remove();
		$("#newRecSec").css("display", "none");
		$("#cmdCancel").attr('disabled','disabled');
		$("#btnSaveNew").css("display", "none");
		$("#btnAddNew").css("display", "block");
	}
});
$('.record_chk').change(function() {
	if(!$(this).is(":checked")) {
		disableEditFields($(this).val());
		$("#selectall").prop('checked' , false);
	}
			
	if ($('.record_chk:checked').length == 0){
		document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
		$("#cmdExport").attr('disabled',false);
		$("#cmdCancel").attr('disabled',true);
		$("#btnAddNew").attr('disabled',false);	
				
		flag_checked="N";
	}
});
$( "#btnSaveNew" ).click(function() {
	
	var valid=true;
	if(jQuery("#APPLICATION_ID").val() == ''){
          form_element_correct($('#APPLICATION_ID'));
		form_element_empty_err($('#APPLICATION_ID'));
		valid = false;
     }
     else{
		form_element_correct($('#APPLICATION_ID'));
	}
	
	if(jQuery("#Text_UserName").val() == ''){
          form_element_correct($('#Text_UserName'));
		form_element_empty_err($('#Text_UserName'));
		valid = false;
     }
     else{
		form_element_correct($('#Text_UserName'));
	}
	
	if(jQuery("#Text_FirstName").val() == ''){
          form_element_correct($('#Text_FirstName'));
		form_element_empty_err($('#Text_FirstName'));
		valid = false;
     }
     else{
		form_element_correct($('#Text_FirstName'));
	}
	
	if(jQuery("#Text_LastName").val() == ''){
          form_element_correct($('#Text_LastName'));
		form_element_empty_err($('#Text_LastName'));
		valid = false;
     }
     else{
		form_element_correct($('#Text_LastName'));
	}
	
	if(jQuery("#DTPicker_StartDate").val() == ''){
          form_element_correct($('#DTPicker_StartDate'));
		form_element_empty_err($('#DTPicker_StartDate'));
		valid = false;
     }
     else{
		form_element_correct($('#DTPicker_StartDate'));
	}
	
	if(jQuery("#DTPicker_EndDate").val() == ''){
          form_element_correct($('#DTPicker_EndDate'));
		form_element_empty_err($('#DTPicker_EndDate'));
		valid = false;
     }
	else if (jQuery("#DTPicker_StartDate").val() != '' && (Date.parse($('#DTPicker_StartDate').val()) >= Date.parse(jQuery("#DTPicker_EndDate").val()))) {
        
		form_element_correct($('#DTPicker_EndDate'));
		$('#DTPicker_EndDate').addClass('error_ele');
		$('#DTPicker_EndDate').after('<span role="alert" class="not-valid-tip">End date should be greater than Start date.</span>');
		valid = false;
	}
     else{
		form_element_correct($('#DTPicker_EndDate'));
	}
	
	if (valid==true) {
		document.getElementById("addNewForm").submit();
	}
	
});
function form_element_empty_err(element)
{
    element.addClass('error_ele');
    element.after('<span role="alert" class="not-valid-tip">The field is required.</span>');
}
function form_element_valid_err(element)
{
    element.addClass('error_ele');
    element.after('<span role="alert" class="not-valid-tip">The field is not valid.</span>');
}
function form_element_correct(element)
{
    element.removeClass('error_ele');
    element.next('span.not-valid-tip').remove();
    //element.nextAll().remove();
}
	</script>

	
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>