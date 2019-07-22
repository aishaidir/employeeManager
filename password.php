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
	            disableFormButton('password_form', 'password_form_button');
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
					<span>Edit Profile</span>
				</h3>
				<!-- header_widgets -->
				<?php include_once("incs/header_widgets.php"); ?>
				<!-- header_widgets -->
			</header>
			<!-- /header -->
			<?php include_once('incs/user_sub_header.php'); ?>
			
			<!-- page_content -->
			<div class="page_content">
				<div class="prompt_msg"></div>
				<!-- form_section -->
				<div class="form_section">
					<form action="javascript:void(0)" id="password_form" data-controller="user" form-type="change_password">
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
													<label>Current Password</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="password" 
														class="form_val required" 
														id="password" 
														name="password">
													<span class="validation_error" id="password_error"></span>
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
													<label for="new_password">New Password</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="password" 
														class="form_val required" 
														id="new_password" 
														name="new_password">
													<span class="validation_error" id="new_password_error"></span>
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
													<label for="confirm_password">Confirm Password</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="password" 
														class="form_val required" 
														id="confirm_password" 
														name="confirm_password">
													<span class="validation_error" id="confirm_password_error"></span>
												</div>
												<!-- /column_12 -->
											</div>
											<!-- /row -->
										</div>
										<!-- /form_group -->
									</div>
									<!-- /column_12 -->
								</div>
								<!-- /row -->
							</div>
							<!-- /column_5 -->
							
							<!-- column_5 -->
							<div class="column_5 pull_center">
								<!-- form_action -->
								<div class="form_action">
									<button 
										type="button" 
										class="button primary_button process"
										data-form="password_form"
										id="password_form_button" 
										disabled="disabled" 
										onclick="javascript:processForm('password_form', 'Save')">Save</button>
								</div>
								<!-- /form_action -->
							</div>
							<!-- /column_5 -->
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
