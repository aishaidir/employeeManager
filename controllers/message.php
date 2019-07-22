<?php
 
require_once("../models/init.php");

$message = new Message;

if($_SERVER['REQUEST_METHOD'] == "POST")
{
 	
 	$action = $_POST["action"];
 	
 	switch($action) {

 		case 'create': 
 			
 			$message_ = new stdClass;
			$message_->first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
			$message_->last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
			$message_->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$message_->phone = filter_var($_POST['phone_no'], FILTER_SANITIZE_NUMBER_INT);
			$message_->message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
			echo $message->save_message($message_);
			break; 
	}
}

?>