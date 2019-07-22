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
	            disableFormButton('role_form', 'role_form_button');
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
					<span>Create new role</span>
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
					<form action="javascript:void(0)" id="role_form" data-controller="role" form-type="create">
						<!-- row -->
						<div class="row">
							<!-- column_5 -->
							<div class="column_5 pull_center">
								<!-- row -->
								<div class="row">
									<!-- column_12 -->
									<div class="column_12">
										<!-- form_group -->
										<div class="form_group">
											<!-- row -->
											<div class="row no_margin">
												<!-- column_12 -->
												<div class="column_12">
													<label>Role</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="text" 
														class="form_val required" 
														id="role" 
														name="role" 
														placeholder="e.g. Admin">
													<span class="validation_error" id="role_error"></span>
												</div>
												<!-- /column_12 -->
											</div>
											<!-- /row -->
										</div>
										<!-- /form_group -->
										<!-- form_group -->
										<div class="form_group">
											<!-- row -->
											<div class="row no_margin">
												<!-- column_12 -->
												<div class="column_12">
													<label>Description</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<textarea 
														type="text" 
														class="form_val required" 
														id="description" 
														name="description"
														placeholder="e.g. Manages everything on the app"></textarea>
													<span class="validation_error" id="description_error" style="top:124px;"></span>
												</div>
												<!-- /column_12 -->
											</div>
											<!-- /row -->
										</div>
										<!-- /form_group -->
										<!-- form_group -->
										<div class="form_group">
											<div class="row no_margin">
												<div class="column_12">
			                                        <h3 class="checkbox_header">Permissions</h3>
			                                    </div>
												
												<?php echo $htmlControl->getPerms(); ?>

											</div>
										</div>
										<!-- /form_group -->
									</div>
									<!-- /column_12 -->
								</div>
								<!-- /row -->
							</div>
							<!-- /column_5 -->
							
							<!-- column_12 -->
							<div class="column_12">
								<!-- form_action -->
								<div class="form_action align_right">
									<button 
										class="button default_button small"
										onclick="window.location='<?php echo $baseURL; ?>roles'">Cancel</button>
									<button 
										type="button" 
										class="button primary_button small process"
										data-form="role_form"
										id="role_form_button" 
										disabled="disabled" 
										onclick="javascript:processForm('role_form', 'Create')">Create</button>
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
