<?php ob_start ();
session_start();
include("conn.php");
check_login();
?>
<?php
	   $CREATE_PRIV_wbs_PERMISSION = getTimeAccountingModuleStatusByUser('CREATE_PRIV','Create WBS',$_SESSION['user_id']);
	   $UPDATE_PRIV_wbs_PERMISSION = getTimeAccountingModuleStatusByUser('UPDATE_PRIV','Create WBS',$_SESSION['user_id']);
	   $VIEW_PRIV_wbs_PERMISSION = getTimeAccountingModuleStatusByUser('VIEW_PRIV','Create WBS',$_SESSION['user_id']);
	   $ENABLE_AUDIT_wbs_PERMISSION = getTimeAccountingModuleStatusByUser('ENABLE_AUDIT','Create WBS',$_SESSION['user_id']);
				
	   if($CREATE_PRIV_wbs_PERMISSION=='N' && $UPDATE_PRIV_wbs_PERMISSION=='N' && $VIEW_PRIV_wbs_PERMISSION=='N' && $ENABLE_AUDIT_wbs_PERMISSION=='N')
	   {
			 header('location:index.php');
	   }

     if(isset($_SESSION['wbs_msg'])){ $wbs_msg=$_SESSION['wbs_msg'];	$_SESSION['wbs_msg']=""; }else{ $wbs_msg=""; }

     $RecordsPerPage = 1;
	$LoginUserId = $_SESSION['user_id'];
	$PageName = "workbreakdown-structure.php";
	
	$sort =  isset( $_GET['sort'] )? $_GET['sort']:'asc';
	$OrderBY = "";
	$FieldName = "";
	
	$OrderBY = "desc";
	$FieldName = "WBS_ID";
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
	
	$updArr = array();
	$insArr = array();

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
	//$start_from = ($page-1) *  1;
	
	if($IsUpdate =='Y' && $_POST['update_ids']!='' && $_POST['update_ids']!='')
	{
	  
	   $ids = explode(",",$_POST['update_ids']);
	   
	   $WBS_ID = $_POST['WBS_ID'];
		
	   foreach($ids as $id)
	   {
			$SEGMENT = trim($_POST['SEGMENT'.$id]);
			$DISPLAY_VALUE = trim($_POST['DISPLAY_VALUE'.$id]);
			$DESCRIPTION = trim($_POST['DESCRIPTION'.$id]);
			
			if(isset($_POST['ROLLUP'.$id])){	$ROLLUP = 'Y';	}else{	$ROLLUP='N';	}
			if(isset($_POST['ACTIVE_FLAG'.$id])){	$ACTIVE_FLAG = 'Y';	}else{	$ACTIVE_FLAG='N';	}
			if(isset($_POST['IN_USE'.$id])){	$IN_USE = 'Y';	}else{	$IN_USE='N';	}
						
			
			$updArr['SEGMENT'.$id]=trim($SEGMENT);
			$updArr['DISPLAY_VALUE'.$id]=trim($DISPLAY_VALUE);
			$updArr['DESCRIPTION'.$id]=trim($DESCRIPTION);
			
			$updArr['ROLLUP'.$id]=trim($ROLLUP);
			$updArr['ACTIVE_FLAG'.$id]=trim($ACTIVE_FLAG);
			$updArr['IN_USE'.$id]=trim($IN_USE);
			
			 
			
			updatedata("cxs_wbs",$updArr," Where WBS_ID = $WBS_ID");
	   }
	   if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!='')
	   {
			 header('Location:workbreakdown-structure.php?'.$_SERVER['QUERY_STRING']);
	   }
	   else
	   {
			 header('Location:workbreakdown-structure.php');
	   }
	   
	}
	if(isset($_POST['h_wbs_add']) && $_POST['h_wbs_add']=='1')
	{
	   for($i=1;$i<=15;$i++)
	   {
			 $insArr['SEGMENT'.$i]=trim($_POST['ins_SEGMENT'.$i]);
			 $insArr['DISPLAY_VALUE'.$i]=trim($_POST['ins_DISPLAY_VALUE'.$i]);
			 $insArr['DESCRIPTION'.$i]=trim($_POST['ins_DESCRIPTION'.$i]);
			
			 if(isset($_POST['ins_ROLLUP'.$i])){ $insArr['ROLLUP'.$i] = 'Y';	}else{ $insArr['ROLLUP'.$i]='N'; }
			 if(isset($_POST['ins_ACTIVE_FLAG'.$i])){ $insArr['ACTIVE_FLAG'.$i] = 'Y'; }else{ $insArr['ACTIVE_FLAG'.$i]='N'; }
			 if(isset($_POST['ins_IN_USE'.$i])){ $insArr['IN_USE'.$i] = 'Y'; }else{ $insArr['IN_USE'.$i]='N'; }
			 
			 $insArr['CREATION_DATE']= date('Y-m-d H:i:s') ;
			
	   }
	   insertdata("cxs_wbs",$insArr);
	   
	   $_SESSION['wbs_msg']='<div class="alert alert-success"><i class="icon-ok"></i> Records inserted successfully.</div>';
	   
	   header('Location:workbreakdown-structure.php');
	}
?>
<script type="text/javascript" >
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "Create WBS";		
		var s2 = "<?php echo $PageName; ?>";				
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
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
			makeRequest("ajax-finddata.php","REQUEST=FindDataWBS&AliasName=" +str);
		}
	
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
<style>
	@media (min-width: 992px) 
	{
		.modal-lg1 
		{
			width: 1280px;
		}
		.box-responsive-width
		{
			width : 500px;
		}
	}
	.round3
	{
		border: 1px solid red;
		border-radius: 12px;
		padding : 25px;
	}
	.requirefieldcls
	{
		background-color: #fff99c;
	}
	.not-valid-tip{	color: #ff0000;	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>

<!--Search modals start -->
	<div class="modal fade bs-example-modal-lg custom-modal" tabindex="-1" id = "FindPopup" role="dialog" aria-labelledby="myLargeModalLabel">
	  <div class="modal-dialog modal-lg1 cus-modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title " id="myModalLabel">Find Project WBS </h4>
		  </div>
		  
		  <div class="modal-body"> 
			<!-- field start-->
			<div class="col-sm-12">
				<div class="cus-form-cont">
					
					<div class="col-sm-4 form-group">
					  <label>Project WBS</label>
					  <input type="text" id="Text_FindProjectWBS" name="Text_FindProjectWBS" class="form-control requirefieldcls" required placeholder="" maxlength="100">
					  <span id = "span_find"></span>
					</div>
					
					<div class="col-sm-4 form-group">
						<br>
					  <button type="button" id="cmdFindPopup" name="cmdFindPopup" class="btn btn-primary btn-style " onclick="FindData()" >Find</button>
					</div>
				
					
					<div class="col-sm-12 form-group">
							<div class="data-bx">
								<div class="table-responsive">
									<table id='Table1' class="table table-bordered " width="100%" >
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
										<tbody>
											<?php
												for($i=1;$i<=5;$i++)
												{													
											?>	
												<tr>
													<?php
														for($j=1;$j<=15;$j++)
														{													
													?>	
													<td> &nbsp; </td>
													<?php } ?>	
												</tr>
												<?php } ?>	
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
			<!--<button type="button" id="cmdFindPopup" name="cmdFindPopup" class="btn btn-primary btn-style" onclick="FindData()">Find</button> -->
		  </div>
		</div>
	  </div>
	</div>
	<!-- Search Modal  -->
	
<?php include("header.php"); ?>
<section class="md-bg">
  <div class="container-fluid">
    <div class="row"> 
      <!-- brd crum-->
      <div class="brd-crmb">
        <ul>
          <li> <a href="#"> Set Up </a></li>
          <li> <a href="#"> Create WBS </a></li>
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
					$result=mysql_query($qry);
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
				<!--<button type="button" id = "cmdFind" name = "cmdFind"  class="btn btn-primary btn-style2" data-toggle="modal" data-target="#FindPopup"> <i class="fa fa-search" aria-hidden="true"></i> Find </button>
				<button type="button" id = "cmdRefresh" name = "cmdRefresh"class="btn btn-primary btn-style2" onclick="RefreshData()" ><i class="fa fa-refresh" aria-hidden="true"></i>Refresh</button>
				-->
			</div>
		</div>
      <!-- inner work-->
	<div class="cont-box">
		<div class="pge-hd">
		  <h2 class="sec-title"> <label id="Label_Title"> Define Projects / Task Work Break Down Structure </label> </h2>
		</div>
		<div class="row">
				    <h4 class="text-center" id="wbs_msg_section"><?php echo $wbs_msg; ?></h4>
				    </div>
		<div>
			<div class="fleft two">
				<button type="button" class="btn-style btn" <?php if($UPDATE_PRIV_wbs_PERMISSION=='Y'){ ?>id="cmdUpdateSelected" name="cmdUpdateSelected" onclick= 'EditRecord();'<?php }else{ ?>disabled="disabled"<?php } ?>> Update selected </button>
				<!--<button type="button" class="btn-style btn" id="cmdCancelUpdate" name="cmdCancelUpdate" style="display:none"> Cancel Update</button>-->
				<!--<button type="button" class="btn-style btn" id="cmdExport" name="cmdExport" onclick='ExportRecord();' > Export All Projects</button>-->
				<button type="button" class="btn-style btn" id="cmdExport" name="cmdExport" onclick="window.location.href='exportAllWBS.php'"> Export All Projects</button>
				
				
				<button type="button" class="btn-style btn" <?php if($CREATE_PRIV_wbs_PERMISSION=='Y'){ ?>id="cmdActivate" name="cmdActivate"<?php }else{ ?>disabled="disabled"<?php } ?> > Activate</button>
				<button type="button" class="btn-style btn" id="cmdCancel" name="cmdCancel" disabled="disabled"> Cancel</button>
			</div>
			 <div class="fright cr-user">
				<button type="button" class="btn btn-primary btn-style text-right" id="cmdSaveWBS" name="cmdSaveWBS" disabled="disabled"> Save </button>
			 </div>
	   <div class="data-bx">
			 <div class="table-responsive">
			 <form action="" method="post" id="frmWBS">
			 <table class="table table-bordered mar-cont" id="WBSdataTable">
				    <thead>
				    <tr>
						  <th width="5%" class="check-bx "><input type="checkbox" id="Checkbox_SelectAll" onchange="checkAll(this)"></th>
						   
						  <th width="5%">Sequance</th>
						  <th width="20%">Segments</th>
						  <th width="20%">Display Value</th>
						  <th width="20%">Description</th>
						  <th width="5%">Roll up</th>
						  <th width="5%">Active</th>
						  <th width="5%">In Use</th>
						  <th width="5%"> </th>
				    </tr>
				    </thead>
				    <tbody>
				    <?php
						  $allSegments = "";
						  $selectQuery = "select * from cxs_wbs $s_Query $SQueryOrderBy";
						  $selectQueryForPages  = $selectQuery;
						  $selectQuery = $selectQuery." limit $start_from , $record_per_page";
					
						  $result=mysql_query	($selectQuery);
						  $TotalRecords = mysql_num_rows($result);
										
						  if($TotalRecords>0)
						  {
								$row_wbs = mysql_fetch_array($result);
									   
								for ($i=1;$i<=15;$i++) {
									   if($allSegments!='')
									   {
											 $allSegments.='.';
									   }
									   $allSegments .= $row_wbs['SEGMENT'.$i];
						  ?>
				    <tr ondblclick="ShowReadOnly('<?php echo $Display_AliasId; ?>')">
						  <td class="check-bx "><input type="checkbox" id="<?php echo "CheckboxInline$i"; ?>" name="<?php echo "CheckboxInline$i"; ?>" value="<?php echo $i; ?>" onchange="checkInline()" class="record_chk">
								<input type="hidden" id = <?php echo "h_AliasId".$i; ?> name = <?php echo "h_AliasId".$i; ?> value = "<?php echo $Display_AliasId; ?>">
						  </td>
						  <td > <?php echo$i; ?></td>
						  <td>
								<div class="form-group">
								<span id="disp_SEGMENT_<?php echo $i; ?>"><?php echo $row_wbs['SEGMENT'.$i]; ?></span>
								<input type = "text" class="form-control requirefieldcls" required id="SEGMENT<?php echo $i; ?>" name="SEGMENT<?php echo $i; ?>" value ="<?php echo $row_wbs['SEGMENT'.$i]; ?>" style="display: none;">
								<input type = "text" class="form-control requirefieldcls" required id="ins_SEGMENT<?php echo $i; ?>" name="ins_SEGMENT<?php echo $i; ?>" value ="" style="display: none;">
								</div>
						  </td>									 
						  <td>
								<span id="disp_DISPLAY_VALUE_<?php echo $i; ?>"><?php echo $row_wbs['DISPLAY_VALUE'.$i]; ?></span>
								<div class="form-group">
									   <input type = "text" class="form-control requirefieldcls" required id="DISPLAY_VALUE<?php echo $i; ?>" name="DISPLAY_VALUE<?php echo $i; ?>" value ="<?php echo $row_wbs['DISPLAY_VALUE'.$i]; ?>" style="display: none;">
									   <input type = "text" class="form-control requirefieldcls" required id="ins_DISPLAY_VALUE<?php echo $i; ?>" name="ins_DISPLAY_VALUE<?php echo $i; ?>" value ="" style="display: none;" >
								</div>
						  </td>
						  <td>
								<span id="disp_DESCRIPTION_<?php echo $i; ?>"><?php echo $row_wbs['DESCRIPTION'.$i]; ?></span>
								<div class="form-group">
									   <input type = "text" class="form-control requirefieldcls" required id="DESCRIPTION<?php echo $i; ?>" name="DESCRIPTION<?php echo $i; ?>" value ="<?php echo $row_wbs['DESCRIPTION'.$i]; ?>" style="display: none;">
									   <input type = "text" class="form-control requirefieldcls" required id="ins_DESCRIPTION<?php echo $i; ?>" name="ins_DESCRIPTION<?php echo $i; ?>" value ="" style="display: none;" >
								</div>
						  </td>
						  <td class="check-bx ">
								<span id="disp_ROLLUP_<?php echo $i; ?>"><?php if($row_wbs['ROLLUP'.$i]=='Y'){ echo "Yes"; }else{ echo "No"; } ?></span>
								<input type="checkbox" id="ROLLUP<?php echo $i; ?>" name="ROLLUP<?php echo $i; ?>" value="1" style="display: none;" <?php if($row_wbs['ROLLUP'.$i]=='Y'){ ?>checked="checked"<?php } ?>>
								<input type="checkbox" id="ins_ROLLUP<?php echo $i; ?>" name="ins_ROLLUP<?php echo $i; ?>" value="Y" style="display: none;">
						  </td>
						  <td class="check-bx ">
								<span id="disp_ACTIVE_FLAG_<?php echo $i; ?>"><?php if($row_wbs['ACTIVE_FLAG'.$i]=='Y'){ echo "Yes"; }else{ echo "No"; } ?></span>
								<input type="checkbox" id="ACTIVE_FLAG<?php echo $i; ?>" name="ACTIVE_FLAG<?php echo $i; ?>" value="1" style="display: none;" <?php if($row_wbs['ACTIVE_FLAG'.$i]=='Y'){ ?>checked="checked"<?php } ?>>
								<input type="checkbox" id="ins_ACTIVE_FLAG<?php echo $i; ?>" name="ins_ACTIVE_FLAG<?php echo $i; ?>" value="Y" style="display: none;">
						  </td>
						  <td class="check-bx ">
								<span id="disp_IN_USE_<?php echo $i; ?>"><?php if($row_wbs['IN_USE'.$i]=='Y'){ echo "Yes"; }else{ echo "No"; } ?></span>
								<input type="checkbox" id="IN_USE<?php echo $i; ?>" name="IN_USE<?php echo $i; ?>" value="1" style="display: none;" <?php if($row_wbs['IN_USE'.$i]=='Y'){ ?>checked="checked"<?php } ?>>
								<input type="checkbox" id="ins_IN_USE<?php echo $i; ?>" name="ins_IN_USE<?php echo $i; ?>" value="Y" style="display: none;">
						  </td>
						  <td>
								<button type="button" id="vwBtn_<?php echo $i; ?>" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="Created By: <?php echo $Display_CreatedByName; ?> <br> Updated By: <?php echo $Display_UpdatedByName; ?><br> Creation Date: <?php echo date("d-M-Y",strtotime($row_wbs['CREATION_DATE'])); ?> <br> Last Update Date: <?php echo date("d-M-Y",strtotime($row_wbs['LAST_UPDATE_DATE'])); ?>"> <i class=" fa fa-eye"></i> </button>
						  </td>
				    </tr>
						  <?php  
						  }
						  ?>
						  <input type="hidden" id="WBS_ID" name="WBS_ID" value="<?php echo $row_wbs['WBS_ID']; ?>">
						  <?php
				    }
				    ?>
							
						</tbody>
						</table>
			 
				    <input type="hidden" id="h_wbs_add" name="h_wbs_add" value="">
				    
				    <input type="hidden" id="h_field_name" name="h_field_name" value="<?php echo $FileName; ?>">
				    <input type="hidden" id="h_field_order" name="h_field_order" value="<?php echo $Sorts; ?>">
				    <input type="hidden" id="h_field_update" name="h_field_update" value="">
				    <input type="hidden" id="h_NumRows" name="h_NumRows" value="0"/>		
				    <input type="hidden" id="h_query" name="h_query" value=""/>
				    <input type="hidden" id="h_pagename" name="h_pagename" value="<?php echo $PageName; ?>"/>
				    <input type="hidden" id="update_ids" name="update_ids" value=""/>
						  
					</form>
					</div>
					<?php  $WBS_FullName = "Segment1.Segment2.Segment3.Segment4.Segment5.Segment6.Segment7.Segment8.Segment9.Segment10.Segment11.Segment12.Segment13.Segment14.Segment15"; ?>
					<div class = "app-detail-bx">
						<h5><b>Work Breakdown Structure </b></h5>
						<div id = "div_wbs_structure" class = "table-responsive round3 ">
							<input class = "form-control " type = "text" id = "Text_WBS" name = "Text_WBS" value = "<?php /*echo $WBS_FullName;*/ echo $allSegments; ?>" readonly >
						</div>
					</div>
				</div>
			 <!--<div class="fleft two">
				<button type="button" class="btn-style btn" id="cmdAddWBS" name="cmdAddWBS"> Add </button>
			 </div>-->
			 <!-- pagination start-->
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
				
			<!-- pagination end -->
			</div>
		</div>
    </div>
  </div>
</section>
<footer> </footer>
<script type="text/javascript">
$(document).ready(function()
{
	   setTimeout(function(){
			 if ($("#wbs_msg_section").html().length > 0) {
				    $("#wbs_msg_section").empty();
			 }
	   }, 12000);
	   /*$.each($(".record_chk:checked"), function(){            
			//exportable.push($(this).val());
			//flag_checked="Y";
	   });*/
	   $('.record_chk').change(function() {
			if(!$(this).is(":checked")) {
			 
				    $("#disp_SEGMENT_"+$(this).val()).css("display", "block");
				    $("#SEGMENT"+$(this).val()).css("display", "none");
				
				    $("#disp_DISPLAY_VALUE_"+$(this).val()).css("display", "block");
				    $("#DISPLAY_VALUE"+$(this).val()).css("display", "none");
				
				    $("#disp_DESCRIPTION_"+$(this).val()).css("display", "block");
				    $("#DESCRIPTION"+$(this).val()).css("display", "none");
				
				    $("#disp_ROLLUP_"+$(this).val()).css("display", "block");
				    $("#ROLLUP"+$(this).val()).css("display", "none");
				    
				    $("#disp_ROLLUP_"+$(this).val()).css("display", "block");
				    $("#ROLLUP"+$(this).val()).css("display", "none");
				    
				    $("#disp_ACTIVE_FLAG_"+$(this).val()).css("display", "block");
				    $("#ACTIVE_FLAG"+$(this).val()).css("display", "none");
				    
				    $("#disp_IN_USE_"+$(this).val()).css("display", "block");
				    $("#IN_USE"+$(this).val()).css("display", "none");
				    
				    
			 
			}
			
			if ($('.record_chk:checked').length == 0){
				document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
				$("#cmdExport").attr('disabled',false);
				$("#cmdActivate").attr('disabled',false);
				
				$("#cmdCancel").attr('disabled',true);
				flag_checked="N";
			}
	   });
});
$("#cmdCancel").click(function() {
	   if ($("#cmdUpdateSelected").text() == 'Save'){
			 cancelUpdate();
	   }
	   else{
			 cancelActivate();
	   }
});
function cancelUpdate()
{
	   $('.record_chk').each(function () {
				
			 $(this).prop('checked' , false);
				
			 $("#disp_SEGMENT_"+$(this).val()).css("display", "block");
			 $("#SEGMENT"+$(this).val()).css("display", "none");
				
			 $("#disp_DISPLAY_VALUE_"+$(this).val()).css("display", "block");
			 $("#DISPLAY_VALUE"+$(this).val()).css("display", "none");
				
			 $("#disp_DESCRIPTION_"+$(this).val()).css("display", "block");
			 $("#DESCRIPTION"+$(this).val()).css("display", "none");
				
			 $("#disp_ROLLUP_"+$(this).val()).css("display", "block");
			 $("#ROLLUP"+$(this).val()).css("display", "none");
				    
			 $("#disp_ROLLUP_"+$(this).val()).css("display", "block");
			 $("#ROLLUP"+$(this).val()).css("display", "none");
				    
			 $("#disp_ACTIVE_FLAG_"+$(this).val()).css("display", "block");
			 $("#ACTIVE_FLAG"+$(this).val()).css("display", "none");
				    
			 $("#disp_IN_USE_"+$(this).val()).css("display", "block");
			 $("#IN_USE"+$(this).val()).css("display", "none");    
	   });
			 
	   if ($("#cmdUpdateSelected").text() == 'Save'){
			 $("#cmdUpdateSelected").text('Update selected');
			 $("#cmdExport").attr('disabled',false);
			 $("#cmdActivate").attr('disabled',false);
			 
			 $("#Checkbox_SelectAll").prop('checked' , false);
			 $("#Checkbox_SelectAll").attr('disabled',false);
			 
			 $("#cmdCancel").attr('disabled',true);
	   }
}
function cancelActivate() {
	   
	  for(i=1;i<=15;i++)
	   {
			 form_element_correct($("#ins_SEGMENT"+i));
			 $("#disp_SEGMENT_"+i).css("display", "block");
			 $("#ins_SEGMENT"+i).css("display", "none");
			 
			 form_element_correct($("#ins_DISPLAY_VALUE"+i));
			 $("#disp_DISPLAY_VALUE_"+i).css("display", "block");
			 $("#ins_DISPLAY_VALUE"+i).css("display", "none");
			 
			 form_element_correct($("#ins_DESCRIPTION"+i));
			 $("#disp_DESCRIPTION_"+i).css("display", "block");
			 $("#ins_DESCRIPTION"+i).css("display", "none");
			 
			 $("#disp_ROLLUP_"+i).css("display", "block");
			 $("#ins_ROLLUP"+i).css("display", "none");
			 
			 $("#disp_ACTIVE_FLAG_"+i).css("display", "block");
			 $("#ins_ACTIVE_FLAG"+i).css("display", "none");
			 
			 $("#disp_IN_USE_"+i).css("display", "block");
			 $("#ins_IN_USE"+i).css("display", "none");
			 
			 $("#vwBtn_"+i).attr('disabled',false);
			 
			 
	   }
	   
	   $('.record_chk').each(function () {
			 $(this).prop('checked' , false);
			 $(this).attr('disabled' , false);
	   });
	   /*var checkboxes = $(".record_chk");
	   
	   for (var i = 0; i < checkboxes.length; i++) {
			 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = false;
					 checkboxes[i].disabled = false;
			 }
	   }*/
	   document.getElementById("Checkbox_SelectAll").checked =false;
	   $("#cmdUpdateSelected").attr('disabled',false);
	   $("#cmdExport").attr('disabled',false);
	   $("#cmdActivate").attr('disabled',false);
	   $("#cmdSaveWBS").attr('disabled',true);
	   
	   $("#Checkbox_SelectAll").attr('disabled',false);
	   $("#cmdCancel").attr('disabled',true);
}

$("#cmdActivate").click(function() {
	   for(i=1;i<=15;i++)
	   {
			 $("#disp_SEGMENT_"+i).css("display", "none");
			 $("#ins_SEGMENT"+i).css("display", "block");
			 
			 $("#disp_DISPLAY_VALUE_"+i).css("display", "none");
			 $("#ins_DISPLAY_VALUE"+i).css("display", "block");
			 
			 $("#disp_DESCRIPTION_"+i).css("display", "none");
			 $("#ins_DESCRIPTION"+i).css("display", "block");
			 
			 $("#disp_ROLLUP_"+i).css("display", "none");
			 $("#ins_ROLLUP"+i).css("display", "block");
			 
			 $("#disp_ACTIVE_FLAG_"+i).css("display", "none");
			 $("#ins_ACTIVE_FLAG"+i).css("display", "block");
			 
			 $("#disp_IN_USE_"+i).css("display", "none");
			 $("#ins_IN_USE"+i).css("display", "block");
			 
			 $("#vwBtn_"+i).attr('disabled',true);
			 
	   }
	   var checkboxes = $(".record_chk");
		 
	   for (var i = 0; i < checkboxes.length; i++) {
			 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = false;
			 }
	   }
	   document.getElementById("Checkbox_SelectAll").checked =false;
	   
	   $("#Checkbox_SelectAll").attr('disabled',true);
	   $(".record_chk").attr('disabled',true);
	   
	   $("#cmdUpdateSelected").attr('disabled',true);
	   $("#cmdExport").attr('disabled',true);
	   $("#cmdActivate").attr('disabled',true);
	   $("#cmdSaveWBS").attr('disabled',false);
	   
	   $("#cmdCancel").attr('disabled',false);
	   
});
$("#cmdSaveWBS").click(function() {
	   
	   var valid_frm = 'Y';
	   
	   for(i=1;i<=15;i++)
	   {
			 if ($("#ins_SEGMENT"+i).val()==''){
				    form_element_correct($("#ins_SEGMENT"+i));
				    form_element_empty_err($("#ins_SEGMENT"+i));
				    valid_frm = 'N';
			 }
			 else
			 {
				    form_element_correct($("#ins_SEGMENT"+i));
			 }
			 
			 if ($("#ins_DISPLAY_VALUE"+i).val()=='') {
				    form_element_correct($("#ins_DISPLAY_VALUE"+i));
				    form_element_empty_err($("#ins_DISPLAY_VALUE"+i));
				    valid_frm = 'N';
			 }
			 else
			 {
				    form_element_correct($("#ins_DISPLAY_VALUE"+i));
			 }
			 
			 if ($("#ins_DESCRIPTION"+i).val()=='') {
				    form_element_correct($("#ins_DESCRIPTION"+i));
				    form_element_empty_err($("#ins_DESCRIPTION"+i));
				    valid_frm = 'N';
			 }
			 else
			 {
				    form_element_correct($("#ins_DESCRIPTION"+i));
			 }
	   }
	   
	   if (valid_frm == 'Y') {
			 $("#h_wbs_add").val('1');
			 $("#frmWBS").submit();
	   }
});

$("#cmdAddWBS").click(function(){
	   
	   $("#h_wbs_add").val('1');
	   $("#frmWBS").submit();
});
function checkAll(ele)
{	
	   var checkboxes = $(".record_chk");
	   if (ele.checked) {
			 for (var i = 0; i < checkboxes.length; i++){
				 if (checkboxes[i].type == 'checkbox'){
					 checkboxes[i].checked = true;
				 }
			 }
		 } else {
			 
			 /*for (var i = 0; i < checkboxes.length; i++) {
				 //console.log(i)
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = false;
				 }
			}*/
			
			 $('.record_chk').each(function () {
				
				    $(this).prop('checked' , false);
				
				    $("#disp_SEGMENT_"+$(this).val()).css("display", "block");
				    $("#SEGMENT"+$(this).val()).css("display", "none");
				
				    $("#disp_DISPLAY_VALUE_"+$(this).val()).css("display", "block");
				    $("#DISPLAY_VALUE"+$(this).val()).css("display", "none");
				
				    $("#disp_DESCRIPTION_"+$(this).val()).css("display", "block");
				    $("#DESCRIPTION"+$(this).val()).css("display", "none");
				
				    $("#disp_ROLLUP_"+$(this).val()).css("display", "block");
				    $("#ROLLUP"+$(this).val()).css("display", "none");
				    
				    $("#disp_ROLLUP_"+$(this).val()).css("display", "block");
				    $("#ROLLUP"+$(this).val()).css("display", "none");
				    
				    $("#disp_ACTIVE_FLAG_"+$(this).val()).css("display", "block");
				    $("#ACTIVE_FLAG"+$(this).val()).css("display", "none");
				    
				    $("#disp_IN_USE_"+$(this).val()).css("display", "block");
				    $("#IN_USE"+$(this).val()).css("display", "none");    
			 });
			 
			 if ($("#cmdUpdateSelected").text() == 'Save'){
				    $("#cmdUpdateSelected").text('Update selected');
				    $("#cmdExport").attr('disabled',false);
				    $("#cmdActivate").attr('disabled',false);
				    $("#cmdCancel").attr('disabled',true);
			 }
	   }
}
function checkInline()
{		
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
		var WBS_ID = $("#WBS_ID").val();
		
		var counter = document.getElementById("WBSdataTable").rows.length;
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
			makeRequest("ajax.php","REQUEST=ExportWBS&qry=" + qry+"&sortby="+qry1+"&ID="+WBS_ID);
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
	   var counter = document.getElementById("WBSdataTable").rows.length;
	   var flag_updaterecord;
	   var OriginalContent;
	   var flag_checked="";
	   counter = counter-1; // heading not count
	   document.getElementById("h_NumRows").value = counter;
	   var ButtonCaption = document.getElementById("cmdUpdateSelected").innerHTML;

	   if (ButtonCaption != "Save")
	   {
			$.each($(".record_chk:checked"), function(){            
			 
				    $("#disp_SEGMENT_"+$(this).val()).css("display", "none");
				    $("#SEGMENT"+$(this).val()).css("display", "block");
				
				    $("#disp_DISPLAY_VALUE_"+$(this).val()).css("display", "none");
				    $("#DISPLAY_VALUE"+$(this).val()).css("display", "block");
				
				    $("#disp_DESCRIPTION_"+$(this).val()).css("display", "none");
				    $("#DESCRIPTION"+$(this).val()).css("display", "block");
				
				    $("#disp_ROLLUP_"+$(this).val()).css("display", "none");
				    $("#ROLLUP"+$(this).val()).css("display", "block");
				    
				    $("#disp_ROLLUP_"+$(this).val()).css("display", "none");
				    $("#ROLLUP"+$(this).val()).css("display", "block");
				    
				    $("#disp_ACTIVE_FLAG_"+$(this).val()).css("display", "none");
				    $("#ACTIVE_FLAG"+$(this).val()).css("display", "block");
				    
				    $("#disp_IN_USE_"+$(this).val()).css("display", "none");
				    $("#IN_USE"+$(this).val()).css("display", "block");
				    
				//$("#disp_active_flag_"+$(this).val()).css("display", "none");
				//$("#edit_active_flag_"+$(this).val()).css("display", "block");
				flag_checked="Y";
			});
			
			if (flag_checked=="Y")
			{
				document.getElementById("cmdUpdateSelected").innerHTML = "Save";
				$("#cmdExport").attr('disabled',true);
				$("#cmdActivate").attr('disabled',true);				
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
			var IsActiveUserActualValue="";
			var EndDateValue="";
			//var todayDate = new Date();			
			//var todayDate = document.getElementById("h_todaysDate").value;
			var IsActiveUser = '';
			var updateable = [];
			//var new_words = [];
			
			$.each($(".record_chk:checked"),function(){
				/*form_element_correct($("#edit_word_name_"+$(this).val()));
				
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
					
					//new_words.push(cur_val);
				}*/
				updateable.push($(this).val());
				flag_final = 'Y';
			});
			
			$("#update_ids").val(updateable.join(","));
			
			if (flag_final=="") 
			{ 
				flag_final="Y";
			}
			if (flag_final=="Y")
			{	
				frmWBS.submit();				
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
			else if(KEY == "ExportRecord"){
					var str = http_request.responseText;						
					window.open('downloaddata.php?r=wbs-structure', '_blank');
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

<!--<script src="js/jquery.min.js"></script>-->
<script src="js/bootstrap.min.js"></script> 
<script src="js/custom.js" type="text/javascript"></script>
</body>
</html>