<script type="text/javascript" >
function makeRequestRoles(url,data)
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
	http_request.onreadystatechange = function() { alertContents22(http_request); };
	http_request.open('POST', url, true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http_request.send(data);
}

function alertContents22(http_request)
{
	if (http_request.readyState == 4)
	{
		if (http_request.status == 200)
		{
			
			if (KEY == "SearchRoles")
			{
				var s1 = http_request.responseText;
				s1 = s1.trim();
				//	alert(s1+"result:");
				document.getElementById("ListRoleName").innerHTML = http_request.responseText;						
			}
		}
		else
		{
			document.getElementById(KEY).innerHTML = "";
			alert('There was a problem with the request.');
		}
	}
}	
	
function SearchRoles(search_by_field_name)
{
	
	KEY = "SearchRoles";
	
	var rl_nm = $.trim($('#Text_SearchRoleName').val());
	var rl_desc = $.trim($('#Text_SearchRoleDescription').val());
		
	makeRequestRoles("ajax1.php","REQUEST=SearchRoles&RoleName="+rl_nm+"&RoleDescription="+rl_desc+"&SearchField="+search_by_field_name);
}	
function SelectedRoleName(s1,s2,s3,search_by_field)
{
	
	document.getElementById("Text_RoleName").value = s1;
	document.getElementById("Text_RoleDescription").value = s2;
	
	
	
	document.getElementById("hdn_searchFld").value = search_by_field;
			
	//document.getElementById("ListUserName").style.display = 'none';	
	/*document.getElementById("Text_SearchRoleName").value = "";		
	document.getElementById("Text_SearchFirstName").value = "";		
	document.getElementById("Text_SearchLastName").value = "";
	document.getElementById("Text_SearchResourceGroup").value = "";
	document.getElementById("ListRoleName").innerHTML = "";	*/
	$("#SearchRoles .close").click();
	$("#cmdFindUserAccess").click(); //for access-management-roles.php		
	UpdateValueToTextBox(); //for assign-app-adminstrator.php
}
</script>
	<form  method="post" action="" >
	  <div class="modal fade custom-modal" id="SearchRoles" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display:none">
		<input type="hidden" id="search_by_field_name" value="">
		<div class="modal-dialog modal-lg cus-modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <!--<h4 class="modal-title " id="myModalSearchLabel"> Find Users </h4>-->
			  <h4 class="modal-title " id="myModalSearchLabel"> Find Roles </h4>
			</div>
			<div class="modal-body">
			<!-- field start-->
			  <div class="col-sm-12">
				<div class="cus-form-cont">
					
					<div class="col-sm-4 form-group srchFld" id="sec_RoleName" style="display: none;">
						<label> Enter Role Name </label>
						<input type="text" id="Text_SearchRoleName" name="Text_SearchRoleName" value="" class="form-control" placeholder="">
					</div>
					
					<div class="col-sm-4 form-group srchFld" id="sec_RoleDescription" style="display: none;">
						<label> Enter Role Description </label>
						<input type="text" id="Text_SearchRoleDescription" name="Text_SearchRoleDescription" value="" class="form-control" oninput="this.value=this.value.toUpperCase()" placeholder="">
					</div>					
								
					
					
					<div class="col-sm-4 form-group ">
						<label style="visibility:hidden"> submit </label>
						<!--<button type="button" id = "cmdFindUsers" name = "cmdFindUsers" class="btn btn-primary btn-style2 w100" onclick="SearchUsers()" > <i class="fa fa-search" aria-hidden="true"></i> Find Users </button>-->
						<button type="button" id="cmdFindAvlblRoles" name="cmdFindAvlblRoles" class="btn btn-primary btn-style2 w100" onclick="SearchRoles($('#search_by_field_name').val())" > <i class="fa fa-search" aria-hidden="true"></i> Find Roles</button>
					</div>
				</div>
				<div class="data-bx">
				  <div class="table-responsive">
					<table class="table table-bordered " width="100%">
					  <thead>
						<tr>
							<th><span> Role Name </span></th>
							<th><span> Role Description </span></th>
						</tr>
					  </thead>
					  <tbody id='ListRoleName'>
					
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