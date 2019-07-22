<?php

include_once("models/init.php");
include_once("incs/auth.php");

if(!$user->hasPrivilege("Manage Reports")) {
	echo "No permission";
	die;
} 

$today = date("Y-m-d");
$report = new Report;

$date = new DateTime($today);
$week = $date->format("W");
//$week = $report->getWeek($today, "sunday");

$dayofweek = date('W', strtotime($today)) == 0 ? 7 : date('w', strtotime($today));
$year = date('Y', strtotime($today));
$month = date('M', strtotime($today));



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
	            disableFormButton('report_form', 'report_form_button');
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
					<span>Week <?php echo $week .", Day " . $dayofweek; ?></span><span class="page_title_date"><?php echo date("D M d Y") ?></span>
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
					<form action="javascript:void(0)" class="form_center_auto" id="report_form" data-controller="report" form-type="create_daily_report">
						<input type="hidden" name="year" value="<?php echo $year; ?>">	
						<input type="hidden" name="month" value="<?php echo $month; ?>">
						<input type="hidden" name="week" value="<?php echo $week; ?>">
						<input type="hidden" name="day" value="<?php echo $dayofweek; ?>">
						<!-- row -->
						<div class="row">
							<!-- column_12 -->
							<div class="column_12">
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
													<label>Activity</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<textarea class="form_val required" placeholder="e.g. I created my first login page with HTML & CSS" name="activity" id="activity"></textarea>
													<span class="validation_error" id="activity_error"></span>
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
													<label>Milestone</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<textarea class="form_val" placeholder="e.g. I am now proficient in Web development" name="milestone" id="milestone"></textarea>
													<span class="validation_error" id="milestone_error"></span>
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
							<!-- /column_12 -->
							<!-- column_12 -->
							<div class="column_12">
								<!-- form_action -->
								<div class="form_action">
									<button 
										class="button default_button small"
										onclick="window.location='<?php echo $baseURL; ?>reports'">Cancel</button>
									<button 
										type="button" 
										class="button primary_button small process"
										data-form="report_form"
										id="report_form_button" 
										disabled="disabled" 
										onclick="javascript:processForm('report_form', 'Save')">Save</button>
									
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
