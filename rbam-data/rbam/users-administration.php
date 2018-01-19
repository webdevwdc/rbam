<?php ob_start ();
session_start();
include("conn.php");
check_login();
include ("find.php");	
?>
<?php

	$LoginUserId = $_SESSION['user_id'];
	$PageName = "users-administration.php";
	$sort =  isset( $_GET['sort'] )? $_GET['sort']:'desc';
	$OrderBY = "";
	$FieldName = "";
	
	$OrderBY = "asc";
	$FieldName = "USER_NAME";
	$Sorts = "";
	$Sorts = isset( $_POST['h_field_order'] )? $_POST['h_field_order']: $sort;
	$FileName = isset( $_POST['h_field_name'] )? $_POST['h_field_name']: $FieldName;
	$s_Query = isset( $_POST['h_query'] )? $_POST['h_query']: "";	
	$IsUpdate = isset( $_POST['h_field_update'] )? $_POST['h_field_update']: "";
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
	//if (isset($_POST['cmdUpdateSelected'] ))
	if($IsUpdate =='Y' && $TotalRows >0) //when data post with the caption save
	{
		for($i=1;$i<=$TotalRows;$i++)
		{
			$Check_Record = isset( $_POST['Check_Record'.$i] )? $_POST['Check_Record'.$i]: false;
			if($Check_Record==1)
			{
				$StartDate = isset($_POST['Date_Start'.$i] )? $_POST['Date_Start'.$i]: false;
				$EndDate = isset($_POST['Date_End'.$i] )? $_POST['Date_End'.$i]: false;				
				$Post_UserId = isset($_REQUEST['h_userid'.$i])?$_REQUEST['h_userid'.$i]:0;
				$Post_ResourceId = isset($_REQUEST['h_resourceId'.$i])?$_REQUEST['h_resourceId'.$i]:0;				
				//$date1 = date("Y/m/d", strtotime($StartDate));
				$date1 = date("Y/m/d", strtotime($StartDate));					
				$insArr['START_DATE'] = $date1;
				
				$date1="";
				if($EndDate!='')
				{
					$date1 = date("Y/m/d", strtotime($EndDate));	
					//$date1 = str_replace('/', '-', $EndDate);
					//$date1=date("Y-m-d", strtotime($date1));
				}
				$insArr['END_DATE'] = $date1;
				$insArr['RESOURCE_ID'] = $Post_ResourceId;
				$insArr['LAST_UPDATED_BY']=$LoginUserId;
				updatedata("cxs_users",$insArr,"Where USER_ID = $Post_UserId");
			}
		}
	}
	if (isset($_POST['cmdCreateUser'] ))
	{
		//$LoginUserId = 1;
		$Text_UserName  = isset($_POST['Text_UserName'] )? $_POST['Text_UserName']: false;
		$Text_Password  = isset($_POST['Text_Password'] )? $_POST['Text_Password']: false;

		$Pass = GetPassword($_POST['Text_Password']);
		$Text_ResetPasswordDays  = isset($_POST['Text_ResetPasswordDays'] )? $_POST['Text_ResetPasswordDays']: false;
		$Combo_ResourceName  = isset($_POST['Combo_ResourceName'] )? $_POST['Combo_ResourceName']: false;
		$DTPicker_StartDate = isset($_POST['DTPicker_StartDate'] )? $_POST['DTPicker_StartDate']: false;
		$DTPicker_EndDate= isset($_POST['DTPicker_EndDate'] )? $_POST['DTPicker_EndDate']: false;
	//	$Combo_PasswordSecurityRules = isset($_POST['Combo_PasswordSecurityRules'] )? $_POST['Combo_PasswordSecurityRules']: false;
		$Combo_ApplicationRoles = isset($_POST['Combo_ApplicationRoles'] )? $_POST['Combo_ApplicationRoles']: false;
		$DTPicker_RoleStartDate = isset($_POST['DTPicker_RoleStartDate'] )? $_POST['DTPicker_RoleStartDate']: false;
		$DTPicker_RoleEndDate = isset($_POST['DTPicker_RoleEndDate'] )? $_POST['DTPicker_RoleEndDate']: false;
		$insArr = array();

		$insArr['USER_NAME']=strtoupper($Text_UserName);
		$insArr['ENC_KEY']=$Pass;
		$insArr['RESET_DAYS']=$Text_ResetPasswordDays;
		$insArr['RESOURCE_ID']=$Combo_ResourceName;		
		$date1 = date("Y/m/d", strtotime($DTPicker_StartDate));			
		$insArr['START_DATE']=$date1;

		$date2="";
		if ($DTPicker_EndDate!='')
		{
			$date2 = date("Y/m/d", strtotime($DTPicker_EndDate));			
		}
		$insArr['END_DATE']=$date2;
//		$insArr['PWD_RULE_CODE']=$Combo_PasswordSecurityRules;
		$insArr['CREATION_DATE']= date('Y-m-d H:i:s') ;
		$insArr['CREATED_BY']=$LoginUserId;
		$insArr['LAST_UPDATED_BY']=$LoginUserId;
		
		$insArr['ROLE_ID']=$Combo_ApplicationRoles;
		$date1 = date("Y/m/d", strtotime($DTPicker_RoleStartDate));	
	     $insArr['ROLE_START_DATE']=$date1;
		$date2="";
		$date2 = date("Y/m/d", strtotime($DTPicker_RoleEndDate));
		
		

		insertdata("cxs_users",$insArr);
		$LastInsertedUserId = mysql_insert_id();
		
		if($_FILES["PHOTO"]["name"] != "")
		{
			 if ($_FILES["PHOTO"]["error"] > 0)
			 {
				    $msg = "Return Code: " . $_FILES["PHOTO"]["error"] . "<br />";
			 }
			 else
			 {
				    if (!file_exists('img/uploads/user_images/'.$LastInsertedUserId)) {
						  mkdir('img/uploads/user_images/'.$LastInsertedUserId, 0777, true);
				    }
				    $photo_name = $_FILES["PHOTO"]["name"];
				    $ds = move_uploaded_file($_FILES["PHOTO"]["tmp_name"], "img/uploads/user_images/".$LastInsertedUserId."/".$photo_name) or die('error');
				    
				    $updArr['PHOTO'] = $photo_name;
				    
				    updatedata("cxs_users",$updArr," Where USER_ID = $LastInsertedUserId");
			 }
		}
		
		/**************** Code for sending email *****************/
		
		$from_name='Coexsys Time Accounting'; //Website Name
		$from_email='admin@testrbam.com'; //Admin Email
		$to=$Text_UserName;
		
		
		$subject = "Welcome to ".$from_name;

		$cc="";
	
		include "email/newUser.php"; //email design with content included
		
		$headers  = "MIME-Version: 1.0\r\n";
    		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	    	$headers .= "From: $from_name < $from_email >\r\n";
		
	     mail($to, $subject, $message, $headers);
		
		/*********************************************************/
		
		/*
		if($Combo_ApplicationRoles!='' && $DTPicker_RoleStartDate!='')
		{
		
			//if(($DTPicker_RoleStartDate!='') )
			//{
				unset ($insArr);
				$insArr['CREATION_DATE']=date('Y-m-d H:i:s') ;
				$insArr['CREATED_BY']=$LoginUserId;
				$insArr['LAST_UPDATED_BY']=$LoginUserId;
				$insArr['APPLICATION_ROLE_ID']=$Combo_ApplicationRoles;

				
				$date1 = date("Y/m/d", strtotime($DTPicker_RoleStartDate));	
				$insArr['ROLE_START_DATE']=$date1;
				
				$date2="";
				$date2 = date("Y/m/d", strtotime($DTPicker_RoleEndDate));	
				if ($date2<>"")
				{				
					$date2 = date("Y/m/d", strtotime($DTPicker_RoleEndDate));	
					$insArr['ROLE_END_DATE']=$date2;
				}
				$insArr['USER_ID']=$LastInsertedUserId;
				insertdata("cxs_application_assignments",$insArr);
			//}
		}*/
	}
	if (isset($_POST['cmdResetPassword'] ))
	{
	   
	     $user_id = $_POST['rsPsw_userId'];
		$user_name = getvalue("cxs_users","USER_NAME", "where USER_ID = $user_id");
		
		$Text_NewPassword  = isset($_POST['Text_NewPassword'] )? $_POST['Text_NewPassword']: false;
		unset ($insArr);
		$Pass = GetPassword($_POST['Text_NewPassword']);
		$insArr['ENC_KEY']=$Pass;
		$insArr['LAST_UPDATED_BY']=$LoginUserId;
		updatedata("cxs_users",$insArr, " where USER_ID = $user_id");
		
		
		/**************** Code for sending email *****************/
		
		$from_name='Coexsys Time Accounting'; //Website Name
		$from_email='admin@testrbam.com'; //Admin Email
		$to=$user_name;
		
		
		$subject = "Welcome to ".$from_name;

		$cc="";
	
		include "email/passwordChanged.php"; //email design with content included
		
		$headers  = "MIME-Version: 1.0\r\n";
    		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	    	$headers .= "From: $from_name < $from_email >\r\n";
		
	     mail($to, $subject, $message, $headers);
		
		/*********************************************************/

	}
	
	/***** Password rules *****/
	
	$password_rules = array();
	if(getSettingVal('ALLOW_NUMERIC')=='Y')
	{
	   array_push($password_rules,"At least one numeric value.");
	}
	if(getSettingVal('ALLOW_UPPERCASE')=='Y')
	{
	   array_push($password_rules,"At least one upper case character.");
	}
	if(getSettingVal('ALLOW_LOWERCASE')=='Y')
	{
	   array_push($password_rules,"At least one lower case character.");
	}
	if(getSettingVal('ALLOW_SPECIALS')=='Y')
	{
	   array_push($password_rules,"At least one special character.");
	}
	array_push($password_rules,"No Spaces Allowed.");
	array_push($password_rules,"Must not exceed 240 characters.");
	if(getSettingVal('ENABLE_COMMON')=='Y')
	{
	   array_push($password_rules,"Must not use commonly used words.");
	}
	array_push($password_rules,"Must not use any UniCode or Asian Characters.");

	
	
?>

<script type="text/javascript" >
$(document).ready(function() 
{													
	   $('.record_chk').change(function() {
			if(!$(this).is(":checked")) {
				    HideDatePicker($(this).val());
				    for(i=5;i<=7;i++)
				    {
						  document.getElementById($(this).val()+"_"+i).style.borderColor  = "";
						  document.getElementById($(this).val()+"_"+i).style.backgroundColor = "";
				    }
			}
			
			if ($('.record_chk:checked').length == 0){
				document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
				$("#cmdCancel").attr('disabled',true);
				$("#cmdExport").attr('disabled',false);
				//flag_checked="N";
				flag_updaterecord = "N";
			}
	   });
});

var GridCurrentRow;
GridCurrentRow = 0;
var IsGridDateValid;
IsGridDateValid = "";
function DataSort(str1,str2)
{
	var str3;
	document.getElementById('h_field_name').value = str1;
	document.getElementById('h_field_order').value = str2;
	AdministrationList.submit();
}
function SearchData()
{
	document.getElementById('h_field_name').value = '';
	document.getElementById('h_field_order').value = '';
	AdministrationList.submit();
}
function test()
{
	//alert("hi");
	//$('.case').attr('checked', this.checked);
	//$('.case').attr('checked', this.checked);
	document.getElementByName("case").checked = true;

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
function ResetPasswordDaysValidation(e)
{
		var charCode = (e.which) ? e.which : e.keyCode
		if (charCode > 31  && !(charCode== 46 || charCode== 35 || charCode== 36|| charCode== 37 || charCode== 39 || charCode== 45) && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
	function chkfld(CurrentForm)
	{
		var s1 ;
		var s2 ;
		var s3;
		var ReEnterPsw;
		if (CurrentForm =='CreateUser')
		{
			//alert('Ok');
			s1 = document.getElementById("Text_Password").value;
		//	s2 = document.getElementById("Combo_PasswordSecurityRules").value;
			s3 = document.getElementById("Text_UserName").value;
			/*if (s3.length>10)
			{
				alert("User Name Must Be Less Than Or Equal To 10 Characters");
				document.getElementById("Text_UserName").focus();
				return false;
			}*/
			
			if (!isEmail(s3)) {
				alert("Please enter valid Email Address");
				document.getElementById("Text_UserName").focus();
				return false;
			}
			var ss1,ss2;
			ss1 = document.getElementById("Combo_ApplicationRoles").value;
			ss2 = document.getElementById("DTPicker_RoleStartDate").value;
			if (ss1!=''&& ss2=='')
			{
				alert("Please Enter Application Role Start Date");
				document.getElementById("DTPicker_RoleStartDate").focus();
				return false;
			}
			else if (ss2!=''&& ss1=='')
			{
				alert("Please Enter Application Role");
				document.getElementById("Combo_ApplicationRoles").focus();
				return false;
			}
		}
		else if (CurrentForm =='ResetPsw')
		{
			s1 = document.getElementById("Text_NewPassword").value;
			s2 = document.getElementById("CurrentUserPswRule").innerHTML;
			ReEnterPsw = document.getElementById("Text_ReEnterPassword").value;
			if (s1!=ReEnterPsw)
			{
				alert("Password Not Match");
				return false;
			}

			document.getElementById("h_userid").value = document.getElementById("CurrentUserId").innerHTML;

		}
		var CheckPsw;
		if (s1.length<8)
		{
			alert("Passward must be atleast 8 characters long.");
			document.getElementById("Text_Password").focus();
			return false;
		}

		if (s2 == "Simple")
		{
			s3 = hasWhiteSpace(s1);
			if (s3==true)
			{
				alert("Space not allow in password.");
				document.getElementById("Text_Password").focus();
				return false;
			}

		}
		if (s2 == "Moderate")
		{
			CheckPsw = CheckPassword(s1);
			if (CheckPsw == false)
			{
				alert("Password Criteria Not Match");
				document.getElementById("Text_Password").focus();
				return false;
			}
		}
		if (s2 == "Complex")
		{
			CheckPsw = CheckPassword(s1);
			if (CheckPsw == false)
			{
				alert("Password Criteria Not Match");
				document.getElementById("Text_Password").focus();
				return false;
			}
			CheckPsw = CheckConsecutiveNumbers(s1);
			if (CheckPsw == false)
			{
				alert("Do Not Use Consecutive Numbers ");
				document.getElementById("Text_Password").focus();
				return false;
			}
		}
		return true;
	}

	function hasWhiteSpace(s)
	{
		return /\s/g.test(s);
	}

	function CheckPassword(inputtxt)   //To check a password between 8 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character
	{
	//	var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
		var decimal=  /^(?=.*\d)(?=.*[A-Z])(?=.*[^A-Z0-9])(?!.*\s).{8,240}$/;
		if(inputtxt.match(decimal))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function CheckConsecutiveNumbers(s)
	{
    // Check for sequential numerical characters
		for(var i in s)
		{
			if (+s[+i+1] == +s[i]+1 && +s[+i+2] == +s[i]+2)
			{
				return false;
			}
		}
    // Check for sequential alphabetical characters
    /*for(var i in s)
        if (String.fromCharCode(s.charCodeAt(i)+1) == s[+i+1] &&
            String.fromCharCode(s.charCodeAt(i)+2) == s[+i+2]) return false;*/
    return true;
	}

	function DuplicateUserName(name)
	{
		if (name!='')
		{
			KEY = "UserName";
			var str = document.getElementById('Text_UserName').value;
			makeRequest("ajax.php","REQUEST=UserCheck&UserName=" + str);
		}
	}
	
	function chk_validdate()
	{
	   
		var StartDate,EndDate;
		var RoleStartDate,RoleEndDate;
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

			RoleStartDate = document.getElementById("DTPicker_RoleStartDate").value;
			RoleEndDate = document.getElementById("DTPicker_RoleEndDate").value;
		}
		if (StartDate!='' && EndDate!='')// for pop up form
		{
			StartDate = new Date($('#DTPicker_StartDate').val());
			EndDate = new Date($('#DTPicker_EndDate').val());

			if (StartDate > EndDate)
			{
				alert("Start Date Must Be Greater Than End Date");
				document.getElementById("DTPicker_StartDate").focus();
				document.getElementById("cmdCreateUser").disabled = true;
			}
			else
			{
				document.getElementById("cmdCreateUser").disabled = false;
			}
		}
		if (EndDate=='')
		{
			document.getElementById("cmdCreateUser").disabled = false;
		}

		if (RoleStartDate!='' && RoleEndDate!='')// for pop up form
		{
			RoleStartDate = new Date($('#DTPicker_RoleStartDate').val());
			RoleEndDate = new Date($('#DTPicker_RoleEndDate').val());

			if (RoleStartDate > RoleEndDate)
			{
				alert("Start Date Must Be Greater Than End Date");
				document.getElementById("DTPicker_RoleStartDate").focus();
				document.getElementById("cmdCreateUser").disabled = true;
			}
			else
			{
				document.getElementById("cmdCreateUser").disabled = false;
			}
		}		
		if (GridStartDate!='' && GridEndDate!='') // for grid dtpicker
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
			 
			 /**********/
			 $('.record_chk').each(function () {
				    $(this).prop('checked' , false);
				    HideDatePicker($(this).val());
				    for(i=5;i<=7;i++)
				    {
						  document.getElementById($(this).val()+"_"+i).style.borderColor  = "";
						  document.getElementById($(this).val()+"_"+i).style.backgroundColor = "";
				    }
			 });
			 if ($('.record_chk:checked').length == 0){
				    document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
				    $("#cmdCancel").attr('disabled',true);
				    $("#cmdExport").attr('disabled',false);
				    $("#selectall").prop('checked' , false);
				    //flag_checked="N";
				    flag_updaterecord = "N";
			 }
			 /*********/
		 }
	}   
	function checkAll1()
	{
		//var checkboxes = document.getElementsByTagName('input');
		var checkboxes = $(".record_chk");
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
	function ExportRecord()
	{
	   
		KEY= "ExportRecord";
		var qry="";
		var qry1="";
		var s1="";
		var counter = document.getElementById("UserDataTable").rows.length;
		counter = counter-1; // heading not count
		var flag_checked="";
		for(i=1;i<=counter;i++)
		{
			if (document.getElementById("Check_Record"+i).checked )
			{
				flag_checked="Y";
				s1 = document.getElementById(i+"_0").innerHTML;
				s1 = s1.trim();
				qry += s1+"|";
			}
		}	
		qry1 = '<?php echo $SQueryOrderBy; ?>';					
		if(flag_checked=="Y")
		{
			makeRequest("ajax.php","REQUEST=ExportUsrAdministration&qry=" + qry+"&sortby="+qry1);
		}
		else
		{
			alert("Please Select Records For Export");
			document.getElementById("selectall").focus();
		}
	}	
	function EditRecord()
	{
	
		var i,j;
		var counter = document.getElementById("UserDataTable").rows.length;
		var flag_updaterecord;
		var OriginalContent;
		counter = counter-1; // heading not count
		document.getElementById("h_NumRows").value = counter;
		var ButtonCaption = document.getElementById("cmdUpdateSelected").innerHTML;


		if (ButtonCaption != "Save")
		{
			for(i=1;i<=counter;i++)
			{
				if (document.getElementById("Check_Record"+i).checked )
				{
					flag_updaterecord = "Y";							
					for(j=4;j<=7;j++)
					{
						if (j!=4)
						{
							//document.getElementById(i+"_"+j).contentEditable = "true";
							document.getElementById(i+"_"+j).style.borderColor  = "#000";
							document.getElementById(i+"_"+j).style.backgroundColor = "white";							
						}
						if(j==3)
						{
							/*document.getElementById(i+"_"+j).onclick = function () { 
							$('#EditModalResourceName').modal(); 							
							}*/
						}
					}				
					document.getElementById('row'+i).onmouseover = 	function(){ this.style.color = "black";	};
					ShowDatePicker(i);
				}
			}
			if (flag_updaterecord=="Y")
			{
				document.getElementById("cmdUpdateSelected").innerHTML = "Save";
				$("#cmdCancel").attr('disabled',false);
				$("#cmdExport").attr('disabled',true);
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
			var IsActiveUserActualValue="";
			var EndDateValue="";
			//var todayDate = new Date();			
			var todayDate = document.getElementById("h_todaysDate").value;
			var IsActiveUser = '';
			
			for(i=1;i<=counter;i++)
			{
				if (document.getElementById("Check_Record"+i).checked )
				{
					EndDateValue = document.getElementById("Date_End"+i).value;	
					IsActiveUserActualValue = document.getElementById("Combo_ActiveUser"+i).value;
					if(document.getElementById("Date_Start"+i).value == "")
					{
						alert("Pleae Select Start Date");
						document.getElementById("Date_Start"+i).focus();
						flag_final = "N";
						break;
					}
					
					todayDate = new Date($('#h_todaysDate').val());	
					if(EndDateValue	!='')
					{
						EndDateValue = new Date($('#Date_End'+i).val());			
						if (EndDateValue >= todayDate)
						{
							IsActiveUser = "Active" ;
						}
						else
						{
							IsActiveUser = "Inactive";
						}
					}
					else
					{
						IsActiveUser = "Active";
					}
					
					if (IsActiveUser != IsActiveUserActualValue)								
					{						
						alert("Please Check Date Period For Active User");
						document.getElementById("Date_End"+i).focus();
						flag_final ="N";
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
			}
			if (flag_final=="") 
			{ 
				flag_final="Y";
			}
			if (flag_final=="Y")
			{	
				AdministrationList.submit();					
			}
		}
	}
	function ShowDatePicker(CurrentRow)
	{
		//document.getElementById(CurrentRow+"_5").value = "Save";
		document.getElementById("span"+CurrentRow+"_5").style.display = 'none';
		document.getElementById("span"+CurrentRow+"_6").style.display = 'none';
		document.getElementById("Date_Start"+CurrentRow).style.display = 'block';
		document.getElementById("Date_End"+CurrentRow).style.display = 'block';
		document.getElementById("Combo_ActiveUser"+CurrentRow).style.display = 'block';
		document.getElementById("span"+CurrentRow+"_7").style.display = 'none';
	}
	function HideDatePicker(CurrentRow)
	{
		//document.getElementById(CurrentRow+"_5").value = "Save";
		document.getElementById("span"+CurrentRow+"_5").style.display = 'block';
		document.getElementById("span"+CurrentRow+"_6").style.display = 'block';
		document.getElementById("Date_Start"+CurrentRow).style.display = 'none';
		document.getElementById("Date_End"+CurrentRow).style.display = 'none';
		document.getElementById("Combo_ActiveUser"+CurrentRow).style.display = 'none';
		document.getElementById("span"+CurrentRow+"_7").style.display = 'block';
	}
	function TableRowFunction(UserId)
	{
		if (document.getElementById("cmdUpdateSelected").innerHTML!="Save")
		{	
			KEY= "SingleRecord";
			$("#ModalUserDetail").find('.modal-title').text('User Administration');	
			$("#cmdCreateUser").hide();
			
			$("#crtFrmPswRules").hide();
			$("#new_psw_err_tooltip").empty();
			
			$('#ModalUserDetail').modal();		
			var str = UserId;		
			makeRequest("ajax.php","REQUEST=SingleUserRecord&UserId=" + str);
		}
	}
	
	function ClearField()
	{
		//alert("hi");
		$("#ModalUserDetail").find('.modal-title').text('Create User');	
		$("#cmdCreateUser").show();
		$("#crtFrmPswRules").show();
		$("#new_psw_err_tooltip").empty();
		
		document.getElementById("Text_UserName").value = "";
		document.getElementById("Text_UserName").disabled = false;
		
		document.getElementById("Text_Password").value = "";
		document.getElementById("Text_Password").disabled = false;
		
		document.getElementById("Text_ResetPasswordDays").value = "30";
		document.getElementById("Text_ResetPasswordDays").disabled = false;
		
		document.getElementById("Combo_ResourceName").value = "";
		document.getElementById("Combo_ResourceName").disabled = false;
		
		document.getElementById("DTPicker_StartDate").value = "";
		document.getElementById("DTPicker_StartDate").disabled = false;
		
		document.getElementById("DTPicker_EndDate").value = "";
		document.getElementById("DTPicker_EndDate").disabled = false;
		
	//	document.getElementById("Combo_PasswordSecurityRules").value = "";
	//	document.getElementById("Combo_PasswordSecurityRules").disabled = false;
		
		document.getElementById("Combo_ApplicationRoles").value = "";
		document.getElementById("Combo_ApplicationRoles").disabled = false;
		
		document.getElementById("DTPicker_RoleStartDate").value = "";
		document.getElementById("DTPicker_RoleStartDate").disabled = false;
		
		document.getElementById("DTPicker_RoleEndDate").value = "";
		document.getElementById("DTPicker_RoleEndDate").disabled = false;
		
		//document.getElementById("cmdCreateUser").disabled = false;
	}
	function EditResourceForm(currentRow)
	{
		var ButtonCaption = document.getElementById("cmdUpdateSelected").innerHTML;
		var cellBgColor = document.getElementById(currentRow+"_3").style.backgroundColor;
		if (ButtonCaption == "Save" && cellBgColor == "white")
		{	
			$('#EditModalResourceName').modal();
			ResetResourceDiv();
			document.getElementById("span_userid").innerHTML = currentRow;
		}
	}
	function SearchResourceName()
	{
		KEY= "SearchResourceNameData";			
		var str = document.getElementById("Text_ResourceName").value;		
		makeRequest("ajax.php","REQUEST=SearchResourceNameData&ResourceName=" + str);
	}
	function SelectedResourceName(s1,s2)
	{
		document.getElementById("Text_ResourceName").value = s1;		
		document.getElementById("Text_ResourceId").value = s2;		
		document.getElementById("ListResourceResult").style.display = 'none';				
	}
	function ResetResourceDiv()
	{
		document.getElementById("ListResourceResult").style.display = 'block';
		document.getElementById("ListResourceResult").innerHTML = "";
		document.getElementById("Text_ResourceName").value = "";
		document.getElementById("Text_ResourceId").value = "";
	}
	function EditResourceName()
	{
		var s1 = document.getElementById("Text_ResourceName").value;		
		var s2 = document.getElementById("Text_ResourceId").value;	
		if (s2=="")
		{
			alert("Please Select Resouce Name From List");
			document.getElementById("Text_ResourceName").focus();			
		}
		else
		{
			var CurrentRow = document.getElementById("span_userid").innerHTML;		
			GridCurrentRow = CurrentRow;
			
			document.getElementById("span"+GridCurrentRow+"_3").innerHTML = s1;
			document.getElementById(GridCurrentRow+"_4").innerHTML = s2;					
			document.getElementById("h_resourceId"+GridCurrentRow).value = s2;					
			$("#EditModalResourceName .close").click()			
		}
	/*	KEY= "FindEditResourceId";			
		var str = document.getElementById("Text_ResourceName").value;		
		makeRequest("ajax.php","REQUEST=FindEditResourceId&ResourceName=" + str);*/
	}
	function CheckDate(currentRow)
	{
		var date1 = document.getElementById("Date_Start"+currentRow).value;
		var date2 = document.getElementById("Date_End"+currentRow).value;
		var IsActive = document.getElementById("Combo_ActiveUser"+currentRow).value;
		if (IsActive=="Inactive" && date2=='')
		{
			alert("Please Select End Date");
			document.getElementById("Date_End"+currentRow).focus();
		}
		
		if (date1!='' && date2!='') //
		{
			date1 = new Date($('#Date_Start'+currentRow).val());
			date2 = new Date($('#Date_End'+currentRow).val());			
			
			if (date1 > date2)
			{
				alert("Start Date Must Be Greater Than End Date");
				document.getElementById("Date_End"+currentRow).focus();				
			}			
		}
		
	}
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "User Administration";		
		var s2 = "users-administration.php";				
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
	}
	function RefreshData()
	{
		//$('#SearchUsers').modal();
		AdministrationList.submit();
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
					//document.getElementById("Check_RemoveAccess").checked = true;
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
</script>
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
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<script src="js1/jquery.js"></script>
	<link href="datepicker/datepicker.css" rel="stylesheet">
	<script src="datepicker/bootstrap-datepicker.js"></script>
	
	<script type="text/javascript" ><?php //include 'find.php'; ?></script>
<style type="text/css">
.requirefieldcls{ background-color: #fff99c;	}
.AttachOnMouseOverText{ color: black;	}
.myclass{ padding-top : 3px; padding-bottom : 3px; }
.datepicker { font-size: 9px; }
.not-valid-tip{ color: #ff0000; }
.bootstrap-datetimepicker-widget td.day { width: 200px;line-height: 10px;font-size: 10px; }
#new_psw_err_tooltip,#reset_psw_err_tooltip { position: absolute; z-index: 999; background: #ededed; }
#new_psw_err_tooltip span,#reset_psw_err_tooltip span{ display: block; padding: 12px 12px 0 12px; }
#new_psw_err_tooltip span:last-child,#reset_psw_err_tooltip span:last-child{ padding-bottom: 26px; }
#new_psw_err_tooltip br,#reset_psw_err_tooltip br{ height: 10px; }
</style>

</head>
<body>
    <!-- modals start -->
    <!--<form method="post" action="" onsubmit = "return chkfld(document.getElementById('Text_Password').value , document.getElementById('Combo_PasswordSecurityRules').value),''">-->
	<form method="post" action="" onsubmit = "return chkfld('CreateUser')" enctype="multipart/form-data">
		<div class="modal fade bs-example-modal-lg custom-modal createUserModal" id="ModalUserDetail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg cus-modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title " id="myModalLabel"> Create User</h4>
					</div>
					<div class="modal-body">
						<!-- field start-->
						<div class="col-sm-12">
							<div class="cus-form-cont">
								<div class="col-sm-6 form-group">
								<label> Email Address  (Your Email Address is your User Name) </label>
								<input type="text"  id="Text_UserName" name = "Text_UserName" required class="form-control requirefieldcls" placeholder=""  onkeypress = 'return UserNameValidation(event);' oninput="this.value=this.value.toUpperCase()" onblur = "DuplicateUserName(this.value)"> <!--onkeyup="this.value=this.value.toUpperCase()" oninput='UserNameValidation(this.value);' -->
								</div>
								<div class="col-sm-6 form-group">
									<label> Password </label>
									<input type="password" id="Text_Password" name="Text_Password" required class="form-control requirefieldcls" placeholder="" maxlength="240">
								     <span id="new_psw_err_tooltip" style="color: #ff0000"></span>
								</div>
								<div class="col-sm-6 form-group">
									<label> Reset Password Days </label>
									<input type="text" id="Text_ResetPasswordDays" name="Text_ResetPasswordDays" required class="form-control requirefieldcls" value = "30"  placeholder="" maxlength="3" onkeypress = 'return ResetPasswordDaysValidation(event);'>
								</div>
								<div class="col-sm-6 form-group">
									<label> Resource Name </label>
									<?php
										$qry = "select cxs_resources.*, concat( cxs_resources.FIRST_NAME,' ',cxs_resources.LAST_NAME) as RESOURCE_NAME from cxs_resources order by RESOURCE_NAME";
										$result = mysql_query($qry);
										echo '<select id = "Combo_ResourceName" name = "Combo_ResourceName" class="form-control " style="background-color: #fff99c;" required>';
										echo "<option value=''>- Assign Resource Name -</option>";
										while($row=mysql_fetch_array($result))
										{?>
											<option value='<?php echo$row['RESOURCE_ID'];?>'<?php echo ($row['RESOURCE_ID']==$Display_ResourceId)?' selected':'';?>><?php echo $row['RESOURCE_NAME'];?></option>;
									<?php
										}
									?>
									</select>
								</div>


								<div class="col-sm-6 form-group cus-form-ico">
									<label> Start Date </label>
									<input type="text" id="DTPicker_StartDate" name="DTPicker_StartDate" class="form-control requirefieldcls" placeholder="" maxlength="25" required onchange = chk_validdate();>
									<span class="inp-icons"><i class="fa fa-calendar"></i></span>
								</div>

								<div class="col-sm-6 form-group cus-form-ico">
									<label> End Date </label>
									<input type="text" id="DTPicker_EndDate" name="DTPicker_EndDate" class="form-control" placeholder="" maxlength="25" onchange = chk_validdate();>
									<span class="inp-icons"><i class="fa fa-calendar"></i></span>
								</div>
								<!--<div class="col-sm-6 form-group cus-form-ico">
									<label> Upload Photo </label>
									<input type="file" id="PHOTO" name="PHOTO">
								</div>-->
								

						<div class="col-sm-12">
							<div class="row">
								<div class="bdr-btn">
									<h2 class="f-hd"> Application Roles</h2>
									<span></span>
								</div>
								<div class="col-sm-4 form-group">
								<?php
									//$qry = "select * from cxs_application_roles order by ROLE_NAME";
									$qry = "select * from cxs_am_roles order by ROLE_NAME";
									
									$result = mysql_query($qry);
									echo '<select id = "Combo_ApplicationRoles" name = "Combo_ApplicationRoles" class="form-control "  >';
									echo "<option value=''>- Assign Application Role -</option>";
									while($row=mysql_fetch_array($result))
									{
								?>
										<option value='<?php echo$row['ROLE_ID'];?>'<?php echo ($row['ROLE_ID']==$Display_ApplicationRoleId)?' selected':'';?>><?php echo $row['ROLE_NAME'];?></option>
								<?php
									}
								?>
									</select>

								</div>
								<div class="col-sm-4 form-group cus-form-ico">
									<input type="text" id="DTPicker_RoleStartDate" name="DTPicker_RoleStartDate" class="form-control" onchange = chk_validdate() placeholder="Start Date">
									<span class="inp-icons"><i class="fa fa-calendar"></i></span>
								</div>
								<div class="col-sm-4 form-group cus-form-ico">
									<input type="text" id="DTPicker_RoleEndDate" name="DTPicker_RoleEndDate" class="form-control" onchange = chk_validdate() placeholder="End Date">
									<span class="inp-icons"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
					<!-- end -->
			</div>
			<div class="clear-both"></div>
			<div class="modal-footer cr-user">
				    <div class="col-sm-8" style="text-align: left;">
							<div id="crtFrmPswRules">
								New Password must have:
								<ol>
								<?php foreach($password_rules as $rl){ ?>
								<li><?php echo $rl; ?></li>
								<?php } ?>
								</ol>
						  </div>
						  </div>
			 <div class="col-sm-4">
				<button type="submit" id="cmdCreateUser" name="cmdCreateUser" class="btn btn-primary btn-style" disabled="disabled">Create User</button>
				</div>
			</div>
			</div>
		</div>
		</div>
    <!-- modals end -->
	</form>
    <!-- modals end -->


	<!--Password Reset modals start -->
	<form method="post" action="" onsubmit="return resetPasswordFormValidation()"><!--onsubmit = "return chkfld('ResetPsw')"-->
	   <input type="hidden" id="reset_psw_used_common_word" name="reset_psw_used_common_word" value="0">
		<div class="modal fade custom-modal" id = "ModalResetPassword" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg cus-modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title " id="myModalLabel"> Reset Password </h4>
					</div>
					<div class="modal-body">
						<!-- field start-->
						<div class="col-sm-12">
							<div class="cus-form-cont">

								<div class="col-sm-6 form-group">
									
									<label> New Password </label>
									<input type="password" id="Text_NewPassword" name="Text_NewPassword" class="form-control" placeholder="" maxlength="240">
								     <span id="reset_psw_err_tooltip" style="color: #ff0000"></span>
									<span id="CurrentUserId" style = " visibility: hidden;"></span>
									<span id="CurrentUserPswRule"  style = " visibility: hidden;"></span>
								</div>
								<div class="col-sm-6 form-group">
									<label> Re-enter Password </label>
									<input type="password" id="Text_ReEnterPassword" name="Text_ReEnterPassword" class="form-control" placeholder="" maxlength="25">
								</div>
							</div>
						</div>
						<!-- end -->
					</div>
					<div class="clear-both"></div>
					<div class="modal-footer cr-user">
						  <div class="col-sm-8" style="text-align: left;">
								
								New Password must have:
								<ol>
								<?php foreach($password_rules as $rl){ ?>
								<li><?php echo $rl; ?></li>
								<?php } ?>
								</ol>
						  </div>
						  <div class="col-sm-4">
						  <input type='hidden' name='h_userid' id="h_userid" >
						  <input type="hidden" id="rsPsw_userId" name="rsPsw_userId"/>
						  <button type="submit" id = "cmdResetPassword" name = "cmdResetPassword"  class="btn btn-primary btn-style" disabled="disabled"> Save </button>
						  </div>
					</div>
				</div>
			</div>
		</div>
	</form>
    <!--Password Reset modals end -->
	<!--EDIT modals start -->
	<form method="post" action="" >
		<div class="modal fade custom-modal" id = "EditModalResourceName" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg cus-modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title " id="myModalLabel"> Edit Resource Name </h4>
					</div>
					<div class="modal-body">
						<!-- field start-->
						<div class="col-sm-12">
							<div class="cus-form-cont">
								<div class="col-sm-6 form-group">
									<span id = "span_userid" style = "display:none"> </span>
									<label> Enter Resource Name </label>
									<input type="text" id ="Text_ResourceName" name ="Text_ResourceName" value = "" class="form-control" onkeyup="SearchResourceName()" placeholder="">
									<input type="text" id ="Text_ResourceId" name ="Text_ResourceId" value = "" class="form-control" placeholder="" style = "display:none">
									<div id="ListResourceResult"  class="list-item" style = "margin-top:15px;"></div>
								</div>
							</div>
						</div>
						<!-- end -->
					</div>
					<div class="clear-both"></div>
					<div class="modal-footer cr-user">
						<button type="button" id = "ResetResourceName" name = "ResetResourceName"  class="btn btn-primary btn-style" onclick = "EditResourceName()"> Edit Resouce </button>
					</div>
				</div>
			</div>
		</div>
	</form>
    <!--EDIT modals end -->
	
	<!--View Role modals start -->
    <div class="modal fade bs-example-modal-lg2 custom-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg cus-modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title " id="myModalLabel"> User Roles & Permissions </h4>
                </div>
                <div class="modal-body">
                    <!-- field start-->
                <!--    <div class="col-sm-12">
                        <div class="cus-form-cont">
                            <div class="col-sm-6 form-group">
                                <label> New Password </label>
                                <input type="password" class="form-control" placeholder="" maxlength="25">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label> Re-enter Password </label>
                                <input type="email" class="form-control" placeholder="" maxlength="25">
                            </div>
                        </div>
                    </div>
                    <!-- end -->
                </div>
                <div class="clear-both"></div>
                <div class="modal-footer cr-user">
                <!--    <button type="button" class="btn btn-primary btn-style"> Save </button> -->
                </div>
            </div>
        </div>
    </div>
	
    <!--View Role modals end -->
	<!--New View Role modals START - PR-->
	<div class="modal fade bs-example-modal-lg custom-modal" id="Modal_ViewRoleDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
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
	<!--New View Role modals END - PR-->

	<?php include("header.php"); ?>
	<section class="md-bg">
		<div class="container-fluid">
			<div class="row">
			  <div class="brd-crmb">
				<ul>
				  <li> <a href="#"> Users And Roles </a></li>
				  <li> <a href="#"> User Administration </a></li>
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
            <div class="cont-box">
				<div class="pge-hd">
                  <h2 class="sec-title"> <label id="Label_Title"> User Administration </label> </h2>
                </div>
				<?php
					$UpdateButtonStyle="onclick= 'EditRecord();' ";
					$ViewButtonStyle="onclick= 'ExportRecord();'";
					$Query ="Select * from cxs_am_user_admin where USER_ID = $LoginUserId";
					/*$RunQuery = mysql_query($Query);
					while($row=mysql_fetch_array($RunQuery))
					{
						$IsCreateUser	 = $row['CREATE_NEW_USER'];
						$IsViewOnly 	 = $row['VIEW_ONLY'];
						$IsUpdateOnly 	 = $row['UPDATE_ONLY'];
						
						if($IsUpdateOnly == "Y" && $IsViewOnly == "Y")
						{
							$UpdateButtonStyle="onclick= 'EditRecord();' ";
							$ViewButtonStyle="onclick= 'ExportRecord();'";
						}
						else if($IsCreateUser == "N" && $IsViewOnly == "N")
						{
							$UpdateButtonStyle="style='display:none;'";
							$ViewButtonStyle="style='display:none;'";
						}
						else if($IsViewOnly == "Y")
						{
							$ViewButtonStyle="onclick= 'ExportRecord();'";
						}
						else if($IsViewOnly == "N")
						{
							$ViewButtonStyle="disabled";
							$UpdateButtonStyle="disabled";
						}
						if($IsUpdateOnly == "N")
						{
							$UpdateButtonStyle="style='display:none;'";
						}
					}	*/			
					$msg = "";
					$s_Query = str_replace("\\","",$s_Query);
					$selectQuery = "select count(*) as expr1 from (SELECT  concat( cxs_resources.FIRST_NAME,' ',cxs_resources.LAST_NAME) as RESOURCE_NAME,cxs_users.* FROM cxs_users Left JOIN cxs_resources ON cxs_users.RESOURCE_ID = cxs_resources.RESOURCE_ID WHERE 1=1 $s_Query  ) as a";
					$RunUserQuery=mysql_query($selectQuery);
					while($row = mysql_fetch_array($RunUserQuery))
					{
						$TotalSearchRecords = $row['expr1'];
					}
					if ($TotalSearchRecords==0)
					{
						$msg = "No Record Found";
					}
				?>
                <div>
					<form class="form" id="AdministrationList" name="AdministrationList" action="" method="POST">
						<div class="row">
							<h4 class="text-center" style = "color:red;"> <?php echo $msg; ?> </h4>
						</div>
						<div class="fleft two">						
							<button type="button" class="btn-style btn" <?php if(getRoleAccessStatusByUser('VIEW_ONLY',$_SESSION['user_id'])!='Y' && getRoleAccessStatusByUser('UPDATE_ONLY',$_SESSION['user_id'])=='Y'){ ?>id="cmdUpdateSelected" name="cmdUpdateSelected"   <?php echo $UpdateButtonStyle; ?><?php }else{ ?>disabled="disabled"<?php } ?>> Update selected </button>
							<button type="button" class="btn-style btn" id="cmdExport" name="cmdExport"  <?php echo $ViewButtonStyle; ?> > Export </button>
							<button type="button" class="btn-style btn" id="cmdCancel" name="cmdCancel" disabled="disabled"> Cancel</button>
							<!--<a href="downloaddata.php?r=user-administration" target= "_blank" class="btn-style btn">Export</a>-->
						</div>
						<div class="fright cr-user">
						
						<?php
						
						
						
							//if($IsCreateUser == "Y")
							//{ ?>
								<button type="button" onclick="ClearField()" class="btn btn-primary btn-style" <?php if(getRoleAccessStatusByUser('CREATE_NEW_USER',$_SESSION['user_id'])=='Y' && getRoleAccessStatusByUser('VIEW_ONLY',$_SESSION['user_id'])!='Y' && getRoleAccessStatusByUser('UPDATE_ONLY',$_SESSION['user_id'])!='Y'){ ?> data-toggle="modal" data-target=".createUserModal" <?php }else{ ?> disabled<?php } ?> > Create User</button>
					<?php 	//}	?>	
						</div>
						<?php 
							//if($IsViewOnly == "Y")
							//{ ?>
		<div id = "dataView" name = "dataView">
			<div class="data-bx">
				<div class="table-responsive">
				<table id='UserDataTable' class="table table-bordered " width="100%" >
				<thead>
				<tr>
					<th style="display:none;"><span> User ID </span></th>
					<th width="5%" class="check-bx"> <input type="checkbox" id="selectall"  onchange="checkAll(this)"> </th>
					<th width="10%">
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

					<th width="15%">
						<?php if($Sorts == 'desc' && $FileName == 'RESOURCE_NAME') { ?>
							  <span style="">
								Resource Name 
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('RESOURCE_NAME','asc');"></i>
							  </span>
						<?php } else { ?>
							  <span style="">
								Resource Name 
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('RESOURCE_NAME','desc');"></i>
							  </span>
						<?php } ?>
					</th>

					<th width="12%"> Resource ID </th>

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

					<th width="12%"> Active User </th>
					<th width="4%"> Actions </th>
				  </tr>
			</thead>
			<tbody>
			<?php
				$s_data = "";
				$s_data = "User Name, Resource Name, Resource Id, Start Date Active, End Date Active, Active User  \r\n";
				$selectQuery = "SELECT  concat( cxs_resources.FIRST_NAME,' ',cxs_resources.LAST_NAME) as RESOURCE_NAME,cxs_users.* FROM cxs_users Left JOIN cxs_resources ON cxs_users.RESOURCE_ID = cxs_resources.RESOURCE_ID WHERE 1=1 $s_Query  $SQueryOrderBy";
				$selectQueryForPages  = $selectQuery;
				$selectQuery = $selectQuery." limit $start_from , $record_per_page";
				$RunUserQuery=mysql_query($selectQuery);
				$StdNumRows = mysql_num_rows($RunUserQuery);
				$i= 1;
				while($rows=mysql_fetch_array($RunUserQuery))
				{
					$UserId			= $rows['USER_ID'];
					$UserName 		= $rows['USER_NAME'];
					$ResourceId 	= $rows['RESOURCE_ID'];
					$CurrentDate = date('m/d/Y');
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
						$EndDate1 = strtotime($EndDate);
						$CurrentDate1 = strtotime($CurrentDate);
										
						if($EndDate1 >= $CurrentDate1)
						{
							$ActiveUser = "Active";
						}
						else
						{
							$ActiveUser = "Inactive";
						}
					}
					else
					{
						$EndDate ='';
						$ActiveUser = "Active";
					}
					//$EndDate 		= $rows['END_DATE'];
					$ResourceName	= $rows['RESOURCE_NAME'];
					$CreationDate = date('m/d/Y ', strtotime($rows['CREATION_DATE']));
					$CreatedBy		= $rows['CREATED_BY'];		
					$LastUpdate = date('m/d/Y h:i:sa', strtotime($rows['LAST_UPDATE_DATE']));
					$UpdatedBy		= $rows['LAST_UPDATED_BY'];
					$CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $CreatedBy");
					$UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $UpdatedBy");
					$PasswardSecurityRules = $rows['PWD_RULE_CODE'];
				?>
				  <tr id = "<?php $rowId = "row$i"; echo $rowId; ?>" ondblclick="TableRowFunction('<?php echo $UserId; ?>')" >
					<td style="display:none;" id="<?php echo $i."_0";?>">
						 <?php echo $UserId; ?>
					</td>
					<th id="<?php echo $i."_1"; ?>" class="check-bx"> 
						<input type="checkbox" id="<?php echo "Check_Record$i";?>" name="<?php echo "Check_Record$i";?>" onclick="checkAll1()" value = "<?php echo $i; ?>" class="record_chk">
						<input type="hidden" id = <?php echo "h_userid".$i; ?> name = <?php echo "h_userid".$i; ?> value = "<?php echo $UserId; ?>">
						<input type="hidden" id = <?php echo "h_resourceId".$i; ?> name = <?php echo "h_resourceId".$i; ?> value = "<?php echo $ResourceId; ?>">
					</th>
					<td id="<?php echo $i."_2";?>"  > <?php echo $UserName; ?></td>
					<td id="<?php echo $i."_3";?>" onclick="EditResourceForm(<?php echo $i; ?>);" >
						 <span id = "<?php echo "span".$i."_3"; ?>"><?php echo $ResourceName; ?></span>						</td>
					<td id="<?php echo $i."_4";?>"> <?php echo $ResourceId; ?></td>
					<td id="<?php echo $i."_5";?>" >
						<span id = "<?php echo "span".$i."_5"; ?>" style = "display:show">	<?php echo $StartDate; ?></span>									
						<input type="text" id="<?php echo "Date_Start".$i; ?>" name="<?php echo "Date_Start".$i; ?>" class="form-control small" value = "<?php echo $StartDate; ?>" style = "height : 24px;font-size:9pt;   display:none" >
					</td>
					<td id="<?php echo $i."_6";?>" >
						<span id = "<?php echo "span".$i."_6"; ?>" style = "display:show">	<?php echo $EndDate; ?></span>
						<input type="text" id="<?php echo "Date_End".$i; ?>" name="<?php echo "Date_End".$i; ?>"  class="form-control" value = "<?php echo $EndDate; ?>" style = "height : 24px; font-size:9pt;display:none" >
					</td>
						<td id="<?php echo $i."_7";?>" > <span id = "<?php echo "span".$i."_7"; ?>" style = "display:show">	<?php echo $ActiveUser; ?></span>
							<select id = "<?php echo "Combo_ActiveUser".$i; ?>" name="<?php echo "Combo_ActiveUser".$i; ?>"class="form-control"style = "height : 24px;padding-top: 1px;padding-bottom: 1px;display:none" onchange = "CheckDate(<?php echo $i; ?>);">
					<?php 
						if ($ActiveUser=="Active")
						{
							$IsSelected = "selected";
						}
						else
						{
							$IsSelected = "";
						}
					?>
					<option value='Active'<?php echo $IsSelected;?> >Active</option>
					<?php 
						if ($ActiveUser=="Inactive")
						{
							$IsSelected = "selected";
						}
						else
						{
							$IsSelected = "";
						}
					?>
					<option value='Inactive' <?php echo $IsSelected;?>>Inactive</option>
				</select>
				</td>
				<td id="<?php echo $i."_8";?>" >
					<ul class="action-bx">
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle action-drop" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-caret-down"></i></a>
						  <ul class="dropdown-menu ac-custom" id = "CurrentUserAction">
							<li data-toggle="modal" data-target="#ModalResetPassword"><a href="javascript:fun1(<?php echo $UserId; ?>,'<?php echo $PasswardSecurityRules;?>');"><i class="fa fa-key"></i> Reset Password </a></li>
							<li data-toggle="modal"  title = 'Creation Date: <?php  echo $CreationDate; ?>&#013; Created By: <?php echo $CreatedByName; ?> &#013 Last Update Date : <?php  echo $LastUpdate; ?>&#013; Updated By: <?php echo $UpdatedByName; ?>'><a href="javascript:ViewRole('<?php echo $UserName; ?>')"> <i class="fa fa-eye"></i> View Roles </a></li>
						  </ul>
						</li>
					</ul>
				</td>
			</tr>
			<?php
			$i=$i+1;
			//$s_data .= "$rows[USER_NAME], $rows[RESOURCE_NAME], $rows[RESOURCE_ID], $StartDate, $EndDate, $ActiveUser \r\n";
			}
			//$_SESSION['User_Administration_Export'] = $s_data;
			?>
			</tbody>
		</table>
		</div>
		</div>
						  
		<input type="hidden" id="h_field_name" name="h_field_name" value="<?php echo $FileName; ?>">
		<input type="hidden" id="h_field_order" name="h_field_order" value="<?php echo $Sorts; ?>">
		<input type="hidden" id="h_field_update" name="h_field_update" value="">
		<input type="hidden" id="h_NumRows" name="h_NumRows" value="0"/>			  
		<input type="hidden" id="h_todaysDate" name="h_todaysDate" value="<?php echo  date('m/d/Y'); ?>"/>
		<input type = "hidden" id="h_query" name="h_query" value=""/>
		<input type = "hidden" id="h_pagename" name="h_pagename" value="<?php echo $PageName; ?>"/>
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
							<!--<a rel="0" href="#"> «</a>-->
							<a rel="0" href="#">&laquo;</a>
						</li>
					  <?php  } else{  ?>
						<li class="">
							<a rel="0" href="?page=<?php echo ($page-1); ?>&sort=<?php echo $Sorts; ?>">&laquo;</a>
						</li>
					<?php }
					   for($i=1;$i<=$total_pages;$i++){ ?>
						<li class="<?php echo ($page==$i)?'active':''; ?>"><a class="<?php echo ($page==$i)?'current':''; ?>" style = "<?php if($page==$i){echo 'background-color: #337ab7';} ?>" href="?page=<?php echo $i;?>&sort=<?php echo $Sorts; ?>"><?php echo $i; ?></a></li>
					<?php }
					 if (($page+1)>$total_pages){   ?>
						<li class="disabled"><a href="#">&raquo;</a></li>
					<?php  }else{    ?>
					   <li class=""><a href="?page=<?php echo ($page+1); ?>&sort=<?php echo $Sorts; ?>">&raquo;</a></li>
					  <?php } ?>
					</ul>

					</div>
				</div>
			<!-- pagination end -->
			</div>
				<?php 
						//} ?>
				</form>
			</div>
		</div>
		</div>
	  </div>
	</section>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript">
$(document).ready(function(){													
	   
});
$('#Text_Password').keyup(function() {
	   checkPasswordError($(this).val(),$("#new_psw_err_tooltip"),$("#cmdCreateUser"));
});
$('#Text_NewPassword').keyup(function() {
	   checkPasswordError($(this).val(),$("#reset_psw_err_tooltip"),$("#cmdResetPassword"));
});
$('#Text_ReEnterPassword').keyup(function() {
	   form_element_correct($('#Text_ReEnterPassword'));
});
$('#Text_Password,#Text_NewPassword,#Text_ReEnterPassword').keypress(function(e) {
	 
	   if ((e.which >= 33 && e.which<=45) || (e.which >= 47 && e.which<=126) || e.which==8 || e.which==0) {
			 return true;
	   }
	   else{
			 return false;
	   }
	   
	   /*if(e.which === 32 || e.which === 46) //not accepts space and dot
	   {
			 return false;
	   }*/
});
$('#DTPicker_StartDate').datepicker({
	//format:'DD,  MM d, yyyy',
	   format: 'mm/dd/yyyy',
	   defaultDate: '',
	   autoclose : true
});
$('#DTPicker_EndDate').datepicker({
	   //format:'DD,  MM d, yyyy',
	   format: 'mm/dd/yyyy',
	   defaultDate: '',
	   autoclose : true
});
$('#DTPicker_RoleStartDate').datepicker(
{
	   //format:'DD,  MM d, yyyy',
	   format: 'mm/dd/yyyy',
	   defaultDate: '',
	   autoclose : true
});
$('#DTPicker_RoleEndDate').datepicker(
{
	format: 'mm/dd/yyyy',
	//format:'DD,  MM d, yyyy',
	defaultDate: '',
	autoclose : true
});
$("#cmdCancel").click(function(){
	   $('.record_chk').each(function () {
			 $(this).prop('checked' , false);
			 HideDatePicker($(this).val());
			 for(i=5;i<=7;i++)
			 {
				    document.getElementById($(this).val()+"_"+i).style.borderColor  = "";
				    document.getElementById($(this).val()+"_"+i).style.backgroundColor = "";
			 }
	   });
	   if ($('.record_chk:checked').length == 0){
				document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
				$("#cmdCancel").attr('disabled',true);
				$("#cmdExport").attr('disabled',false);
				$("#selectall").prop('checked' , false);
				//flag_checked="N";
				flag_updaterecord = "N";
	   }
});
function fun1(userid,rules)
{
	document.getElementById("CurrentUserId").innerHTML =userid;
	document.getElementById("CurrentUserPswRule").innerHTML =rules;
	$("#rsPsw_userId").val(userid);
}
	/*	$('#datepicker').datepicker(
		{
			//format: 'mm/dd/yyyy',
			format:'DD,  MM d, yyyy',
			defaultDate: '',
			autoclose : true
		});
		*/
		
var TotalRows = document.getElementById("UserDataTable").rows.length;
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
				else if (KEY == "SubjectData")
				{
						document.getElementById("SubjectData").innerHTML = http_request.responseText;
				}

				else if(KEY == 'UserName')
				{
					var s1 = http_request.responseText;
					s1 = s1.trim();
					if(s1.length > 1)
					{
						alert(s1);
						document.getElementById("Text_UserName").focus();
					}
				}
				else if (KEY == "SingleRecord")
				{
					var str = "";
					var n = 0;

					str = http_request.responseText;
					n = str.indexOf("|");					

					s1 = "";
					s2 = "";
					s3 = "";
					s4 = "";
					s5 = "";
					s6 = "";
					s7 = "";
					s8 = "";
					s9 = "";
					s10 = "";
					s11 = "";
					s12 = "";
					s13 = "";
					s14 = "";
					s15 = "";
					s16 = "";
					s17 = "";
					s18 = "";
					s19 = "";
					s20 = "";					
					
					s1 = str.substring(0,n);
					s2 = str.substring(n+1);
					document.getElementById("Text_UserName").value = s1;
					document.getElementById("Text_UserName").disabled = true;
										
					str = s2;
					n = str.indexOf("|");
					s3 = str.substring(0,n);
					s4 = str.substring(n+1);
					document.getElementById("Text_Password").value = s3;
					document.getElementById("Text_Password").disabled = true;
					
					str = s4;
					n = str.indexOf("|");
					s5 = str.substring(0,n);
					s6 = str.substring(n+1);
					document.getElementById("Text_ResetPasswordDays").value = s5;
					document.getElementById("Text_ResetPasswordDays").disabled = true;
					
					str = s6;
					n = str.indexOf("|");
					s7 = str.substring(0,n);
					s8 = str.substring(n+1);
					document.getElementById("Combo_ResourceName").value = s7;
					document.getElementById("Combo_ResourceName").disabled = true;
					//background-color: #eee;
					document.getElementById("Combo_ResourceName").style.backgroundColor="#eee";
					str = s8;
					n = str.indexOf("|");
					s9 = str.substring(0,n);
					s10 = str.substring(n+1);
					document.getElementById("DTPicker_StartDate").value = s9;
					document.getElementById("DTPicker_StartDate").disabled = true;
					
					str = s10;
					n = str.indexOf("|");
					s11 = str.substring(0,n);
					s12 = str.substring(n+1);
					document.getElementById("DTPicker_EndDate").value = s11;
					document.getElementById("DTPicker_EndDate").disabled = true;
					
				/*	str = s12;
					n = str.indexOf("|");
					s13 = str.substring(0,n);
					s14 = str.substring(n+1);
					document.getElementById("Combo_PasswordSecurityRules").value = s13;
					document.getElementById("Combo_PasswordSecurityRules").disabled = true;
				*/	
					str = s14;
					n = str.indexOf("|");
					s15 = str.substring(0,n);
					s16 = str.substring(n+1);
					document.getElementById("Combo_ApplicationRoles").value = s15;
					document.getElementById("Combo_ApplicationRoles").disabled = true;
					
					str = s16;
					n = str.indexOf("|");
					s17 = str.substring(0,n);
					s18 = str.substring(n+1);
					document.getElementById("DTPicker_RoleStartDate").value = s17;
					document.getElementById("DTPicker_RoleStartDate").disabled = true;
					
					str = s18;
					n = str.indexOf("|");
					s19 = str.substring(0,n);
					s20 = str.substring(n+1);
					document.getElementById("DTPicker_RoleEndDate").value = s19;
					document.getElementById("DTPicker_RoleEndDate").disabled = true;					
					document.getElementById("cmdCreateUser").disabled = true;
				}
				else if (KEY == "SearchResourceNameData")
				{
					var str = http_request.responseText;					
					document.getElementById("ListResourceResult").innerHTML = str;
					
					if (document.getElementById("Text_ResourceName").value ==""	)
					{
						ResetResourceDiv();
					}
				}
				else if (KEY == "FindEditResourceId")
				{
					var userid = http_request.responseText;	
					userid = userid.trim();
					alert(userid);
					var s1 = document.getElementById("Text_ResourceName").value;	
					document.getElementById("span"+GridCurrentRow+"_3").innerHTML = s1;
					document.getElementById(GridCurrentRow+"_4").innerHTML = userid;					
					document.getElementById("h_resourceId"+GridCurrentRow).value = userid;					
					$("#EditModalResourceName .close").click()					
				}
				else if(KEY == "ExportRecord")
				{
					var str = http_request.responseText;	
					window.open('downloaddata.php?r=user-administration', '_blank');					
					//window.location.href = "downloaddata.php?r=user-administration","target='_blank'";					
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
function resetPasswordFormValidation()
{
	   var valid_frm = 'Y';
	   
	   var minPswLength = <?php echo getSettingVal('MINIMUM_ALLOWED'); ?>;
	   
	   var oneCapLtr = new RegExp('(?=.*[A-Z])');
	   var oneLowrLtr = new RegExp('(?=.*[a-z])');
	   var oneDigit = new RegExp('(?=.*\d)');
	   var oneSplChar = /[!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]/;
	   
	   var new_Password = $("#Text_NewPassword");
	   var reentered_Password = $("#Text_ReEnterPassword");
	   
	   if ($.trim(new_Password.val())!='') {
			 comparePswdWithCommonWords($.trim(new_Password.val()),$("#reset_psw_used_common_word"));
	   }	   
	   
	   if ($.trim(new_Password.val())=='') {
			 form_element_correct(new_Password);
			 form_element_empty_err(new_Password);
			 valid_frm = 'N';
	   }
	   else if ($.trim(new_Password.val()).length<minPswLength) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The New Password should contain atleast '+minPswLength+' characters.</span>');
			 valid_frm = 'N';
	   }
	   <?php if(getSettingVal('ALLOW_SPECIALS')=='Y'){ ?>
	   else if (!oneSplChar.test($.trim(new_Password.val()))) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The new password must have at least one special character: \':;/?.>,<`~@#$%^&*()_+=-][{}\|"</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_UPPERCASE')=='Y'){ ?>
	   else if (!oneCapLtr.test($.trim(new_Password.val()))) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The new password must have at least one uppercase character.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_LOWERCASE')=='Y'){ ?>
	   else if (!oneLowrLtr.test($.trim(new_Password.val()))) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The new password must have at least one lowercase character.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_NUMERIC')=='Y'){ ?>
	   else if ($.trim(new_Password.val()).search(/\d/) == -1) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">The new password must have at least one Numeric Value.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ENABLE_COMMON')=='Y'){ ?>
	   else if ($("#reset_psw_used_common_word").val() >= 1) {
			 form_element_correct(new_Password);
			 new_Password.addClass('error_ele');
			 new_Password.after('<span role="alert" class="not-valid-tip">You have entered a password that is a very commonly or known word, consecutive alphabets or with consecutive numbers. This is not allowed. Please try different combination that is not common.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   else
	   {
			 form_element_correct(new_Password);
	   }
			 
	   if ($.trim(reentered_Password.val())==''){
			 form_element_correct(reentered_Password);
			 form_element_empty_err(reentered_Password);
			 valid_frm = 'N';
	   }
	   else
	   {
			 form_element_correct(reentered_Password);
	   }
	   
	   if ($.trim(new_Password.val())!='' && $.trim(reentered_Password.val())!='' && ($.trim(new_Password.val())!=$.trim(reentered_Password.val()))){
			 form_element_correct(reentered_Password);
			 reentered_Password.addClass('error_ele');
			 reentered_Password.after('<span role="alert" class="not-valid-tip">Password not matched.</span>');
			 valid_frm = 'N';
	   }
	   else if ($.trim(new_Password.val())!='' && $.trim(reentered_Password.val())!='') {
			
			 form_element_correct(reentered_Password);
	   }
	   
	   if (valid_frm == 'Y') {
			 return true;
	   }
	   else
	   {
			 return false;
	   }
}
function checkPasswordError(password,ele_error_tooltip,btn_submit_ele)
{
	   ele_error_tooltip.empty();
	   
	   var valid_frm = 'Y';
	   
	   var minPswLength = <?php echo getSettingVal('MINIMUM_ALLOWED'); ?>;
	   
	   var oneCapLtr = new RegExp('(?=.*[A-Z])');
	   var oneLowrLtr = new RegExp('(?=.*[a-z])');
	   var oneDigit = new RegExp('(?=.*\d)');
	   var oneSplChar = /[!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]/;
	   
	   
	   <?php if(getSettingVal('ALLOW_NUMERIC')=='Y'){ ?>
	   if (password.search(/\d/) == -1) {
			 ele_error_tooltip.append('<span>* The new password must have at least one Numeric Value.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_UPPERCASE')=='Y'){ ?>
	   if (!oneCapLtr.test(password)) {
			 ele_error_tooltip.append('<span>* The new password must have at least one uppercase character.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_LOWERCASE')=='Y'){ ?>
	   if (!oneLowrLtr.test(password)) {
			 ele_error_tooltip.append('<span>* The new password must have at least one lowercase character.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   <?php if(getSettingVal('ALLOW_SPECIALS')=='Y'){ ?>
	   if (!oneSplChar.test(password)) {
			 ele_error_tooltip.append('<span>* The new password must have at least one special character: \':;/?.>,<`~@#$%^&*()_+=-][{}\|</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   if (password.length<minPswLength) {
			 			 
			 ele_error_tooltip.append('<span>* The New Password should contain atleast '+minPswLength+' characters.</span>');
			 valid_frm = 'N';
	   }
	   if (password.length>240) {
			 			 
			 ele_error_tooltip.append('<span>* The New Password should contain maximum 240 characters.</span>');
			 valid_frm = 'N';
	   }
	   <?php if(getSettingVal('ENABLE_COMMON')=='Y'){ ?>
	   comparePswdWithCommonWords(password,$("#reset_psw_used_common_word"));
	   if ($("#reset_psw_used_common_word").val() >= 1) {
			 ele_error_tooltip.append('<span>* You have entered a password that is a very commonly or known word, consecutive alphabets or with consecutive numbers. This is not allowed. Please try different combination that is not common.</span>');
			 valid_frm = 'N';
	   }
	   <?php } ?>
	   
	   if (valid_frm=='Y') {
			 btn_submit_ele.attr('disabled',false);
	   }
	   else
	   {
			 btn_submit_ele.attr('disabled',true);
	   }
	   	   
}
function comparePswdWithCommonWords(pwd,ele_psw_used_cmn_wrd){
	   
	   var form_data = new FormData();
	   form_data.append("psword", pwd);
	   
	   jQuery.ajax({
			url: "ajax-functions/comparePswdWithCommonWords.php", // point to server-side PHP script 
			dataType: 'text', // what to expect back from the PHP script
			cache: false,
			contentType: false,
			processData: false,
			async: false,
			data: form_data,
			type: 'POST',
			success: function (response) {
				ele_psw_used_cmn_wrd.val(response);
			},
			error: function (response) {
				//$('#fileMsg').html(response); // display error response from the PHP script
			}
	   });
}
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
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
	</script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>
</html>