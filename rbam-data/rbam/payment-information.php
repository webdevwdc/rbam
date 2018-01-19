<?php ob_start();
session_start();
include("conn.php");
check_login();
?>
<?php
	$LoginUserId = 1;
	$PageName = "payment-information.php";
?>
<script type="text/javascript" >
	function CheckFavoriteData()
	{	
		KEY = "CheckFavoriteData";			
		var s1 = "Payment Information";		
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
                        <li> <a href="#"> Payment Information  </a></li>
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
                <!--   -->

                <!-- search -->
                <div class="search-bx">
                    <div class="cus-form-cont">
                        <div class="pge-hd">
                            <h2 class="sec-title"> Payment Information </h2>

                        </div>
                        <div class="fright cr-user checkbox">

                            <label>
                  <input type="checkbox"> Default </label>

                        </div>
                        <div class="clear-both"></div>


                        <div class="col-sm-3 form-group ">
                            <label> Card Holder </label>
                            <input type="text" class="form-control" placeholder="Card Holder" maxlength="100">
                        </div>
                        <div class="col-sm-3 form-group ">
                            <label> Type </label>
                            <select class="form-control">
              <option> Visa</option>
            </select>
                        </div>
                        <div class="col-sm-3 form-group ">
                            <label> Card Number </label>
                            <input type="text" class="form-control" placeholder="Card Number" maxlength="20">
                        </div>
                        <div class="col-sm-3 form-group cus-form-ico">
                            <label> Expiry Date </label>
                            <input type="text" class="form-control" placeholder="Expiry Date">
                            <span class="inp-icons"><i class="fa fa-calendar"></i></span>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label> Security Code </label>
                            <input type="text" class="form-control" placeholder="Security Code" maxlength="4">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label> Alias </label>
                            <input type="text" class="form-control" placeholder="Alias" maxlength="20">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label> Pay Every Month </label>
                            <select class="form-control">
              <option> 1 </option>
              <option> 2 </option>
              <option> 3 </option>
              <option> 4 </option>
              <option> 5 </option>
            </select>
                        </div>

                        <div class="col-sm-3 form-group">

                            <button type="button" class="btn btn-primary btn-style2"> Save </button>
                        </div>
                    </div>
                </div>
                <!-- search end -->

                <div class="cont-box">
                    <div class="pge-hd">
                    </div>
                    <h2 class="sec-title"> Other Payment Method on File </h2>
                    <div>

                        <div class="data-bx">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="15%"> Card Holder </th>
                                            <th width="15%"> Card Type </th>
                                            <th width="15%"> Card Number </th>
                                            <th width="15%"> Expiry Date </th>
                                            <th width="15%"> Nick Name </th>
                                            <th width="15%"> Auto Play </th>
                                            <th width="8%"> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> <button type="button" class="btn btn-primary btn-style2 small-btn"> Delete </button> </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> <button type="button" class="btn btn-primary btn-style2 small-btn"> Delete </button> </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> <button type="button" class="btn btn-primary btn-style2 small-btn"> Delete </button> </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> <button type="button" class="btn btn-primary btn-style2 small-btn"> Delete </button> </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> <button type="button" class="btn btn-primary btn-style2 small-btn"> Delete </button> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- pagination start-->
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
                        <!-- pagination end -->
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