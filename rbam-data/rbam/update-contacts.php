<?php ob_start ();
session_start();
include("conn.php");
check_login();

$VIEW_SLA_permission = getRoleAccessStatusByUser('VIEW_SLA',$_SESSION['user_id']);
?>
<?php

	if(isset($_SESSION['addr_msg'])){ $addr_msg=$_SESSION['addr_msg'];	$_SESSION['addr_msg']=""; }else{ $addr_msg=""; }
	$LoginUserId = $_SESSION['user_id'];
	$PageName = "update-contacts.php";
	$sort =  isset( $_GET['sort'] )? $_GET['sort']:'asc';
	$OrderBY = "";
	$FieldName = "";
	
	$OrderBY = "asc";
	$FieldName = "ADDRESS_RESOURCE_ID";
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

	if(isset($_GET["page"]))
	{
		$page  = $_GET["page"];
	}
	else
	{
		$page=1;
	}
	$start_from = ($page-1) *  $record_per_page;
	
	if(isset($_POST['valid_new_address']) && $_POST['valid_new_address']=='Y')
	{
		$insArr =[];
		
		$insArr['ADDRESS1'] = $_POST['ADDRESS1'];
		$insArr['ADDRESS2'] = $_POST['ADDRESS2'];
		$insArr['ADDRESS3'] = $_POST['ADDRESS3'];
		$insArr['CITY'] = $_POST['CITY'];
		$insArr['POSTAL_CODE'] = $_POST['POSTAL_CODE'];
		$insArr['STATE'] = $_POST['STATE'];
		$insArr['COUNTRY'] = $_POST['COUNTRY'];
		
		$PRIMARY_FLAG='';
		$ACTIVE_FLAG='';
		
		if(isset($_POST['PRIMARY_FLAG'])){	$PRIMARY_FLAG = 'Y';	}
		if(isset($_POST['ACTIVE_FLAG'])){	$ACTIVE_FLAG = 'Y';	}
		
		$insArr['PRIMARY_FLAG']= $PRIMARY_FLAG;
		$insArr['ACTIVE_FLAG']= $ACTIVE_FLAG;
		
		$insArr['CREATION_DATE']= date('Y-m-d H:i:s') ;
		
		insertdata("cxs_resource_address",$insArr);
		
		$_SESSION['addr_msg']='<div class="alert alert-success"><i class="icon-ok"></i> Records inserted successfully.</div>';
	   
		header('Location:update-contacts.php');
		
	}
	
	
	if($IsUpdate =='Y' && $_POST['update_ids']!='' && $_POST['update_ids']!='')
	{
		
		$ids = explode(",",$_POST['update_ids']);
	   
		//$ADD_RES_ID = $_POST['WBS_ID'];
	   
		foreach($ids as $id)
		{
			$ADDRESS1 = trim($_POST['ADDRESS1_'.$id]);
			$ADDRESS2 = trim($_POST['ADDRESS2_'.$id]);
			$ADDRESS3 = trim($_POST['ADDRESS3_'.$id]);
			
			$CITY = trim($_POST['CITY_'.$id]);
			$POSTAL_CODE = trim($_POST['POSTAL_CODE_'.$id]);
			$STATE = trim($_POST['STATE_'.$id]);
			$COUNTRY = trim($_POST['COUNTRY_'.$id]);
			
			
			if(isset($_POST['PRIMARY_FLAG_'.$id])){	$PRIMARY_FLAG = 'Y';	}else{	$PRIMARY_FLAG='N';	}
			if(isset($_POST['ACTIVE_FLAG_'.$id])){	$ACTIVE_FLAG = 'Y';	}else{	$ACTIVE_FLAG='N';	}
			
						
			
			$updArr['ADDRESS1']=trim($ADDRESS1);
			$updArr['ADDRESS2']=trim($ADDRESS2);
			$updArr['ADDRESS3']=trim($ADDRESS3);
			
			$updArr['CITY']=trim($CITY);
			$updArr['POSTAL_CODE']=trim($POSTAL_CODE);
			$updArr['STATE']=trim($STATE);
			$updArr['COUNTRY']=trim($COUNTRY);
			
			$updArr['PRIMARY_FLAG']=trim($PRIMARY_FLAG);
			$updArr['ACTIVE_FLAG']=trim($ACTIVE_FLAG);
			
			
			
			updatedata("cxs_resource_address",$updArr," where ADDRESS_RESOURCE_ID = $id");
			
			$_SESSION['addr_msg']='<div class="alert alert-success"><i class="icon-ok"></i> Records updated successfully.</div>';
		}
		if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!='')
		{
			header('Location:update-contacts.php?'.$_SERVER['QUERY_STRING']);
		}
		else
		{
			 header('Location:update-contacts.php');
		}
	   
	}
?>
<script type="text/javascript" >
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "Update Contacts";		
		var s2 = "<?php echo $PageName; ?>";				
		makeRequest("ajax.php","REQUEST=FavoritesList&FeatureName=" +s1+"&PageName="+s2);
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<style>
	.not-valid-tip{ color: #ff0000; }
	.col-sm-3.ss {
    width: auto;
}
</style>
</head>

<body>
    <!-- modals start -->
    <form method="POST" id="frmNewAddress">
    <div id="address" class="modal fade bs-example-modal-lg custom-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg cus-modal-lg" role="document">
		
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"> Add New Addresses </h4>
                </div>
                <div class="modal-body">
                    <!-- field start-->
				<input type="hidden" id="valid_new_address" name="valid_new_address" value="">
                    <div class="col-sm-12">
                        <div class="cus-form-cont">
                            <div class="col-sm-3 form-group">
                                <label> Address 1  </label>
                                <input type="text" class="form-control" placeholder="" maxlength="15" id="ADDRESS1" name="ADDRESS1">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label> Address 2  </label>
                                <input type="text" class="form-control" placeholder="" maxlength="50" id="ADDRESS2" name="ADDRESS2">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> Address 3  </label>
                                <input type="text" class="form-control" placeholder="" maxlength="50" id="ADDRESS3" name="ADDRESS3">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> City   </label>
                                <input type="text" class="form-control" placeholder="" maxlength="200" id="CITY" name="CITY">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> Zip   </label>
                                <input type="text" class="form-control" placeholder="" maxlength="15" id="POSTAL_CODE" name="POSTAL_CODE">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> State   </label>
                                <input type="text" class="form-control" placeholder="" maxlength="15" id="STATE" name="STATE">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> Country   </label>
                                <input type="text" class="form-control" placeholder="" maxlength="40" id="COUNTRY" name="COUNTRY">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico ss">
                                <label> Primary  </label>
                                <input type="checkbox" class="form-control" placeholder="" maxlength="1" id="PRIMARY_FLAG" name="PRIMARY_FLAG">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico ss">
                                <label> Active   </label>
                                <input type="checkbox" class="form-control" placeholder="" maxlength="1" id="ACTIVE_FLAG" name="ACTIVE_FLAG">
                            </div>
                        </div>
                    </div>
				
                </div>
                <!-- end -->
            </div>
		  
            <div class="clear-both"></div>
            <div class="modal-footer cr-user">
                <button type="button" class="btn btn-primary btn-style" onclick="createNewAddress();"> Add </button>

            </div>
		

        </div>
    </div>
	</form>

    <div id="contact" class="modal fade bs-example-modal-lg custom-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg cus-modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id=""> Add New Contacts </h4>
                </div>
                <div class="modal-body">
                    <!-- field start-->
                    <div class="col-sm-12">
                        <div class="cus-form-cont">

                            <div class="col-sm-3 form-group">
                                <label> First Name  </label>
                                <input type="text" class="form-control" placeholder="" maxlength="15">
                            </div>
                            <div class="col-sm-3 form-group">
                                <label>  Last Name  </label>
                                <input type="text" class="form-control" placeholder="" maxlength="50">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label>  Phone   </label>
                                <input type="text" class="form-control" placeholder="" maxlength="50">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> Email   </label>
                                <input type="text" class="form-control" placeholder="" maxlength="200">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> Phone Type   </label>
                                <input type="text" class="form-control" placeholder="" maxlength="40">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> Title   </label>
                                <input type="text" class="form-control" placeholder="" maxlength="15">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> Primary   </label>
                                <input type="text" class="form-control" placeholder="" maxlength="1">
                            </div>
                            <div class="col-sm-3 form-group cus-form-ico">
                                <label> Active  </label>
                                <input type="text" class="form-control" placeholder="" maxlength="1">
                            </div>


                            <!-- <div class="col-sm-6 form-group cus-form-ico">
                  <label> End Date </label>
                  <input type="text" class="form-control" placeholder=""  maxlength="40">
                  <span class="inp-icons"><i class="fa fa-calendar"></i></span>
                </div> -->

                        </div>
                    </div>
                </div>
                <!-- end -->
            </div>
            <div class="clear-both"></div>
            <div class="modal-footer cr-user">
                <button type="button" class="btn btn-primary btn-style"> Add </button>

            </div>


        </div>
    </div>


    <!-- modals end -->
    
	<?php include("header.php"); ?>
	
    <section class="md-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="brd-crmb">
                    <ul>
                        <li> <a href="#"> Billing & Payment </a></li>
                        <li> <a href="#"> Update Contacts  </a></li>
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
						<a type="button" id="cmdViewSLA" name="cmdViewSLA" class="btn btn-primary btn-style2" <?php if($VIEW_SLA_permission=='Y'){ ?>href="test.pdf"<?php }else{ ?>disabled="disabled"<?php } ?> target="_blank">View SLA</a>
                    </div>
                </div>

                <div class="cont-box ">
                    <!-- detail-head -->
                    <div class="pge-hd">
                        <h2 class="sec-title"> Update Contacts </h2>
                    </div>
                    <div class="data-bx">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="check-bx"> <input type="checkbox" id="inlineCheckbox1" value="option1"> </th>
                                        <th> Customer Number
                                            <a href="#" class="sort-bx"> <i class="fa fa-sort"></i></a>
                                        </th>
                                        <th> Customer Name
                                            <a href="#" class="sort-bx"> <i class="fa fa-sort"></i></a>
                                        </th>
                                        <th> Inception Date
                                            <a href="#" class="sort-bx"> <i class="fa fa-sort"></i></a>
                                        </th>
                                        <th> Number of subscribers
                                            <a href="#" class="sort-bx"> <i class="fa fa-sort"></i></a>
                                        </th>
                                        <th> Plan </th>
                                        <th> Channel (Buy oy Try) </th>
                                        <th> Last Update Date </th>
                                        <th> Last Updated BY </th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="check-bx"> <input type="checkbox" id="" value="option1"> </td>
                                        <td>Dummy Text</td>
                                        <td>Dummy Text </td>
                                        <td>Dummy Text </td>
                                        <td>Dummy Text </td>
                                        <td>Dummy Text</td>
                                        <td>Dummy Text</td>
                                        <td>Dummy Text </td>
                                        <td>Dummy Text </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="pge-hd">
                        <h2 class="sec-title"> Addresses </h2>
                    </div>
				<div class="row">
				    <h4 class="text-center" id="addr_msg_section"><?php echo $addr_msg; ?></h4>
				    </div>
                    <div class="fleft two">
					<button type="button" class="btn-style btn" id="cmdUpdateSelected" name="cmdUpdateSelected" onclick='EditRecord();'> Update selected </button>
                        <button type="button" class="btn-style btn" id="cmdExport" name="cmdExport" onclick='ExportRecord();' <?php echo $ViewButtonStyle; ?> > Export </button>
				    <button type="button" class="btn-style btn" id="cmdCancel" name="cmdCancel" disabled="disabled"> Cancel </button>
                    </div>

                    <div class="fright cr-user">
                        <!-- <button type="button" class="btn btn-primary btn-style" data-toggle="modal" data-target=".bs-example-modal-lg" id="address"> Create New </button> -->

                        <a href="#address" class="btn btn-primary btn-style" data-toggle="modal" onclick="clearForm();"> Create New </a>
                    </div>
				
          <div class="data-bx">
			<div class="table-responsive">
				<form action="" method="post" id="frmAddressUpd" name="frmAddressUpd">
				<table class="table table-bordered mar-cont" id="AddressTable">
				<thead>
					<tr>
						<td class="check-bx " width="5%"> <input type="checkbox" id="Checkbox_SelectAll" onchange="checkAll(this)"> </td>
                              <th width="15%"> Address 1 </th>
                              <th width="15%"> Address 2 </th>
                              <th width="15%"> Address 3 </th>
                              <th width="12%">
							<?php if($Sorts == 'desc' && $FileName == 'CITY') { ?>
							<span style="">
								City
							<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('CITY','asc');"></i>
							</span>
							<?php } else { ?>
							<span style="">
								City 
							<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('CITY','desc');"></i>
							</span>
						<?php } ?>
						</th>
                              <th width="10%"> Zip </th>
                              <th width="12%"> State </th>
                              <th width="11%"> Country </th>
                              <th width="5%"> Primary </th>
                              <th width="5%"> Active </th>
                         </tr>
                    </thead>
                    <tbody>
				<?php
					$qry_addr = "select * from cxs_resource_address $s_Query  $SQueryOrderBy";
					
					$selectQueryForPages  = $qry_addr;
					$qry_addr = $qry_addr." limit $start_from , $record_per_page";
					$result_addr=mysql_query	($qry_addr);
					$TotalRecords_addr = mysql_num_rows($result_addr);
				
					if($TotalRecords_addr>0)
					{
						while($row_addr=mysql_fetch_object($result_addr))
						{
							?>
                         <tr ondblclick="TableRowFunction('<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>')">
                              <td class="check-bx ">
							<input id="ADDRESS_RESOURCE_ID_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" name="ADDRESS_RESOURCE_ID_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" value="<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" type="checkbox" onchange="checkInline()" class="record_chk"> </td>
						<td>
                                   <div class="form-group">
								<span id="disp_ADDRESS1_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>"><?php echo $row_addr->ADDRESS1; ?></span>
								<span id="edit_ADDRESS1_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" style="display: none;"><input id="ADDRESS1_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" name="ADDRESS1_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" value="<?php echo $row_addr->ADDRESS1; ?>" class="form-control" placeholder="ADDRESS1" maxlength="15" type="text"></span>
                                   </div>
                              </td>
                              <td>
                                   <div class="form-group">
								<span id="disp_ADDRESS2_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>"><?php echo $row_addr->ADDRESS2; ?></span>
                                        <span id="edit_ADDRESS2_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" style="display: none;"><input id="ADDRESS2_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" value="<?php echo $row_addr->ADDRESS2; ?>" name="ADDRESS2_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" class="form-control" placeholder="" maxlength="50" type="text"></span>
                                   </div>
                              </td>
                              <td>
                                   <div class="form-group">
								<span id="disp_ADDRESS3_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>"><?php echo $row_addr->ADDRESS3; ?></span>
                                        <span id="edit_ADDRESS3_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" style="display: none;"><input id="ADDRESS3_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" name="ADDRESS3_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" class="form-control" placeholder="" maxlength="50" type="text" value="<?php echo $row_addr->ADDRESS3; ?>"></span>
                                   </div>
                              </td>
                                        
						<td>
                                   <div class="form-group">
								<span id="disp_CITY_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>"><?php echo $row_addr->CITY; ?></span>
								<span id="edit_CITY_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" style="display: none;"><input id="CITY_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" name="CITY_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" class="form-control" placeholder="" maxlength="200" type="text" value="<?php echo $row_addr->CITY; ?>"></span>
							</div>
                              </td>
                              <td>
                                            <div class="form-group">
									<span id="disp_POSTAL_CODE_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>"><?php echo $row_addr->POSTAL_CODE; ?></span>
                                             <span id="edit_POSTAL_CODE_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" style="display: none;"><input id="POSTAL_CODE_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" name="POSTAL_CODE_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" class="form-control" placeholder="POSTAL_CODE" maxlength="15" type="text" value="<?php echo $row_addr->POSTAL_CODE; ?>"></span>
                                            </div>
                                        </td>
								<td>
                                            <div class="form-group">
									<span id="disp_STATE_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>"><?php echo $row_addr->STATE; ?></span>
                                             <span id="edit_STATE_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" style="display: none;"><input id="STATE_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" name="STATE_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" class="form-control" placeholder="" maxlength="40" type="text" value="<?php echo $row_addr->STATE; ?>"></span>
                                            </div>
                                        </td>
								<td>
                                            <div class="form-group">
										<span id="disp_COUNTRY_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>"><?php echo $row_addr->COUNTRY; ?></span>
                                                <span id="edit_COUNTRY_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" style="display: none;"><input id="COUNTRY_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" name="COUNTRY_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" class="form-control" placeholder="COUNTRY" maxlength="15" type="text" value="<?php echo $row_addr->COUNTRY; ?>"></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
										<span id="disp_PRIMARY_FLAG_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>"><?php if($row_addr->PRIMARY_FLAG=='Y'){ echo "Yes"; }else{ echo "No"; } ?></span>
                                                <span id="edit_PRIMARY_FLAG_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" style="display: none;"><input id="PRIMARY_FLAG_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" name="PRIMARY_FLAG_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" class="form-control" type="checkbox" <?php if($row_addr->PRIMARY_FLAG=='Y'){ ?>checked="checked"<?php } ?>></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <span id="disp_ACTIVE_FLAG_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>"><?php if($row_addr->ACTIVE_FLAG=='Y'){ echo "Yes"; }else{ echo "No"; } ?></span>
                                                <span id="edit_ACTIVE_FLAG_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" style="display: none;"><input id="ACTIVE_FLAG_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" name="ACTIVE_FLAG_<?php echo $row_addr->ADDRESS_RESOURCE_ID; ?>" class="form-control" type="checkbox" <?php if($row_addr->ACTIVE_FLAG=='Y'){ ?>checked="checked"<?php } ?>></span>
                                            </div>
                                        </td>

                                    </tr>
							 <?php }
								}
								else{ ?>
								<tr><td colspan="10">No record found.</td></tr>
									
							<?php }
							 ?>

                                </tbody>
                            </table>
				
						<input type="hidden" id="h_field_name" name="h_field_name" value="<?php echo $FileName; ?>">
						<input type="hidden" id="h_field_order" name="h_field_order" value="<?php echo $Sorts; ?>">
						<input type="hidden" id="h_field_update" name="h_field_update" value="">
						<input type="hidden" id="h_NumRows" name="h_NumRows" value="0"/>		
						<input type="hidden" id="h_query" name="h_query" value=""/>
						<input type="hidden" id="h_pagename" name="h_pagename" value="<?php echo $PageName; ?>"/>
						<input type="hidden" id="update_ids" name="update_ids" value=""/>
					</form>
                        </div>
                        <div class="fright cr-user mar-top-20pxs">
                            <button type="button" class="btn btn-primary btn-style"> Save Record </button>
                        </div>
                        <!-- pagination -->
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
                    </div>
                    <div class="clear-both"></div>

                    <div class="pge-hd">
                        <h2 class="sec-title"> Contacts </h2>
                    </div>
                    <div class="fleft two">
                        <button type="button" class="btn-style btn"> Update selected </button>
                        <button type="button" class="btn-style btn"> Export </button>

                    </div>
                    <div class="fright cr-user">
                        <a href="#contact" type="button" class="btn btn-primary btn-style" data-toggle="modal"> Create New </a>
                    </div>

                    <div class="data-bx">
                        <div class="table-responsive">
                            <table class="table table-bordered mar-cont">
                                <thead>
                                    <tr>
                                        <td class="check-bx " width="5%"> <input id="" value="option1" type="checkbox"> </td>
                                        <th width="15%">First Name</th>
                                        <th width="12%">Last Name</th>
                                        <th width="10%">Phone</th>
                                        <th width="10%">Email</th>
                                        <th width="12%">Phone Type</th>
                                        <th width="15%">Title</th>
                                        <th width="10%">Primary</th>
                                        <th width="15%">Active</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="check-bx "> <input id="" value="option1" type="checkbox"> </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="" maxlength="15" type="text">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="" maxlength="50" type="text">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="" maxlength="50" type="text">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="" maxlength="200" type="text">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="" maxlength="40" type="text">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="" maxlength="15" type="text">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="" maxlength="1" type="text">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="" maxlength="1" type="text">
                                            </div>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                        <div class="fright cr-user mar-top-20pxs">
                            <button type="button" class="btn btn-primary btn-style"> Save Record </button>
                        </div>

                        <!-- pagination -->
                        <div class="pagination-bx">
                            <div class="bs-example">
                                <ul class="pagination">
                                    <li><a href="#">«</a></li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li><a href="#">»</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <div class="app-detail-bx modif2 ">
                            <div class="col-sm-6">
                                <h3> Remit to Address :</h3>
                                <div> 41593 <br> WICHNESTER ROAD <br> TEMECULA CA,92590.
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h3> Account Executive</h3>
                                <div> Name: Ruchir Vaishnav <br> Phone :858.945.8003 <br> Email:ruchir.vaishnav@coexsys.com
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
</section>
<!--<script src="js/jquery.min.js"></script>-->
<script type="text/javascript">
$(document).ready(function()
{
	setTimeout(function(){
			 if ($("#addr_msg_section").html().length > 0) {
				    $("#addr_msg_section").empty();
			 }
	}, 12000);
	
	$('.record_chk').change(function() {
		if(!$(this).is(":checked")) {
			deactivateEditForm($(this).val());
		}
		if ($('.record_chk:checked').length == 0){
			document.getElementById("cmdUpdateSelected").innerHTML = "Update selected";
			$("#cmdExport").attr('disabled',false);
								
			$("#cmdCancel").attr('disabled',true);
			flag_checked="N";
		}
	});
});
function clearForm()
{
	$("#ADDRESS1").val('');
	$("#ADDRESS1").attr('disabled',false);
					
	$("#ADDRESS2").val('');
	$("#ADDRESS2").attr('disabled',false);
					
	$("#ADDRESS3").val('');
	$("#ADDRESS3").attr('disabled',false);
					
	$("#CITY").val('');
	$("#CITY").attr('disabled',false);
					
	$("#STATE").val('');
	$("#STATE").attr('disabled',false);
					
	$("#COUNTRY").val('');
	$("#COUNTRY").attr('disabled',false);
					
	$("#POSTAL_CODE").val('');
	$("#POSTAL_CODE").attr('disabled',false);
					
	$("#PRIMARY_FLAG").prop('checked', false);
	$("#PRIMARY_FLAG").attr('disabled',false);
					
	$("#ACTIVE_FLAG").prop('checked', false);
	$("#ACTIVE_FLAG").attr('disabled',false);
	
	$("#address").find('#myModalLabel').text('Add New Addresses');
		
	$("#address").find('.modal-footer').show();
}
function TableRowFunction(res_addr_id)
{
	if (document.getElementById("cmdUpdateSelected").innerHTML!="Save")
	{	
		KEY= "SingleAddress";
		$("#address").find('#myModalLabel').text('Address Detail');
		
		$("#address").find('.modal-footer').hide();
		//$("#cmdCreateUser").hide();
		
		//$("#crtFrmPswRules").hide();
		//$("#new_psw_err_tooltip").empty();
			
		$('#address').modal();		
		var str = res_addr_id;		
		makeRequest("ajax.php","REQUEST=ResourceAddressRecord&res_addr_id=" + str);
	}
}
function deactivateEditForm(id)
{
	$("#disp_ADDRESS1_"+id).css("display", "block");
	$("#edit_ADDRESS1_"+id).css("display", "none");
			
	$("#disp_ADDRESS2_"+id).css("display", "block");
	$("#edit_ADDRESS2_"+id).css("display", "none");
			
	$("#disp_ADDRESS3_"+id).css("display", "block");
	$("#edit_ADDRESS3_"+id).css("display", "none");
	
	$("#disp_CITY_"+id).css("display", "block");
	$("#edit_CITY_"+id).css("display", "none");
	
	$("#disp_POSTAL_CODE_"+id).css("display", "block");
	$("#edit_POSTAL_CODE_"+id).css("display", "none");
	
	$("#disp_STATE_"+id).css("display", "block");
	$("#edit_STATE_"+id).css("display", "none");
	
	$("#disp_COUNTRY_"+id).css("display", "block");
	$("#edit_COUNTRY_"+id).css("display", "none");
	
			
	$("#disp_PRIMARY_FLAG_"+id).css("display", "block");
	$("#edit_PRIMARY_FLAG_"+id).css("display", "none");
			
	$("#disp_ACTIVE_FLAG_"+id).css("display", "block");
	$("#edit_ACTIVE_FLAG_"+id).css("display", "none");
}
function activateEditForm(id)
{
	$("#disp_ADDRESS1_"+id).css("display", "none");
	$("#edit_ADDRESS1_"+id).css("display", "block");
			
	$("#disp_ADDRESS2_"+id).css("display", "none");
	$("#edit_ADDRESS2_"+id).css("display", "block");
			
	$("#disp_ADDRESS3_"+id).css("display", "none");
	$("#edit_ADDRESS3_"+id).css("display", "block");
	
	$("#disp_CITY_"+id).css("display", "none");
	$("#edit_CITY_"+id).css("display", "block");
	
	$("#disp_POSTAL_CODE_"+id).css("display", "none");
	$("#edit_POSTAL_CODE_"+id).css("display", "block");
	
	$("#disp_STATE_"+id).css("display", "none");
	$("#edit_STATE_"+id).css("display", "block");
	
	$("#disp_COUNTRY_"+id).css("display", "none");
	$("#edit_COUNTRY_"+id).css("display", "block");
	
			
	$("#disp_PRIMARY_FLAG_"+id).css("display", "none");
	$("#edit_PRIMARY_FLAG_"+id).css("display", "block");
			
	$("#disp_ACTIVE_FLAG_"+id).css("display", "none");
	$("#edit_ACTIVE_FLAG_"+id).css("display", "block");
}
function DataSort(str1,str2)
{
	var str3;
	document.getElementById('h_field_name').value = str1;
	document.getElementById('h_field_order').value = str2;
	frmAddressUpd.submit();
}
function SearchData()
{
	document.getElementById('h_field_name').value = '';
	document.getElementById('h_field_order').value = '';
	frmAddressUpd.submit();
}
$("#POSTAL_CODE").keypress(function(e){ 
	   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
	   }
});
$("#cmdCancel").click(function() {
	$('.record_chk').each(function () {
				
		$(this).prop('checked',false);
		
		deactivateEditForm($(this).val());
				
	});
			 
	if ($("#cmdUpdateSelected").text() == 'Save'){
		$("#cmdUpdateSelected").text('Update selected');
		$("#cmdExport").attr('disabled',false);
					 
		$("#Checkbox_SelectAll").prop('checked' , false);
		//$("#Checkbox_SelectAll").attr('disabled',false);
			 
		$("#cmdCancel").attr('disabled',true);
	}
});

function createNewAddress()
{
	var flag_final = 'Y';
				
	if ($("#ADDRESS1").val()=='') {
		form_element_correct($("#ADDRESS1"));
		form_element_empty_err($("#ADDRESS1"));
		flag_final = "N";
	}
	else{
		form_element_correct($("#ADDRESS1"));
	}
	if ($("#ADDRESS2").val()=='') {
		form_element_correct($("#ADDRESS2"));
		form_element_empty_err($("#ADDRESS2"));
		flag_final = "N";
	}
	else{
		form_element_correct($("#ADDRESS2"));
	}
	if ($("#ADDRESS3").val()=='') {
		form_element_correct($("#ADDRESS3"));
		form_element_empty_err($("#ADDRESS3"));
		flag_final = "N";
	}
	else{
		form_element_correct($("#ADDRESS3"));
	}
	if ($("#CITY").val()=='') {
		form_element_correct($("#CITY"));
		form_element_empty_err($("#CITY"));
		flag_final = "N";
	}
	else{
		form_element_correct($("#CITY"));
	}
	if ($("#POSTAL_CODE").val()=='') {
		form_element_correct($("#POSTAL_CODE"));
		form_element_empty_err($("#POSTAL_CODE"));
		flag_final = "N";
	}
	else{
		form_element_correct($("#POSTAL_CODE"));
	}
	if ($("#STATE").val()=='') {
		form_element_correct($("#STATE"));
		form_element_empty_err($("#STATE"));
		flag_final = "N";
	}
	else{
		form_element_correct($("#STATE"));
	}
	if ($("#COUNTRY").val()=='') {
		form_element_correct($("#COUNTRY"));
		form_element_empty_err($("#COUNTRY"));
		flag_final = "N";
	}
	else{
		form_element_correct($("#COUNTRY"));
	}
	
	if (flag_final == 'Y') {
		$("#valid_new_address").val('Y');
		$("#frmNewAddress").submit();
	}
}
	/////////////////
function checkAll(ele)
{	
	
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
					
					deactivateEditForm($(this).val());
			 
					/*if($("#disp_word_name_"+$(this).val()).css('display') == 'none')
					{
						$("#disp_word_name_"+$(this).val()).css("display", "block");
						$("#edit_word_name_"+$(this).val()).css("display", "none");
						$("#edit_word_name_"+$(this).val()).val($("#disp_word_name_"+$(this).val()).text());
						$("#edit_word_name_"+$(this).val()).next('span').remove();
					}
					if($("#disp_active_flag_"+$(this).val()).css('display') == 'none')
					{
						$("#disp_active_flag_"+$(this).val()).css("display", "block");
						$("#edit_active_flag_"+$(this).val()).css("display", "none");
					}*/
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
	var counter = document.getElementById("AddressTable").rows.length;
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
			makeRequest("ajax.php","REQUEST=ExportResourceAddress&qry=" + qry+"&sortby="+qry1);
		}
	else
	{
		alert("Please Select Records For Export");
		//document.getElementById("selectall").focus();
	}
}
function EditRecord()
{	
	var i,j;
	var counter = document.getElementById("AddressTable").rows.length;
	var flag_updaterecord;
	var OriginalContent;
	var flag_checked="";
	counter = counter-1; // heading not count
	//document.getElementById("h_NumRows").value = counter;
	var ButtonCaption = document.getElementById("cmdUpdateSelected").innerHTML;

	if (ButtonCaption != "Save")
	{
		$.each($(".record_chk:checked"), function(){            
			
			activateEditForm($(this).val());
						
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
					
		$.each($(".record_chk:checked"),function(){
							
							
			if ($("#ADDRESS1_"+$(this).val()).val()=='') {
				form_element_correct($("#ADDRESS1_"+$(this).val()));
				form_element_empty_err($("#ADDRESS1_"+$(this).val()));
				flag_final = "N";
			}
			else
			{
				form_element_correct($("#ADDRESS1_"+$(this).val()));
			}
			
			if ($("#ADDRESS2_"+$(this).val()).val()=='') {
				form_element_correct($("#ADDRESS2_"+$(this).val()));
				form_element_empty_err($("#ADDRESS2_"+$(this).val()));
				flag_final = "N";
			}
			else
			{
				form_element_correct($("#ADDRESS2_"+$(this).val()));
			}
			
			if ($("#ADDRESS3_"+$(this).val()).val()=='') {
				
				form_element_correct($("#ADDRESS3_"+$(this).val()));
				form_element_empty_err($("#ADDRESS3_"+$(this).val()));
				flag_final = "N";
			}
			else
			{
				form_element_correct($("#ADDRESS3_"+$(this).val()));
			}
			
			if ($("#CITY_"+$(this).val()).val()=='') {
				form_element_correct($("#CITY_"+$(this).val()));
				form_element_empty_err($("#CITY_"+$(this).val()));
				flag_final = "N";
			}
			else
			{
				form_element_correct($("#CITY_"+$(this).val()));
			}
			
			if ($("#STATE_"+$(this).val()).val()=='') {
				form_element_correct($("#STATE_"+$(this).val()));
				form_element_empty_err($("#STATE_"+$(this).val()));
				flag_final = "N";
			}
			else
			{
				form_element_correct($("#STATE_"+$(this).val()));
			}
			
			if ($("#COUNTRY_"+$(this).val()).val()=='') {
				form_element_correct($("#COUNTRY_"+$(this).val()));
				form_element_empty_err($("#COUNTRY_"+$(this).val()));
				flag_final = "N";
			}
			else
			{
				form_element_correct($("#COUNTRY_"+$(this).val()));
			}
			
			updateable.push($(this).val());
		});
		
		$("#update_ids").val(updateable.join(","));
			
		if (flag_final=="") 
		{ 
			flag_final="Y";
		}
		if (flag_final=="Y")
		{
			frmAddressUpd.submit();				
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
				else if (KEY == "SingleAddress")
				{
					var str = "";
					var n = 0;
					
					str = http_request.responseText;
					n = str.indexOf("|");
					
					var arr = str.split('|');
					
					$("#ADDRESS1").val(arr[0]);
					$("#ADDRESS1").attr('disabled',true);
					form_element_correct($("#ADDRESS1"));
					
					$("#ADDRESS2").val(arr[1]);
					$("#ADDRESS2").attr('disabled',true);
					form_element_correct($("#ADDRESS2"));
					
					$("#ADDRESS3").val(arr[2]);
					$("#ADDRESS3").attr('disabled',true);
					form_element_correct($("#ADDRESS3"));
					
					$("#CITY").val(arr[3]);
					$("#CITY").attr('disabled',true);
					form_element_correct($("#CITY"));
					
					$("#STATE").val(arr[4]);
					$("#STATE").attr('disabled',true);
					form_element_correct($("#STATE"));
					
					$("#COUNTRY").val(arr[5]);
					$("#COUNTRY").attr('disabled',true);
					form_element_correct($("#COUNTRY"));
					
					$("#POSTAL_CODE").val(arr[6]);
					$("#POSTAL_CODE").attr('disabled',true);
					form_element_correct($("#POSTAL_CODE"));
					
					
					if(arr[7]=='Y')
					{
						$("#PRIMARY_FLAG").prop('checked', true);
					}
					$("#PRIMARY_FLAG").attr('disabled',true);
					
					if(arr[8]=='Y')
					{
						$("#ACTIVE_FLAG").prop('checked', true);
					}
					$("#ACTIVE_FLAG").attr('disabled',true);
					
				}
			}
			else
			{
				document.getElementById(KEY).innerHTML = "";
				alert('There was a problem with the request.');
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
/*
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
					window.open('downloaddata.php?r=resource-address', '_blank');
					//window.location.href = "downloaddata.php?r=user-administration","target='_blank'";					
				}
			}
			else
			{
				document.getElementById(KEY).innerHTML = "";
				alert('There was a problem with the request.');
			}
	   }
}	*/
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

    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>