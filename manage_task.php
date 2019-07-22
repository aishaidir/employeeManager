<?php

include_once("models/init.php");
include_once("incs/auth.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $siteTitle; ?></title>
		<meta name="description" content="">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="0"/>
		<?php include_once("incs/src_links.php"); ?>
		<script type="text/javascript">
			$(function() {
	            disableFormButton('task_form', 'task_form_button');
			});
		</script>

	</head>
	
	<body>
		
		<!-- light_overlay -->
		<div class="light_overlay"></div>
		<!-- /light_overlay -->
		
		<!-- page_container -->
		<div class="page_container">
			
			<!-- aside -->
			<?php include_once("incs/aside.php"); ?>
			<!-- /aside -->
			
			<!-- header -->
			<header cleafix>
				<div class="mobile_navicon pull_left">
					<i class="ion ion-navicon"></i>
				</div>
				<h3 class="page_title clearfix">
					Create new task
				</h3>
				<!-- header_widgets -->
				<?php include_once("incs/header_widgets.php"); ?>
				<!-- header_widgets -->
			</header>
			<!-- /header -->
			
			<!-- page_content -->
			<div class="page_content">
				<div class="prompt_msg"></div>
				<!-- form_section -->
				<div class="form_section">
					<form action="javascript:void(0)" class="form_center_auto" id="task_form" style="width: 70%;" data-controller="task" form-type="create_task">
						<!-- row -->
						<div class="row">
							<!-- column_6 -->
							<div class="column_6">
								<!-- form_group -->
								<div class="form_group">
									<label>Title</label>
									<div class="form_item">
										<input type="text" class="form_val required" id="title" name="title">
										<span class="validation_error" id="title_error"></span>
									</div>
								</div>
								<!-- /form_group -->
							</div>
							<!-- /column_6 -->
							<!-- column_6 -->
							<div class="column_6">
								<!-- form_group -->
								<div class="form_group">
									<label>Description</label>
									<div class="form_item">
										<textarea class="form_val" id="description" name="description"></textarea>
									</div>
								</div>
								<!-- /form_group -->
							</div>
							<!-- /column_6 -->
							<!-- column_6 -->
							<div class="column_6">
								<!-- form_group -->
								<div class="form_group">
									<label>Start Date</label>
									<div class="form_item">
										<input type="date" class="form_val required" id="start_date" name="start_date">
										<span class="validation_error" id="start_date_error"></span>
									</div>
								</div>
								<!-- /form_group -->
							</div>
							<!-- /column_6 -->
							<!-- column_6 -->
							<div class="column_6">
								<!-- form_group -->
								<div class="form_group">
									<label>Due Date</label>
									<div class="form_item">
										<input type="date" class="form_val" id="due_date" name="due_date">
										<span class="validation_error" id="due_date_error"></span>
									</div>
								</div>
								<!-- /form_group -->
							</div>
							<!-- /column_6 -->
							<!-- column_6 -->
							<div class="column_6">
								<!-- form_group -->
								<div class="form_group">
									<label>Assign To</label>
									<div class="form_item">
										<select class="form_val" id="assign_to" name="assign_to">
											<option value="">-- Select --</option>
											<?php
												echo $htmlControl->assignTaskTo($uid);
											?>
										</select>
									</div>
								</div>
								<!-- /form_group -->
							</div>
							<!-- /column_6 -->
							<!-- column_6 -->
							<div class="column_6">
								<!-- participants -->
								<div class="participants" id="participants"></div>
								<textarea class="hidden" id="participants_list" name="participants"></textarea>
							</div>
							<!-- /column_6 -->
							<!-- column_7 -->
							<div class="column_7">
								<!-- form_group -->
								<div class="form_group">
									<label>Priority</label>
									<div class="form_item clearfix">
										<div class="radio_option">
											<label for="low">
												<input type="radio" id="low" name="priority" value="Low"> 
												<span>Low</span>
											</label>
										</div>
										<div class="radio_option">
											<label for="medium">
												<input type="radio" id="medium" name="priority" value="Medium"> 
												<span>Medium</span>
											</label>
										</div>
										<div class="radio_option">
											<label for="high">
												<input type="radio" id="high" name="priority" value="High"> 
												<span>High</span>
											</label>
										</div>
									</div>
								</div>
								<!-- /form_group -->
							</div>
							<!-- /column_7 -->
							
							<!-- column_12 -->
							<div class="column_12">
								<!-- form_action -->
								<div class="form_action no_padding">
									<button 
										class="button default_button small"
										onclick="window.location='<?php echo $baseURL; ?>tasks'">Cancel</button>
									<button 
										type="button" 
										class="button primary_button small process"
										data-form="task_form"
										id="task_form_button" 
										disabled="disabled" 
										onclick="javascript:processForm('task_form', 'Save')">Save</button>
									
								</div>
								<!-- /form_action -->
							</div>
							<!-- /column_12 -->
						</div>
						<!-- /row -->
					</form>
				</div>
				<!-- /form_section -->
			</div>
			
		</div>
		<!-- /page_container -->
		
	</body>

</html>
