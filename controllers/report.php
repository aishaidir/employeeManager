<?php

require_once("../models/init.php");

$user = new User;
$report = new Report;

if($user->isLoggedIn()) {
	$userInfo = $user->isLoggedIn();
	$id = $userInfo->id;
}

 if($_SERVER['REQUEST_METHOD'] == "POST"):
 	$action = $_POST["action"];
 
 	switch($action):

 		case 'create_daily_report': 
			$report_ = new stdClass;
			$report_->year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
			$report_->month = filter_var($_POST['month'], FILTER_SANITIZE_STRING);
			$report_->week = filter_var($_POST['week'], FILTER_SANITIZE_NUMBER_INT);
			$report_->day = filter_var($_POST['day'], FILTER_SANITIZE_NUMBER_INT);
			$report_->activity = filter_var($_POST['activity'], FILTER_SANITIZE_STRING);
			$report_->milestone = filter_var($_POST['milestone'], FILTER_SANITIZE_STRING);
			$report_->userId = $id;
			echo $report->createDailyReport($report_);
			break;

		case 'create_weekly_report': 
			$report_ = new stdClass;
			$report_->weekly_id = filter_var($_POST['weekly_id'], FILTER_SANITIZE_NUMBER_INT);
			$report_->key_challenges = filter_var($_POST['key_challenges'], FILTER_SANITIZE_STRING);
			$report_->recommendations = filter_var($_POST['recommendations'], FILTER_SANITIZE_STRING);
			$report_->uid = $id;
			echo $report->submitWeeklyReport($report_);
			break;

		case 'edit_day_report': 
			$report_ = new stdClass;
			$report_->id = filter_var($_POST['daily_id'], FILTER_SANITIZE_NUMBER_INT);
			$report_->activity = filter_var($_POST['activity'], FILTER_SANITIZE_STRING);
			$report_->milestone = filter_var($_POST['milestone'], FILTER_SANITIZE_STRING);
			echo $report->editDayReport($report_);
			break;

		case "review_report":
			$report_ = new stdClass;
			$report_->userId = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
			$report_->weeklyId = filter_var($_POST['weekly_id'], FILTER_SANITIZE_NUMBER_INT);
			$report_->ratingId = filter_var($_POST['rating_id'], FILTER_SANITIZE_NUMBER_INT);
			$report_->remarks = filter_var($_POST['remarks'], FILTER_SANITIZE_STRING);
			$report_->remarkedBy = $id;
			echo $report->reviewReport($report_);
			break;
	
	endswitch;

 endif;

?>