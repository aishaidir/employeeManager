<?php

include_once("models/init.php");
include_once("incs/auth.php");

$report = new Report;
$supervisor = false;

// echo base64_decode("rox44CJogto");

if(isset($_GET['month']) && isset($_GET['year']) && isset($_GET['week']) && isset($_GET['id'])) {
	$month = $_GET["month"];
	$year = $_GET["year"];
	$week = $_GET["week"];
	$weeklyId = $_GET["id"];

	if(isset($_GET["subId"])) {
		$uid = $_GET["subId"];
		$supervisor = true;
	}

	if($report->getWeeksDailySummary($month, $year, $week, $weeklyId, $uid) == NULL) {
		die("You don't have the permission to view this page");
	} else {
		$dailySummary = $report->getWeeksDailySummary($month, $year, $week, $weeklyId, $uid);
		$len = count($dailySummary);
		$percentage = 0;
		$submitStatus = $report->checkSubmitStatus($weeklyId);
		$disabled = $submitStatus ? 'disabled="disabled"' : "";
		$dateSubmitted = "Submitted on: ". date("D M d Y h:i A", strtotime($report->weeklyReportSubmitDate($weeklyId)));

		$reviewStatus = $report->reviewStatus($weeklyId);

		switch ($len) {
			case 1:
				$percentage = 20;
				break;
			case 2:
				$percentage = 40;
				break;
			case 3:
				$percentage = 60;
				break;
			case 4:
				$percentage = 80;
				break;
			case 5:
				$percentage = 100;
				break;
			
			default:
				$percentage = 0;
				break;
		}
	}

} else {
	die;
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
	            
	            disableFormButton('report_form', 'report_form_button');
	            disableFormButton('edit_day_report_form', 'edit_day_report_form_button');
	            disableFormButton('rating_form', 'rating_form_button');

	            $("input[name='rating']").on("click", function() {
            		var rating = $(this).val();
            		$("#rating_id").val(rating);
        		});

        		setTimeout(function(){
        			$(".notifier").html("").css({"opacity":"0", "visibility":"hidden"});
        		}, 3000);
			});
		</script>
		 <?php
			
			if(isset($_SESSION["week_report_submitted"])) {

				echo "<script type=\"text/javascript\">";
				echo "$(document).ready(function(){ $('.notifier').html(\"<span>Week report was submitted. <a href='#' id='hide_notifier'>HIDE</a></span>\").css({'opacity':'1', 'visibility':'visible'}) })";
				echo "</script>";

			}
			if(isset($_SESSION["week_report_reviewed"])) {

				echo "<script type=\"text/javascript\">";
				echo "$(document).ready(function(){ $('.notifier').html(\"<span>Report review was successful. <a href='#' id='hide_notifier'>HIDE</a></span>\").css({'opacity':'1', 'visibility':'visible'}) })";
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
					<span><?php echo ucwords($month)."/".$year; ?></span><span class="page_title_date">Week <?php echo $week; ?></span>
				</h3>
				<!-- header_widgets -->
				<?php include_once("incs/header_widgets.php"); ?>
				<!-- header_widgets -->
			</header>
			<!-- /header -->
			
			<!-- page_content -->
			<div class="page_content" style="padding-bottom: 50px;">

				<div class="notifier"></div>
				
				<div class="prompt_msg"></div>
				
				<!-- reports_section -->
				<div class="reports_section">
					
					<!-- row -->
					<div class="row no_margin">

						<form action="javascript:void(0)" id="weekly_report_form" data-controller="report" form-type="create_weekly_report">
						<input type="hidden" id="weekly_id" name="weekly_id" value="<?php echo $weeklyId; ?>">
						
						<!-- column_7 -->
						<div class="column_7" id="summary">

							<?php
								for ($i = 0; $i < $len; $i++) {
									
									extract($dailySummary[$i]);

									echo '<!-- day_summary -->';
							        echo '<div class="day_summary">';
								    echo '<h3 class="title clearfix">';
									//echo '<span class="pull_left">Day '. $day .'</span>';
									echo '<span class="date pull_left">'. date('D, M d Y h:i A', strtotime($date_created)) .'</span>';
									if(!$supervisor && !$submitStatus) {
										echo '<input type="hidden" id="daily_id'. $id .'" value="'. $id .'">';
										echo '<input type="hidden" id="activity'. $id .'" value="'. $activity .'">';
										echo '<input type="hidden" id="milestone'. $id .'" value="'. $milestone .'">';
										echo '<span class="arrow_bottom has_menu">';
										echo '<i class="fa fa-angle-down" aria-hidden="true"></i>';
										echo '<div class="menu" style="top:25px;left:-200px;">';
										echo '<div class="menu_content">';
										echo '<div class="menu_section" style="padding: 2px;">';
										echo '<ul class="menu_list">';
										echo '<li><a style="padding: 0 15px;" data-id="'. $id .'" id="edit_day_report" href ="javascript:void(0);">Edit</a></li>';
										echo '</ul>';
										echo '</div>';
										echo '</div>';
										echo '</div>';
										echo '</span>';
									}
								    echo '</h3>';
								    echo '<div class="details">';
									echo '<p>';
									echo '<span class="label">Activity</span>';
									echo '<span id="activity'.$id.'">'. $activity .'</span>';
									echo '</p>';
									echo '<p>';
									echo '<span class="label">Milestone</span>';
									echo '<span id="milestone'.$id.'">'. $milestone .'</span>';
									echo '</p>';
								    echo '</div>';
							        echo '</div>';
							        echo '<!-- /day_summary -->';

							        if($i >= 0 && $day < 5) {
							        	echo '<div class="separator"></div>';
							        	
							    	}
								}
							?>
							
						</div>
						<!-- /column_7 -->

						<!-- column_5 -->
						<div class="column_5">

							<!-- green -->
				            <div class="clearfix">
				                <div class="c100 p<?php echo $percentage; ?> big blue">
				                    <span><?php echo $percentage; ?>%</span>
				                    <div class="slice">
				                        <div class="bar"></div>
				                        <div class="fill"></div>
				                    </div>
				                </div>
				            </div>
				            <!-- /green -->

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
													<label>Key Challenges</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<textarea <?php echo $disabled; ?> class="form_val required" name="key_challenges" id="key_challenges"><?php echo $report->getKeyChallengesRecomm("key_challenges", $weeklyId); ?></textarea>
													<span class="validation_error" id="key_challenges_error"></span>
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
													<label>Recommendations</label>
												</div>
												<!-- /column_12 -->
												<!-- column_12 -->
												<div class="column_12 form_item">
													<textarea <?php echo $disabled; ?> class="form_val required" name="recommendations" id="recommendations"><?php echo $report->getKeyChallengesRecomm("recommendations", $weeklyId); ?></textarea>
													<span class="validation_error" id="recommendations_error"></span>
												</div>
												<!-- /column_12 -->
											</div>
											<!-- /row -->
										</div>
										<!-- /form_group -->
										
									</div>
									<!-- /column_12 -->
									<!-- column_12 -->
									<div class="column_12">
									

									<?php
										if($report->checkSubmitStatus($weeklyId)) {
											if(!$supervisor)
												echo "<h3 class=\"report_submitted\" style='display:block'>You have submitted this week's report</h3>";
											else
												echo "<h3 class=\"report_submitted\" style='display:block'>".$dateSubmitted."</h3>";
										} else {
											echo '<div class="form_action" style="padding: 0;">';
											echo '<button type="button" class="button primary_button submit_report">
											Submit Report</button>';
											echo '</div>';
										}
									?>
										
									</div>
									<!-- /column_12 -->
								</div>
								<!-- /row -->

						</div>
						<!-- column_5 -->

						</form>

					</div>
					<!-- /row -->

				</div>
				<!-- /reports_section -->

				<?php
					if($supervisor && !$reviewStatus) {

						echo '<div class="rating_area clearfix">';
						echo '<h3>Supervisor Area</h3>';
						echo '<form action="javascript:;" id="rating_form" data-controller="report" form-type="review_report">';

						echo '<div class="form_group clearfix">';
					    echo '<label for="rating">Rate</label>';					    
						echo '<fieldset class="rating">';
						
						echo '<input class="rate form_val required" type="radio" id="star5" name="rating" value="10" />';
						echo '<label class = "full" for="star5" title="Awesome - 5 stars"></label>';
						
						echo '<input class="rate form_val required" type="radio" id="star4half" name="rating" value="9" />';
						echo '<label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>';
						
						echo '<input class="rate form_val required" type="radio" id="star4" name="rating" value="8" />';
						echo '<label class = "full" for="star4" title="Pretty good - 4 stars"></label>';
						
						echo '<input class="rate form_val required" type="radio" id="star3half" name="rating" value="7" />';
						echo '<label class="half" for="star3half" title="Meh - 3.5 stars"></label>';
						
						echo '<input class="rate form_val required" type="radio" id="star3" name="rating" value="6" />';
						echo '<label class = "full" for="star3" title="Meh - 3 stars"></label>';
						
						echo '<input class="rate form_val required" type="radio" id="star2half" name="rating" value="5" />';
						echo '<label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>';
						
						echo '<input class="rate form_val required" type="radio" id="star2" name="rating" value="4" />';
						echo '<label class = "full" for="star2" title="Kinda bad - 2 stars"></label>';
						
						echo '<input class="rate form_val required" type="radio" id="star1half" name="rating" value="3" />';
						echo '<label class="half" for="star1half" title="Meh - 1.5 stars"></label>';
						
						echo '<input class="rate form_val required" type="radio" id="star1" name="rating" value="2" />';
						echo '<label class = "full" for="star1" title="Sucks big time - 1 star"></label>';
						
						echo '<input class="rate form_val required" type="radio" id="starhalf" name="rating" value="1" />';
						echo '<label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
					
						echo '</fieldset>'; 
						echo '</div>';

					    echo '<div class="form_group">';
						echo '<label>Remarks</label>';
						echo '<textarea class="form_val" id="remarks" name="remarks"></textarea>';
						echo '<input type="hidden" class="form_val" id="user_id" name="user_id" value="'. $uid .'">';
						echo '<input type="hidden" class="form_val" id="rating_id" name="rating_id">';
						echo '<input type="hidden" class="form_val" id="weekly_id" name="weekly_id" value="'. $weeklyId .'">';
						echo '</div>';

						echo '<div class="form_action" style="padding: 0;">';
						echo '<button class="button primary_button process" data-form="rating_form" id="rating_form_button" disabled="disabled" ';
						echo 'onclick="javascript:processForm(\'rating_form\', \'Save\')">';
						echo 'Send';
						echo '</button>';
						echo '</div>';

						echo '</form>';
			
						echo '</div>';
					} else if(!$reviewStatus) {
						echo "<h4 class='no_report'>This report has not been reviewed yet.</h4>";
					} else {
						$review = $report->getReportSummary($weeklyId);
						$username = strtolower($review["firstname"].$review["lastname"]);
						echo '<div class="report_summary_section">';
						echo '<div class="row">';
						echo '<div class="column_6 pull_center">';
						echo '<table class="table review_table">';
						echo '<tr>';
						echo '<th style="width: 25%;">Rating</th>';
						echo '<td>'. $review["rating"] .'</td>';
						echo '</tr>';
						echo '<tr>';
						echo '<th>Remarks</th>';
						echo '<td>'. $review["remarks"] .'</td>';
						echo '</tr>';
						echo '<tr>';
						echo '<th>Date Reviewed</th>';
						echo '<td>'. date("D M d Y h:i A", strtotime($review["date_reviewed"])) .'</td>';
						echo '</tr>';
						echo '<tr>';
						echo '<th>Reviewed By</th>';
						echo '<td><a href="'. $baseURL .'view/'. $username .'/'. $review["id"] .'">'. $review["reviewed_by"] .'</a></td>';
						echo '</tr>';
						echo '</table>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
					}

				?>
				

			</div>
			<!-- page_content -->

		</div>
		<!-- /page_container -->

		<div class="modal small" id="submit_report_modal">
	        <div class="modal_backdrop"></div>
	        <div class="modal_dialogue">
	            <div class="modal_content">
	                <div class="modal_header">
	                    <h4>Submit report?</h4>
	                </div>
	                <div class="modal_body">
	                    <b>Are you sure you want to submit this report?</b>
	                    <br><br>
	                    Once submitted, it is recorded that you are done for the week.
	                    <br>
	                </div>
	                <div class="modal_footer">
	                    <button class="button cancel_button cancel_delete small">No, cancel</button>
	                    <form action="javascript:void(0)" data-controller="report" form-type="create_weekly_report" id="submit_report_form" style="display: inline-block;">
	                    	<input type="hidden" id="weekly_id_" name="weekly_id">
	                    	<input type="hidden" id="key_challenges_" name="key_challenges">
	                    	<input type="hidden" id="recommendations_" name="recommendations">
	                    	<button 
							type="button" 
							class="button primary_button small process"
							data-form="submit_report_form"
							id="submit_report_form_button" 
							onclick="javascript:processForm('submit_report_form', 'Yes, submit')">Yes, submit</button>
	                    </form>
	                </div>
	            </div>
	        </div>
    	</div>

    	<div class="modal small" id="edit_report">
	        <div class="modal_backdrop"></div>
	        <div class="modal_dialogue">
	        <form action="javascript:void(0)" id="edit_day_report_form" data-controller="report" form-type="edit_day_report">
	            <input type="hidden" id="edit_daily_id" name="daily_id">
	            <div class="modal_content">
	                <div class="modal_header">
	                    <h4>Edit report</h4>
	                </div>
	                <div class="modal_body">
	                    <div class="form_group">
	                    	<label for="edit_activity">Activity</label>
	                    	<input type="text" class="form_val required" id="edit_activity" name="activity">
	                    </div>
	                    <div class="form_group">
	                    	<label for="edit_milestone">Milestone</label>
	                    	<input type="text" class="form_val" id="edit_milestone" name="milestone">
	                    </div>
	                    	
	                    
	                </div>
	                <div class="modal_footer">
	                    <button type="button" class="button small cancel_button cancel_delete">Cancel</button>
	                    <button 
							type="button" 
							class="button primary_button small process"
							data-form="edit_day_report_form"
							id="edit_day_report_form_button" 
							disabled="disabled" 
							onclick="javascript:processForm('edit_day_report_form', 'Save')">Save</button>
	                </div>
	            </div>
	            </form>
	        </div>
    	</div>

    	<?php 
			unset($_SESSION["week_report_submitted"]);
			unset($_SESSION["week_report_reviewed"]);
		?>
		
	</body>

</html>
