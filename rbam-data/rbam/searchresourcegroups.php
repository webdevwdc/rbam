<script type="text/javascript" >
function makeResourceGroups(url,data)
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
	http_request.onreadystatechange = function() { alertContents222(http_request); };
	http_request.open('POST', url, true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http_request.send(data);
}

function alertContents222(http_request)
{
	if (http_request.readyState == 4)
	{
		if (http_request.status == 200)
		{
			
			if (KEY == "SearchResourceGroups")
			{
				var s1 = http_request.responseText;
				s1 = s1.trim();
				//	alert(s1+"result:");
				document.getElementById("ListResourceGroupName").innerHTML = http_request.responseText;						
			}
		}
		else
		{
			document.getElementById(KEY).innerHTML = "";
			alert('There was a problem with the request.');
		}
	}
}	
	
function SearchResourceGroups(search_by_field_name)
{
	
	KEY = "SearchResourceGroups";
	
	var res_grp = $.trim($('#Text_SearchResourceGroup').val());
		
	makeResourceGroups("ajax1.php","REQUEST=SearchResourceGroups&ResGroup="+res_grp+"&SearchField="+search_by_field_name);
}	
function SelectedResGroupName(s1,s2,s3,search_by_field)
{
	document.getElementById("Text_ResourceGroup").value = s2;
		
	//document.getElementById("hdn_searchField").value = search_by_field;
	
	$("#hdn_searchField").val(search_by_field);
			
	//document.getElementById("ListUserName").style.display = 'none';	
	/*document.getElementById("Text_SearchRoleName").value = "";		
	document.getElementById("Text_SearchFirstName").value = "";		
	document.getElementById("Text_SearchLastName").value = "";
	document.getElementById("Text_SearchResourceGroup").value = "";
	document.getElementById("ListRoleName").innerHTML = "";	*/
	$("#SearchResourceGroups .close").click();
	$('#cmdFindRoles').removeAttr('disabled');
	$('#cmdSavePermission').removeAttr('disabled');
	$("#cmdFindRoles").click(); //for access-management-roles.php		
	//UpdateValueToTextBox(); //for assign-app-adminstrator.php
}
</script>
	<form  method="post" action="" >
	  <div class="modal fade custom-modal" id="SearchResourceGroups" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display:none">
		<input type="hidden" id="search_by_field_nm">
		<div class="modal-dialog modal-lg cus-modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <!--<h4 class="modal-title " id="myModalSearchLabel"> Find Users </h4>-->
			  <h4 class="modal-title " id="myModalSearchLabel"> Find Resource Groups </h4>
			</div>
			<div class="modal-body">
			<!-- field start-->
			  <div class="col-sm-12">
				<div class="cus-form-cont">
					<div class="col-sm-4 form-group srchFld" id="sec_ResourceGroup"><!--style="display: none;"-->
						<label> Enter Resource Group </label>
						<input type="text" id="Text_SearchResourceGroup" name="Text_SearchResourceGroup" value = "" class="form-control" placeholder="">
					</div>
					
								
					
					
					<div class="col-sm-4 form-group ">
						<label style="visibility:hidden"> submit </label>
						<!--<button type="button" id = "cmdFindUsers" name = "cmdFindUsers" class="btn btn-primary btn-style2 w100" onclick="SearchUsers()" > <i class="fa fa-search" aria-hidden="true"></i> Find Users </button>-->
						<button type="button" id="cmdFindResGroups" name="cmdFindResGroups" class="btn btn-primary btn-style2 w100" onclick="SearchResourceGroups($('#search_by_field_nm').val())" > <i class="fa fa-search" aria-hidden="true"></i> Find Resource Groups</button>
					</div>
				</div>
				<div class="data-bx">
				  <div class="table-responsive">
					<table class="table table-bordered " width="100%">
					  <thead>
						<tr>
							<th><span> Name </span></th>
							<th><span> Description </span></th>
						</tr>
					  </thead>
					  <tbody id='ListResourceGroupName'>
					
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