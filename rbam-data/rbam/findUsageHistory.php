<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script type="text/javascript" >
var page1="users-administration.php";
var page2="access-management.php";
var page3="assign-app-adminstrator.php";
var page4="current-subscriber.php";
	
$(document).ready(function() 
{													
	/*   $(function() 
	   {
			 var str1 = document.getElementById("h_pagename").value;			
			 if(str1==page1)
			 {
				document.getElementById("div1_for_accessmgmt").style.display = "none";
				document.getElementById("div1_for_assignappAdmin").style.display = "none";
				document.getElementById("div1_for_currentSubscriber").style.display = "none";
			 }
			 else if(str1==page2)
			 {
				document.getElementById("div1_for_useradmin").style.display = "none";//first name
				document.getElementById("div2_for_useradmin").style.display = "none";//last name
				document.getElementById("div1_for_assignappAdmin").style.display = "none";
				document.getElementById("div1_for_currentSubscriber").style.display = "none";
			 }
			 else if(str1==page3)
			 {				
				document.getElementById("div1_for_accessmgmt").style.display = "none";	
				document.getElementById("div1_for_currentSubscriber").style.display = "none";				
			 }
			 else if(str1==page4)
			 {				
				document.getElementById("div1_for_useradmin").style.display = "none";//first name
				document.getElementById("div2_for_useradmin").style.display = "none";//last name
				document.getElementById("div1_for_accessmgmt").style.display = "none";	
				document.getElementById("div1_for_assignappAdmin").style.display = "none";	
			 }
	   });		*/									
});
function makeRequest1(url,data)
{
	   var http_request = false;
	   if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			 http_request = new XMLHttpRequest();
			 if (http_request.overrideMimeType) {
				    http_request.overrideMimeType('text/xml');
				    // See note below about this line
			 }
	   }
	   else if (window.ActiveXObject) { // IE
			 try {
				    http_request = new ActiveXObject("Msxml2.XMLHTTP");
			 }catch(e){
				    try {
						  http_request = new ActiveXObject("Microsoft.XMLHTTP");
				    }catch(e){}
			 }
	   }

	   if (!http_request) {
			 alert('Giving up :( Cannot create an XMLHTTP instance');
			 return false;
	   }
	   http_request.onreadystatechange = function() { alertContents1(http_request); };
	   http_request.open('POST', url, true);
	   http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	   http_request.send(data);
}

function alertContents1(http_request)
{
		if (http_request.readyState == 4)
		{
			if (http_request.status == 200)
			{
				if (KEY == "FindData")
				{
					var s1 = http_request.responseText;
					var s2 = document.getElementById("h_pagename").value;					
					s1 = s1.trim();
					s2 = s2.trim();
					
					document.getElementById("h_query").value=s1;					
					if (s2==page1)
					{
						AdministrationList.submit();
					}
					else if (s2==page2)
					{
						Access_Management.submit();
					}
					else if (s2==page3)
					{
						Form1.submit();
					}
					else if (s2==page4)
					{
						CurrentSubscriberList.submit();
					}
				}
			}
			else
			{
				document.getElementById(KEY).innerHTML = "";
				alert('There was a problem with the request.');
			}
		}
}	
	
	 
function FindData()
{
	   KEY = "FindData";			
	   var str = document.getElementById("Text_FindUserName").value;
	   var str1 = document.getElementById("Text_FindFirstName").value;
	   var str2 = document.getElementById("Text_FindLastName").value;
	   var str3 = document.getElementById("DTPicker_FindStartDate").value;								
	   var str4 = document.getElementById("DTPicker_FindEndDate").value;	
	   var str5 = document.getElementById("h_pagename").value;		
	   var str6 = "";
	   if(str5==page1)
	   {
			 makeRequest1("ajax1.php","REQUEST=FindData&UserName=" +str+"&FirstName="+str1+"&LastName="+str2+"&StartDate="+str3+"&EndDate="+str4+"&PageName="+str5);
	   }
	   else if(str5==page2)
	   {
			str6 = document.getElementById("Combo_FindAppAdmin").value;			
			makeRequest1("ajax1.php","REQUEST=FindData&UserName=" +str+"&AppAdmin="+str6+"&StartDate="+str3+"&EndDate="+str4+"&PageName="+str5);
	   }
	   else if(str5==page3)
	   {
			str6 = document.getElementById("Combo_FindApplication").value;	
			makeRequest1("ajax1.php","REQUEST=FindData&UserName=" +str+"&FirstName="+str1+"&LastName="+str2+"&StartDate="+str3+"&EndDate="+str4+"&PageName="+str5+"&ApplicationId="+str6);
	   }
	   else if(str5==page4)
	   {
			str6 = document.getElementById("Text_FindSubscriber").value;	
			makeRequest1("ajax1.php","REQUEST=FindData&UserName=" +str+"&StartDate="+str3+"&EndDate="+str4+"&PageName="+str5+"&SubscriberName="+str6);
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
	</head>
	
	<body>
		<form  method="post" action="" >
		  <div class="modal fade custom-modal" id="FindUsageHistoryPopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg cus-modal-lg" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <h4 class="modal-title " id="myModalLabel"> Find Users </h4>
				</div>
		  <div class="modal-body">
				<!-- field start-->
			 <div class="col-sm-12">
				<div class="cus-form-cont">
				    <div class="col-sm-3 form-group cus-form-ico">
					   <label> Start Date </label>
					   <input type="text" class="form-control" placeholder="Start Date">
					   <span class="inp-icons"><i class="fa fa-calendar"></i></span>
				    </div>
                        <div class="col-sm-3 form-group cus-form-ico">
                            <label> End Date </label>
                            <input type="text" class="form-control" placeholder="End Date">
                            <span class="inp-icons"><i class="fa fa-calendar"></i></span>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label> First Name </label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label> Last Name </label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label> User Name </label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label> Supervisor </label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col-sm-3 form-group">

                            <!--<button type="button" class="btn btn-primary btn-style2"> <i class="fa fa-search" aria-hidden="true"></i> Find Data</button>-->
                        </div>
				</div>					
			 </div>
				  
				<!-- end -->
				</div>
				<div class="clear-both"></div>
				<div class="modal-footer cr-user">
					<button type="button" id="cmdFindUsers" name="cmdFindUsers" class="btn btn-primary btn-style"><i class="fa fa-search" aria-hidden="true"></i> Find Users </button>
				</div>
			  </div>
			</div>
		  </div>
		</form>
		<!--EDIT modals end -->
		<script type="text/javascript" >
	
		$('#DTPicker_FindStartDate').datepicker(
		{
			//format:'DD,  MM d, yyyy',
			format: 'mm/dd/yyyy',
			defaultDate: '',
			autoclose : true
		});
		$('#DTPicker_FindEndDate').datepicker(
		{
			//format:'DD,  MM d, yyyy',
			format: 'mm/dd/yyyy',
			defaultDate: '',
			autoclose : true
		});
		
	</script>
	</body>
</html>
	
