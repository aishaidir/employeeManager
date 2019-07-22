<?php

include_once("models/init.php");
include_once("incs/auth.php");

if(!$userLoggedIn->hasPrivilege("Manage Users"))  {
	header('Location: '. $baseURL.'users');
}

$pageTitle = "Create New User";
$formType = "create";
$userId = "";
$staffId = "";
$firstName = "";
$lastName = "";
$email = "";
$phone = "";
$departmentId = "";
$getSupervisors = "get_supervisors";


if(isset($_GET['id'])) {
	$id = $_GET['id'];
	
	if($user->userDetails($id) == NULL) {
    	echo 'Oops';
    	die;
    } else {
    	$pageTitle = "Edit User";
    	$formType = "edit";
    	$arr = $user->userDetails($id);
    	$userId = $arr["id"];
    	$staffId =$arr["staffid"];
    	$firstName = $arr["firstname"];
    	$lastName = $arr["lastname"];
    	$email = $arr["email"];
    	$phone = $arr["phone"];
    	$designationId = $arr["designation_id"];
    	$department = $user->getDepartment($designationId);
    	$departmentId = $department["department_id"];
    	$gradeId = $arr["grade_id"];
    	$supervisor = $user->getSupervisor($userId);
    	$supervisorId = $supervisor["id"];
    	$role = $user->getRole($userId);
    	$roleId = $role["id"];
    	$getSupervisors = "get_supervisors_edit";
    }
}

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
	            disableFormButton('user_form', 'user_form_button');
			});
		</script>
		<?php
			if($departmentId != "") {
				echo "<script type=\"text/javascript\">";
				echo "$(function() {";
				echo "$('#dept_id').val(". $departmentId .");";
				echo "getSubCat('filter', ". $departmentId .", 'designations', 'department_id', 'designation', ". $designationId .");";
				echo "getSubCat('get_supervisors', ". $gradeId .", 'users', 'grade_id', 'supervisor', ". $supervisorId .");";
				echo "$('#grade').val(". $gradeId .");";
				echo "$('#role').val(". $roleId .");";
				echo "});";
				echo "</script>";
			}
		?>
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
					<span><?php echo $pageTitle; ?></span>
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
					<form action="javascript:void(0)" id="user_form" data-controller="user" form-type="<?php echo $formType; ?>">
						<input type="hidden" name="user_id" value="<?php echo $userId; ?>">
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
													<label>Staff ID</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="text" 
														class="form_val required" 
														id="staff_id" 
														name="staff_id" 
														value="<?php echo $staffId; ?>">
													<span class="validation_error" id="staff_id_error"></span>
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
													<label>First name</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<input 
														type="text" 
														class="form_val required" 
														id="first_name" 
														name="first_name" 
														value="<?php echo $firstName; ?>">
													<span class="validation_error" id="first_name_error"></span>
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
														id="last_name" 
														name="last_name"
														value="<?php echo $lastName; ?>">
													<span class="validation_error" id="last_name_error"></span>
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
														value="<?php echo $email; ?>">
													<span class="validation_error" id="email_error"></span>
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
														type="tel" 
														class="form_val required" 
														id="phone" 
														name="phone"
														value="<?php echo $phone; ?>">
													<span class="validation_error" id="phone_error"></span>
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
													<label>Department</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<?php
														$sql  = "SELECT id as id, name as name FROM departments ORDER BY name ASC";
														echo $htmlControl->select($sql, 
															"dept_id", 
															"dept_id", 
															"required", 
															"", 
															"javascrip:filterSubCat(this.value, 
															'designations', 
															'department_id', 
															'designation', 
															'filter', 
															'0')");
													?>
													<span class="validation_error" id="dept_id_error"></span>
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
													<label>Designation</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<select class="form_val required" id="designation" name="designation">
														<option value="">-- Select --</option>
													</select>
													<span class="loading_contents" data-index="0"></span>
													<span class="validation_error" id="designation_error"></span>
													
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
												<div class="column_12 form_item">
													<?php
														$sql  = "SELECT id as id, role as name FROM roles ORDER BY role ASC";
														echo $htmlControl->select($sql, 
															"role", 
															"role", 
															"required");
													?>
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
													<label>Grade</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<?php
														$sql  = "SELECT id as id, grade as name FROM grades ORDER BY grade ASC";
														echo $htmlControl->select($sql, 
															"grade", 
															"grade", 
															"required",
															"", 
															"javascrip:filterSubCat(this.value, 
															'users', 
															'grade_id', 
															'supervisor', 
															'". $getSupervisors ."', 
															'1',
															'". $userId ."')");
													?>
													<span class="validation_error" id="grade_error"></span>
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
												<div class="column_12 form_item">
													<select class="form_val" id="supervisor" name="supervisor">
														<option>-- Select --</option>
													</select>
													<span class="validation_error" id="supervisor_error"></span>
													<span class="loading_contents" data-index="1"></span>
												</div>
												<!-- /column_12 -->
											</div>
											<!-- /row -->
										</div>
										<!-- /form_group -->
										<?php 
											if(!isset($_GET['id'])) {
												echo '<!-- form_group -->';
										        echo '<div class="form_group">';
											    echo '<!-- row -->';
											    echo '<div class="row no_margin">';
												echo '<!-- column_12 -->';
												echo '<div class="column_12">';
												echo '<label>Password</label>';
												echo '</div>';
												echo '<!-- /column_12 -->';
												echo '<!-- column_12 -->';
												echo '<div class="column_12 form_item">';
												echo '<input type="password" class="form_val required" id="password" name="password">';
												echo '<span class="validation_error" id="password_error"></span>';
												echo '</div>';
												echo '<!-- /column_12 -->';
												echo '</div>';
												echo '<!-- /row -->';
												echo '</div>';
												echo '<!-- /form_group -->';
												echo '<!-- form_group -->';
												echo '<div class="form_group">';
												echo '<!-- row -->';
												echo '<div class="row no_margin">';
												echo '<!-- column_12 -->';
												echo '<div class="column_12">';
												echo '<label>Confirm password</label>';
												echo '</div>';
												echo '<!-- /column_12 -->';
												echo '<!-- column_12 -->';
												echo '<div class="column_12 form_item">';
												echo '<input type="password" class="form_val required" id="confirm_password" name="confirm_password">';
												echo '<span class="validation_error" id="confirm_password_error"></span>';
												echo '</div>';
												echo '<!-- /column_12 -->';
												echo '</div>';
												echo '<!-- /row -->';
										        echo '</div>';
												echo '<!-- /form_group -->';
											}
										?>
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
									<img id="photo_preview" src="<?php echo $baseURL; ?>imgs/avatar.png">
									<!-- menu -->
									<div class="menu small" style="top:105px;left:-5px;">
										<div class="menu_content">
											<div class="menu_section">
												<ul class="menu_list">
													<li class="photo_list_item">
														<input type="file" name="photo" id="file" onchange="javascript:validatePhoto();">
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
								<div class="form_action" style="margin-top: 20px;">
									<button 
										class="button default_button small"
										onclick="window.location='<?php echo $baseURL; ?>users'">Cancel</button>
									<button 
										type="button" 
										class="button primary_button small process"
										data-form="user_form"
										id="user_form_button" 
										disabled="disabled" 
										onclick="javascript:processForm('user_form', 'Create')">Create</button>
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
