<?php
 
require_once("../models/init.php");

$service = new Service;
$user = new User;

if($user->is_logged_in())
{
	$user_info = $user->is_logged_in();
	$uid = $user_info->id;
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
 	
 	$action = $_POST["action"];
 	
 	switch($action) {

 		case 'create': 
 			
 			$service_ = new stdClass;
			$service_->title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
			$service_->service = $_POST['s_desc'];
			$service_->author_id = $uid;
			echo $service->create_service($service_);
			break; 

		case 'edit':
			$service_ = new stdClass;
			$service_->id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
			$service_->title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
			$service_->service = $_POST['s_desc'];
			echo $service->edit_service($service_);
			break;
	}
}

?>