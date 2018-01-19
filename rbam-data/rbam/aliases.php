<?php ob_start();
session_start();
	include("conn.php");
check_login();
?>
<?php
	$LoginUserId = 1;
	$PageName = "aliases.php";
	
	$sort =  isset( $_GET['sort'] )? $_GET['sort']:'desc';
	$OrderBY = "";
	$FieldName = "";
	
	$OrderBY = "asc";
	$FieldName = "ALIAS_NAME";
	$Sorts = "";
	$Sorts = isset( $_POST['h_field_order'] )? $_POST['h_field_order']: $sort;
//	$FileName = isset( $_POST['h_field_name'] )? $_POST['h_field_name']: $FieldName;
	$FileName = isset( $_POST['h_field_name'] )? $_POST['h_field_name']: $FieldName;
	$s_Query = isset( $_POST['h_query'] )? $_POST['h_query']: "";	
	
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
	

	if (isset($_GET["page"]))
	{
		$page  = $_GET["page"];
	}
	else
	{
		$page=1;
	}
	//	$record_per_page=$RecordsPerPage;
	// $start_from = ($page-1) *  $record_per_page;
	$start_from = ($page-1) *  $RecordsPerPage;
?>
<script type="text/javascript" >
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "Aliases";		
		var s2 = "<?php echo $PageName; ?>";				
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
	}
	function FindData()
	{
		KEY = "FindData";
		var str = document.getElementById("Text_FindAliasName").value;		
		makeRequest("ajax-finddata.php","REQUEST=FindDataAliases&AliasName=" +str);
	
	}
	function RefreshData()
	{
		AliasList.submit();
	}
	function ShowReadOnly(Id)
	{
		
		if (document.getElementById("cmdUpdateSelected").innerHTML!="Save")
		{	
			KEY= "SingleRecord";			
			//ReadonlyInputElements(true);
			$('#DisplayPopup').modal();		
			var str = Id;		
			//makeRequest("ajax.php","REQUEST=SingleUserRecord&PeriodId=" + str);
		}
	}
	function ReadonlyInputElements(jFlag)
	{
		
		$('#Text_StartDate').prop('disabled', jFlag);
		$('#Text_EndDate').prop('disabled', jFlag);
		$('#Text_Year').prop('disabled', jFlag);
		$('#Text_PeriodName').prop('disabled', jFlag);
		$('#Combo_Status').prop('disabled', jFlag);
		//$('#cmdAdd').prop('disabled', jFlag);		
		if (jFlag == true)
		{
			$("#ModalAddAccountingPeriod").find('.modal-title').text('Display Record');
			$("#cmdAdd").hide();
		}
		else
		{
			$("#ModalAddAccountingPeriod").find('.modal-title').text('Add New Accounting Periods');
			$("#cmdAdd").show();
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
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>

<!--Search modals start -->
	<div class="modal fade bs-example-modal-lg custom-modal" tabindex="-1" id = "FindPopup" role="dialog" aria-labelledby="myLargeModalLabel">
	  <div class="modal-dialog modal-lg cus-modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title " id="myModalLabel">Find Aliases </h4>
		  </div>
		  <div class="modal-body"> 
			<!-- field start-->
			<div class="col-sm-12">
				<div class="cus-form-cont">
					
					<div class="col-sm-4 form-group">
					  <label>Alias Name</label>
					  <input type="text" id="Text_FindAliasName" name="Text_FindAliasName" class="form-control" placeholder="" maxlength="100">
					</div>
					
					<div class="col-sm-8 form-group">
						<label>&nbsp;&nbsp;&nbsp;</label>
						<div class="checkbox">
							<label style = "padding-right:5px;"> <input type="checkbox" id="Check_FindCopyAllowed" name="Check_CopyAllowed"> Copy Allowed </label>
							<label style = "padding-right:5px;"> <input type="checkbox" id="Check_FindAutoPopulate" name="Check_AutoPopulate" > Auto Populate </label>
							<label style = "padding-right:5px;"> <input type="checkbox" id="Check_FindActive" name="Check_Active" > Active </label>
						</div>
					</div>					
				</div>
			</div>
			<!-- end --> 
		  </div>
		  <div class="clear-both"></div>
		  <div class="modal-footer cr-user">
			<button type="button" id="cmdFindPopup" name="cmdFindPopup" class="btn btn-primary btn-style" onclick="FindData()">Find</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- Search Modal  -->
	
	<!--Display modals start -->
	<div class="modal fade bs-example-modal-lg custom-modal" tabindex="-1" id = "DisplayPopup" role="dialog" aria-labelledby="myLargeModalLabel">
	  <div class="modal-dialog modal-lg cus-modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title " id="myModalLabel">Alias</h4>
		  </div>
		  <div class="modal-body"> 
			<!-- field start-->
			<div class="col-sm-12">
				<div class="cus-form-cont">
					
					<div class="col-sm-4 form-group">
					  <label>Alias Name</label>
					  <input type="text" id="Text_AliasName" name="Text_AliasName" class="form-control" disabled maxlength="100">
					</div>
					
					<div class="col-sm-4 form-group">
					  <label>Description</label>
					  <input type="text" id="Text_Description" name="Text_Description" class="form-control" disabled maxlength="100">
					</div>
					
					<div class="col-sm-4 form-group">
						<label> Alias Type </label>
						<select id = "Combo_AliasType" name = "Combo_AliasType" class="form-control " disabled maxlength="20">
							<option value="RES-Resource Specific Alias">RES-Resource Specific Alias</option>
						</select>
					</div>	
					
					<div class="col-sm-4 form-group">
					  <label> Alias Class </label>
					  <select id = "Combo_AliasClass" name = "Combo_AliasClass" class="form-control" disabled maxlength="20">
						<option value="">- Assign Alias Class -</option>
						<option value="Leave">Leave</option>
						<option value="Shift">Shift</option>
						<option value="Overtime">Overtime</option>
						<!-- <option value="Policy">Policy</option> -->
					  </select>
					</div>
					
					<div class="col-sm-4 form-group">
					  <label> Project WBS </label>
					  <input type="text" id="Text_ProjectWBS" name="Text_ProjectWBS"value = "<?php echo $Text_ProjectWBS; ?>" class="form-control" disabled maxlength="25" >
					</div>
					
					<div class="col-sm-8 form-group">
						<label>&nbsp;&nbsp;&nbsp;</label>
						<div class="checkbox">
							<label style = "padding-right:5px;"> <input type="checkbox" id="Check_CopyAllowed" name="Check_CopyAllowed" disabled> Copy Allowed </label>
							<label style = "padding-right:5px;"> <input type="checkbox" id="Check_AutoPopulate" name="Check_AutoPopulate" disabled> Auto Populate </label>
							<label style = "padding-right:5px;"> <input type="checkbox" id="Check_Active" name="Check_Active" disabled> Active </label>
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
	<!-- Display Modal  -->
<?php include("header.php"); ?>
<section class="md-bg">
  <div class="container-fluid">
    <div class="row"> 
      <!-- brd crum-->
      <div class="brd-crmb">
        <ul>
          <li> <a href="#"> Set Up </a></li>
          <li> <a href="#"> Aliases </a></li>
        </ul>
      </div>
      <!-- Dash board -->
      <div class="dash-strip">
        <div class="fleft cr-user">
          <a href="index.php"> <button type="button" class="btn btn-primary dash"> Dashboard </button>  </a> 
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
			<button type="button" id = "cmdFind" name = "cmdFind"  class="btn btn-primary btn-style2" data-toggle="modal" data-target="#FindPopup"> <i class="fa fa-search" aria-hidden="true"></i> Find </button>
			<button type="button" id = "cmdRefresh" name = "cmdRefresh"class="btn btn-primary btn-style2" onclick="RefreshData()" ><i class="fa fa-refresh" aria-hidden="true"></i>Refresh</button>
        </div>
      </div>
      <!-- inner work-->
      <div class="cont-box">
        <div class="pge-hd">
          <h2 class="sec-title"> <label id="Label_Title"> Aliases </label> </h2>
        </div>
        <div>
          <div class="fleft two">
            <button type="button" class="btn-style btn" id = "cmdUpdateSelected" name = "cmdUpdateSelected"> Update Selected </button>
            <button type="button" class="btn-style btn"> Export </button>
          </div>
          
		  <div class="fright cr-user">
            <a href="create-new-alias.php"> <button type="button" class="btn btn-primary btn-style"> Create New Alias </button></a>
          </div>
          <div class="data-bx">
            <div class="table-responsive">
              <table class="table table-bordered mar-cont">
                <thead>
                  <tr>
					<th width="5%" class="check-bx "><input type="checkbox" id="Checkbox_SelectAll" onchange="checkAll()"></th>											
                   
					 <th width="10%">
						<?php if($Sorts == 'desc' && $FileName == 'ALIAS_NAME') { ?>
							  <span style="">
								Alias Name
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('ALIAS_NAME','asc');"></i>
							  </span>
						<?php } else { ?>
							  <span style="">
								Alias Name
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('ALIAS_NAME','desc');"></i>
							  </span>
						<?php } ?>
					</th>
					
					 <th width="15%">
						<?php if($Sorts == 'desc' && $FileName == 'ALIAS_NAME') { ?>
							  <span style="">
								Alias Type
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('ALIAS_NAME','asc');"></i>
							  </span>
						<?php } else { ?>
							  <span style="">
								Alias Type
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('ALIAS_NAME','desc');"></i>
							  </span>
						<?php } ?>
					</th>
					
					 <th width="15%">
						<?php if($Sorts == 'desc' && $FileName == 'DESCRIPTION') { ?>
							  <span style="">
								Description
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('DESCRIPTION','asc');"></i>
							  </span>
						<?php } else { ?>
							  <span style="">
								Description
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('DESCRIPTION','desc');"></i>
							  </span>
						<?php } ?>
					</th>
					
					 <th width="5%">
						<?php if($Sorts == 'desc' && $FileName == 'ACTIVE_FLAG') { ?>
							  <span style="">
								Active
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('ACTIVE_FLAG','asc');"></i>
							  </span>
						<?php } else { ?>
							  <span style="">
								Active
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('ACTIVE_FLAG','desc');"></i>
							  </span>
						<?php } ?>
					</th>
					
					 <th width="10%">
						<?php if($Sorts == 'desc' && $FileName == 'WBS_ID') { ?>
							  <span style="">
								Project WBS
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('WBS_ID','asc');"></i>
							  </span>
						<?php } else { ?>
							  <span style="">
								Project WBS
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('WBS_ID','desc');"></i>
							  </span>
						<?php } ?>
					</th>
					
					<th width="5%">
						<?php if($Sorts == 'desc' && $FileName == 'COPY_ALLOWED') { ?>
							  <span style="">
								Copy
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('COPY_ALLOWED','asc');"></i>
							  </span>
						<?php } else { ?>
							  <span style="">
								Copy
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('COPY_ALLOWED','desc');"></i>
							  </span>
						<?php } ?>
					</th>
					
					 <th width="8%">
						<?php if($Sorts == 'desc' && $FileName == 'AUTOPOPULATE') { ?>
							  <span style="">
								Auto Populate
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('AUTOPOPULATE','asc');"></i>
							  </span>
						<?php } else { ?>
							  <span style="">
								Auto Populate
								<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('AUTOPOPULATE','desc');"></i>
							  </span>
						<?php } ?>
					</th>
					
					
                    <th width="5%"> </th>
                  </tr>
                </thead>
                <tbody>
					<?php
						$s_data = "";																
						$selectQuery = "SELECT  cxs_aliases.*,cxs_users.USER_NAME as CreatedBy FROM cxs_aliases inner join cxs_users on cxs_users.USER_ID = cxs_aliases.CREATED_BY  WHERE 1=1 and cxs_aliases.ALIAS_CLASS <> '' $s_Query  $SQueryOrderBy";
						$selectQueryForPages  = $selectQuery;
						$selectQuery = $selectQuery." limit $start_from , $RecordsPerPage";
						$RunUserQuery=mysql_query($selectQuery);
						$StdNumRows = mysql_num_rows($RunUserQuery);
						$i= 1;
						while($rows=mysql_fetch_array($RunUserQuery))
						{
							$Display_AliasId = $rows['ALIAS_ID'];							
							$Display_AliasName	= $rows['ALIAS_NAME'];
							$Display_AliasType	= "";//$rows['PERIOD_NAME'];	
							$Display_Description	= $rows['DESCRIPTION'];
							
							$Display_Active	= $rows['ACTIVE_FLAG'];
							$Display_Copy	= $rows['COPY_ALLOWED'];
							$Display_AutoPopulate	= $rows['AUTOPOPULATE'];
							
							$Display_ProjectWBS = $rows['WBS_ID'];
							$Display_CreatedByName	= $rows['CreatedBy'];	
							$Display_CreationDate = date('m/d/Y ', strtotime($rows['CREATION_DATE']));							
							$UpdatedBy		= $rows['LAST_UPDATED_BY'];
							$Display_UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $UpdatedBy");							
							$Display_LastUpdate = date('m/d/Y h:i:sa', strtotime($rows['LAST_UPDATE_DATE']));
							
						?>	
                  <!--<tr>
                    <td class="check-bx "><input type="checkbox" id="inlineCheckbox1" value="option1"></td>
                    <td> Dummy Text </td>
                    <td><div class="form-group">
                        <select class="form-control">
                          <option value="">option 1</option>
                          <option value="">Option 2</option>
                          <option value="">Option 3</option>
                          <option value="">Option 4</option>
                        </select>
                      </div></td>
                    <td> Dummy Text </td>
                    <td class="check-bx "><input type="checkbox" id="inlineCheckbox1" value="option1"></td>
                    <td> Dummy Text </td>
                    <td><input type="checkbox" id="inlineCheckbox1" value="option1"></td>
                    <td><input type="checkbox" id="inlineCheckbox1" value="option1"></td>
                    <td><button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left" data-content="Created By: VAISHNAVR Updated By: JBOB Creation Date: 11th March 2017 4:40 PM Last Update Date: 12th March 2017 4:40 PM" > <i class=" fa fa-eye"></i> </button></td>
                  </tr>				  
                  -->
					<tr ondblclick="ShowReadOnly('<?php echo $Display_AliasId; ?>')">
						<td class="check-bx "><input type="checkbox" id="<?php echo "CheckboxInline$i"; ?>" name="<?php echo "CheckboxInline$i"; ?>" value="1" onchange="checkInline()">
							<input type="hidden" id = <?php echo "h_AliasId".$i; ?> name = <?php echo "h_AliasId".$i; ?> value = "<?php echo $Display_AliasId; ?>">												
						</td>
						
						<td> 
							<span id = "<?php echo "span".$i."_2"; ?>"> <?php echo $Display_AliasName; ?> </span>
							<input type="text" id="<?php echo "Text_AliasName".$i; ?>" name="<?php echo "Text_AliasName".$i; ?>" class="form-control small  requirefieldcls" required value = "<?php echo $Display_AliasName; ?>"  style = "height : 24px;font-size:9pt;   display:none" >
						</td>	
						
						<td> 
							<span id = "<?php echo "span".$i."_2"; ?>"> <?php echo $Display_AliasType; ?> </span>
							<input type="text" id="<?php echo "Text_AliasType".$i; ?>" name="<?php echo "Text_AliasType".$i; ?>" class="form-control small  "  value = "<?php echo $Display_AliasType; ?>"  style = "height : 24px;font-size:9pt;   display:none" >
						</td>						  						
						
						<td> 
							<span id = "<?php echo "span".$i."_3"; ?>"> <?php echo $Display_Description; ?> </span>
							<input type="text" id="<?php echo "Text_Description".$i; ?>" name="<?php echo "Text_Description".$i; ?>"  class="form-control requirefieldcls" required value = "<?php echo $Display_Description; ?>" style = "height : 24px; font-size:9pt;display:none" >
						</td>
						
						<td> 
							<span id = "<?php echo "span".$i."_4"; ?>"> <?php echo $Display_Active; ?> </span>							
						</td>
						
						<td> 
							<span id = "<?php echo "span".$i."_5"; ?>"> <?php echo $Display_ProjectWBS; ?> </span>							
						</td>
						
						<td> 
							<span id = "<?php echo "span".$i."_6"; ?>"> <?php echo $Display_Copy; ?> </span>																															
						</td>
						
						<td> 
							<span id = "<?php echo "span".$i."_7"; ?>"> <?php echo $Display_AutoPopulate; ?> </span>																															
						</td>
						
						<td>
							<button type="button" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
							Created By: <?php echo $Display_CreatedByName; ?> <br> Updated By: <?php echo $Display_UpdatedByName; ?> 
							<br> Creation Date: <?php echo $Display_CreationDate; ?> <br> Last Update Date: <?php echo $Display_LastUpdate; ?>"> <i class=" fa fa-eye"></i> </button>
						</td>
					</tr>
				 <?php   
						$i=$i+1;
						}
					?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="fright cr-user mar-top-20pxs">
            <button type="button" class="btn btn-primary btn-style"> Copy Alias </button>
          </div>
         <!-- pagination start-->
			
			<div class="pagination-bx">
				<div class="bs-example">
				  <ul class="pagination">
					<?php

							//$selectQueryForPages=$selectQueryForPages;
							$RunDepQuery=mysql_query($selectQueryForPages);
							$num_records = mysql_num_rows($RunDepQuery);
							$total_pages= ceil($num_records/$RecordsPerPage);
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
      </div>
    </div>
  </div>
</section>
<footer> </footer>
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/custom.js" type="text/javascript"></script>
<script type="text/javascript">
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
			}
			else
			{
				document.getElementById(KEY).innerHTML = "";
				alert('There was a problem with the request.');
			}
		}
	}	
	
	</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 

</body>
</html>