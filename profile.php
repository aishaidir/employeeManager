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
	            disableFormButton('profile_form', 'profile_form_button');
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
					<form action="javascript:void(0)" id="profile_form" data-controller="user" form-type="edit_profile">
						
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
													<label>First name</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="text" 
														class="form_val required" 
														id="firstname" 
														name="firstname"
														value="<?php echo $uFirstName; ?>">
													<span class="validation_error" id="firstname_error"></span>
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
													<label>Last name</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="text" 
														class="form_val required" 
														id="lastname" 
														name="lastname"
														value="<?php echo $uLastName; ?>">
													<span class="validation_error" id="lastname_error" style="top:124px;"></span>
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
													<label>Phone</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="text" 
														class="form_val required" 
														id="phone" 
														name="phone"
														value="<?php echo $uPhone; ?>">
													<span class="validation_error" id="phone_error" style="top:124px;"></span>
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
													<label>Email</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="text" 
														class="form_val required" 
														id="email" 
														name="email"
														value="<?php echo $uEmail; ?>">
													<span class="validation_error" id="email_error" style="top:124px;"></span>
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
										data-form="profile_form"
										id="profile_form_button" 
										disabled="disabled" 
										onclick="javascript:processForm('profile_form', 'Save')">Save</button>
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
