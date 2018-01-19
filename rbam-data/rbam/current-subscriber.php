<?php ob_start ();
session_start();
include("conn.php");
check_login();
include ("find.php");

if(getRoleAccessStatusByUser('VIEW_SUBSCRIBERS',$_SESSION['user_id'])!='Y')
{
	   header('location:index.php');
}
$VIEW_SLA_permission = getRoleAccessStatusByUser('VIEW_SLA',$_SESSION['user_id']);
?>
<?php
     if(isset($_SESSION['subs_msg'])){ $subs_msg=$_SESSION['subs_msg'];	$_SESSION['subs_msg']=""; }else{ $subs_msg=""; }

	$LoginUserId = $_SESSION['user_id'];
	$PageName = "current-subscriber.php";
	
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
	
	$insArr = array();
	
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
	
	$insArr = array();
	if (isset($_POST['cmdSubscibe'] ))
	{
		$date1="";
		$date2="";
		$Text_UserName  = isset($_POST['Text_UserName'] )? $_POST['Text_UserName']: false;
		$DTPicker_StartDate = isset($_POST['DTPicker_StartDate'] )? $_POST['DTPicker_StartDate']: false;
		$DTPicker_EndDate= isset($_POST['DTPicker_EndDate'] )? $_POST['DTPicker_EndDate']: false;
		$Text_FirstName  = isset($_POST['Text_FirstName'] )? $_POST['Text_FirstName']: false;
		$Text_LastName  = isset($_POST['Text_LastName'] )? $_POST['Text_LastName']: false;
		
	//	$date1 = str_replace('/', '-', $DTPicker_StartDate);
		$date1=date("Y/m/d", strtotime($DTPicker_StartDate));
		
		if ($DTPicker_EndDate!='')
		{		
			$date2=date("Y/m/d", strtotime($DTPicker_EndDate));		
		}
		$LastInsertedUserId = "";
		if(isset($_POST['Check_CreateUser']) && $Text_UserName!='')
		{
			$insArr['USER_NAME']=strtoupper($Text_UserName);		
			$insArr['START_DATE']=$date1;
			$insArr['END_DATE']=$date2;
			$insArr['CREATION_DATE']= date('Y-m-d H:i:s') ;
			$insArr['CREATED_BY']=$LoginUserId;
			$insArr['LAST_UPDATED_BY']=$LoginUserId;		
			insertdata("cxs_users",$insArr);
			$LastInsertedUserId = mysql_insert_id();
		}
		
		unset ($insArr);
		$insArr['USER_ID']=$LastInsertedUserId;		
		$insArr['FIRST_NAME']=$Text_FirstName;
		$insArr['LAST_NAME']=$Text_LastName;
		$insArr['CREATION_DATE']= date('Y-m-d H:i:s') ;
		$insArr['CREATED_BY']=$LoginUserId;
		$insArr['LAST_UPDATED_BY']=$LoginUserId;		
		$insArr['START_DATE']=$date1;
		$insArr['END_DATE']=$date2;
		insertdata("cxs_subscribers",$insArr);
		
		$_SESSION['subs_msg']='<div class="alert alert-success"><i class="icon-ok"></i> Records inserted successfully.</div>';
		
		header("Location:current-subscriber.php");
	}
	
	if($IsUpdate =='Y' && $_POST['update_ids']!='') //when data post with the caption save
	{
	   $ids = explode(",",$_POST['update_ids']);
	   
	   foreach($ids as $id)
	   {
			 $StartDate = isset($_POST['Date_Start'.$id] )? $_POST['Date_Start'.$id]: false;
			 $EndDate = isset($_POST['Date_End'.$id] )? $_POST['Date_End'.$id]: false;
			 
			 $updArr['START_DATE'] = date("Y/m/d", strtotime($StartDate));
			 
			 $endDate="";
			 if($EndDate!='')
			 {
				    $updArr['END_DATE'] = date("Y/m/d", strtotime($EndDate));
			 }
			 updatedata("cxs_subscribers",$updArr," Where USER_ID = $id");
			 
	   }
	   
		for($i=1;$i<=$TotalRows;$i++)
		{
			$Check_Record = isset( $_POST['Check_Record'.$i] )? $_POST['Check_Record'.$i]: false;
			if($Check_Record==1)
			{
				$StartDate = isset($_POST['Date_Start'.$i] )? $_POST['Date_Start'.$i]: false;
				$EndDate = isset($_POST['Date_End'.$i] )? $_POST['Date_End'.$i]: false;				
				$Post_SubscriberId = isset($_REQUEST['h_subscriberId'.$i])?$_REQUEST['h_subscriberId'.$i]:0;
				//$Post_ResourceId = isset($_REQUEST['h_resourceId'.$i])?$_REQUEST['h_resourceId'.$i]:0;				
				
				$date1 = date("Y/m/d", strtotime($StartDate));				
				$insArr['START_DATE'] = $date1;
				$date1="";
				if($EndDate!='')
				{
					$date1 = date("Y/m/d", strtotime($EndDate));						
				}
				$insArr['END_DATE'] = $date1;
				$insArr['LAST_UPDATED_BY']=$LoginUserId;
				//$insArr['RESOURCE_ID'] = $Post_ResourceId;
				updatedata("cxs_subscribers",$insArr,"Where USER_ID = $Post_SubscriberId");
				
				unset($insArr);
				$date1 = date("Y/m/d", strtotime($StartDate));				
				$insArr['START_DATE'] = $date1;				
				$date1="";
				if($EndDate!='')
				{
					$date1 = date("Y/m/d", strtotime($EndDate));						
				}
				$insArr['END_DATE'] = $date1;
				$insArr['LAST_UPDATED_BY']=$LoginUserId;
				updatedata("cxs_users",$insArr,"Where USER_ID = $Post_SubscriberId");
			}
		}
	}
	$qry = "Select count(SUBSCRIBER_ID) as expr1 from cxs_subscribers";
	$result = mysql_query($qry);
	while($row = mysql_fetch_array($result))
	{
		$TotalSubscribers = $row['expr1'];
	}
?>
<script type="text/javascript">
	IsValidUserName = "";
	var GridCurrentRow;
	GridCurrentRow = 0;
	var IsGridDateValid;
	IsGridDateValid = "";
	function DataSort(str1,str2)
	{
		var str3;
		document.getElementById('h_field_name').value = str1;
		document.getElementById('h_field_order').value = str2;
		CurrentSubscriberList.submit();
	}
	function SearchData()
	{
		document.getElementById('h_field_name').value = '';
		document.getElementById('h_field_order').value = '';
		CurrentSubscriberList.submit();
	}
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "Current Subscriber";		 
		var s2 = "<?php echo $PageName; ?>";	 			
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
	}
	function CheckBackColor()
	{
		if (document.getElementById("Check_CreateUser").checked)
		{
			document.getElementById("Text_UserName").style.background = "#fff99c";			
			document.getElementById("Text_UserName").disabled = "";
		}
		else
		{
			document.getElementById("Text_UserName").disabled = "true";
			document.getElementById("Text_UserName").style.background = "#DCDCDC";					
		}
	}
	function DuplicateUserName()
	{
		var str = document.getElementById('Text_UserName').value;
		if (str!='')
		{
			KEY = "UserName";			
			makeRequest("ajax.php","REQUEST=UserCheck&UserName=" + str);
		}
	}
	function chkfld()
	{
		
		if (document.getElementById("Check_CreateUser").checked)
		{
			if (document.getElementById("Text_UserName").value == "")
			{
				alert("Please Fill User Name");
				document.getElementById("Text_UserName").focus();
				return false;
			}	
		}		
		if (IsValidUserName=="N")
		{
			return false;
		}
	
	}
	function UserNameValidation(e)
	{
	   keyEntry = (e.keyCode) ? e.keyCode : e.which;
	   //if (((keyEntry >= '65') && (keyEntry <= '90')) || ((keyEntry >= '97') && (keyEntry <= '122')) || (keyEntry == '46') || keyEntry == '8' || keyEntry == '9' || keyEntry == '32' || keyEntry == '37'|| keyEntry == '38')
	   if (keyEntry == '32' ) //do not allow space
		   return false;
	   else
		   return true;
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
	function EditRecord()
	{
		var i,j;
		var counter = document.getElementById("SubscriberDataTable").rows.length;
		var flag_updaterecord;
		//var OriginalContent;
		counter = counter-1; // heading not count
		document.getElementById("h_NumRows").value = counter;
		var ButtonCaption = document.getElementById("cmdUpdateSelected").innerHTML;


		if (ButtonCaption != "Save")
		{
			 $.each($(".record_chk:checked"), function(){
				    $("#"+$(this).val()+"_4").css("borderColor", "#000");
				    $("#"+$(this).val()+"_4").css("backgroundColor", "white");
				    
				    $("#"+$(this).val()+"_5").css("borderColor", "#000");
				    $("#"+$(this).val()+"_5").css("backgroundColor", "white");
				    
				    ShowDatePicker($(this).val());
				    flag_updaterecord = "Y";
			 });
			
			if (flag_updaterecord=="Y")
			{
				document.getElementById("cmdUpdateSelected").innerHTML = "Save";
				$("#cmdExport").attr('disabled',true);
				$("#cmdCancel").attr('disabled',false);
			}
			else
			{
				alert("Please Select Records For Update");
			}
		}
		else if (ButtonCaption == "Save")
		{
			 document.getElementById('h_field_update').value = 'Y';
			 var flag_final="";			
			 var EndDateValue="";
			
			 var updateable = [];
			
			 $.each($(".record_chk:checked"),function(){
				    form_element_correct($("#Date_Start"+$(this).val()));
				    
				    var start_date = $.trim($("#Date_Start"+$(this).val()).val());
				
				    if (start_date=='') {
						  form_element_correct($("#Date_Start"+$(this).val()));
						  form_element_empty_err($("#Date_Start"+$(this).val()));
						  flag_final = "N";
				    }
				    else
				    {
						  form_element_correct($("#Date_Start"+$(this).val()));
						  updateable.push($(this).val());
				    }
				    
			 });
			 
			 $("#update_ids").val(updateable.join(","));
			 
			/*for(i=1;i<=counter;i++)
			{
				if (document.getElementById("Check_Record"+i).checked )
				{
					EndDateValue = document.getElementById("Date_End"+i).value;						
					if(document.getElementById("Date_Start"+i).value == "")
					{
						alert("Pleae Select Start Date");
						document.getElementById("Date_Start"+i).focus();
						flag_final = "N";
						break;
					}
						
					if(EndDateValue != "")
					{
						GridCurrentRow=i;
						chk_validdate();						
						if (IsGridDateValid=="N")	
						{
							flag_final = "N";
							break;
						}
					}
				}				
			}*/
			if (flag_final=="") 
			{ 
				flag_final="Y";
			}
			if (flag_final=="Y")
			{	
				CurrentSubscriberList.submit();					
			}
		}
	}
	function ShowDatePicker(CurrentRow)
	{
		//document.getElementById(CurrentRow+"_5").value = "Save";
		document.getElementById("span"+CurrentRow+"_4").style.display = 'none';
		document.getElementById("span"+CurrentRow+"_5").style.display = 'none';
		document.getElementById("Date_Start"+CurrentRow).style.display = 'block';
		document.getElementById("Date_End"+CurrentRow).style.display = 'block';		
	}
	function HideDatePicker(CurrentRow)
	{
		//document.getElementById(CurrentRow+"_5").value = "Save";
		document.getElementById("span"+CurrentRow+"_4").style.display = 'block';
		document.getElementById("span"+CurrentRow+"_5").style.display = 'block';
		document.getElementById("Date_Start"+CurrentRow).style.display = 'none';
		document.getElementById("Date_End"+CurrentRow).style.display = 'none';		
	}
	function ExportRecord()
	{
		KEY= "ExportRecord";
		var qry="";
		var qry1="";
		var s1="";
		var counter = document.getElementById("SubscriberDataTable").rows.length;
		counter = counter-1; // heading not count
		var flag_checked="";
		/*for(i=1;i<=counter;i++)
		{
			if (document.getElementById("Check_Record"+i).checked )
			{
				flag_checked="Y";
				s1 = document.getElementById("h_subscriberId"+i).value;
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
			makeRequest("ajax.php","REQUEST=ExportCurrentSubscriber&qry="+qry+"&sortby="+qry1);
		}
		else
		{
			alert("Please Select Records For Export");
			document.getElementById("selectall").focus();
		}
	}
	function TableRowFunction(SubscriberId)
	{
		if (document.getElementById("cmdUpdateSelected").innerHTML!="Save")
		{	
			KEY= "SingleRecord";	
			$('#ModalSubscriberDetail').modal();		
			var str = SubscriberId;		
			makeRequest("ajax.php","REQUEST=SingleSubscriberRecord&SubscriberId=" + str);
		}
	}
	function ClearField()
	{
		$("#ModalSubscriberDetail").find('.modal-title').text('Add New Subscriber');
		$("#cmdSubscibe").show();
		document.getElementById("Text_FirstName").value = "";
		document.getElementById("Text_FirstName").disabled = false;
		
		document.getElementById("Text_LastName").value = "";
		document.getElementById("Text_LastName").disabled = false;		
		
		document.getElementById("DTPicker_StartDate").value = "";
		document.getElementById("DTPicker_StartDate").disabled = false;
		
		document.getElementById("DTPicker_EndDate").value = "";
		document.getElementById("DTPicker_EndDate").disabled = false;
		
		document.getElementById("Text_UserName").value = "";
		document.getElementById("Text_UserName").disabled ;		
		
		document.getElementById("Check_CreateUser").checked = false;
		document.getElementById("Check_CreateUser").disabled = false;
		document.getElementById("cmdSubscibe").disabled = false;
	}	
	function RefreshData()
	{
		CurrentSubscriberList.submit();
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
	
	<script src="js1/jquery.js"></script>
	<link href="datepicker/datepicker.css" rel="stylesheet">
	<script src="datepicker/bootstrap-datepicker.js"></script>
	
	<style type="text/css">
		.requirefieldcls
		{
			background-color: #fff99c;
		}
	</style>
</head>

<body>
    <!-- modals start -->
	<form method="post" action="" onsubmit = "return chkfld()">
		<div class="modal fade bs-example-modal-lg custom-modal" id = "ModalSubscriberDetail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg cus-modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"> Add New Subscribers </h4>
					</div>
					<div class="modal-body">
						<!-- field start-->
						<div class="col-sm-12">
							<div class="cus-form-cont">
								<div class="checkbox create-user-bx">
									<label> <input type="checkbox" id="Check_CreateUser" name="Check_CreateUser" value="1" class="mar-tp3" onchange="CheckBackColor()" > Create User </label>
								</div>
								<div class="col-sm-6 form-group">
									<label> First Name </label>
									<input type="text" id = "Text_FirstName" name = "Text_FirstName" class="form-control requirefieldcls" placeholder="" maxlength="40" required>
								</div>
								<div class="col-sm-6 form-group">
									<label> Last Name </label>
									<input type="text" class="form-control requirefieldcls" id = "Text_LastName" name = "Text_LastName" placeholder="" maxlength="40" required>
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
								<div class="col-sm-6 form-group">
									<label> Email</label>
									<input type="email" class="form-control" id="Text_UserName" name="Text_UserName" placeholder="" maxlength="25" onkeypress = 'return UserNameValidation(event);' oninput="this.value=this.value.toUpperCase()" onblur="DuplicateUserName()" style="background:#DCDCDC"; disabled>
								</div>
								<div class="col-sm-6">
									<div class="fix-txt2 "> Amount: $9.99 </div>
								</div>					
							</div>
						</div>
					</div>
					<!-- end -->
				</div>
				<div class="clear-both"></div>
				<div class="modal-footer cr-user">
					<div class="btn2"> <a <?php if($VIEW_SLA_permission=='Y'){ ?>href="test.pdf"<?php }else{ ?>disabled="disabled"<?php } ?> target="_blank"> View SLA </a></div>
					<button type="submit" id = "cmdSubscibe" name = "cmdSubscibe" class="btn btn-primary btn-style" > Subscribe </button>

				</div>


			</div>
		</div>
	</form>	
    <!-- modals end -->
    
	<?php include("header.php"); ?>
	
    <section class="md-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="brd-crmb">
                    <ul>
                        <li> <a href="#"> Subscriber Administration </a></li>
                        <li> <a href="#"> Current Subscribers  </a></li>
                    </ul>
                </div>
                <div class="dash-strip">
                    <div class="fleft cr-user">
                        <a href="index.php"> <button type="button" class="btn btn-primary dash"> Dashboard </button></a>
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

                <div class="cont-box ">
                    <!-- detail-head -->
                    <div class="app-detail-bx">
                        <ul>
                            <li> <span> Application : </span> 							
						<span>
						<select id = "combo_Application" name = "combo_Application" class="form-control" style = "height: 22px;padding: 1px 1px;font-size: 12px;">
						<?php
							$qry = "select * from sys_applications order by NAME";
							$result = mysql_query($qry);
																
							while($row = mysql_fetch_array($result)	)
							{
								$ApplicationName = $row['NAME'];
								$ApplicationId = $row['APPLICATION_ID'];
										?>
							<option value='<?php echo $ApplicationId?>'><?php echo $ApplicationName?></option>
						<?php 	}
									
						
						?>
							</select>
						</span>
					</li>
						
                            <li > <span> Current Subscribers Count : </span> <span id="span_TotalSubsciber" name="span_TotalSubscriber" > <?php echo $TotalSubscribers; ?> </span>  </li>
                        </ul>
                    </div>

                    <div class="pge-hd">
                        <h2 class="sec-title"> <label id="Label_Title"> Current Subscribers </label> </h2>
                    </div>
						
					<?php
						$TotalRecords1 = 0;
						$msg = "";
						$selectQuery = "select count(*) as expr1 from (Select cxs_subscribers.*,cxs_users.USER_NAME  from cxs_subscribers left join cxs_users on cxs_users.USER_ID = cxs_subscribers.USER_ID where 1=1  $s_Query limit $start_from , $record_per_page )as a";
						$result = mysql_query($selectQuery);							
						while ($row=mysql_fetch_array($result))
						{
							$TotalRecords1	= $row['expr1'];
							if($TotalRecords1==0)
							{
								$msg = "No Record Found";
							}
						}
					?>
						<!--<span  class="text-center" style = "color:red";> <h4><?php echo $msg; ?></h4></span>-->
				    <div class="row">
				    <h4 class="text-center" id="subs_msg_section"><?php echo $subs_msg; ?></h4>
				    </div>
                    <div>
					<form class="form" id="CurrentSubscriberList" name="CurrentSubscriberList" action="" method="POST">
                        <div class="fleft two">
                            <button type="button" id = "cmdUpdateSelected" name = "cmdUpdateSelected" class="btn-style btn" onclick= 'EditRecord();' > Update selected </button>
                            <button type="button" class="btn-style btn" id="cmdExport" onclick= 'ExportRecord();'> Export </button>
					   <button type="button" class="btn-style btn" id="cmdCancel" name="cmdCancel" disabled="disabled"> Cancel</button>
                        </div>

                        <div class="fright cr-user">
                            <button type="button" class="btn btn-primary btn-style" data-toggle="modal" data-target=".bs-example-modal-lg"  onclick="ClearField()"> Create New Subscriber </button>
                        </div>
						
                        <div class="data-bx">
                            <div class="table-responsive">
                                <table id='SubscriberDataTable' class="table table-bordered" >
                                    <thead>
                                        <tr>
                                        <th width="5%" class="check-bx"> <input type="checkbox" id="selectall"  onchange="checkAll(this)">  </th>
                                            
					<th width="20%">
						<?php if($Sorts == 'desc' && $FileName == 'FIRST_NAME') { ?>
							<span style="">
								Subscriber Name
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('FIRST_NAME','asc');"></i>
							</span>
						<?php } else { ?>
							<span style="">
								Subscriber Name
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('FIRST_NAME','desc');"></i>
							</span>
						<?php } ?>
					</th>
											
					<th width="18%">
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
									Start Date Active
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('START_DATE','asc');"></i>
								</span>
						<?php } else { ?>
								<span style="">
									Start Date Active
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('START_DATE','desc');"></i>
								</span>
						<?php } ?>
					</th>
											
					<th width="20%">
						<?php if($Sorts == 'desc' && $FileName == 'END_DATE') { ?>
								<span style="">
									End Date Active
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('END_DATE','asc');"></i>
								</span>
						<?php } else { ?>
								<span style="">
									End Date Active
									<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('END_DATE','desc');"></i>
								</span>
						<?php } ?>
					</th>
											                                         
                                        <th width="19%"> Monthly Biling </th>
                                        </tr>
                        </thead>
                        <tbody>
					<?php
						$selectQuery = "Select cxs_subscribers.*,cxs_users.USER_NAME  from cxs_subscribers left join cxs_users on cxs_users.USER_ID = cxs_subscribers.USER_ID where 1=1  $s_Query $SQueryOrderBy";
						$selectQueryForPages  = $selectQuery;
						$selectQuery = $selectQuery." limit $start_from , $record_per_page";
						$result = mysql_query($selectQuery);
						$i=1;
						while($row = mysql_fetch_array($result))
						{
							$SubscriberName = $row['FIRST_NAME']." ".$row['LAST_NAME'];
							$UserName = $row['USER_NAME'];
						//	$StartDate 		= $row['START_DATE'];										
							//	$EndDate 		= $row['END_DATE'];	
							$UserId  		= $row['USER_ID'];	
							$SubscriberId  	= $row['SUBSCRIBER_ID'];
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
									?>
			 <tr  id = "<?php $rowId = "row$SubscriberId"; echo $rowId; ?>" ondblclick="TableRowFunction('<?php echo $SubscriberId;?>')">
                        <th class="check-bx" id="<?php echo $SubscriberId."_1"; ?>">
						  <input type="checkbox" id="Check_Record<?php echo $SubscriberId; ?>" name="chkbox_SUBSCRIBER_ID"  onclick="checkAll1()" value="<?php echo $SubscriberId; ?>" class="record_chk"> 
						  <input type="hidden" id = "h_subscriberId<?php echo $SubscriberId; ?>" name="h_subscriberId<?php echo $SubscriberId; ?>" value = "<?php echo $SubscriberId; ?>">
				    </th>
                                            <td id="<?php echo $SubscriberId."_2"; ?>"> <?php echo $SubscriberName;?> </td>
                                            <td id="<?php echo $SubscriberId."_3"; ?>"> <?php echo $UserName;?> </td>
                                            <td id="<?php echo $SubscriberId."_4"; ?>"> 
						<span id = "<?php echo "span".$SubscriberId."_4"; ?>" style = "display:show"><?php echo $StartDate; ?></span>
						<input type="text" id="Date_Start<?php echo $SubscriberId; ?>" name="Date_Start<?php echo $SubscriberId; ?>" class="form-control small" value = "<?php echo $StartDate; ?>" style = "height : 24px;font-size:9pt;   display:none" >
						</td>
                                            <td id="<?php echo $SubscriberId."_5"; ?>"> 
						<span id = "<?php echo "span".$SubscriberId."_5"; ?>" style = "display:show"><?php echo $EndDate; ?></span>
						<input type="text" id="<?php echo "Date_End".$SubscriberId; ?>" name="<?php echo "Date_End".$SubscriberId; ?>"  class="form-control" value = "<?php echo $EndDate; ?>" style = "height : 24px; font-size:9pt;display:none" >
					</td>
                                            <td id="<?php echo $SubscriberId."_6"; ?>"> $ 0 </td>
                                        </tr>
						<?php 
						$i=$i+1;
					}										
						?>
										
					</tbody>
                                </table>
                            </div>
					<input type="hidden" id="h_field_name" name="h_field_name" value="<?php echo $FileName; ?>">
					<input type="hidden" id="h_field_order" name="h_field_order" value="<?php echo $Sorts; ?>">
					<input type="hidden" id="h_field_update" name="h_field_update" value="">
					<input type="hidden" id="h_NumRows" name="h_NumRows" value="0"/>		
					<input type = "hidden" id="h_query" name="h_query" value=""/>
					<input type = "hidden" id="h_pagename" name="h_pagename" value="<?php echo $PageName; ?>"/>
					<input type="hidden" id="update_ids" name="update_ids" value=""/>
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
            </div>
        </div>
    </section>
<script type="text/javascript">
$(document).ready(function(){
	   
	   $('.record_chk').change(function() {
			if(!$(this).is(":checked")) {
			 
				    $("#"+$(this).val()+"_4").css("borderColor", "");
				    $("#"+$(this).val()+"_4").css("backgroundColor", "");
				    
				    $("#"+$(this).val()+"_5").css("borderColor", "");
				    $("#"+$(this).val()+"_5").css("backgroundColor", "");
				    HideDatePicker($(this).val());
				
			}
			
			if ($('.record_chk:checked').length == 0){
				document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
				$("#cmdExport").attr('disabled',false);
				$("#cmdCancel").attr('disabled',true);				
				flag_checked="N";				
				
			}
	   });
	   
	   setTimeout(function(){
			 if ($("#subs_msg_section").html().length > 0) {
				    $("#subs_msg_section").empty();
			 }
	   }, 12000);
});
$('#DTPicker_StartDate').datepicker({
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
$("#cmdCancel").click(function(){
	   $.each($(".record_chk"), function(){
			 $(this).prop('checked' , false);
			 
			 $("#"+$(this).val()+"_4").css("borderColor", "");
			 $("#"+$(this).val()+"_4").css("backgroundColor", "");
				    
			 $("#"+$(this).val()+"_5").css("borderColor", "");
			 $("#"+$(this).val()+"_5").css("backgroundColor", "");
			 HideDatePicker($(this).val());
			
	   });
	   if ($('.record_chk:checked').length == 0){
			 $("#selectall").prop('checked' , false);
			 document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
			 $("#cmdExport").attr('disabled',false);
			 $("#cmdCancel").attr('disabled',true);
				
			 flag_checked="N";
	   }
});
var TotalRows = document.getElementById("SubscriberDataTable").rows.length;
TotalRows=TotalRows-1;
for (i=1;i<=TotalRows;i++)
{
	   $('#Date_Start'+i).datepicker({
			//font-size:10px;
			format:'mm/dd/yyyy',
			defaultDate: '',
			autoclose : true 
		});			
		
		$('#Date_End'+i).datepicker({
			//font-size:10px;
			format:'mm/dd/yyyy',
			defaultDate: '',
			autoclose : true 
		});					
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
	   } 
	   else if (window.ActiveXObject) { // IE
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
				else if(KEY == 'UserName')
				{
					var s1 = http_request.responseText;
					s1 = s1.trim();					
					if(s1.length>1)
					{					
						IsValidUserName="N";
						alert(s1);
						document.getElementById("Text_UserName").focus();
						return false;
					}	
					else
					{
						IsValidUserName="Y";
					}					
				}
				else if(KEY == "ExportRecord")
				{
					var str = http_request.responseText;						
					window.open('downloaddata.php?r=current-subscriber', '_blank');					
					//window.location.href = "downloaddata.php?r=user-administration","target='_blank'";					
				}
				else if(KEY == "SingleRecord")
				{
					var str = "";
					var str = http_request.responseText;
					str = str.trim();
					var n = 0;
					var s1 = "";
					var s2 = "";
					var i = 1;
					
					n = str.indexOf("|");	
					//alert(str);
					do
					{
						s1 = str.substring(0,n);
						s2 = str.substring(n+1);
						
						str = s2;
						n = str.indexOf("|");
						if(i==1)
						{
							document.getElementById("Text_FirstName").value = s1;							
						}
						else if(i==2)
						{
							document.getElementById("Text_LastName").value = s1;							
						}
						else if(i==3)
						{
							document.getElementById("DTPicker_StartDate").value = s1;							
						}
						else if(i==4)
						{
							document.getElementById("DTPicker_EndDate").value = s1;							
						}
						else if(i==5)
						{
							document.getElementById("Text_UserName").value = s1;
							document.getElementById("Check_CreateUser").checked = true;
						}
						i=i+1;
					}while(n>0);
					
					document.getElementById("Text_FirstName").disabled = true;	
					document.getElementById("Text_LastName").disabled = true;
					document.getElementById("DTPicker_StartDate").disabled = true;
					document.getElementById("DTPicker_EndDate").disabled = true;
					document.getElementById("Text_UserName").disabled = true;
					document.getElementById("cmdSubscibe").disabled = true;	
					document.getElementById("Check_CreateUser").disabled = true;
					
					$("#ModalSubscriberDetail").find('.modal-title').text('Current Subscriber');
					$("#cmdSubscibe").hide();
				}
			}
			else
			{
				document.getElementById(KEY).innerHTML = "";
				alert('There was a problem with the request.');
			}
		}
}
function chk_validdate()
{
		var StartDate,EndDate;		
		var GridStartDate,GridEndDate;
		
		if (document.getElementById("cmdUpdateSelected").innerHTML == "Save")
		{
			GridStartDate = document.getElementById("Date_Start"+GridCurrentRow).value;
			GridEndDate = document.getElementById("Date_End"+GridCurrentRow).value;			
		}
		else
		{
			StartDate = document.getElementById("DTPicker_StartDate").value;
			EndDate = document.getElementById("DTPicker_EndDate").value;
		}
		if (StartDate!='' && EndDate!='')// for pop up form
		{
			StartDate = new Date($('#DTPicker_StartDate').val());
			EndDate = new Date($('#DTPicker_EndDate').val());

			if (StartDate > EndDate)
			{
				alert("Start Date Must Be Greater Than End Date");
				document.getElementById("DTPicker_StartDate").focus();
				document.getElementById("cmdSubscibe").disabled = true;
			}
			else
			{
				document.getElementById("cmdSubscibe").disabled = false;
			}
		}
		else if (GridStartDate!='' && GridEndDate!='') // for grid dtpicker
		{
			//GridStartDate = document.getElementById("Date_Start"+GridCurrentRow).value;
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
</script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>