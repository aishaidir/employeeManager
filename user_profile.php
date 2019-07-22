<?php

include_once("models/init.php");
include_once("incs/auth.php");

$report = new Report;
$library = new Library();

if(isset($_GET["id"]) && is_numeric($_GET["id"])) {
	$userId = $_GET["id"];

	if($user->userDetails($userId) == NULL) {
		echo "Oops...";
		die;
	} else {
		$userInfo = $user->userDetails($userId);
		$staffId = $userInfo["staffid"];
		$firstName = $userInfo["firstname"];
		$lastName = $userInfo["lastname"];
		$fullname = $firstName . " " . $lastName;
		$username = $library->cleanURL($firstName. " " .$lastName);
		$subEmail = $userInfo["email"];
		$subPhone = $userInfo["phone"];
		$designationId = $userInfo["designation_id"];
		$deptDesgn = $user->getDepartment($designationId);
		$department = $deptDesgn["department"];
		$designation = $deptDesgn["name"];
		$gradeId = $userInfo["grade_id"];
		$grade = $user->getGrade($gradeId);
		$roleArr = $user->getRole($userId);
		$role = $roleArr["role"];
		$roleDesc = $roleArr["description"];

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
					<span><?php echo $fullname; ?></span><span class="page_title_date"></span>
				</h3>
				<!-- header_widgets -->
				<?php include_once("incs/header_widgets.php"); ?>
				<!-- header_widgets -->
			</header>
			<!-- /header -->

			<!-- page_content -->
			<div class="page_content">

				<div class="prompt_msg"></div>

				<!-- profile_section -->
				<div class="profile_section">

					<div class="row">

						<!-- column_2 -->
						<div class="column_3">
							<div class="photo_previewer">
								<img id="photo_preview" src="<?php echo $baseURL; ?>imgs/avatar.png">

							</div>
						</div>
						<!-- /column_3 -->

						<div class="column_6">
							<table>
							<tr>
									<th>Staff ID</th>
                                    <td><a href="mailto:<?php echo $subEmail ?>"><?php echo $staffId; ?></a></td>
								</tr>
								<tr>
									<th>Email</th>
                                    <td><a href="mailto:<?php echo $subEmail ?>"><?php echo $subEmail; ?></a></td>
								</tr>
								<tr>
									<th>Phone</th>
									<td><?php echo $subPhone; ?></td>
								</tr>
								<tr>
									<th>Department</th>
									<td><?php echo $department; ?></td>
								</tr>
								<tr>
									<th>Designation</th>
									<td><?php echo $designation; ?></td>
								</tr>
								<tr>
									<th>Grade</th>
									<td><?php echo $grade; ?></td>
								</tr>
								<tr>
									<th>Role</th>
									<td><?php echo $role . " (". $roleDesc .")"; ?></td>
								</tr>
							</table>
						</div>

						<div class="column_4"></div>

					</div>

				</div>
				<!-- /profile_section -->


				<!-- sub_report_section -->
				<div class="sub_report_section">

					<div class="row">

						<div class="column_12">
							<h1 class="title">Reports</h1>
						</div>

						<?php

							if(!$user->isSupervisor($userId, $uid) && $userId != $uid) {
								die("<div class='column_12'><h4 class=\"no_report\">You do not have the privilege to view this user's reports.</h4></div>");
							}
							if($report->getWeekReport($userId, 1) == NULL) {
								echo "<div class='column_12'>";
								echo '<h4 class="no_report">This user hasn\'t submitted any report yet.</h4>';
								echo '</div>';
							} else {
								echo '<div class="column_12">';
								echo '<div class="sub_report_year_pad">';
								echo '<div class="sub_report_year">';
								echo '<div class="report_year">2017</div>';
								echo '</div>';
							    echo '</div>';
						        echo '</div>';
								$weekReport = $report->getWeekReport($userId, 1);
								$len = count($weekReport);
								for ($i = 0; $i < $len; $i++) {

									extract($weekReport[$i]);

									$monthToLower = strtolower($month);

									echo '<div class="column_2">';
								    echo '<a href="'. $baseURL .'report/'. $monthToLower .'/'. $year .'/'. $week .'/' . $id . '/'. $userId .'/#'. $username .'">';
									echo '<div class="report_month_week">';
									echo '<span class="week_title">Week</span>';
                                    echo '<span class="week">'. $week .'</span>';
									echo '</div>';
									echo '</a>';
									echo '</div>';
								}
							}
						?>

					</div>

				</div>
				<!-- /sub_report_section -->

			</div>
			<!-- page_content -->

		</div>
		<!-- /page_container -->

	</body>

</html>
