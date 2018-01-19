<?php ob_start();
session_start();
include("conn.php");
check_login();
?>
<?php
	$LoginUserId = 1;
	$PageName = "view-bill-payment.php";
	
	$sort =  isset( $_GET['sort'] )? $_GET['sort']:'desc';
	$OrderBY = "";
	$FieldName = "";
	
	$OrderBY = "asc";
	$FieldName = "USER_NAMES";
	$Sorts = "";
	$Sorts = isset( $_POST['h_field_order'] )? $_POST['h_field_order']: $sort;
	$FileName = isset( $_POST['h_field_name'] )? $_POST['h_field_name']: $FieldName;
	//$IsUpdate = isset( $_POST['h_field_update'] )? $_POST['h_field_update']: "";
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
?>
<script type="text/javascript" >
	function DataSort(str1,str2)
	{
		var str3;
		document.getElementById('h_field_name').value = str1;
		document.getElementById('h_field_order').value = str2;
		BillPaymentList.submit();
	}
	function SearchData()
	{
		document.getElementById('h_field_name').value = '';
		document.getElementById('h_field_order').value = '';
		BillPaymentList.submit();
	}
	
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "View Bill Payment";		
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
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    
	<?php include("header.php"); ?>
	
    <section class="md-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="brd-crmb">
                    <ul>
                        <li> <a href="#"> Billing & Payment </a></li>
                        <li> <a href="#"> View Bill Payment </a></li>
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
                    </div>
                </div>

                <div class="cont-box">
                    <div class="pge-hd mar-btn20">
                        <h2 class="sec-title"> Current Payment Due </h2>
                    </div>
                    
					<div class="tble-btm">
                        <div class="data-bx data-bx2">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="12%">
										<?php if($Sorts == 'desc' && $FileName == 'VIEW_BILL') { ?>
												<span style="">
													View Bill
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('VIEW_BILL','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													View Bill
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('VIEW_BILL','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="13%">
										<?php if($Sorts == 'desc' && $FileName == 'Billing_Period') { ?>
												<span style="">
													Billing Period
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Billing_Period','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Billing Period
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Billing_Period','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="26%">
										<?php if($Sorts == 'desc' && $FileName == 'Subscriber_Billed') { ?>
												<span style="">
													Number of Subscribers Billed
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Subscriber_Billed','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Number of Subscribers Billed
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Subscriber_Billed','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="11%">
										<?php if($Sorts == 'desc' && $FileName == 'Amount') { ?>
												<span style="">
													Amount
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Amount','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Amount
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Amount','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="10%">
										<?php if($Sorts == 'desc' && $FileName == 'Due_Date') { ?>
												<span style="">
													Due Date
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Due_Date','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Due Date
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Due_Date','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="8%">
										<?php if($Sorts == 'desc' && $FileName == 'Status') { ?>
												<span style="">
													Status
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Status','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Status
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Status','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="20%">
										<?php if($Sorts == 'desc' && $FileName == 'Payment_Information') { ?>
												<span style="">
													Payment Information
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Payment_Information','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Payment Information
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Payment_Information','desc');"></i>
												</span>
										<?php } ?>
											</th>
                                                                                   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> As of 2/2017 </td>
                                            <td> Feb-17 </td>
                                            <td>100</td>
                                            <td> 999999999 </td>
                                            <td> 2/28/2017 </td>
                                            <td> Paid </td>
                                            <td> Chase </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="fleft cr-user">
                            <button type="button" class="btn btn-primary btn-style" data-toggle="modal" data-target=".bs-example-modal-lg"> Pay Now </button>
                        </div>
                    </div>
                    <!-- section -->
                    <div class="sep-res"></div>
                    <div class="pge-hd mar-btn20">
                        <h2 class="sec-title"> Payment History </h2>
                    </div>
                    <div>
                    <form class="form" id="BillPaymentList" name="BillPaymentList" action="" method="POST">
						<div class="data-bx data-bx2">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="12%">
										<?php if($Sorts == 'desc' && $FileName == 'VIEW_BILL') { ?>
												<span style="">
													View Bill
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('VIEW_BILL','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													View Bill
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('VIEW_BILL','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="13%">
										<?php if($Sorts == 'desc' && $FileName == 'Billing_Period') { ?>
												<span style="">
													Billing Period
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Billing_Period','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Billing Period
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Billing_Period','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="26%">
										<?php if($Sorts == 'desc' && $FileName == 'Subscriber_Billed') { ?>
												<span style="">
													Number of Subscribers Billed
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Subscriber_Billed','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Number of Subscribers Billed
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Subscriber_Billed','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="11%">
												Amount
											</th>
											
											<th width="10%">
										<?php if($Sorts == 'desc' && $FileName == 'Due_Date') { ?>
												<span style="">
													Due Date
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Due_Date','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Due Date
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Due_Date','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="8%">
										<?php if($Sorts == 'desc' && $FileName == 'Status') { ?>
												<span style="">
													Status
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Status','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Status
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Status','desc');"></i>
												</span>
										<?php } ?>
											</th>
											
											<th width="20%">
										<?php if($Sorts == 'desc' && $FileName == 'Payment_Information') { ?>
												<span style="">
													Payment Information
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Payment_Information','asc');"></i>
												</span>
										<?php } else { ?>
												<span style="">
													Payment Information
													<i style="cursor:pointer;" class="fa fa-sort pull-right" onclick="DataSort('Payment_Information','desc');"></i>
												</span>
										<?php } ?>
											</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
										$selectQuery = "SELECT  1  $SQueryOrderBy";
										$selectQueryForPages  = $selectQuery;
										$selectQuery = $selectQuery." limit $start_from , $record_per_page";
										//$RunUserQuery=mysql_query($selectQuery);
										//$StdNumRows = mysql_num_rows($RunUserQuery);
										$i= 1;
									
										//while($rows=mysql_fetch_array($RunUserQuery))
										{
												
										
										
										
										?>
										<tr>
                                            <td> <?php echo "As of 2/2017"; ?> </td>
                                            <td> <?php echo "Feb-17"; ?> </td>
                                            <td> <?php echo "100"; ?> </td>
                                            <td> <?php echo "999999999"; ?> </td>
                                            <td> <?php echo "2/28/2017"; ?> </td>
                                            <td> <?php echo "Paid"; ?> </td>
                                            <td> <?php echo "Chase"; ?> </td>
                                        </tr>
								<?php  	
										$i=$i+1;
										} 
								?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- pagination start-->
                        <div class="pagination-bx">
                            <div class="bs-example">
                                <ul class="pagination">
									<?php
									//$RunDepQuery=mysql_query($selectQueryForPages);
									//$num_records = mysql_num_rows($RunDepQuery);
									//$total_pages= ceil($num_records/$record_per_page);
									
									if (($page-1)==0){ ?>
										<li class="disabled">
											<a rel="0" href="#">&laquo;</a>
										</li>
							<?php  	} else { ?>
										<li class="">
											<a rel="0" href="?type=<?php echo $GetType;?>&page=<?php echo ($page-1); ?>&sort=<?php echo $Sorts; ?>">&laquo;</a>
										</li>
							<?php 	}
									for($i=1;$i<=$total_pages;$i++){ ?>
										<li class="<?php echo ($page==$i)?'active':''; ?>"><a class="<?php echo ($page==$i)?'current':''; ?>" style = "<?php if($page==$i){echo 'background-color: #337ab7';} ?>" href="?type=<?php echo $GetType;?>&page=<?php echo $i;?>&sort=<?php echo $Sorts; ?>"><?php echo $i; ?></a></li>
							<?php 	}
									if (($page+1)>$total_pages){   ?>
										<li class="disabled"><a href="#">&raquo;</a></li>
							<?php  	} else { ?>
										<li class=""><a href="?type=<?php echo $GetType;?>&page=<?php echo ($page+1); ?>&sort=<?php echo $Sorts; ?>">&raquo;</a></li>
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

    <footer>

    </footer>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>