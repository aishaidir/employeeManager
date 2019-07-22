<?php
 
require_once("../models/init.php");

$company = new Company;

if($_SERVER['REQUEST_METHOD'] == "POST")
{
 	
 	$action = $_POST["action"];
 	
 	switch($action) {

 		case 'update_company_info': 
 			$company_ = new stdClass;
			$company_->name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$company_->address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
			$company_->phone_no = filter_var($_POST['phone_no'], FILTER_SANITIZE_NUMBER_INT);
			$company_->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$company_->website = filter_var($_POST['website'], FILTER_SANITIZE_STRING);
			$company_->postal_code = filter_var($_POST['postal_code'], FILTER_SANITIZE_STRING);
			$company_->about = $_POST['about'];
			echo $company->update_company_info($company_);
			break; 

		case 'mission_vision':
			$mission = $_POST['mission'];
			$vision = $_POST['vision'];
			echo $company->mission_vision($mission, $vision);
			break;

		case 'social_media':
			$company_ = new stdClass;
			$company_->facebook = $_POST['facebook'];
			$company_->twitter = $_POST['twitter'];
			$company_->google_plus = $_POST['google_plus'];
			$company_->linked_in = $_POST['linked_in'];
			$company_->instagram = $_POST['instagram'];
			echo $company->social_media($company_);
			break;
	}
}

?>