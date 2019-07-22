<?php
 
 require_once("../models/init.php");
 
 if($_SERVER['REQUEST_METHOD'] == "POST"):
 	$page = $_POST["action"]; 
  
    switch($page):

 		case 'filter': 
			$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
			$tbl = filter_var($_POST['tbl'], FILTER_SANITIZE_STRING);
			$col = filter_var($_POST['col'], FILTER_SANITIZE_STRING);
			echo $htmlControl->filterSubCat($id, $tbl, $col);
			break;
		case "get_supervisors":
			$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
			$tbl = filter_var($_POST['tbl'], FILTER_SANITIZE_STRING);
			$col = filter_var($_POST['col'], FILTER_SANITIZE_STRING);
			echo $htmlControl->getSupervisors($id, $tbl, $col);
			break;
		case "get_supervisors_edit":
			$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
			$tbl = filter_var($_POST['tbl'], FILTER_SANITIZE_STRING);
			$col = filter_var($_POST['col'], FILTER_SANITIZE_STRING);
			$userId = filter_var($_POST['userId'], FILTER_SANITIZE_NUMBER_INT);
			echo $htmlControl->getSupervisors($id, $tbl, $col, $userId);
			break; 
	endswitch;

 endif;

?>