<?php

require_once("../models/init.php");

$user = new User;
$task = new Task;

if($user->isLoggedIn()) {
	$userInfo = $user->isLoggedIn();
	$uid = $userInfo->id;
}

	if($_SERVER['REQUEST_METHOD'] == "POST") {
 		
 		$action = $_POST["action"];
 
	 	switch($action) {

	 		case 'create_task': 
				$task_ = new stdClass;
				$task_->title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
				$task_->description = isset($_POST['description']) ? filter_var($_POST['description'], FILTER_SANITIZE_STRING) : "";
				$task_->startDate = isset($_POST['start_date']) ? filter_var($_POST['start_date'], FILTER_SANITIZE_NUMBER_INT) : "";
				$task_->dueDate = isset($_POST['due_date']) ? filter_var($_POST['due_date'], FILTER_SANITIZE_NUMBER_INT) : "";
				$task_->priority = isset($_POST['priority']) ? filter_var($_POST['priority'], FILTER_SANITIZE_STRING) : "";
				$task_->participants = $_POST['participants'];
	    		$task_->author = $uid;
				echo $task->createTask($task_);
				break;

			case "update_status":
				$taskId = filter_var($_POST['task_id'], FILTER_SANITIZE_NUMBER_INT);
				$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
				echo $task->updateTaskStatus($taskId, $uid, $status);
				break;

			case "participant_update":
				$authorId = filter_var($_POST['author_id'], FILTER_SANITIZE_NUMBER_INT);
				$taskId = filter_var($_POST['task_id'], FILTER_SANITIZE_NUMBER_INT);
				$participantRemarks = filter_var($_POST['participant_remarks'], FILTER_SANITIZE_STRING);
				$status = isset($_POST["participant_status"]) ? 1 : 0;
				echo $task->updateParticipantStatus($taskId, $authorId, $uid, $participantRemarks, $status);
				break;

			case "get_participant_status":
				$taskId = filter_var($_POST['task_id'], FILTER_SANITIZE_NUMBER_INT);
				$participantId = filter_var($_POST['participant_id'], FILTER_SANITIZE_NUMBER_INT);
				echo json_encode($task->getParticipantDetails($taskId, $participantId));
				break;

			case "review_participant":
				$taskId = filter_var($_POST['task_id'], FILTER_SANITIZE_NUMBER_INT);
				$participantId = filter_var($_POST['participant_id'], FILTER_SANITIZE_NUMBER_INT);
				$authorRating = filter_var($_POST['rating'], FILTER_SANITIZE_STRING);
				$authorRemarks = filter_var($_POST['author_remarks'], FILTER_SANITIZE_STRING);
				echo $task->reviewParticipant($taskId, $participantId, $authorRating, $authorRemarks);
				break;
		}
	}

?>