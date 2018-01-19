<?php ob_start();
session_start();
include("conn.php");
check_login();
?>
<?php 
	$LoginUserId = 1; 
	$PageName = "create-new-alias.php";
	
	
	$insArr = array();
	
	if (isset($_POST['cmdSaveRecord'] ))
	{
		$Text_AliasName = isset($_POST["Text_AliasName"] )? $_POST["Text_AliasName"]: false;
		$Text_Description = isset($_POST["Text_Description"] )? $_POST["Text_Description"]: false;
		$Combo_AliasType = isset($_POST["Combo_AliasType"] )? $_POST["Combo_AliasType"]: false;
		$Combo_AliasClass = isset($_POST["Combo_AliasClass"] )? $_POST["Combo_AliasClass"]: false;
	//	$Text_ProjectWBS = isset($_POST["Text_ProjectWBS"] )? $_POST["Text_ProjectWBS"]: false;
		$Check_CopyAllowed = isset($_POST['Check_CopyAllowed'] )? $_POST['Check_CopyAllowed']: false;
		$Check_AutoPopulate = isset($_POST['Check_AutoPopulate'] )? $_POST['Check_AutoPopulate']: false;
		$Check_Active = isset($_POST['Check_Active'] )? $_POST['Check_Active']: false;
		$Check_AddInUse = isset($_POST['Check_AddInUse'] )? $_POST['Check_AddInUse']: false;
		$WBSProjectId = isset($_POST['h_ProjectWBSId'] )? $_POST['h_ProjectWBSId']: false;
		$insArr['ALIAS_NAME'] = $Text_AliasName;
		$insArr['DESCRIPTION'] = $Text_Description;
		$insArr['ALIAS_TYPE'] = $Combo_AliasType;
		$insArr['ALIAS_CLASS'] = $Combo_AliasClass;
		$insArr['WBS_ID'] = $WBSProjectId;
		$insArr['COPY_ALLOWED'] = ($Check_CopyAllowed==1)?"Y":"N";
		$insArr['AUTOPOPULATE'] = ($Check_AutoPopulate==1)?"Y":"N";
		$insArr['ACTIVE_FLAG'] = ($Check_Active==1)?"Y":"N";
		$insArr['ADDINUSE_FLAG'] = ($Check_AddInUse==1)?"Y":"N";
		$insArr['LAST_UPDATED_BY'] 		= $LoginUserId;	
		if($HeaderId!='')
		{
			updatedata("cxs_aliases",$insArr,"Where cxs_aliases.ALIAS_ID = $HeaderId");		
		}	
		else
		{
			$insArr['CREATION_DATE']=date('Y-m-d H:i:s') ;
			$insArr['CREATED_BY']=$LoginUserId;
			
			insertdata("cxs_aliases",$insArr);	
			$HeaderId= mysql_insert_id();						
		/*	echo "<script>";
			echo "document.getElementById('h_field_headerid').value = $HeaderId";
			echo "</script>";
		
			echo "<script>";				
			echo "location.href='aliases.php'";
			echo "</script>";*/
			
		}
	}	
	
	
	
	
?>
<script type="text/javascript" >
	
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "Create New Alias";		
		var s2 = "<?php echo $PageName; ?>";				
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
	}		
	function SearchPopUp()
	{	
		document.getElementById("Text_FindProjectWBS").value = "";
		document.getElementById("TablePopupHeading").style.display = "none";
		document.getElementById("TablePopupList").innerHTML = "";
		document.getElementById("span_msg").innerHTML = "";
		$('#Text_FindProjectWBS').focus();
		$('#ModalFindProjectWBS').modal();			
	}
	function AliasNameValidation(e)
	{
	   keyEntry = (e.keyCode) ? e.keyCode : e.which;
	   //if (((keyEntry >= '65') && (keyEntry <= '90')) || ((keyEntry >= '97') && (keyEntry <= '122')) || (keyEntry == '46') || keyEntry == '8' || keyEntry == '9' || keyEntry == '32' || keyEntry == '37'|| keyEntry == '38')
	   if (keyEntry == '32' ) //do not allow space
		   return false;
	   else
		   return true;
	}
	function CheckDuplicate(name)
	{	
		if (name!='')
		{
			KEY = "CheckDuplicate";
			var regex = /\d+/g;
			var position = name.match(regex);
			
			var s1="";
			var str="";
			var TableName = "cxs_aliases";
			var FieldName = "ALIAS_NAME";
			var FieldValue = "";
			var FieldId = "";
			var SelectedId = "";
			
			if (position==null)
			{
				FieldValue = document.getElementById('Text_AliasName').value;	
			}
			else
			{
				RELATEDPOSITION = position; 
				FieldValue = document.getElementById('Text_AliasName'+position).value;
				SelectedId = document.getElementById('h_AliasId'+position).value;
			}					
			
			
			//makeRequest("ajax-checkduplicate.php","REQUEST=CheckDuplicate&aliasname=" + str+"&selectedid="+s1+"&tablename="+TableName+"&FieldName="+FieldName);
			makeRequest("ajax-checkduplicate.php","REQUEST=CheckDuplicate&TableName=" + TableName+"&FieldName="+FieldName+"&FieldValue="+FieldValue+"&FieldId="+FieldId+"&SelectedId="+SelectedId);
		}
	}
	function FindData()
	{
		var str = document.getElementById("Text_FindProjectWBS").value;		
		if (str=="")
		{
			document.getElementById("span_find").innerHTML = "<b>Do not leave blank.</b>";
			document.getElementById("Text_FindProjectWBS").focus();
		}
		else
		{
			document.getElementById("span_find").innerHTML = "";
			KEY = "FindData";			
			makeRequest("ajax1.php","REQUEST=FindDataWBS&Segment1=" +str+"&StartNumber=1&EndNumber=5");
		}
	
	}
	function SelectedWBSProject(s1)	
	{	
		if(s1!="")
		{
			document.getElementById("h_ProjectWBSId").value = s1;
			KEY = "SelectedWBS";
			makeRequest("ajax1.php","REQUEST=SelectedWBS&Id=" +s1);
		}
	}
	
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

<script src="datepicker/jquery.js"></script>
<link href="datepicker/datepicker.css" rel="stylesheet">
<script src="datepicker/bootstrap-datepicker.js"></script>

<style type="text/css">
	.requirefieldcls
	{
		background-color: #fff99c;
	}
	@media (min-width: 992px) 
	{
		.modal-lg
		{
			width: 1280px;
		}
	}
</style>

</head>

<body>
<?php include("header.php"); ?>

<!-- modals start -->

		<div class="modal fade bs-example-modal-lg custom-modal" id = "ModalFindProjectWBS" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">		
			<div class="modal-dialog modal-lg cus-modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title " id="myModalLabel"> Find Project WBS </h4>
					</div>
					<div class="modal-body"> 
			<!-- field start-->
						<div class="col-sm-12">
							<div class="cus-form-cont">
								
								<div class="col-sm-4 form-group">
								  <label>Project WBS</label>								  
								  <input type="text" id="Text_FindProjectWBS" name="Text_FindProjectWBS" class="form-control requirefieldcls" required  maxlength="100" onkeypress="Javascript: if (event.keyCode==13) FindData();" autofocus >
								  <span id = "span_find"></span>
								</div>
								
								<div class="col-sm-4 form-group">
									<br>
								  <button type="button" id="cmdFindPopup" name="cmdFindPopup" class="btn btn-primary btn-style " onclick="FindData()" >Find</button>
								</div>
								
								
								<div class="col-sm-12 form-group">
										<div id="span_msg" class="text-center" style = "font-weight:bold"> </div>
										<div class="data-bx">
											<div class="table-responsive">
												<table id='TablePopupHeading' class="table table-bordered " width="100%" >
													<thead>
													  <tr>
														<?php
															for($i=1;$i<=15;$i++)
															{
														?>	
															<th> Segment<?php echo $i; ?> </th>
														<?php	}
														?>
													  </tr>
													</thead>
													<tbody id = "TablePopupList">
																												
													</tbody>
												</table>
											</div>	
										</div>			
								</div>			
							</div>
						</div>
						<!-- end --> 
					  </div>
					<div class="clear-both"></div>
					<div class="modal-footer cr-user">
						
					</div>					
				</div>
			</div>
		</div>
	
	<!-- modals end -->

<section class="md-bg">
  <div class="container-fluid">
    <div class="row"> 
      <!-- brd crum-->
      <div class="brd-crmb">
        <ul>
          <li> <a href="#"> Set Up </a></li>
          <li> <a href="aliases.php"> Aliases </a></li>
          <li> <a href="#"> Create New Alias </a></li>
        </ul>
      </div>
      <!-- Dash board -->
      <div class="dash-strip">
        <div class="fleft cr-user">
          <button type="button" class="btn btn-primary dash" onclick="window.location.href='index.php'"> Dashboard </button>
        </div>
		<div class="fright">
			 <?php
				$qry = "select * from cxs_users_favorites where USER_ID = $LoginUserId and PAGE_NAME ='$PageName' AND MODULE_NAME = '$ModuleName'";
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
      <!-- inner work-->
	
		<div class="cont-box">
			<div class="pge-hd">
			  <h2 class="sec-title"  > <label id="Label_Title">Create New Alias</label> 				
				<label class = "fright" style = "font-size: 12px; margin-right : 40px; "> <input type="checkbox" id="Check_AddInUse" name="Check_AddInUse" value="1"  > In Use </label>
			  </h2>
			</div>
			<form class="form" id="Form1" name="Form1" action="" method="POST" onsubmit = "return chkfld_form1()">
				
				<div class="col-sm-12"> 
					<div class="cus-form-cont">
						<div class="col-sm-4 form-group">
						  <label> Alias Name </label>
						  <input id = "Text_AliasName" name = "Text_AliasName" type="text" class="form-control requirefieldcls"  maxlength="40" required oninput="this.value=this.value.toUpperCase()" onkeypress = 'return AliasNameValidation(event);' onblur = "CheckDuplicate(this.id)">
						  <span id = "Span_AliasName">&nbsp;</span>
						</div>
						<div class="col-sm-4 form-group">
						  <label> Description </label>
						  <input id = "Text_Description" name = "Text_Description" type="text" class="form-control requirefieldcls" placeholder="" maxlength="100" required>
						 <span>&nbsp;&nbsp;</span>
						
						</div>
						<div class="col-sm-4 form-group">
						  <label> Alias Type </label>
						  <select id = "Combo_AliasType" name = "Combo_AliasType" class="form-control requirefieldcls" required maxlength="20">
							<!--<option value="RES-Resource Specific Alias">RES-Resource Specific Alias</option>-->
							<option value="">- Assign Alias Type -</option>
							<option value="EHE-Excess Hours Earned">EHE-Excess Hours Earned</option>
							<option value="EHU-Excess Hours Used">EHU-Excess Hours Used</option>
							<option value="HEC-Holiday Earned Credit">HEC-Holiday Earned Credit</option>
							<option value="OTE-Over Time/Eve (Cash at time and one-half/Evening Shift)">OTE-Over Time/Eve (Cash at time and one-half/Evening Shift)</option>
							<option value="OTD-Over Time/Day (Cash compensation at time and one-half)">OTD-Over Time/Day (Cash compensation at time and one-half)</option>
							<option value="OTS -Over Time/Straight (Cash compensation at straight time)">OTS -Over Time/Straight (Cash compensation at straight time)</option>
							<option value="CTH-Time & Half (CTO compensation at time and one-half)">CTH-Time & Half (CTO compensation at time and one-half)</option>
							<option value="CTS-Straight Time (CTO compensation at straight rate)">CTS-Straight Time (CTO compensation at straight rate)</option>
							<option value="RTE-Regular Time Evening Shift">RTE-Regular Time Evening Shift</option>
							<option value="RTD-Regualr Time Day Shift">RTD-Regualr Time Day Shift</option>
							<option value="RTN-Regular Time Night Shift">RTN-Regular Time Night Shift</option>
							<option value="HOL-HolidayName">HOL-HolidayName</option>
							<option value="REC-HolidayRecess">REC-HolidayRecess</option>
							<option value="PTO-Personal Time Off">PTO-Personal Time Off</option>
							<option value="CTO-Compensatory Time Off">CTO-Compensatory Time Off</option>
							<option value="RTO-Required Time Off">RTO-Required Time Off</option>
							<option value="ILL-Sick Leave">ILL-Sick Leave</option>
							<option value="JDT-Jury Duty">JDT-Jury Duty</option>
							<option value="MTL-Maternal Leave">MTL-Maternal Leave</option>
							<option value="PTL-Paternal Leave">PTL-Paternal Leave</option>
							<option value="RES-Resource Specific Alias">RES-Resource Specific Alias</option>
							<option value="DES-Disabilty/Injury Leave">DES-Disabilty/Injury Leave</option>
							<option value="RDO-Regular Daily Schedule">RDO-Regular Daily Schedule</option>
							<option value="MIL- Military Leave">MIL- Military Leave</option>
							<option value="BRV-Beravement Leave">BRV-Beravement Leave</option>
							<option value="PDD-Professional Development Days">PDD-Professional Development Days</option>
							<option value="ITO-Informal Time Off">ITO-Informal Time Off</option>							
							
						  </select>
						  <span>&nbsp;&nbsp;</span>
						</div>
						<div class="col-sm-4 form-group">
						  <label> Alias Class </label>
						  <select id = "Combo_AliasClass" name = "Combo_AliasClass" class="form-control requirefieldcls" required maxlength="20">
							<option value="">- Assign Alias Class -</option>
							<option value="Leave">Leave</option>
							<option value="Shift">Shift</option>
							<option value="Overtime">Overtime</option>
							<option value="Policy">Policy</option>
							<option value="Seed">Seed</option>
						  </select>
						</div>
									
						<div class="col-sm-8 form-group">
						  <label> Project WBS </label>
						  <input type="text" id="Text_ProjectWBS" name="Text_ProjectWBS"value = "<?php echo $Text_ProjectWBS; ?>" class="form-control requirefieldcls" required placeholder="" maxlength="25" onfocus ="SearchPopUp()">
						</div>
						<div class="col-sm-5 form-group">
							<label> &nbsp;&nbsp;&nbsp;&nbsp; </label>
							<div class="checkbox">
								<label style = "padding-right:5px;"> <input type="checkbox" id="Check_CopyAllowed" name="Check_CopyAllowed" value="1"> Copy Allowed </label>
								<label style = "padding-right:5px;"> <input type="checkbox" id="Check_AutoPopulate" name="Check_AutoPopulate" value="1"> Auto Populate </label>
								<label style = "padding-right:5px;"> <input type="checkbox" id="Check_Active" name="Check_Active" value="1"> Active </label>								
							</div>
						</div>	
						
						
						<div class="col-sm-7 form-group text-right ">
							<button type="submit" id = "cmdSaveRecord" name = "cmdSaveRecord" class="btn btn-primary btn-style"> Save Record </button>
						</div>
					</div>
				</div>
				<input type="hidden" id="h_duplicate" name="h_duplicate" value=""/>
				<input type="hidden" id="h_ProjectWBSId" name="h_ProjectWBSId" value=""/>
			</form>			
		</div>			
    </div>
  </div>
</section>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/custom.js" type="text/javascript"></script>
<!--<script src="js/jquery.validate.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
-->
<script type="text/javascript">
	$(document).ready(function() 
{													
	$(function() 
	{
		//myFunction() ;				
	});											
});

function myFunction()
{
	//$("#TablePopupHeading").DataTable({"searching": false});
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
					//alert(str);
					window.open('downloaddata.php?r=holiday-calendars', '_blank');
				}
				else if(KEY == "ExportRecordCont")
				{
					var str = http_request.responseText;	
					
					//alert(str);
					window.open('downloaddata.php?r=new-resource-contacts', '_blank');					
					//window.location.href = "downloaddata.php?r=user-administration","target='_blank'";					
				}
				else if(KEY == 'CheckDuplicate')
				{
					
					var s1 = http_request.responseText;
					s1 = s1.trim();					
					if(s1.length > 1)
					{
						//alert(s1);
						document.getElementById("Span_AliasName").innerHTML = s1;
						document.getElementById("h_duplicate").value = "Y";	
						document.getElementById("Text_AliasName").focus();					
					}
					else
					{
					/*	if (RELATEDPOSITION!="")
						{
							document.getElementById("h_duplicate1").value = "";
						}
						else
						{
							document.getElementById("h_duplicate").value = "";
						}*/
						document.getElementById("Span_AliasName").innerHTML = "&nbsp;";
					}
				}
				else if(KEY == 'FindData')
				{
					var s = http_request.responseText;
					s = s.trim();	
					var n = s.indexOf("#");
					var s2 = s.substr(n);
					var s1 = s.substr(0,n);
					document.getElementById("TablePopupList").innerHTML = s1;	
					document.getElementById("TablePopupHeading").style.display = "block";					
					//document.getElementById("myqry").innerHTML = s2;			
					var TableTotalRows = document.getElementById("TablePopupList").rows.length;
					if (TableTotalRows==0)
					{
						document.getElementById("span_msg").innerHTML = "No Record Found.";
					}
					else
					{
						document.getElementById("span_msg").innerHTML = "";
					}
				}
				else if (KEY == 'SelectedWBS')
				{
					var s = http_request.responseText;
					s = s.trim();						
					document.getElementById("Text_ProjectWBS").value = s;					
					$("#ModalFindProjectWBS .close").click();					
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

</body>
</html>