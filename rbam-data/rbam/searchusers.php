<script type="text/javascript" >
function makeRequest2(url,data)
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
	http_request.onreadystatechange = function() { alertContents2(http_request); };
	http_request.open('POST', url, true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http_request.send(data);
}

function alertContents2(http_request)
{
	if (http_request.readyState == 4)
	{
		if (http_request.status == 200)
		{
			if (KEY == "SearchUsers")
			{
				var s1 = http_request.responseText;
				s1 = s1.trim();
				//	alert(s1+"result:");
				document.getElementById("ListUserName").innerHTML = http_request.responseText;						
			}
		}
		else
		{
			document.getElementById(KEY).innerHTML = "";
			alert('There was a problem with the request.');
		}
	}
}	
	
function SearchUsers(search_by_field_name)
{
	KEY = "SearchUsers";
	
	//var res_grp = $.trim($('#Text_SearchResourceGroup').val());
	var usr_name = $.trim($('#Text_SearchUserName').val());
	var first_name = $.trim($('#Text_SearchFirstName').val());
	var last_name = $.trim($('#Text_SearchLastName').val());
			
	var str = document.getElementById("Text_SearchUserName").value;
	var str1 = document.getElementById("Text_SearchFirstName").value;
	var str2 = document.getElementById("Text_SearchLastName").value;
	
	//makeRequest2("ajax1.php","REQUEST=SearchUsers&GroupName="+res_grp+"&UserName="+usr_name+"&FirstName="+first_name+"&LastName="+last_name+"&SearchField="+search_by_field_name);
	makeRequest2("ajax1.php","REQUEST=SearchUsers&UserName="+usr_name+"&FirstName="+first_name+"&LastName="+last_name+"&SearchField="+search_by_field_name);
}	
function SelectedUserName(s1,s2,s3,user_id,search_by_field,resource_group_id)
{
	var rowNo = '';
	if( $('#h_currentRowNo').length )
	{
	    rowNo=$('#h_currentRowNo').val();
	}
	
	document.getElementById("Text_UserName"+rowNo).value = s1;		
	document.getElementById("Text_FirstName"+rowNo).value = s2;		
	document.getElementById("Text_LastName"+rowNo).value = s3;
	document.getElementById("h_userid"+rowNo).value = user_id;
	
		
	
	document.getElementById("hdn_searchField").value = search_by_field;
			
	//document.getElementById("ListUserName").style.display = 'none';	
	document.getElementById("Text_SearchUserName").value = "";		
	document.getElementById("Text_SearchFirstName").value = "";		
	document.getElementById("Text_SearchLastName").value = "";
	document.getElementById("ListUserName").innerHTML = "";	
	$("#SearchUsers .close").click();
	$("#cmdFindRoles").click();
	/*if (resource_group_id==0) {
		$("#cmdFindRoles").click();	//for access-management-roles.php
	}
	else
	{
		$('#Text_ResourceGroup').attr('disabled','disabled');
		$('#cmdFindRoles').attr('disabled','disabled');
		$('#cmdSavePermission').attr('disabled','disabled')
	}*/
	//UpdateValueToTextBox(); //for assign-app-adminstrator.php
}
</script>
	<form  method="post" action="" >
	  <div class="modal fade custom-modal" id="SearchUsers" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display:none">
		<input type="hidden" id="search_by_field_name" value="">
		<div class="modal-dialog modal-lg cus-modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <!--<h4 class="modal-title " id="myModalSearchLabel"> Find Users </h4>-->
			  <h4 class="modal-title " id="myModalSearchLabel"> Find Resources </h4>
			</div>
			<div class="modal-body">
			<!-- field start-->
			  <div class="col-sm-12">
				<div class="cus-form-cont">
					
					<div class="col-sm-4 form-group srchFld" id="sec_ResourceGroup"><!--style="display: none;"-->
						<label> Enter Resource Group </label>
						<input type="text" id="Text_SearchResourceGroup" name="Text_SearchResourceGroup" value = "" class="form-control" placeholder="">
					</div>
					
					<div class="col-sm-4 form-group srchFld" id="sec_UserName"><!--style="display: none;"-->
						<label> Enter User Name </label>
						<input type="text" id="Text_SearchUserName" name="Text_SearchUserName" value = "" class="form-control" oninput="this.value=this.value.toUpperCase()" placeholder="">
					</div>					
								
					<div class="col-sm-4 form-group srchFld" id="sec_FirstName"><!--style="display: none;"-->
						<label> Enter First Name </label>
						<input type="text" id="Text_SearchFirstName" name="Text_SearchFirstName" value = "" class="form-control" placeholder="">
					</div>
					<div class="col-sm-4 form-group srchFld" id="sec_LastName"><!--style="display: none;"-->
						<label> Enter Last Name </label>
						<input type="text" id="Text_SearchLastName" name="Text_SearchLastName" value = "" class="form-control" placeholder="">
					</div>
					<div class="col-sm-4 form-group ">
						<label style="visibility:hidden"> submit </label>
						<!--<button type="button" id = "cmdFindUsers" name = "cmdFindUsers" class="btn btn-primary btn-style2 w100" onclick="SearchUsers()" > <i class="fa fa-search" aria-hidden="true"></i> Find Users </button>-->
						<button type="button" id="cmdFindUsers" name="cmdFindUsers" class="btn btn-primary btn-style2 w100" onclick="SearchUsers($('#search_by_field_name').val())" > <i class="fa fa-search" aria-hidden="true"></i> Find Resources</button>
					</div>
				</div>
				<div class="data-bx">
				  <div class="table-responsive">
					<table class="table table-bordered " width="100%">
					  <thead>
						<tr>
							<th><span> User Name </span></th>
							<th><span> First Name </span></th>
							<th><span> Last Name </span></th>
						</tr>
					  </thead>
					  <tbody id='ListUserName'>
					
					  </tbody>
					</table>
				  </div>
				</div>
			  </div>
			<!-- end -->
			</div>
			<div class="clear-both"></div>
			<div class="modal-footer cr-user">
			    <!--<button type="button" id = "cmdFindUsers" name = "cmdFindUsers"  class="btn btn-primary btn-style" onclick = "()"><i class="fa fa-search" aria-hidden="true"></i> Find Users </button>  -->
			</div>
		  </div>
		</div>
	  </div>
	  
	</form>
    <!--EDIT modals end -->