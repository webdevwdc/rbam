<?php //ob_start ();
//	include("conn.php");
$LoginUserId = $_SESSION['user_id'];
?>

	<header>
		<div class="top-nav-bx">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        <div class="logo">
                            <a href="index.php"> <img src="img/logo.jpg"> </a>
                            <span class="ac-manage"> Access Management</span>
                        </div>
                    </div>
                    <div class="col-sm-9 col-md-9">
                        <ul class="top-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn-warning cont-supp" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-phone"></i> <span class="sm-hide"> Contact Support </span> <b class="fa fa-angle-down"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"> Chat Now </a></li>
                                    <li><a href="#"> Schedule a Call </a></li>
                                    <li><a href="#"> Send Message </a></li>
                                    <li><a href="#"> Call 858-945-8003 </a></li>
                                    <li><a href="#"> Open a Service request  </a></li>
                                </ul>
                            </li>
                            <li class="dropdown" >
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-star"></i> <span class="sm-hide"> Favorites   </span> <b class="fa fa-angle-down"></b></a>
                                <ul class="dropdown-menu" id = "favorite_list" name = "favorite_list">
									<?php										
										$qry = "select * from cxs_users_favorites where USER_ID = $LoginUserId AND MODULE_NAME = '$ModuleName' order by FEATURE_NAME";
										$result=mysql_query	($qry);
									//	$TotalRecords = mysql_num_rows($result);										
										while($rows = mysql_fetch_array($result))
										{
											$FEATURE_NAME = $rows['FEATURE_NAME'];
											$PAGE_NAME = $rows['PAGE_NAME'];
									?>
                                          <li><a href="<?php echo $PAGE_NAME; ?>"> <?php echo $FEATURE_NAME; ?></a></li>                              
								<?php } ?>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-question-circle"></i> <span class="sm-hide"> Help </span><b class="fa fa-angle-down"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"> Option 1 </a></li>
                                    <li><a href="#"> Option 2 </a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle user-box" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <img class="pro-img-bx" src="<?php echo getProfileImg($_SESSION['user_id']); ?>"/><span class="name-bx2"> User Name </span><b class="fa fa-angle-down"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:uploadProfilePhotoModal();"> Upload Photo </a></li>
                                    <li><a href="logout.php"> Logout </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>		
        <!-- navigation  -->
        <nav class="navbar navbar-default custom-navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only"> Toggle navigation </span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav custom-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Users and Roles <span class="caret"></span></a>
                            <ul class="dropdown-menu">
				<?php
				$VIEW_PRIV_ss_PERMISSION = getTimeAccountingModuleStatusByUser('VIEW_PRIV','Site Settings',$_SESSION['user_id']);
				?>
                              <li><a <?php if($VIEW_PRIV_ss_PERMISSION=='Y'){ ?>href="site-settings.php"<?php }else{ ?>style="color: #e9e9e9; background-color: #ffffff;"<?php } ?>> Site Settings</a></li>
						<li><a href="users-administration.php"> User Administration </a></li>
						<li><a href="aliases.php"> Create Alias </a></li>
						<?php
				$CREATE_PRIV_wbs_PERMISSION = getTimeAccountingModuleStatusByUser('CREATE_PRIV','Create WBS',$_SESSION['user_id']);
				$UPDATE_PRIV_wbs_PERMISSION = getTimeAccountingModuleStatusByUser('UPDATE_PRIV','Create WBS',$_SESSION['user_id']);
				$VIEW_PRIV_wbs_PERMISSION = getTimeAccountingModuleStatusByUser('VIEW_PRIV','Create WBS',$_SESSION['user_id']);
				$ENABLE_AUDIT_wbs_PERMISSION = getTimeAccountingModuleStatusByUser('ENABLE_AUDIT','Create WBS',$_SESSION['user_id']);
				$WBS_page_visibility = false;
				if($CREATE_PRIV_wbs_PERMISSION=='Y' || $UPDATE_PRIV_wbs_PERMISSION=='Y' || $VIEW_PRIV_wbs_PERMISSION=='Y' || $ENABLE_AUDIT_wbs_PERMISSION=='Y')
				{
					$WBS_page_visibility = true;
				}
			  ?>
						<li><a <?php if($WBS_page_visibility==true){ ?>href="workbreakdown-structure.php"<?php }else{ ?>style="color: #e9e9e9; background-color: #ffffff;"<?php } ?>> Create WBS </a></li>
						<li><a href="access-management.php"> Access Management </a></li>								
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Subscriber Administration <span class="caret"></span></a>
                            <ul class="dropdown-menu">
						<?php
						$VIEW_SUBSCRIBERS_permission = getRoleAccessStatusByUser('VIEW_SUBSCRIBERS',$_SESSION['user_id']);
						$USAGE_HISTORY_permission = getRoleAccessStatusByUser('USAGE_HISTORY',$_SESSION['user_id']);
						?>
                                <li><a <?php if($VIEW_SUBSCRIBERS_permission=='Y'){ ?>href="current-subscriber.php"<?php }else{ ?>style="color: #e9e9e9; background-color: #ffffff;"<?php } ?>>Current Subscribers</a></li>
						  
						  
                                <li><a <?php if($USAGE_HISTORY_permission=='Y'){ ?>href="usage-history.php"<?php }else{ ?>style="color: #e9e9e9; background-color: #ffffff;"<?php } ?>> Usage History </a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Billing & Payments <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li> <a href="update-contacts.php"> Update Contacts</a> </li>
                                <li>
                                    <a href="view-bill-payment.php"> View Bill Payment </a>
                                </li>
                                <li> <a href="payment-information.php"> Manage Payment Methods</a> </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>
	   
    </header>
    <!--Upload Photo modals start -->
	   
		<div class="modal fade custom-modal" id = "ModalUploadPhoto" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg cus-modal-lg" role="document" style="width: 525px;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title " id="myModalLabel"> Upload Photo </h4>
					</div>
					<div class="modal-body">
						<form id="cropimage" method="post" enctype="multipart/form-data" action="change-profile-img.php">
							<div class="col-sm-12">
								
 Upload your image <input type="file" name="photoimg" id="photoimg" />
 <input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="<?php echo $_SESSION['user_id']; ?>" />
							</div>
							<div class="col-sm-12" id="previewProfileImg" style="display: none;">
								<img id="imgProfilePreview" src="#">
							</div>
							<div class="col-sm-12">
 <div id='preview-avatar-profile' style="max-width: 250px;"></div>
 <div id="thumbs" style="padding:5px; width:600p"></div>
							</div>
							<div class="col-sm-12" id="img-upl-msg"></div>
						</form>
					</div>
					<div class="clear-both"></div>
					<div class="modal-footer cr-user">
						  
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" id="btn-crop" class="btn btn-primary">Save</button>
					</div>
				</div>
			</div>
		</div>
	
    <!--Upload Photo modals end -->
<script>
function uploadProfilePhotoModal()
{
	
	$("#photoimg").val('');
	$("#preview-avatar-profile").html('');
	$("#previewProfileImg").css("display", "none");
	$('#imgProfilePreview').attr('src', '#');
	$('#ModalUploadPhoto').modal();
}
function readURL(input) {
	
	$("#previewProfileImg").css("display", "none");
	$("#preview-avatar-profile").html('');
	$('#imgProfilePreview').attr('src', '#');
	
	var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
	
	
	
	if (input.files && input.files[0]) {
	
		if($.inArray(input.files[0]["type"], ValidImageTypes) < 0)
		{
			$("#preview-avatar-profile").html('<span style="color:red">Please upload an image file.</span>');
			$("#btn-crop").attr('disabled','disabled');
		}
		else
		{
			var reader = new FileReader();

			reader.onload = function(e) {
				var image = new Image();
				image.src = e.target.result;
				image.onload = function () {
					var height = this.height;
					var width = this.width;
					//alert(this.type);
					if (height > 450 || width > 450) {
						$("#preview-avatar-profile").html('<span style="color:red">Height and Width must not exceed 450px.</span>');
						$("#btn-crop").attr('disabled','disabled');
						//return false;
					}
					else
					{
						$("#previewProfileImg").css("display", "block");
						$('#imgProfilePreview').attr('src', e.target.result);
						$("#btn-crop").removeAttr('disabled');
					}
			     };
			}
		
			reader.readAsDataURL(input.files[0]);
		}
	}
}
$("#photoimg").change(function() {
  readURL(this);
});
/*$('#photoimg').change( function(){*/
jQuery('#btn-crop').on('click', function(e){
	
	if ($("#photoimg").val()=='') {
		$("#preview-avatar-profile").html('<span style="color:red">Please upload an image.</span>');
	}
	else
	{
		
		var form_data = new FormData();
		var ins = document.getElementById('photoimg').files.length;
		for (var x = 0; x < ins; x++) {
			form_data.append("photoimg", document.getElementById('photoimg').files[x]);
		}
		var csrf_token = $("input[name=_token]").val();
    
    
		var hdn_profile_id = $('#hdn-profile-id').val();
    
		form_data.append("hdn-profile-id", hdn_profile_id);
    
		jQuery.ajax({
			url: 'change-profile-img.php', // point to server-side PHP script 
			dataType: 'text', // what to expect back from the PHP script
			cache: false,
			contentType: false,
			processData: false,
			async: false,
			data: form_data,
			type: 'POST',
			success: function (response) {
				var res = response.split('|');
				$('.pro-img-bx').attr('src',res[1]);
				$("#preview-avatar-profile").html('<span style="color:green">Profile image updated successfully.</span>');
			
				setTimeout(function(){
					$('#ModalUploadPhoto').modal('toggle');
				}, 2000);            
			},
			error: function (response) {
			    //$('#fileMsg').html(response); // display error response from the PHP script
			}
			//return filePath;
		});
	}
	/*$("#preview-avatar-profile").html('');
	$("#preview-avatar-profile").html('Uploading....');
	$("#img-upl-msg").text('');
	$("#cropimage").ajaxForm(
	{
		target: '#preview-avatar-profile',
		success:    function(data) {
		
			alert(data);
			$("#img-upl-msg").html('Image updated successfully.');
	    }
	}).submit();
	*/
});
</script>