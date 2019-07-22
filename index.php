<?php

require_once 'models/init.php';


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Login | Employee Daily Report Manager</title>
		<meta name="description" content="">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="0"/>
		<?php include_once("incs/src_links.php"); ?>
	</head>
	
	<body class="bg_gray">
		
		<!-- page_container -->
		<div class="page_container">
			<div class="prompt_msg"></div>
			<!-- display_table -->
			<div class="display_table">
				<!-- display_table_cell -->
				<div class="display_table_cell">
					<!-- access_screen -->
					<div class="access_screen">
						<!-- access_screen_logo -->
						<span style="font-size:30px;padding:10px;">User Login</span>
						<div class="access_screen_logo">
						<i class="fa fa-lock" style="font-size:54px;color:#34675c;"></i>
												<!-- <a href="./">
								<img src="imgs/logo.png">
								<span>Task Manager</span>
							</a> -->
						</div>
						<!-- /access_screen_logo -->
						<!-- access_screen_form -->
						<form action="javascript;" class="access_screen_form" id="login_form" data-controller="user" form-type="login">
							<input type="hidden" id="action" name="action" value="login">
							<!-- form_group -->
							<div class="form_group">
								<input type="text" class="form_val required" name="phone_email" placeholder="Phone Number or Email">
							</div>
							<!-- /form_group -->
							<!-- form_group -->
							<div class="form_group">
								<input type="password" class="form_val required" name="password" placeholder="Password">
							</div>
    					  <!-- /form_group -->
							<!-- form_action -->
     					 <div class="form_action">
								<button 
									type="button" 
									class="button full_button primary_button process"
									data-form="login_form"
									id="login_form_button" 
									onclick="javascript:processForm('login_form', 'Sign in')" 
									>
									Sign in
								</button>
							</div>
							<!-- /form_action -->
						</form>
						<!-- /access_screen_form -->
						<!-- access_screen_footer -->
						<div class="access_screen_footer align_center">
							<a class="" href="password-reset.php">Forgot Password?</a>
						</div>
						<!-- /access_screen_footer -->
					</div>
					<!-- /access_screen -->
				</div>
				<!-- /display_table_cell -->
			</div>
			<!-- /display_table -->
			
		</div>
		<!-- /page_container -->
		
	</body>

</html>