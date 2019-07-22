<?php

require_once("../models/init.php");

$user = new User;

if($user->isLoggedIn()) {
	$userInfo = $user->isLoggedIn();
	$id = $userInfo->id;
}

 if($_SERVER['REQUEST_METHOD'] == "POST"):
 	$action = filter_var($_POST['action'], FILTER_SANITIZE_STRING);
 
 	switch($action):

 		case 'login': 
			$phone_email = filter_var($_POST['phone_email'], FILTER_SANITIZE_EMAIL);
			$password = hash('sha256', $_POST['password']);
			echo $user->login($phone_email, $password);
			break; 

 		case 'create': 
			$user_ = new stdClass;
			$user_->staffId = filter_var($_POST['staff_id'], FILTER_SANITIZE_STRING);
			$user_->firstName = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
			$user_->lastName = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
			$user_->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$user_->phoneNo = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
			$user_->photo = filter_var($_POST['photo'], FILTER_SANITIZE_STRING);
			$user_->password = hash('sha256', $_POST['password']);
			$user_->designation = filter_var($_POST['designation'], FILTER_SANITIZE_NUMBER_INT);
			$user_->grade = filter_var($_POST['grade'], FILTER_SANITIZE_NUMBER_INT);
			$user_->role = filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT);
			if(isset($_POST['supervisor']))
				$user_->supervisor = filter_var($_POST['supervisor'], FILTER_SANITIZE_NUMBER_INT);
    		$user_->authorId = $id;
			echo $user->createUser($user_);
			break;

		case 'edit': 
			$user_ = new stdClass;
			$user_->id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
			$user_->staffId = filter_var($_POST['staff_id'], FILTER_SANITIZE_STRING);
			$user_->firstname = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
			$user_->lastname = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
			$user_->phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
			$user_->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$user_->designationId = filter_var($_POST['designation'], FILTER_SANITIZE_NUMBER_INT);
			$user_->gradeId = filter_var($_POST['grade'], FILTER_SANITIZE_NUMBER_INT);
			$user_->supervisorId = filter_var($_POST['supervisor'], FILTER_SANITIZE_NUMBER_INT);
			$user_->roleId = filter_var($_POST['role'], FILTER_SANITIZE_NUMBER_INT);
    		echo $user->editUser($user_);
			break;

		case 'edit_profile': 
			$user_ = new stdClass;
			$user_->id = $id;
			$user_->firstName = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
			$user_->lastName = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
			$user_->phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
			$user_->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    		echo $user->editProfile($user_);
			break; 

		case 'change_password': 
			$user_ = new stdClass;
			$user_->id = $id;
			$user_->password = $_POST['password'];
			$user_->n_password = $_POST['new_password'];
			$user_->c_password = $_POST['confirm_password'];
    		echo $user->changePassword($user_);
			break; 
	
	endswitch;

 endif;

?>