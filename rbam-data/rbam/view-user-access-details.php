<?php
	//DisplayRecords($abc);
?>
	   
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	
		<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingFour">
					  <h4 class="panel-title"> 
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Time Accounting Modules <i class="fa fa-plus"></i> </a>
								<span class="over-eyecont"> 
									<?php
										$CreatedByName = "";
										$UpdatedByName = "";
									?>
								  <button type="button" id = "btn_heading4" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
									Created By:  <?php  echo $TAMCreatedBy; ?><br>								
									Updated By:  <?php  echo $TAMUpdatedBy; ?><br>
									Creation Date: <?php  echo $TAMCreationDate; ?><br>
									Last Update Date: <?php  echo $TAMLastUpdateDate; ?>"> 
									<i class=" fa fa-eye"></i> 
								  </button>
								</span> 
							  </h4>
							</div>
						
							<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
								<div class="panel-body">
							  <!-- -->
								<div class="col-md-12">
								  <h2 class="f-sec-hd"> Time Accounting Modules </h2>
								</div>
							  
								<div class="col-md-12">
									<div class="data-bx">
									  <div class="table-responsive td-center">
										<table class="table table-bordered" id = "Heading4_Table">
										  <thead>
											<tr>
											  <th width="60%"> Modules </a></th>
											  <th width="10%"> Create Record </th>
											  <th width="10%"> Update </th>
											  <th width="10%"> View </th>
											  <th width="10%"> Enable Audit </th>
											</tr>
										  </thead>
										  <tbody>
											<tr>
											  <td>Time Management Policy<input type="hidden" id="Row1" name="Row1" value="Time Management Policy"></td>
											  <td><input type="checkbox" id="Check_Create1" name="Check_Create1" value="1" <?php if($CreatePriv1 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?> ></td>
											  <td><input type="checkbox" id="Check_Update1" name="Check_Update1" value="1"  <?php if($UpdatePriv1 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?> ></td>
											  <td><input type="checkbox" id="Check_View1" name="Check_View1" value="1"  <?php if($ViewPriv1 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit1" name="Check_Audit1" value="1" <?php if($EnableAudit1 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
										  
											<tr>
											  <td>Holiday Calenders<input type="hidden" id="Row2" name="Row2" value="Holiday Calenders"></td>
											  <td><input type="checkbox" id="Check_Create2" name="Check_Create2" <?php if($CreatePriv2 == "Y"){ ?> checked="checked" <?php } ?> value="1" <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update2" name="Check_Update2" value="1" <?php if($UpdatePriv2 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View2" name="Check_View2" value="1" <?php if($ViewPriv2 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit2" name="Check_Audit2" value="1" <?php if($EnableAudit2 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
										  
											<!--<tr>
											  <td>Work Plans<input type="hidden" id="Row3" name="Row3" value="Work Plans"></td>
											  <td><input type="checkbox" id="Check_Create3" name="Check_Create3" <?php /*if($CreatePriv3 == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
											  <td><input type="checkbox" id="Check_Update3" name="Check_Update3" value="1"<?php if($UpdatePriv3 == "Y"){ ?> checked="checked" <?php } ?> ></td>
											  <td><input type="checkbox" id="Check_View3" name="Check_View3" value="1" <?php if($ViewPriv3 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit3" name="Check_Audit3" value="1" <?php if($EnableAudit3 == "Y"){ ?> checked="checked" <?php } ?>></td>
											</tr>
										  
											<tr>
											  <td>Rotation Plans<input type="hidden" id="Row4" name="Row4" value="Rotation Plans"></td>
											  <td><input type="checkbox" id="Check_Create4" name="Check_Create4" value="1" <?php if($CreatePriv4 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update4" name="Check_Update4" value="1" <?php if($UpdatePriv4 == "Y"){ ?> checked="checked" <?php } ?> ></td>
											  <td><input type="checkbox" id="Check_View4" name="Check_View4" value="1" <?php if($ViewPriv4 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit4" name="Check_Audit4" value="1" <?php if($EnableAudit4 == "Y"){ ?> checked="checked" <?php } ?>></td>
											</tr>
										  
											<tr>
											  <td>RetroAdjustments<input type="hidden" id="Row5" name="Row5" value="RetroAdjustments"></td>
											  <td><input type="checkbox" id="Check_Create5" name="Check_Create5" value="1" <?php if($CreatePriv5 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update5" name="Check_Update5" value="1" <?php if($UpdatePriv5 == "Y"){ ?> checked="checked" <?php } ?> ></td>
											  <td><input type="checkbox" id="Check_View5" name="Check_View5" value="1" <?php if($ViewPriv5 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit5" name="Check_Audit5" value="1" <?php if($EnableAudit5 == "Y"){ ?> checked="checked" <?php } */ ?>></td>
											</tr>-->
										  
											<tr>
											  <td>Time Entry<input type="hidden" id="Row6" name="Row6" value="Time Entry"></td>
											  <td><input type="checkbox" id="Check_Create6" name="Check_Create6"  value="1" <?php if($CreatePriv6 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update6" name="Check_Update6" value="1" <?php if($UpdatePriv6 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View6" name="Check_View6" value="1" <?php if($ViewPriv6 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit6" name="Check_Audit6" value="1" <?php if($EnableAudit6 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
										  
											<tr>
											  <td>Global Aliases<input type="hidden" id="Row7" name="Row7" value="Global Aliases"></td>
											  <td><input type="checkbox" id="Check_Create7" name="Check_Create7"  value="1" <?php if($CreatePriv7 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update7" name="Check_Update7" value="1" <?php if($UpdatePriv7 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View7" name="Check_View7" value="1" <?php if($ViewPriv7 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit7" name="Check_Audit7" value="1" <?php if($EnableAudit7 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
										  
											<!--<tr>
											  <td>PreApproved Time Entry<input type="hidden" id="Row8" name="Row8" value="PreApproved Time Entry"></td>
											  <td><input type="checkbox" id="Check_Create8" name="Check_Create8"  value="1" <?php /*if($CreatePriv8 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update8" name="Check_Update8" value="1" <?php if($UpdatePriv8 == "Y"){ ?> checked="checked" <?php } ?> ></td>
											  <td><input type="checkbox" id="Check_View8" name="Check_View8" value="1" <?php if($ViewPriv8 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit8" name="Check_Audit8" value="1" <?php if($EnableAudit8 == "Y"){ ?> checked="checked" <?php } */ ?>></td>
											</tr>-->
										  
											<tr>
											  <td>Search TimeSheets<input type="hidden" id="Row9" name="Row9" value="Search TimeSheets"></td>
											  <td><input type="checkbox" id="Check_Create9" name="Check_Create9"  value="1" <?php if($CreatePriv9 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update9" name="Check_Update9" value="1" <?php if($UpdatePriv9 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View9" name="Check_View9" value="1" <?php if($ViewPriv9 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit9" name="Check_Audit9" value="1" <?php if($EnableAudit9 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
										  
											<tr>
											  <td>Create Personal Aliases<input type="hidden" id="Row10" name="Row10" value="Create Personal Aliases"></td>
											  <td><input type="checkbox" id="Check_Create10" name="Check_Create10"  value="1" <?php if($CreatePriv10 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update10" name="Check_Update10" value="1" <?php if($UpdatePriv10 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View10" name="Check_View10" value="1" <?php if($ViewPriv10 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit10" name="Check_Audit10" value="1" <?php if($EnableAudit10 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
										  
											<!--<tr>
											  <td>Projects and Programs Access<input type="hidden" id="Row11" name="Row11" value="Projects and Programs Access"></td>
											  <td><input type="checkbox" id="Check_Create11" name="Check_Create11"  value="1" <?php /* if($CreatePriv11 == "Y"){ ?> checked="checked" <?php } ?> ></td>
											  <td><input type="checkbox" id="Check_Update11" name="Check_Update11" value="1" <?php if($UpdatePriv11 == "Y"){ ?> checked="checked" <?php } ?> ></td>
											  <td><input type="checkbox" id="Check_View11" name="Check_View11" value="1" <?php if($ViewPriv11 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit11" name="Check_Audit11" value="1" <?php if($EnableAudit11 == "Y"){ ?> checked="checked" <?php } ?>></td>
											</tr>
										  
											<tr>
											  <td>Time Profile Assignment<input type="hidden" id="Row12" name="Row12" value="Time Profile Assignment"></td>
											  <td><input type="checkbox" id="Check_Create12" name="Check_Create12"  value="1" <?php if($CreatePriv12 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update12" name="Check_Update12" value="1" <?php if($UpdatePriv12 == "Y"){ ?> checked="checked" <?php } ?> ></td>
											  <td><input type="checkbox" id="Check_View12" name="Check_View12" value="1" <?php if($ViewPriv12 == "Y"){ ?> checked="checked" <?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit12" name="Check_Audit12" value="1" <?php if($EnableAudit12 == "Y"){ ?> checked="checked" <?php } */ ?>></td>
											</tr>-->
										  
											<tr>
											  <td>PreApproval Rules<input type="hidden" id="Row13" name="Row13" value="PreApproval Rules"></td>
											  <td><input type="checkbox" id="Check_Create13" name="Check_Create13"  value="1" <?php if($CreatePriv13 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update13" name="Check_Update13" value="1" <?php if($UpdatePriv13 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View13" name="Check_View13" value="1" <?php if($ViewPriv13 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit13" name="Check_Audit13" value="1" <?php if($EnableAudit13 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											
											<tr>
											  <td>Accounting Period<input type="hidden" id="Row14" name="Row14" value="Accounting Period"></td>
											  <td><input type="checkbox" id="Check_Create14" name="Check_Create14"  value="1" <?php if($CreatePriv14 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update14" name="Check_Update14" value="1" <?php if($UpdatePriv14 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View14" name="Check_View14" value="1" <?php if($ViewPriv14 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit14" name="Check_Audit14" value="1" <?php if($EnableAudit14 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											<tr>
											  <td>Site Settings<input type="hidden" id="Row15" name="Row15" value="Site Settings"></td>
											  <td><input type="checkbox" id="Check_Create15" name="Check_Create15"  value="1" <?php if($CreatePriv15 == "Y"){ ?> checked="checked" <?php } ?> disabled="disabled"></td>
											  <td><input type="checkbox" id="Check_Update15" name="Check_Update15" value="1" <?php if($UpdatePriv15 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View15" name="Check_View15" value="1" <?php if($ViewPriv15 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit15" name="Check_Audit15" value="1" <?php if($EnableAudit15 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											<tr>
											  <td>Create Alias<input type="hidden" id="Row16" name="Row16" value="Create Alias"></td>
											  <td><input type="checkbox" id="Check_Create16" name="Check_Create16"  value="1" <?php if($CreatePriv16 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update16" name="Check_Update16" value="1" <?php if($UpdatePriv16 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View16" name="Check_View16" value="1" <?php if($ViewPriv16 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit16" name="Check_Audit16" value="1" <?php if($EnableAudit16 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											<tr>
											  <td>Create WBS<input type="hidden" id="Row17" name="Row17" value="Create WBS"></td>
											  <td><input type="checkbox" id="Check_Create17" name="Check_Create17"  value="1" <?php if($CreatePriv17 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update17" name="Check_Update17" value="1" <?php if($UpdatePriv17 == "Y"){ ?> checked="checked" <?php } ?> ></td>
											  <td><input type="checkbox" id="Check_View17" name="Check_View17" value="1" <?php if($ViewPriv17 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit17" name="Check_Audit17" value="1" <?php if($EnableAudit17 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											<tr>
											  <td>Access Management<input type="hidden" id="Row18" name="Row18" value="Access Management"></td>
											  <td><input type="checkbox" id="Check_Create18" name="Check_Create18"  value="1" <?php if($CreatePriv18 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update18" name="Check_Update18" value="1" <?php if($UpdatePriv18 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View18" name="Check_View18" value="1" <?php if($ViewPriv18 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit18" name="Check_Audit18" value="1" <?php if($EnableAudit18 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											<tr>
											  <td>Subscriber Admin<input type="hidden" id="Row19" name="Row19" value="Subscriber Admin"></td>
											  <td><input type="checkbox" id="Check_Create19" name="Check_Create19"  value="1" <?php if($CreatePriv19 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update19" name="Check_Update19" value="1" <?php if($UpdatePriv19 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View19" name="Check_View19" value="1" <?php if($ViewPriv19 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit19" name="Check_Audit19" value="1" <?php if($EnableAudit19 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											<tr>
											  <td>Billing & Payment<input type="hidden" id="Row20" name="Row20" value="Billing & Payment"></td>
											  <td><input type="checkbox" id="Check_Create20" name="Check_Create20"  value="1" <?php if($CreatePriv20 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update20" name="Check_Update20" value="1" <?php if($UpdatePriv20 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View20" name="Check_View20" value="1" <?php if($ViewPriv20 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit20" name="Check_Audit20" value="1" <?php if($EnableAudit20 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											<tr>
											  <td>View Bill Payment<input type="hidden" id="Row21" name="Row21" value="View Bill Payment"></td>
											  <td><input type="checkbox" id="Check_Create21" name="Check_Create21"  value="1" <?php if($CreatePriv21 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update21" name="Check_Update21" value="1" <?php if($UpdatePriv21 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View21" name="Check_View21" value="1" <?php if($ViewPriv21 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit21" name="Check_Audit21" value="1" <?php if($EnableAudit21 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											<tr>
											  <td>Manage Payment Methods<input type="hidden" id="Row22" name="Row22" value="Manage Payment Methods"></td>
											  <td><input type="checkbox" id="Check_Create22" name="Check_Create22"  value="1" <?php if($CreatePriv22 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Update22" name="Check_Update22" value="1" <?php if($UpdatePriv22 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_View22" name="Check_View22" value="1" <?php if($ViewPriv22 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											  <td><input type="checkbox" id="Check_Audit22" name="Check_Audit22" value="1" <?php if($EnableAudit22 == "Y"){ ?> checked="checked" <?php } ?> <?php if($resource_group_id!='0' && $Text_UserName!=''){ ?>disabled="disabled"<?php } ?>></td>
											</tr>
											
										  </tbody>
										</table>
									  </div>
									</div>
								</div>
							</div>
						</div>
						</div>
					<!-- -->
				  
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingFive">
								<h4 class="panel-title"> 
								  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> Personal Aliases <i class="fa fa-plus"></i> </a>
								  <span class="over-eyecont">
									<?php
											$CreatedByName = "";
											$UpdatedByName = "";
											if($PACreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $PACreatedBy");
											if($PAUpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $PAUpdatedBy");
									?>
									<button type="button" id = "btn_heading5" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
										Created By:  <?php  echo $CreatedByName; ?><br>
										Updated By:  <?php  echo $UpdatedByName; ?><br>
										Creation Date: <?php  echo $PACreationDate; ?> <br>
										Last Update Date: <?php  echo $PALastUpdateDate; ?>">
										<i class=" fa fa-eye"></i> 
									  </button>
								  </span>
								</h4>
							</div>
						
			<div id="collapseFive" class="panel-collapse collapse disable-bg" role="tabpanel" aria-labelledby="headingFive">
				<div class="panel-body">
				<!-- -->
					<div class="col-md-12">
						<div class="data-bx data-bx-center">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
									<tr>
									  <th width="20%"> Alias Name </a></th>
									  <th width="20%"> Description </th>
									  <th width="40%"> Department </th>
									  <th width="20%"> Project WBS </th>
									  <th width="5%"> Active </th>
									</tr>
									</thead>
									<tbody>
									<?php
										$PersonalAliasesRecords="N";
										if($Text_UserName!='')
										{
											
											$i=1;
											$qry = "select * from cxs_am_personal_alias inner join cxs_users on cxs_users.USER_ID = cxs_am_personal_alias.USER_ID where cxs_users.USER_NAME = '$Text_UserName'";
												
											$result = mysql_query($qry);
											$TotalRecords1 = mysql_num_rows($result);
											while($row = mysql_fetch_array($result))
											{
				$PersonalAliasesRecords="Y";
								$Disp_AliasName = $row['ALIAS_NAME'];
								$Disp_Description = $row['DESCRIPTION'];
								$Disp_Department = $row['DEPARTMENT'];
								$Disp_ProjectWBS= $row['WBS_COMBINATION_ID'];
								$Disp_ActiveFlag= $row['ACTIVE_FLAG'];
								$IsChecked = ($Disp_ActiveFlag=="Y"?"checked":"");
															
									?>
									<tr>
									  <td><?php echo $Disp_AliasName; ?> </td>
									  <td> <?php echo $Disp_Description; ?></td>
									  <td> <?php echo $Disp_Department; ?></td>
									  <td> <?php echo $Disp_ProjectWBS; ?></td>														 
									  <td><input type="checkbox" id="Check_Active" name="Check_Active" value="1" <?php echo $IsChecked; ?> disabled></td>
									</tr>
										<!--	<tr>
											  <td><?php echo $Disp_AliasName; ?> </td>
											  <td><input type="text" id="<?php echo "Text_AliasName$i" ?>" name="<?php echo "Text_AliasName$i" ?>" class="form-control" placeholder="  " maxlength="2" disabled="" value = "<?php echo $Disp_AliasName;?>"></td>
											  <td><input type="text" id="Text_Description" name="Text_Description" class="form-control" placeholder="  " maxlength="2" disabled="" value = "<?php echo $Disp_AliasName;?>"></td>
											  <td><input type="text" id="Text_Department" name="Text_Department" class="form-control" placeholder="  " maxlength="2" disabled="" value = "<?php echo $Disp_AliasName;?>"></td>
											  <td><input type="checkbox" id="Check_Active" name="Check_Active" value="" disabled=""></td>
											</tr> -->
											<?php 
													$i=$i+1;
													}
												}	
												if ($PersonalAliasesRecords=="N")
												{
													for($i=1;$i<=5;$i++)
													{
													  echo "<tr>";
													  echo "  <td></td>";
													  echo "<td></td>";
													  echo "<td></td>";
													  echo "<td></td>";								 						 
													  echo '<td><input type="checkbox" id="Check_Active" name="Check_Active" value="1" disabled></td>';
													echo "</tr>";
													}
												}
											?>							
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

				  <!-- -->
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingSix">
								<h4 class="panel-title"> 
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix"> Approval Management <i class="fa fa-plus"></i> </a>
									<span class="over-eyecont">
										<?php
											$CreatedByName="";
											$UpdatedByName="";
												if($AMCreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $AMCreatedBy");
												if($AMUpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $AMUpdatedBy");
											?>
									   <button type="button"  id = "btn_heading6"class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
											Created By:  <?php  echo $CreatedByName; ?><br>
											Updated By:  <?php  echo $UpdatedByName; ?><br>
											Creation Date: <?php  echo $AMCreationDate; ?><br>
											Last Update Date : <?php  echo $AMLastUpdateDate; ?>"> 
										<i class=" fa fa-eye"></i> 
									  </button>
									</span>
								</h4>
							</div>
						
							<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
								<div class="panel-body">
							  <!-- -->
									
								
									<div class="col-md-12 mar-top20">
									  <div class="table-responsive time-acc-bx only-inp-center bder-none">
										<table class="table small-tb" id = "Heading6_Table1">
										  <thead>
											<tr>
											  <th width="60%"> Approver Name </th>
											  <th width="40%"> Approver Type</th>
											</tr>
										  </thead>
										  <tbody>
											<tr id="Row1" name="Row1">
											  <td>									
												<select id="Combo_ApproverName1" name="Combo_ApproverName1" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td>
												<select id="Combo_ApproverType1" name="Combo_ApproverType1" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											</tr>
											
											<tr id="Row2" name="Row2">
											  <td>
												<select id="Combo_ApproverName2" name="Combo_ApproverName2" class="form-control">
												  <option value="">Select</option>									
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td>
												<select id="Combo_ApproverType2" name="Combo_ApproverType2" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											</tr>
											
											<tr id="Row3" name="Row3">
											  <td>
												<select id="Combo_ApproverName3" name="Combo_ApproverName3" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td>
												<select id="Combo_ApproverType3" name="Combo_ApproverType3" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											</tr>
											
											<tr id="Row4" name="Row4">
											  <td>
												<select id="Combo_ApproverName4" name="Combo_ApproverName4" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td>
												<select id="Combo_ApproverType4" name="Combo_ApproverType4" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											</tr>
											
											<tr id="Row5" name="Row5">
											  <td>
												<select id="Combo_ApproverName5" name="Combo_ApproverName5" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td>
												<select id="Combo_ApproverType5" name="Combo_ApproverType5" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											</tr>
										  </tbody>
										</table>
									  </div>
									</div>
								
									<div class="col-md-12 mar-btm20">
									  <div class="row">
										<div class="checkbox col-md-6 col-sm-6">
										  <label><input type="checkbox" id="Check_ApproveDirectReport" name="Check_ApproveDirectReport" <?php if($ApproveDirectReport == "Y"){ ?> checked="checked" <?php } ?> value="1">Approve Direct Report of Other Approvers </label>
										</div>
									  
										<div class="checkbox col-md-6 col-sm-6 ">
										  <label><input type="checkbox" id="Check_UpadteApprovedTimesheet" name="Check_UpadteApprovedTimesheet" <?php if($UpadteApprovedTimesheet == "Y"){ ?> checked="checked" <?php } ?> value="1">Allow Update to Approved TimeSheet </label>
										</div>
									  
										<!--<div class="checkbox col-md-6 col-sm-6 ">
										  <label><input type="checkbox" id="Check_FlyApprovalRequest" name="Check_FlyApprovalRequest" <?php /*if($FlyApprovalRequest == "Y"){ ?> checked="checked" <?php }*/ ?> value="1">Allow on the fly Approval Request </label>
										</div>
									  
										<div class="checkbox col-md-6 col-sm-6 ">
										  <label><input type="checkbox" id="Check_ProjectBasedApproval" name="Check_ProjectBasedApproval" <?php /*if($ProjectBasedApproval == "Y"){ ?> checked="checked" <?php }*/ ?> value="1" disabled>Project Based Approval Only </label>
										</div>-->
									  </div>
									</div>
							  
									<div class="col-md-12 ">
									  <h2 class="f-sec-hd mar-top20"> Temporary Approver </h2>
									  <div class="form-horizontal mar-top20">
										<div class="form-group">
										  <label for="inputEmail3" class="col-sm-2 control-label">Name </label>
										  <div class="col-sm-8">
											<input type="text" class="form-control" id="Text_TempApproverName" name="Text_TempApproverName" placeholder="" maxlength="40">
										  </div>
										</div>
									  </div>
									
									  <div class="table-responsive time-acc-bx only-inp-center mar-top20 bder-none">
										<table class="table small-tb" id="Heading6_Table2">
										  <thead>
											<tr>
											  <th width="50%"> Period ID </th>
											  <th width="10%"></th>
											  <!--<th width="20%"> Alias Name </th>-->
											  <th width="20%" class="text-center"> Active Flag </th>
											</tr>
										  </thead>
										  <tbody>
											<tr id="TempAppRow1" name="TempAppRow1">
											  <td>
												<select id="Combo_PeriodId1" name="Combo_PeriodId1" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td></td>
											  <!--<td>
												<select id="Combo_AliasName1" name="Combo_AliasName1" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>-->
											  <td class="centr"><input type="checkbox" id="Check_ActiveFlag1" name="Check_ActiveFlag1" value="1"></td>
											</tr>
										  
											<tr id="TempAppRow2" name="TempAppRow2">
											  <td>
												<select id="Combo_PeriodId2" name="Combo_PeriodId2" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td></td>
											  <!--<td>
												<select id="Combo_AliasName2" name="Combo_AliasName2" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>-->
											  <td class="centr"><input type="checkbox" id="Check_ActiveFlag2" name="Check_ActiveFlag2" value="1"></td>
											</tr>
										  
											<tr id="TempAppRow3" name="TempAppRow3">
											  <td>
												<select id="Combo_PeriodId3" name="Combo_PeriodId3" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td></td>
											  <!--<td>
												<select id="Combo_AliasName3" name="Combo_AliasName3" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>-->
											  <td class="centr"><input type="checkbox" id="Check_ActiveFlag3" name="Check_ActiveFlag3" value="1"></td>
											</tr>
										  
											<tr id="TempAppRow4" name="TempAppRow4">
											  <td>
												<select id="Combo_PeriodId4" name="Combo_PeriodId4" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td></td>
											  <!--<td>
												<select id="Combo_AliasName4" name="Combo_AliasName4" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>-->
											  <td class="centr"><input type="checkbox" id="Check_ActiveFlag4" name="Check_ActiveFlag4" value="1"></td>
											</tr>
										  
											<tr id="TempAppRow5" name="TempAppRow5">
											  <td>
												<select id="Combo_PeriodId5" name="Combo_PeriodId5" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td></td>
											  <!--<td>
												<select id="Combo_AliasName5" name="Combo_AliasName5" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>-->
											  <td class="centr"><input type="checkbox" id="Check_ActiveFlag5" name="Check_ActiveFlag5" value="1"></td>
											</tr>
										  
											<tr id="TempAppRow6" name="TempAppRow6">
											  <td>
												<select id="Combo_PeriodId6" name="Combo_PeriodId6" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>
											  <td></td>
											  <!--<td>
												<select id="Combo_AliasName6" name="Combo_AliasName6" class="form-control">
												  <option value="">Select</option>
												  <option value="1">Option 1</option>
												  <option value="2">Option 2</option>
												</select>
											  </td>-->
											  <td class="centr"><input type="checkbox" id="Check_ActiveFlag6" name="Check_ActiveFlag6" value="1"></td>
											</tr>
										  </tbody>
										</table>
									  </div>
									</div>
								</div>
							</div>
						</div>
						
					</div>			
			