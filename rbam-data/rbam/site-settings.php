<?php ob_start ();
session_start();
include("conn.php");
check_login();
?>
<?php

	$CREATE_PRIV_ss_PERMISSION = getTimeAccountingModuleStatusByUser('CREATE_PRIV','Site Settings',$_SESSION['user_id']);
	$UPDATE_PRIV_ss_PERMISSION = getTimeAccountingModuleStatusByUser('UPDATE_PRIV','Site Settings',$_SESSION['user_id']);
	$VIEW_PRIV_ss_PERMISSION = getTimeAccountingModuleStatusByUser('VIEW_PRIV','Site Settings',$_SESSION['user_id']);
	$ENABLE_AUDIT_ss_PERMISSION = getTimeAccountingModuleStatusByUser('ENABLE_AUDIT','Site Settings',$_SESSION['user_id']);
	
	if($VIEW_PRIV_ss_PERMISSION!='Y')
	{
	   header('location:index.php');
	}

	if(isset($_SESSION['ss_msg'])){ $ss_msg=$_SESSION['ss_msg'];	$_SESSION['ss_msg']=""; }else{ $ss_msg=""; }
	if(isset($_SESSION['cw_msg'])){ $cw_msg=$_SESSION['cw_msg'];	$_SESSION['cw_msg']=""; }else{ $cw_msg=""; }
	
	$LoginUserId = $_SESSION['user_id'];
	$PageName = "site-settings.php";
	$sort =  isset( $_GET['sort'] )? $_GET['sort']:'asc';
	$OrderBY = "";
	$FieldName = "";
	
	$OrderBY = "desc";
	$FieldName = "COMMON_WORD_ID";
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

	if (isset($_GET["page"])){
	   $page  = $_GET["page"];
	}
	else
	{
	   $page=1;
	}
	$start_from = ($page-1) *  $record_per_page;
	
	/***** Code for Site Settings *****/
		
	$default_date_format_options = array(
		'd-M-Y'=>'DD-MON-YYYY',
		'M-d-Y'=>'MON-DD-YYYY',
		'd/m/Y'=>'DD/MM/YYYY',
		'm/d/Y'=>'MM/DD/YYYY',
		'd/m/y'=>'DD/MM/YY',
		'm/d/y'=>'MM/DD/YY',
		'l d, F, Y'=>'DAY Date, Month, Year',
		'd/m'=>'DD/MM',
		'm/d'=>'MM/DD',
		'M-d'=>'MON-DD',
		'd-M'=>'DD-MON'
	);
	$default_timezone_options = array(
		'Alaskan'=>'Alaskan',
		'Hawaiian'=>'Hawaiian',
		'Pacific'=>'Pacific',
		'Mountain'=>'Mountain',
		'Central'=>'Central',
		'Eastern'=>'Eastern'
	);
		
	$sql_ss = "select * from cxs_site_settings where SITE_SETTINGS_ID='1'";
	$res_ss = mysql_query($sql_ss);
	$numRow_ss = mysql_num_rows($res_ss);
		
	if($numRow_ss > 0)
	{
		$row_ss = mysql_fetch_object($res_ss);
		
		$MANDATORY_PWD = $row_ss->MANDATORY_PWD;
		$INCORRECT_ATTEMPT = $row_ss->INCORRECT_ATTEMPT;
		$IDLE_SESSION = $row_ss->IDLE_SESSION;
		$MINIMUM_ALLOWED = $row_ss->MINIMUM_ALLOWED;
		$DEFAULT_DATE_FORMAT = $row_ss->DEFAULT_DATE_FORMAT;
		$DEFAULT_TIMEZONE = $row_ss->DEFAULT_TIMEZONE;
		$NUMBER_OF_RECENT = $row_ss->NUMBER_OF_RECENT;
		
		$ENFORCE_RECENT = $row_ss->ENFORCE_RECENT;
		$ENABLE_COMMON = $row_ss->ENABLE_COMMON;
		$ALLOW_SPECIALS = $row_ss->ALLOW_SPECIALS;
		
		$ALLOW_UPPERCASE = $row_ss->ALLOW_UPPERCASE;
		$ALLOW_TIME_ENTRY = $row_ss->ALLOW_TIME_ENTRY;
		$ALLOW_LOWERCASE = $row_ss->ALLOW_LOWERCASE;
		$ALLOW_NUMERIC = $row_ss->ALLOW_NUMERIC;
	}
	else
	{
		$MANDATORY_PWD = "";
		$INCORRECT_ATTEMPT = "";
		$IDLE_SESSION = "";
		$MINIMUM_ALLOWED = "";
		$DEFAULT_DATE_FORMAT = "";
		$DEFAULT_TIMEZONE = "";
		$NUMBER_OF_RECENT = "";
		
		$ENFORCE_RECENT = 'N';		
		$ENABLE_COMMON = 'N';
		$ALLOW_SPECIALS = 'N';
		
		$ALLOW_UPPERCASE = 'N';
		$ALLOW_TIME_ENTRY = 'N';
		$ALLOW_LOWERCASE = 'N';
		$ALLOW_NUMERIC = 'N';
	}
	
	if($IsUpdate =='Y' && $_POST['update_ids']!='') //when data post with the caption save
	{
		$ids = explode(",",$_POST['update_ids']);
		
		foreach($ids as $id)
		{
			$word_name = $_POST['edit_word_name_'.$id];
			$active_flag = $_POST['edit_active_flag_'.$id];
			$insArr['WORD_NAME']=trim($word_name);
			$insArr['ACTIVE_FLAG']=$active_flag;
			
			updatedata("cxs_common_words",$insArr,"Where COMMON_WORD_ID = $id");
		}
		header('Location:site-settings.php');
	}
	if (isset($_POST['cmdCreateUser'] ))
	{
		//$LoginUserId = 1;
		$Text_UserName  = isset($_POST['Text_UserName'] )? $_POST['Text_UserName']: false;
		$Text_Password  = isset($_POST['Text_Password'] )? $_POST['Text_Password']: false;

		$insArr['CREATION_DATE']= date('Y-m-d H:i:s') ;
		$insArr['CREATED_BY']=$LoginUserId;
		$insArr['LAST_UPDATED_BY']=$LoginUserId;

		insertdata("cxs_users",$insArr);
		$LastInsertedUserId = mysql_insert_id();
	}
	if(isset($_POST['h_site_settings']) && $_POST['h_site_settings']=='1')
	{
		$MANDATORY_PWD = $_POST['MANDATORY_PWD'];
		$INCORRECT_ATTEMPT = $_POST['INCORRECT_ATTEMPT'];
		$IDLE_SESSION = $_POST['IDLE_SESSION'];
		$MINIMUM_ALLOWED = $_POST['MINIMUM_ALLOWED'];
		$DEFAULT_DATE_FORMAT = $_POST['DEFAULT_DATE_FORMAT'];
		$DEFAULT_TIMEZONE = $_POST['DEFAULT_TIMEZONE'];
		$NUMBER_OF_RECENT = $_POST['NUMBER_OF_RECENT'];
		
		if(isset($_POST['ENFORCE_RECENT'])){	$ENFORCE_RECENT = 'Y';	}else{	$ENFORCE_RECENT = 'N'; $NUMBER_OF_RECENT=NULL;	}
		if(isset($_POST['ENABLE_COMMON'])){	$ENABLE_COMMON = 'Y';	}else{	$ENABLE_COMMON = 'N';	}
		if(isset($_POST['ALLOW_SPECIALS'])){	$ALLOW_SPECIALS = 'Y';	}else{	$ALLOW_SPECIALS = 'N';	}
		
		if(isset($_POST['ALLOW_UPPERCASE'])){	$ALLOW_UPPERCASE = 'Y';	}else{	$ALLOW_UPPERCASE = 'N';	}
		if(isset($_POST['ALLOW_TIME_ENTRY'])){	$ALLOW_TIME_ENTRY = 'Y';	}else{	$ALLOW_TIME_ENTRY = 'N';	}
		if(isset($_POST['ALLOW_LOWERCASE'])){	$ALLOW_LOWERCASE = 'Y';	}else{	$ALLOW_LOWERCASE = 'N';	}
		if(isset($_POST['ALLOW_NUMERIC'])){	$ALLOW_NUMERIC = 'Y';	}else{	$ALLOW_NUMERIC = 'N';	}
		
		$sql = "select * from cxs_site_settings where SITE_SETTINGS_ID='1'";
		$res = mysql_query($sql);
		$numRow = mysql_num_rows($res);
		
		if($numRow == 0)
		{
			$insSQL = "insert into cxs_site_settings
				set
					MANDATORY_PWD=".$MANDATORY_PWD.",
					INCORRECT_ATTEMPT=".$INCORRECT_ATTEMPT.",
					IDLE_SESSION=".$IDLE_SESSION.",
					MINIMUM_ALLOWED=".$MINIMUM_ALLOWED.",
					
					DEFAULT_DATE_FORMAT='".$DEFAULT_DATE_FORMAT."',
					DEFAULT_TIMEZONE='".$DEFAULT_TIMEZONE."',
					NUMBER_OF_RECENT='".$NUMBER_OF_RECENT."',
					
					ENFORCE_RECENT='".$ENFORCE_RECENT."',					
					ENABLE_COMMON='".$ENABLE_COMMON."',
					ALLOW_SPECIALS='".$ALLOW_SPECIALS."',
					
					ALLOW_UPPERCASE='".$ALLOW_UPPERCASE."',
					ALLOW_TIME_ENTRY='".$ALLOW_TIME_ENTRY."',
					ALLOW_LOWERCASE='".$ALLOW_LOWERCASE."',
					ALLOW_NUMERIC='".$ALLOW_NUMERIC."',
					
					CREATION_DATE=now()";
					
			mysql_query($insSQL);
			
			$_SESSION['ss_msg']='<div class="alert alert-success"><i class="icon-ok"></i> Site Settings inserted successfully.</div>';
		}
		else
		{
			$updSQL = "update cxs_site_settings
				set
					MANDATORY_PWD=".$MANDATORY_PWD.",
					INCORRECT_ATTEMPT=".$INCORRECT_ATTEMPT.",
					IDLE_SESSION=".$IDLE_SESSION.",
					MINIMUM_ALLOWED=".$MINIMUM_ALLOWED.",
					
					DEFAULT_DATE_FORMAT='".$DEFAULT_DATE_FORMAT."',
					DEFAULT_TIMEZONE='".$DEFAULT_TIMEZONE."',
					NUMBER_OF_RECENT='".$NUMBER_OF_RECENT."',
					
					ENFORCE_RECENT='".$ENFORCE_RECENT."',
					ENABLE_COMMON='".$ENABLE_COMMON."',
					ALLOW_SPECIALS='".$ALLOW_SPECIALS."',
					
					ALLOW_UPPERCASE='".$ALLOW_UPPERCASE."',
					ALLOW_TIME_ENTRY='".$ALLOW_TIME_ENTRY."',
					ALLOW_LOWERCASE='".$ALLOW_LOWERCASE."',
					ALLOW_NUMERIC='".$ALLOW_NUMERIC."'
				where
					SITE_SETTINGS_ID='1'";
			 echo $updSQL;
			// exit;
			mysql_query($updSQL);
			
			$_SESSION['ss_msg']='<div class="alert alert-success"><i class="icon-ok"></i> Site Settings updated successfully.</div>';
		}
		header("Location:site-settings.php");
	}
	if(isset($_POST['cmdWordAdd']) && isset($_POST['h_duplicate']) && $_POST['h_duplicate']!='')
	{
		$WORD_NAME = isset($_POST['WORD_NAME'] )? $_POST['WORD_NAME']: false;
		$ACTIVE_FLAG = '0';
		if(isset($_POST['CheckboxActive']))
		{
			$ACTIVE_FLAG = '1';
		}
		
		$insArr['WORD_NAME']= trim($WORD_NAME);
		$insArr['ACTIVE_FLAG']= $ACTIVE_FLAG;
		$insArr['CREATION_DATE']= date('Y-m-d');
		
		insertdata("cxs_common_words",$insArr);
		
		$_SESSION['cw_msg']='<div class="alert alert-success"><i class="icon-ok"></i> Common Word inserted successfully.</div>';
		
		$LastInsertedUserId = mysql_insert_id();
		header('Location:site-settings.php');
	}	
?>
<script type="text/javascript" >
var GridCurrentRow;
GridCurrentRow = 0;
var IsGridDateValid;
IsGridDateValid = "";
function DataSort(str1,str2)
{
	var str3;
	document.getElementById('h_field_name').value = str1;
	document.getElementById('h_field_order').value = str2;
	CommonWordList.submit();
}
function SearchData()
{
	document.getElementById('h_field_name').value = '';
	document.getElementById('h_field_order').value = '';
	CommonWordList.submit();
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
			
			s1 = document.getElementById("Text_Password").value;
		//	s2 = document.getElementById("Combo_PasswordSecurityRules").value;
			s3 = document.getElementById("Text_UserName").value;
			if (s3.length>10)
			{
				alert("User Name Must Be Less Than Or Equal To 10 Characters");
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
		else if (CurrentForm =='frmNewCommonWord'){
			var WORD_NAME = document.getElementById("WORD_NAME").value;
			
			if(jQuery("#WORD_NAME").val() == ''){
			        form_element_correct($('#WORD_NAME'));
			        form_element_empty_err($('#WORD_NAME'));
			        return false;
			}
			else{
				form_element_correct($('#WORD_NAME'));
			}
			
			checkExistingCommonWord(WORD_NAME);
			
			if ($('#h_duplicate').val() >0) {
				$('#WORD_NAME').addClass('error_ele');
				$('#WORD_NAME').after('<span role="alert" class="not-valid-tip">Cannot insert duplicate record.</span>');
				return false;
			}
			else
			{
				$('#WORD_NAME').next('span').remove();
			}
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
	
	function checkExistingCommonWord(WORD_NAME)
	{
		var form_data = new FormData();
		form_data.append("WORD_NAME", WORD_NAME);
		form_data.append("STATUS", "INS");
    
		jQuery.ajax({
			url: "checkExistingCommonWords.php", // point to server-side PHP script 
			dataType: 'text', // what to expect back from the PHP script
			cache: false,
			contentType: false,
			processData: false,
			async: false,
			data: form_data,
			type: 'POST',
			success: function (response) {
				$('#h_duplicate').val(response);
			},
			error: function (response) {
				//$('#fileMsg').html(response); // display error response from the PHP script
			}
		});
	}
	function checkExistingCommonWordOnUpdate(WORD_NAME,ID)
	{
		var form_data = new FormData();
		form_data.append("WORD_NAME", WORD_NAME);
		form_data.append("COMMON_WORD_ID", ID);
		form_data.append("STATUS", "UPD");
    
		jQuery.ajax({
			url: "checkExistingCommonWords.php", // point to server-side PHP script 
			dataType: 'text', // what to expect back from the PHP script
			cache: false,
			contentType: false,
			processData: false,
			async: false,
			data: form_data,
			type: 'POST',
			success: function (response) {
				$('#h_duplicate_upd_'+ID).val(response);
			},
			error: function (response) {
				//$('#fileMsg').html(response); // display error response from the PHP script
			}
		});
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
		/*var checkboxValue=document.getElementById('Checkbox_SelectAll').checked;
		var i=1;
		for(i=1;i<=TABLE_ROW;i++)
		{
			document.getElementById("CheckboxInline"+i).checked = checkboxValue;		
		}*/
		//var checkboxes = document.getElementsByTagName('input');
		//var checkboxes = $(".record_chk").attr("checked", "true");
		var checkboxes = $(".record_chk");
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
				    cancelUpdate($(this).val());   
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
	function checkInline()
	{
		//var checkboxes = document.getElementsByTagName('input');
		var checkboxes = $(".record_chk");
		for (var i = 0; i < checkboxes.length; i++)
		{
			if (checkboxes[i].type == 'checkbox')
			{
				if(checkboxes[i].checked == false)
				{
					document.getElementById("Checkbox_SelectAll").checked =false;
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
		var counter = document.getElementById("CommonWordDataTable").rows.length;
		counter = counter-1; // heading not count
		var flag_checked="";
		
		/*for(i=1;i<=counter;i++)
		{
			if (document.getElementById("CheckboxActive"+i).checked )
			{
				if (qry!=''){
					qry += "|";
				}
				flag_checked="Y";
				s1 = document.getElementById("c_word"+i).value;
				//s1 = s1.trim();
				qry += s1;
			}
		}*/
		var exportable = [];
		$.each($(".record_chk:checked"), function(){            
			exportable.push($(this).val());
			flag_checked="Y";
		});
		//alert("My favourite sports are: " + exportable.join(", "));
		qry = exportable.join("|");
		qry1 = '<?php echo $SQueryOrderBy; ?>';					
		if(flag_checked=="Y")
		{
			makeRequest("ajax.php","REQUEST=ExportCommonWord&qry=" + qry+"&sortby="+qry1);
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
		var counter = document.getElementById("CommonWordDataTable").rows.length;
		var flag_updaterecord;
		var OriginalContent;
		var flag_checked="";
		counter = counter-1; // heading not count
		document.getElementById("h_NumRows").value = counter;
		var ButtonCaption = document.getElementById("cmdUpdateSelected").innerHTML;

		if (ButtonCaption != "Save")
		{
			$.each($(".record_chk:checked"), function(){            
								
				$("#disp_word_name_"+$(this).val()).css("display", "none");
				$("#edit_word_name_"+$(this).val()).css("display", "block");
				
				$("#disp_active_flag_"+$(this).val()).css("display", "none");
				$("#edit_active_flag_"+$(this).val()).css("display", "block");
				flag_checked="Y";
			});
			
			if (flag_checked=="Y")
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
			//var todayDate = document.getElementById("h_todaysDate").value;
			var IsActiveUser = '';
			var updateable = [];
			var new_words = [];
			
			$.each($(".record_chk:checked"),function(){
				form_element_correct($("#edit_word_name_"+$(this).val()));
				
				var cur_val = $.trim($("#edit_word_name_"+$(this).val()).val());
				
				if (cur_val=='') {
					form_element_correct($("#edit_word_name_"+$(this).val()));
					form_element_empty_err($("#edit_word_name_"+$(this).val()));
					flag_final = "N";
				}
				else
				{
					checkExistingCommonWordOnUpdate(cur_val,$(this).val())
					var dup_sts = $("#h_duplicate_upd_"+$(this).val()).val();
					
					if (dup_sts!='' && dup_sts>0) {
						$($("#edit_word_name_"+$(this).val())).addClass('error_ele');
						$($("#edit_word_name_"+$(this).val())).after('<span role="alert" class="not-valid-tip">Cannot update duplicate record.</span>');
						flag_final = "N";
					}
					else if (jQuery.inArray( cur_val, new_words ) > -1){
						$($("#edit_word_name_"+$(this).val())).addClass('error_ele');
						$($("#edit_word_name_"+$(this).val())).after('<span role="alert" class="not-valid-tip">Cannot update duplicate record.</span>');
						flag_final = "N";
					}
					else
					{
						form_element_correct($("#edit_word_name_"+$(this).val()));	
						updateable.push($(this).val());
					}
					new_words.push(cur_val);
				}
			});
			
			$("#update_ids").val(updateable.join(","));
			
			if (flag_final=="") 
			{ 
				flag_final="Y";
			}
			if (flag_final=="Y")
			{	
				CommonWordList.submit();				
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
	function TableRowFunction(UserId)
	{
		if (document.getElementById("cmdUpdateSelected").innerHTML!="Save")
		{	
			KEY= "SingleRecord";	
			$('#ModalUserDetail').modal();		
			var str = UserId;		
			makeRequest("ajax.php","REQUEST=SingleUserRecord&UserId=" + str);
		}
	}
	function ClearField()
	{
		//alert("hi");
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
		
		document.getElementById("Combo_PasswordSecurityRules").value = "";
		document.getElementById("Combo_PasswordSecurityRules").disabled = false;
		
		document.getElementById("Combo_ApplicationRoles").value = "";
		document.getElementById("Combo_ApplicationRoles").disabled = false;
		
		document.getElementById("DTPicker_RoleStartDate").value = "";
		document.getElementById("DTPicker_RoleStartDate").disabled = false;
		
		document.getElementById("DTPicker_RoleEndDate").value = "";
		document.getElementById("DTPicker_RoleEndDate").disabled = false;
		
		document.getElementById("cmdCreateUser").disabled = false;
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
		var s1 = "Site Settings";		
		var s2 = "<?php echo $PageName; ?>";				
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
	}
	function RefreshData()
	{
		//$('#SearchUsers').modal();
		CommonWordList.submit();
	}
//PR
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
    element.next('span').remove();
    //element.nextAll().remove();
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
.requirefieldcls{	background-color: #fff99c;	}
.AttachOnMouseOverText{	   color: black;	}
.myclass{	padding-top : 3px;padding-bottom : 3px;	}
.datepicker { font-size: 9px; }
.bootstrap-datetimepicker-widget td.day {	width: 200px;line-height: 10px;font-size: 10px;	}
.not-valid-tip{	color: #ff0000;	}

@media (max-width: 800px) 
{
	   .showOnPC{	display: none;	}
}
</style>

</head>

<body>
    <!-- modals start -->
    <!--<form method="post" action="" onsubmit = "return chkfld(document.getElementById('Text_Password').value , document.getElementById('Combo_PasswordSecurityRules').value),''">-->
	<form method="post" action="" onsubmit = "return chkfld('CreateUser')">
		<div class="modal fade bs-example-modal-lg custom-modal" id = "ModalAddPasswordSecurity" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg cus-modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title " id="myModalLabel"> Add New Rule </h4>
					</div>
					<div class="modal-body">
						<!-- field start-->
						<div class="col-sm-12">
							<div class="cus-form-cont">
								<div class="col-sm-4 form-group">
									<label> Mandatory Password Reset Days </label>
									<input type="text"  id = "Text_ResetDays" name = "Text_ResetDays" required class="form-control requirefieldcls" placeholder="" maxlength="10"  onkeypress = 'return UserNameValidation(event);' oninput="this.value=this.value.toUpperCase()" onblur = "DuplicateUserName(this.id)"> <!--onkeyup="this.value=this.value.toUpperCase()" oninput='UserNameValidation(this.value);' -->
								</div>
								<div class="col-sm-4 form-group">
									<label> Number of Incorrect Attempts Allowed </label>
									<input type="password" id = "Text_Attempts" name = "Text_Attempts"  required class="form-control requirefieldcls" placeholder="" maxlength="25">
								</div>
								<div class="col-sm-4 form-group">
									<label> Idle Session Timeout </label>
									<input type="text" id = "Text_SessionTimeout" name = "Text_SessionTimeout"  class="form-control " value = ""  placeholder="" maxlength="3" onkeypress = 'return ResetPasswordDaysValidation(event);'>
								</div>
								<div class="col-sm-4 form-group">
									<label> Minimum Characters Allowed </label>
									<input type="text" id = "Text_MinCharacter" name = "Text_MinCharacter"  class="form-control " value = ""  placeholder="" maxlength="3" onkeypress = 'return ResetPasswordDaysValidation(event);'>
								</div>
								
								<div class="col-sm-4 form-group">
									<label> Default Date Format </label>
									<select id="Combo_ResourceName" name="Combo_ResourceName" class="form-control">
										<option value=''>- Assign Default Date Format -</option>
										<option value='mm/dd/yyyy'> mm/dd/yyyy</option>
										<option value='mm/yyyy'> mm/yyyy </option>
										<option value='dd/yyyy'> dd/yyyy</option>
									</select>
								</div>

								<div class="col-sm-4 form-group">
									<label> Default Number Format </label>
									<select id = "Combo_ResourceName" name = "Combo_ResourceName" class="form-control " >
										<option value=''>- Assign Default Number Format -</option>
										<option value='option1'> option1</option>
										<option value='option2'> option2 </option>
										<option value='option3'> option3</option>
									</select>
								</div>
								
								<div class="col-sm-4 form-group">
									<label> Default Time Zone  </label>
									<select id = "Combo_ResourceName" name = "Combo_ResourceName" class="form-control " >
										<option value=''>- Assign Default Time Zone -</option>
										<option value='option1'> option1</option>
										<option value='option2'> option2 </option>
										<option value='option3'> option3</option>
									</select>
								</div>			
									
								<div class="clear-both"></div>			
								
								<div class="col-sm-6 form-group">
									<div class="checkbox">
											<label style = "padding-right:5px;"> <input type="checkbox" id="Check_CopyAllowed" name="Check_CopyAllowed"> Enforce Recent Passowrd Reuse </label>
											<label style = "padding-right:5px;"> <input type="checkbox" id="Check_AutoPopulate" name="Check_AutoPopulate" > Number of Recent Passwords </label>
											<label style = "padding-right:5px;"> <input type="checkbox" id="Check_Active" name="Check_Active" > Allow Special Character in Passwords </label>										
											<label style = "padding-right:5px;"> <input type="checkbox" id="Check_CopyAllowed" name="Check_CopyAllowed"> Allow Upper Case Characters in Passwords </label>
									</div>
								</div>			
								
								<div class="col-sm-6 form-group">
									<div class="checkbox">
											<label style = "padding-right:5px;"> <input type="checkbox" id="Check_AutoPopulate" name="Check_AutoPopulate" > Aloow Lower Case Characters in Passwords </label>
											<label style = "padding-right:5px;"> <input type="checkbox" id="Check_Active" name="Check_Active" > Allow Numeric Laters in Passwords </label>										
											<label style = "padding-right:5px;"> <input type="checkbox" id="Check_Active" name="Check_Active" > Enable Commonly Used Words Validation </label>
											<label style = "padding-right:5px;"> <input type="checkbox" id="Check_Active" name="Check_Active" > Allow Time Entry  in Decimals </label>
									</div>
								</div>		
								
							</div>
						</div>

						<!-- end -->
					</div>
					<div class="clear-both"></div>
					<div class="modal-footer cr-user">
						<button type="submit"  id = "cmdCreateUser" name = "cmdCreateUser" class="btn btn-primary btn-style"> Create Rule </button>
					</div>
				</div>
			</div>
		</div>
    <!-- modals end -->
	</form>
    <!-- modals end -->

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

	<!-- modals start -->
	<form method="post" id="frmNewCommonWord" action="" onsubmit = "return chkfld('frmNewCommonWord')">
		<div class="modal fade bs-example-modal-lg custom-modal" id = "ModalAddAccountingPeriod" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">		
			<div class="modal-dialog modal-lg cus-modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title " id="myModalLabel"> Commonly Used Word Exclusion List </h4>
					</div>
					<div class="modal-body"> 
						<!-- field start-->
						<div class="col-sm-12">
							<div class="cus-form-cont">
								<div class="col-sm-6 form-group cus-form-ico">
									<label> Word </label> <label id = "lblHeaderId" style = "display:none" > <?php echo $HeaderId;?> </label>
									<input type="text" id="WORD_NAME" name="WORD_NAME" class="form-control requirefieldcls form_datetime" maxlength="50" >									
								</div>
								<div class="col-sm-6 form-group cus-form-ico">
								  <label style = "width:150px;"> &nbsp;&nbsp; </label> <br>
								  <label > Active &nbsp;&nbsp;</label> <input type="checkbox" id="CheckboxActive" name="CheckboxActive" value="1" >
								</div>
							</div>
						</div>
					<!-- end --> 
					</div>
					<div class="clear-both"></div>
					<div class="modal-footer cr-user">
						<button type="submit" id="cmdWordAdd" name="cmdWordAdd" class="btn btn-primary btn-style">Add</button>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" id="h_duplicate" name="h_duplicate" value=""/>
	</form>
	<!-- modals end -->

	<?php include("header.php"); ?>
	<section class="md-bg">
		<div class="container-fluid">
			<div class="row">
			  <div class="brd-crmb">
				<ul>
				  <li> <a href="#"> Users And Roles </a></li>
				  <li> <a href="#"> Site Settings </a></li>
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
				<!--		<button type="button" id = "cmdFind" name = "cmdFind"  class="btn btn-primary btn-style2" data-toggle="modal" data-target="#FindPopup"> <i class="fa fa-search" aria-hidden="true"></i> Find </button>
						<button type="button" id = "cmdRefresh" name = "cmdRefresh"class="btn btn-primary btn-style2" onclick="RefreshData()" ><i class="fa fa-refresh" aria-hidden="true"></i>Refresh</button>-->
				  </div>
				</div>
            <div class="cont-box">
				<div class="pge-hd">
				  <div class="fleft ">
					<h2 class="sec-title"> <label id="Label_Title"> Site Settings </label></h2>
				</div>
				<div class="fright cr-user">
					<button type="button" <?php if($UPDATE_PRIV_ss_PERMISSION=='Y'){ ?>id="updSiteSettings" name="updSiteSettings" <?php }else{ ?>disabled="disabled"<?php } ?> class="btn btn-primary btn-style  text-right"> Save </button>
				</div>				 
                </div>
			<?php
				$ViewButtonStyle="onclick= 'ExportRecord();'";
				$Query ="Select * from cxs_am_user_admin where USER_ID = $LoginUserId";
						
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
	<form class="form" id="frmSiteSettings" name="frmSiteSettings" action="" method="POST" >
		<div class="row">
			<h4 class="text-center" style="color:red;" id="ss_msg_section"><?php echo $ss_msg; ?></h4>
		</div>
		<input type="hidden" id="h_site_settings" name="h_site_settings" value="">
		<div class="col-sm-12">
		<div class="cus-form-cont">
			<div class="col-sm-4 form-group">
				<label> Mandatory Password Reset Days </label>
				<input type="text" id="MANDATORY_PWD" name="MANDATORY_PWD" class="form-control requirefieldcls" placeholder="" maxlength="2" value="<?php echo $MANDATORY_PWD; ?>">
			</div>
			<div class="col-sm-4 form-group">
				<label> Number of Incorrect Attempts Allowed </label>
				<input type="text" id="INCORRECT_ATTEMPT" name="INCORRECT_ATTEMPT" class="form-control requirefieldcls" placeholder="" maxlength="2" value="<?php echo $INCORRECT_ATTEMPT; ?>">
			</div>
			<div class="col-sm-4 form-group">
				<label> Idle Session Timeout </label>
				<input type="text" id="IDLE_SESSION" name="IDLE_SESSION" class="form-control" value="<?php echo $IDLE_SESSION; ?>">
			</div>
			<div class="col-sm-4 form-group">
				<label> Minimum Characters Allowed </label>
				<input type="text" id="MINIMUM_ALLOWED" name="MINIMUM_ALLOWED" class="form-control requirefieldcls" value="<?php echo $MINIMUM_ALLOWED; ?>">
			</div>
			<div class="col-sm-4 form-group">
				<label> Default Date Format </label>
				<select id="DEFAULT_DATE_FORMAT" name="DEFAULT_DATE_FORMAT" class="form-control">
					<option value=''>- Assign Default Date Format -</option>
					<?php
					foreach ($default_date_format_options as $key => $value) {	?>
						<option value='<?php echo $key; ?>' <?php if($key == $DEFAULT_DATE_FORMAT){ ?>selected="selected"<?php } ?>><?php echo $value; ?></option>
					<?php } ?>
				</select>
			</div>
			<!--<div class="col-sm-4 form-group">
				<label> Default Number Format </label>
				<select id="DEFAULT_NUMBER_FORMAT" name="DEFAULT_NUMBER_FORMAT" class="form-control " >
					<option value=''>- Assign Default Number Format -</option>
					<option value='option1'> option1</option>
					<option value='option2'> option2 </option>
					<option value='option3'> option3</option>
				</select>
			</div>-->
			<div class="col-sm-4 form-group">
				<label> Default Time Zone  </label>
				<select id="DEFAULT_TIMEZONE" name="DEFAULT_TIMEZONE" class="form-control">
					<option value=''>- Assign Default Time Zone -</option>
					<?php
					foreach ($default_timezone_options as $key => $value) {	?>
						<option value='<?php echo $key; ?>' <?php if($key == $DEFAULT_TIMEZONE){ ?>selected="selected"<?php } ?>><?php echo $value; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-sm-4 form-group">
				<label> Number of Recent Passwords </label>
				<input type="text" id="NUMBER_OF_RECENT" name="NUMBER_OF_RECENT" class="form-control" value="<?php if($NUMBER_OF_RECENT==0){ echo ""; }else{ echo $NUMBER_OF_RECENT; } ?>" maxlength="2" <?php if($ENFORCE_RECENT=='N'){ ?> disabled="disabled"<?php } ?>>
			</div>
			<div class="clear-both"></div>	
			<div class="col-sm-4 form-group">
				<div class="checkbox">										
				<label style = "padding-right:5px;padding-bottom:10px;"> <input type="checkbox" id="ENFORCE_RECENT" name="ENFORCE_RECENT" <?php if($ENFORCE_RECENT=='Y'){ ?>checked="checked"<?php } ?>> Enforce Recent Passowrd Reuse  </label><br>
				<label style = "padding-right:5px;padding-bottom:10px;"> <input type="checkbox" id="ENABLE_COMMON" name="ENABLE_COMMON" <?php if($ENABLE_COMMON=='Y'){ ?>checked="checked"<?php } ?>> Enable Commonly Used Words Validation </label><br>
				<label style = "padding-right:5px;padding-bottom:10px;"> <input type="checkbox" id="ALLOW_SPECIALS" name="ALLOW_SPECIALS" <?php if($ALLOW_SPECIALS=='Y'){ ?>checked="checked"<?php } ?>> Allow Special Character in Passwords </label><br>
				</div>
			</div>
		
			<div class="col-sm-4 form-group">
				<div class="checkbox">										
				<label style = "padding-right:5px;padding-bottom:10px;"> <input type="checkbox" id="ALLOW_UPPERCASE" name="ALLOW_UPPERCASE" <?php if($ALLOW_UPPERCASE=='Y'){ ?>checked="checked"<?php } ?>> Allow Upper Case Characters in Passwords </label><br>
				<label style = "padding-right:5px;padding-bottom:10px;"> <input type="checkbox" id="ALLOW_TIME_ENTRY" name="ALLOW_TIME_ENTRY" <?php if($ALLOW_TIME_ENTRY=='Y'){ ?>checked="checked"<?php } ?>> Allow Time Entry in Decimals </label><br>
				<label style = "padding-right:5px;padding-bottom:10px;"> <input type="checkbox" id="ALLOW_LOWERCASE" name="ALLOW_LOWERCASE" <?php if($ALLOW_LOWERCASE=='Y'){ ?>checked="checked"<?php } ?>> Allow Lower Case Characters in Passwords </label><br>
				</div>
			</div>		
			<div class="col-sm-4 form-group">
				<div class="checkbox">
				
				<label style = "padding-right:5px;padding-bottom:10px;"> <input type="checkbox" id="ALLOW_NUMERIC" name="ALLOW_NUMERIC" <?php if($ALLOW_NUMERIC=='Y'){ ?>checked="checked"<?php } ?>> Allow Numeric Value in Passwords </label>
				</div>
			</div>		
		</div>
	</div>
	<div class="modal-footer cr-user"></div>
	</form>
					
		<!--<form class="form" id="PasswordSecurityList" name="PasswordSecurityList" action="" method="POST">-->
		<div class="row">
			<h4 class="text-center"> <?php echo $cw_msg; ?> </h4>
		</div>
		<div class="col-sm-12">
			<form class="form" id="CommonWordList" name="CommonWordList" action="" method="POST">		
		<div class="fleft two">						
			<button type="button" class="btn-style btn" <?php if($UPDATE_PRIV_ss_PERMISSION=='Y'){ ?>id="cmdUpdateSelected" name="cmdUpdateSelected" onclick='EditRecord();'<?php }else{ ?>disabled="disabled"<?php } ?>> Update selected </button>
			<button type="button" class="btn-style btn" id="cmdExport" name="cmdExport" onclick='ExportRecord();' <?php echo $ViewButtonStyle; ?> > Export </button>
			<button type="button" class="btn-style btn" id="cmdCancel" name="cmdCancel" disabled="disabled"> Cancel</button>
		</div>
		<div class="fright cr-user">
			<button type="button" class="btn btn-primary btn-style" <?php if($UPDATE_PRIV_ss_PERMISSION=='Y'){ ?>data-toggle="modal" data-target="#ModalAddAccountingPeriod" onclick= 'ReadonlyInputElements(false)'<?php }else{ ?>disabled="disabled"<?php } ?>> Add </button>					  
		</div>
		<div class="data-bx">
			<div class="table-responsive">						
			<table id='CommonWordDataTable' class="table table-bordered mar-cont">
				<thead>
					<tr>										
						<th width="5%" class="check-bx "><input type="checkbox" id="Checkbox_SelectAll" onchange="checkAll(this)"></th>											
						<th width="10%">
						<?php if($Sorts == 'desc' && $FileName == 'WORD_NAME') { ?>
							<span style="">
								Word Name
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('WORD_NAME','asc');"></i>
							</span>
						<?php } else { ?>
							<span style="">
								Word Name
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('WORD_NAME','desc');"></i>
							</span>
						<?php } ?>
						</th>
						<th width="10%"> Active </th>
						<th width="5%">  </th>
					</tr>
				</thead>
					<?php
					$selectQuery = "select * from cxs_common_words $s_Query $SQueryOrderBy";
					$selectQueryForPages  = $selectQuery;
					$selectQuery = $selectQuery." limit $start_from , $record_per_page";
					
					$result=mysql_query	($selectQuery);
					$TotalRecords = mysql_num_rows($result);
										
					if($TotalRecords>0)
					{
						$i=1;
						while($row_wrd=mysql_fetch_object($result))
						{
							$Display_CreationDate = date("d-M-Y",strtotime($row_wrd->CREATION_DATE));
							$Display_LastUpdate = date("d-M-Y",strtotime($row_wrd->LAST_UPDATE_DATE));
							?>
							<tr id = "<?php $rowId = "row$i"; echo $rowId; ?>">
								<input type="hidden" id="h_duplicate_upd_<?php echo $row_wrd->COMMON_WORD_ID; ?>" name="h_duplicate_upd_<?php echo $row_wrd->COMMON_WORD_ID; ?>" value="">
								<td class="check-bx ">
									<input type="checkbox" id="<?php echo "CheckboxInline".$row_wrd->COMMON_WORD_ID; ?>" name="chkbox_COMMON_WORD" value="<?php echo $row_wrd->COMMON_WORD_ID; ?>" onchange="checkInline()" class="record_chk">
									<input type="hidden" id = <?php echo "c_word".$i; ?> name = <?php echo "c_word".$i; ?> value = "<?php echo $row_wrd->COMMON_WORD_ID; ?>">	
								</td>
								<td class="">
						<span id="disp_word_name_<?php echo $row_wrd->COMMON_WORD_ID; ?>" style="display:show"><?php echo $row_wrd->WORD_NAME; ?></span>
						<input type="text" id="edit_word_name_<?php echo $row_wrd->COMMON_WORD_ID; ?>" name="edit_word_name_<?php echo $row_wrd->COMMON_WORD_ID; ?>" class="form-control small" value = "<?php echo $row_wrd->WORD_NAME; ?>" style="display:none">
								</td>
								<td>
									<span id="disp_active_flag_<?php echo $row_wrd->COMMON_WORD_ID; ?>" name="disp_active_flag_<?php echo $row_wrd->COMMON_WORD_ID; ?>" style="display:show"><?php if($row_wrd->ACTIVE_FLAG=='1'){ echo "Yes"; }else{ echo "No"; } ?></span>
									<select id="edit_active_flag_<?php echo $row_wrd->COMMON_WORD_ID; ?>" name="edit_active_flag_<?php echo $row_wrd->COMMON_WORD_ID; ?>" style="display:none">
										<option value="1" <?php if($row_wrd->ACTIVE_FLAG=='1'){ ?> selected="selected"<?php } ?>>Yes</option>
										<option value="0" <?php if($row_wrd->ACTIVE_FLAG=='0'){ ?> selected="selected"<?php } ?>>No</option>
									</select>
								</td>
								<td>
									<button type="button" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="Created By: <?php echo $Display_CreatedByName; ?> <br> Updated By: <?php echo $Display_UpdatedByName; ?> <br> Creation Date: <?php echo $Display_CreationDate; ?> <br> Last Update Date: <?php echo $Display_LastUpdate; ?>"> <i class="fa fa-eye"></i> </button>
								</td>
							</tr>
						<?php
						$i++;
						}
					}
					?>
						</table>
					</div>
				<input type="hidden" id="h_field_name" name="h_field_name" value="<?php echo $FileName; ?>">
				<input type="hidden" id="h_field_order" name="h_field_order" value="<?php echo $Sorts; ?>">
				<input type="hidden" id="h_field_update" name="h_field_update" value="">
				<input type="hidden" id="h_NumRows" name="h_NumRows" value="0"/>		
				<input type="hidden" id="h_query" name="h_query" value=""/>
				<input type="hidden" id="h_pagename" name="h_pagename" value="<?php echo $PageName; ?>"/>
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
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript">
$('#MANDATORY_PWD,#INCORRECT_ATTEMPT,#IDLE_SESSION,#MINIMUM_ALLOWED,#NUMBER_OF_RECENT').keypress(function(e){ 
	   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)){
			return false;
	   }
});

$("#ENFORCE_RECENT").change(function() {
	   if(this.checked) {
			 $("#NUMBER_OF_RECENT").attr('disabled',false);
			 
	   }
	   else
	   {
			 $("#NUMBER_OF_RECENT").attr('disabled',true);
			 form_element_correct($("#NUMBER_OF_RECENT"))
	   }
});
$("#updSiteSettings").click(function(){
		
	   $("#ss_msg_section").empty();
	   var valid=true;
	   if(jQuery("#MANDATORY_PWD").val() == ''){
                form_element_correct($('#MANDATORY_PWD'));
                form_element_empty_err($('#MANDATORY_PWD'));
                valid = false;
        }
        else{
			 form_element_correct($('#MANDATORY_PWD'));
        }
		
	   if(jQuery("#INCORRECT_ATTEMPT").val() == ''){
                form_element_correct($('#INCORRECT_ATTEMPT'));
                form_element_empty_err($('#INCORRECT_ATTEMPT'));
                valid = false;
        }
        else{
			 form_element_correct($('#INCORRECT_ATTEMPT'));
        }
		
	   if(jQuery("#IDLE_SESSION").val() == ''){
                form_element_correct($('#IDLE_SESSION'));
                form_element_empty_err($('#IDLE_SESSION'));
                valid = false;
        }
        else{
			 form_element_correct($('#IDLE_SESSION'));
        }
		
	   if(jQuery("#MINIMUM_ALLOWED").val() == ''){
                form_element_correct($('#MINIMUM_ALLOWED'));
                form_element_empty_err($('#MINIMUM_ALLOWED'));
                valid = false;
        }
        else{
			 form_element_correct($('#MINIMUM_ALLOWED'));
        }
		
	   if(jQuery("#DEFAULT_DATE_FORMAT").val() == ''){
                form_element_correct($('#DEFAULT_DATE_FORMAT'));
                form_element_empty_err($('#DEFAULT_DATE_FORMAT'));
                valid = false;
        }
        else{
			 form_element_correct($('#DEFAULT_DATE_FORMAT'));
        }
		
	   if(jQuery("#DEFAULT_NUMBER_FORMAT").val() == ''){
                form_element_correct($('#DEFAULT_NUMBER_FORMAT'));
                form_element_empty_err($('#DEFAULT_NUMBER_FORMAT'));
                valid = false;
        }
        else{
			 form_element_correct($('#DEFAULT_NUMBER_FORMAT'));
        }
		
	   if(jQuery("#DEFAULT_TIMEZONE").val() == ''){
                form_element_correct($('#DEFAULT_TIMEZONE'));
                form_element_empty_err($('#DEFAULT_TIMEZONE'));
                valid = false;
        }
        else{
			 form_element_correct($('#DEFAULT_TIMEZONE'));
        }

	   if(jQuery('#ENFORCE_RECENT').prop('checked')==true && jQuery("#NUMBER_OF_RECENT").val() == ''){
                form_element_correct($('#NUMBER_OF_RECENT'));
                form_element_empty_err($('#NUMBER_OF_RECENT'));
                valid = false;
        }
        else{
			 form_element_correct($('#NUMBER_OF_RECENT'));
        }
	   if (valid==true) {
			$("#h_site_settings").val('1');
			document.getElementById("frmSiteSettings").submit();
	   }		
});
	
$(document).ready(function() 
{													
	   $('.record_chk').change(function() {
			if(!$(this).is(":checked")) {
				cancelUpdate($(this).val());
			}
			
			if ($('.record_chk:checked').length == 0){
				document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
				$("#cmdExport").attr('disabled',false);
				$("#cmdCancel").attr('disabled',true);
				flag_checked="N";
			}
	   });
});
$("#cmdCancel").click(function(){
	   
	   $.each($(".record_chk"), function(){
			 
			 $(this).attr('checked', false);
			 
			 if(!$(this).is(":checked")) {
				    cancelUpdate($(this).val());
			 }
			
			
	   });
	   if ($('.record_chk:checked').length == 0){
				document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
				$("#cmdExport").attr('disabled',false);
				$("#cmdCancel").attr('disabled',true);
				$("#Checkbox_SelectAll").attr('checked', false);
				flag_checked="N";
			}
});
function cancelUpdate(id)
{
	   if($("#disp_word_name_"+id).css('display') == 'none')
	   {
			 $("#disp_word_name_"+id).css("display", "block");
			 $("#edit_word_name_"+id).css("display", "none");
			 $("#edit_word_name_"+id).val($("#disp_word_name_"+id).text());
			 $("#edit_word_name_"+id).next('span').remove();
	   }
	   if($("#disp_active_flag_"+id).css('display') == 'none')
	   {
			 $("#disp_active_flag_"+id).css("display", "block");
			 $("#edit_active_flag_"+id).css("display", "none");
	   }
}
function fun1(userid,rules)
{
	   document.getElementById("CurrentUserId").innerHTML =userid;
	   document.getElementById("CurrentUserPswRule").innerHTML =rules;
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
				if (KEY == "message"){
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
				else if(KEY == "CheckFavoriteData"){
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
				else if (KEY == "SubjectData"){
				    document.getElementById("SubjectData").innerHTML = http_request.responseText;
				}
				else if(KEY == 'UserName'){
					var s1 = http_request.responseText;
					s1 = s1.trim();
					if(s1.length > 1)
					{
						alert(s1);
						document.getElementById("Text_UserName").focus();
					}
				}
				else if(KEY == "ExportRecord"){
					var str = http_request.responseText;						
					window.open('downloaddata.php?r=current-commonword', '_blank');
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
</script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>
</html>