<?php
	//DisplayRecords($abc);
?>
	   
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	
	<div class="panel panel-default">						
		<div class="panel-heading" role="tab" id="headingOne">
			<span id="myspan"> </span>
			<h4 class="panel-title"> 
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> User Administration <i class="fa fa-plus"></i> </a> 
				<span class="over-eyecont">
				<?php										
					$CreatedByName = "";
					$UpdatedByName = "";
					if($CreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $CreatedBy");
					if($UpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $UpdatedBy");
				?>
				  <button type="button" id = "btn_heading1" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover"  data-html="true"  data-placement="left" data-content="Created By:  <?php  echo $CreatedByName; ?><br>Updated By:  <?php  echo $UpdatedByName; ?><br>Creation Date: <?php  echo $CreationDate; ?><br>Last Update Date: <?php  echo $LastUpdateDate; ?>"> <i class=" fa fa-eye"></i> </button>
				</span> 
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">
								<!--  -->
				<div class="col-md-12"><h2 class="f-sec-hd"> User Administration </h2></div>
				<div class="col-md-12">
					  <div class="row">
						<div class="checkbox col-md-3">
						  <label><input type="checkbox" id="Check_CreateUser" name="Check_CreateUser" <?php if($CreateUser == "Y"){ ?> checked="checked" <?php } ?>  value="1">Create New Users </label>
						</div>
											
						<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_ViewOnly" name="Check_ViewOnly" <?php if($ViewOnly == "Y"){ ?> checked="checked" <?php } ?> value="1">View Only </label>
						</div>
										
						<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_UpdateOnly" name="Check_UpdateOnly" <?php if($UpdateOnly == "Y"){ ?> checked="checked" <?php } ?> value="1">Update Only </label>
						</div>
					  </div>
				</div>
									<!-- -->
				<div class="col-md-12"><h2 class="f-sec-hd"> Billing Administration </h2></div>
				<div class="col-md-12">
					  <div class="row">
						<div class="checkbox col-md-3">
						  <label><input type="checkbox" id="Check_ViewSubscribers" name="Check_ViewSubscribers" <?php if($ViewSubscribers == "Y"){ ?> checked="checked" <?php } ?> value="1">View Subscribers </label>
						</div>
											
						<div class="checkbox col-md-3">
						  <label><input type="checkbox" id="Check_SubmitCustomization" name="Check_SubmitCustomization" <?php if($SubmitCustom == "Y"){ ?> checked="checked" <?php } ?> value="1">Open Support Requests </label>
						</div>
											
						<!--<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_AllowChat" name="Check_AllowChat" <?php /*if($AllowChat == "Y"){ ?> checked="checked" <?php }*/ ?> value="1">Allow Chat </label>
						</div>-->
											
						<div class="checkbox col-md-3">
							  <label><input type="checkbox" id="Check_ViewSLA" name="Check_ViewSLA" <?php if($ViewSLA == "Y"){ ?> checked="checked" <?php } ?> value="1">View SLA </label>
						</div>
											
						<div class="checkbox col-md-3">
						  <label><input type="checkbox" id="Check_ExistUserAdmin" name="Check_ExistUserAdmin" <?php if($ExistUserAdmin == "Y"){ ?> checked="checked" <?php } ?> value="1">Existing User Admin </label>
						</div>
											
						<!--<div class="checkbox col-md-3">
						  <label><input type="checkbox" id="Check_RemoveAccess" name="Check_RemoveAccess" <?php /*if($RemoveAccess == "Y"){ ?> checked="checked" <?php }*/ ?> value="1">Remove Access </label>
						</div>-->
											
						<div class="checkbox col-md-4">
						  <label><input type="checkbox" id="Check_UsageHistory" name="Check_UsageHistory" <?php if($UsageHistory == "Y"){ ?> checked="checked" <?php } ?> value="1">Usage History </label>
						</div>
					  </div>
					</div>
				</div>
				</div>
			</div>
					  <!-- -->
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title"> 
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Time Accounting Rules <i class="fa fa-plus"></i></a>
						<span class="over-eyecont">
						<?php
							$CreatedByName = "";
							$UpdatedByName = "";
							if($CreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $CreatedBy");
							if($UpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $UpdatedBy");
							
						?>
						  <button type="button" id = "btn_heading2"  class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="Created By:  <?php  echo $CreatedByName; ?><br>Updated By:  <?php  echo $UpdatedByName; ?><br>Creation Date: <?php  echo $CreationDate; ?><br>Last Update Date: <?php  echo $LastUpdateDate; ?> "> 
							<i class=" fa fa-eye"></i> 
						  </button>
						</span>
					</h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
						<div class="col-md-12">
							  <h2 class="f-sec-hd"> Time Accounting Rules </h2>
						</div>
						<div class="col-md-12">
						  <div class="data-bx">
							<div class="table-responsive time-acc-bx ">
							  <table class="table table-bordered">
							<thead>
							  <tr>
								<th width="90%"> Prefrences </th>
								<th width="10%"> User </th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td> Enable Business Messages </td>
								<td><input type="checkbox" id="Check_BusinessMessage" name="Check_BusinessMessage" <?php if($BusinessMessage == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
							  </tr>
											  
							  <tr>
								<td> Set Audit On </td>
								<td><input type="checkbox" id="Check_SetAudit" name="Check_SetAudit" <?php if($SetAudit == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
							  </tr>
											  
							  <!--<tr>
								<td> Allow Timekeeping </td>
								<td><input type="checkbox" id="Check_AllowTimekeeping" name="Check_AllowTimekeeping" <?php /*if($AllowTimekeeping == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
							  </tr>
											  
							  <tr>
								<td> Use Timezone from Projects </td>
								<td><input type="checkbox" id="Check_TimezoneProjects" name="Check_TimezoneProjects" <?php if($TimezoneProjects == "Y"){ ?> checked="checked" <?php } ?> value="1" disabled></td>
							  </tr>
										  
							  <tr>
								<td> Default Timezone </td>
								<td>
								  <select id="Combo_DefaultTimezone" name="Combo_DefaultTimezone" class="form-control">
									<option value="Option 1"></option>								  </select>
								</td>
							  </tr>

							  <tr>
								<td> Default Date Format </td>
								<td>
								  <select id="Combo_DefaultDateFormat" name="Combo_DefaultDateFormat" value="<?php echo $DefaultDateFormat; ?>" class="form-control">
									<option value="mm/dd/yyyy">mm/dd/yyyy</option>
									<option value="dd/mm/yyyy">dd/mm/yyyy</option>
									<option value="yyyy/mm/dd">yyyy/mm/dd</option>
								  </select>
								</td>
							  </tr>
									  
							  <tr>
								<td> Enable Project Accounting </td>
								<td><input type="checkbox" id="Check_ProjectAccounting" name="Check_ProjectAccounting" <?php if($ProjectAccounting == "Y"){ ?> checked="checked" <?php }*/ ?>  value="1" disabled></td>
							  </tr>-->
										  
							  <tr>
								<td> Allow Negative Time Entry </td>
								<td><input type="checkbox" id="Check_AllowNegativeTimeEntry" name="Check_AllowNegativeTimeEntry" <?php if($AllowNegativeTimeEntry == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
							  </tr>
										  
							  <tr>
								<td> Enforce Advance Approval for Overtime </td>
								<td><input type="checkbox" id="Check_AdvanceForOvertime" name="Check_AdvanceForOvertime" <?php if($AdvanceForOvertime == "Y"){ ?> checked="checked" <?php } ?> value="1" ></td>
							  </tr>
										  
							  <tr>
								<td> Update Hours on Submitted Time </td>
								<td><input type="checkbox" id="Check_SubmittedTime" name="Check_SubmittedTime" <?php if($SubmittedTime == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
							  </tr>
										  
										  <tr>
											<td> Override Primary Approver </td>
											<td><input type="checkbox" id="Check_PrimaryApprover" name="Check_PrimaryApprover" <?php if($PrimaryApprover == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
										  </tr>
										  
										  <tr>
											<td> Number of Recent Timecards to Display </td>
											<td><input type="text" id="Text_RecentTimecards" name="Text_RecentTimecards" class="form-control" value="<?php echo $RecentTimecards; ?>" placeholder="" maxlength="2" onkeypress="return onlyNos(event,this);"></td>
										  </tr>
											  
										  <tr>
											<td> Allow RetroAdjustments </td>
											<td><input type="checkbox" id="Check_RetroAdjustments" name="Check_RetroAdjustments" <?php if($RetroAdjustments == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
										  </tr>
											  
										  <tr>
											<td> Maximum Daily Limit </td>
											<td><input type="text" id="Text_MaxDailyLimit" name="Text_MaxDailyLimit" class="form-control" value="<?php echo ($MaxDailyLimit=="")?"24":$MaxDailyLimit; ?>" placeholder="" maxlength="2" onkeypress="return onlyNos(event,this);"></td>
										  </tr>
											  
										  <tr>
											<td> Enter Time in Future Pay Period </td>
											<td><input type="checkbox" id="Check_FlexibleTimeEntry" name="Check_FlexibleTimeEntry" <?php if($FlexibleTimeEntry == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
										  </tr>
											  
										  <!--<tr>
											<td> Enforce Time Entry for Optional Project WBS Segments </td>
											<td><input type="checkbox" id="Check_EnforceTimeEntry" name="Check_EnforceTimeEntry" <?php /*if($EnforceTimeEntry == "Y"){ ?> checked="checked" <?php }*/ ?> value="1" disabled></td>
										  </tr>-->
											  
										  <!--<tr>
											<td> Create Employee Aliases </td>
											<td><input type="checkbox" id="Check_EmployeeAliases" name="Check_EmployeeAliases" <?php /*if($EmployeeAliases == "Y"){ ?> checked="checked" <?php }*/ ?> value="1"></td>
										  </tr>-->
										  
										  <tr>
											<td> Number of Periods allow for Retro Updates </td>
											<td><input type="text" id="Text_AllowRetroUpdates" name="Text_AllowRetroUpdates" class="form-control" value="<?php echo $AllowRetroUpdates; ?>" placeholder="" maxlength="2" onkeypress="return onlyNos(event,this);"></td>
										  </tr>
										  
										  <tr>
											<td> Allow Copy TimeSheet between Employees </td>
											<td><input type="checkbox" id="Check_CopyTimesheetEmployees" name="Check_CopyTimesheetEmployees" <?php if($CopyTimesheetEmployees == "Y"){ ?> checked="checked" <?php } ?> value="1"></td>
										  </tr>
										</tbody>
									  </table>
										</div>
									  </div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThree">
								<h4 class="panel-title"> 
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Time Approval	Rules <i class="fa fa-plus"></i> </a>
							<span class="over-eyecont">
								<?php
									$CreatedByName = "";
									$UpdatedByName = "";
									if($CreatedBy!='') $CreatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $CreatedBy");
									if($UpdatedBy!='') $UpdatedByName = getvalue("cxs_users","USER_NAME", "where USER_ID = $UpdatedBy");
								?>
							  <button type="button" id = "btn_heading3" class="btn btn-default" data-trigger="focus" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-content="
										Created By:  <?php  echo $CreatedByName; ?><br>
										Updated By:  <?php  echo $UpdatedByName; ?><br>
										Creation Date: <?php  echo $CreationDate; ?><br>
										Last Update Date: <?php  echo $LastUpdateDate; ?>"> 
										<i class=" fa fa-eye"></i> 
							</button>
							</span> 
								</h4>
							</div>							
							<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							  <div class="panel-body">
							  <!-- -->
								<div class="col-md-12">
								  <h2 class="f-sec-hd"> Time Approval Rules </h2>
								</div>
								<div class="col-md-12">
								  <div class="row">
									
									<div class="checkbox col-md-4">
									  <label><input type="checkbox" id="Check_CreateTimeSheet" name="Check_CreateTimeSheet" <?php if($CreateTimeSheet == "Y"){ ?> checked="checked" <?php } ?> value="1">Create Anyone's TimeSheet </label>
									</div>
									
									<div class="checkbox col-md-4">
									  <label><input type="checkbox" id="Check_ApproveTimeSheet" name="Check_ApproveTimeSheet" <?php if($ApproveTimeSheet == "Y"){ ?> checked="checked" <?php } ?> value="1">Approve Anyone's TimeSheet </label>
									</div>
									
									<div class="checkbox col-md-4">
									  <label><input type="checkbox" id="Check_CreateTimeSheetTeam" name="Check_CreateTimeSheetTeam" <?php if($CreateTimeSheetTeam == "Y"){ ?> checked="checked" <?php } ?> value="1">Create Anyone's TimeSheet in a Team </label>
									</div>
									
									<div class="checkbox col-md-4">
									  <label><input type="checkbox" id="Check_ApproveTimeSheetTeam" name="Check_ApproveTimeSheetTeam" <?php if($ApproveTimeSheetTeam == "Y"){ ?> checked="checked" <?php } ?> value="1" disabled>Approve Anyone's TimeSheet in a Team </label>
									</div>
									
									<div class="checkbox col-md-4">
									  <label><input type="checkbox" id="Check_CreateSupervisorTimeSheet" name="Check_CreateSupervisorTimeSheet" <?php if($CreateSupervisorTimeSheet == "Y"){ ?> checked="checked" <?php } ?> value="1" disabled>Allow Supervisor to Create TimeSheet </label>
									</div>
									
									<div class="checkbox col-md-4">
									  <label><input type="checkbox" id="Check_AllowPreApproval" name="Check_AllowPreApproval" <?php if($AllowPreApproval == "Y"){ ?> checked="checked" <?php } ?> value="1">Allow PreApproval </label>
									</div>
									
									
								  </div>
								</div>
							  </div>
							</div>
						</div>

					</div>			
			