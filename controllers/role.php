<?php
 
include_once("../models/init.php");

$roleModel = new Role();
 
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $action = $_POST["action"]; 
    sleep(4);
    switch($action) {
 		case 'create':
			$name        = filter_var($_POST['role'], FILTER_SANITIZE_STRING);
			$description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
			if(isset($_POST['perm'])) {
				$perms = implode(",", $_POST['perm']);
			} else {
				$perms = 0;
			}
			echo $roleModel->createRole($name, $description, $perms);
			break;
    }
}

?>