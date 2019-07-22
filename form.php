<?php

include_once("models/init.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Admin</title>
		<meta name="description" content="">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="0"/>
		<?php include_once("incs/src_links.php"); ?>
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
					<span>Create a new user</span>
				</h3>
				<!-- header_widgets -->
				<?php include_once("incs/header_widgets.php"); ?>
				<!-- header_widgets -->
			</header>
			<!-- /header -->
			
			<!-- page_content -->
			<div class="page_content">
				<!-- form_section -->
				<div class="form_section">
					<form action="javascript:void(0)">
						<!-- row -->
						<div class="row">
							<!-- column_8 -->
							<div class="column_8">
								<!-- row -->
								<div class="row">
									<!-- column_6 -->
									<div class="column_6">
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
												<div class="column_12">
													<input type="text">
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
												<div class="column_12">
													<input type="text">
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
												<div class="column_12">
													<input type="text">
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
												<div class="column_12">
													<input type="text">
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
													<label>Password</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12">
													<input type="text">
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
													<label>Confirm password</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12">
													<input type="text">
												</div>
												<!-- /column_12 -->
											</div>
											<!-- /row -->
										</div>
										<!-- /form_group -->
									</div>
									<!-- /column_6 -->
									<!-- column_6 -->
									<div class="column_6">
										<!-- form_group -->
										<div class="form_group">
											<!-- row -->
											<div class="row no_margin">
												<!-- column_12 -->
												<div class="column_12">
													<label>Department</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12">
													<select>
														<option value="">-- Select --</option>
													</select>
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
													<label>Designation</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12">
													<select>
														<option value="">-- Select --</option>
													</select>
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
													<label>Role</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12">
													<select>
														<option value="">-- Select --</option>
													</select>
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
													<label>Supervisor</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12">
													<input type="text">
												</div>
												<!-- /column_12 -->
											</div>
											<!-- /row -->
										</div>
										<!-- /form_group -->
									</div>
									<!-- /column_6 -->
								</div>
								<!-- /row -->
							</div>
							<!-- /column_8 -->
							<!-- column_4 -->
							<div class="column_4">
								<div class="photo_previewer has_menu">
									<div class="photo_overlay">
										<div class="change_photo">
											<span>
												<i class="ion ion-camera"></i>
											</span>
											<h3>Change photo</h3>
										</div>
										
									</div>
									<img id="photo_preview" src="imgs/avatar.png">
									<!-- menu -->
									<div class="menu small" style="top:105px;left:-5px;">
										<div class="menu_content">
											<div class="menu_section">
												<ul class="menu_list">
													<li class="photo_list_item">
														<input type="file" name="file" id="file" onchange="javascript:validatePhoto();">
														<span href="javascript:void(0)">Upload</span>
													</li>
													<li><a href="">Remove</a></li>
												</ul>
											</div>
											<div class="menu_divider"></div>
											<div class="menu_section">
												<ul class="menu_list">
													<li><a href="">Cancel</a></li>
												</ul>
											</div>
										</div>
									</div>
									<!-- /menu -->
								</div>
							</div>
							<!-- /column_4 -->
							<!-- column_12 -->
							<div class="column_12">
								<!-- form_action -->
								<div class="form_action align_right">
									<button class="button default_button small">Cancel</button>
									<button class="button primary_button small">Create</button>
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
