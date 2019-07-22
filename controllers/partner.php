<?php
 
require_once("../models/init.php");

$partner = new Partner;
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
 			
 			$partner_ = new stdClass;
			$partner_->name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$partner_->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$partner_->phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
			$partner_->website = filter_var($_POST['website'], FILTER_SANITIZE_STRING);
			$partner_->address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
			$partner_->author_id = $uid;
			$partner_->imgs = $_POST['imgs_id_in_array'];
			echo $partner->create_partner($partner_);
			
			break; 

		case 'edit':

			$partner_ = new stdClass;
			$partner_->id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
			$partner_->name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$partner_->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$partner_->phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
			$partner_->website = filter_var($_POST['website'], FILTER_SANITIZE_STRING);
			$partner_->address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
			$partner_->imgs = $_POST['imgs_id_in_array'];
			echo $partner->edit_partner($partner_);
			
			break;
	}
}

?>