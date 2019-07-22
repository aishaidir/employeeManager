<?php

$user = new User;
$err = new Error;
$userLoggedIn = $user->isLoggedIn();
if($userLoggedIn) {
 	$userInfo = $user->isLoggedIn();
	$uid = $userInfo->id;
	$uFirstName = $userInfo->firstName;
	$uLastName = $userInfo->lastName;
	$name = $uFirstName. " " .$uLastName;
	$uPhone = $userInfo->phone;
	$uEmail = $userInfo->email;

	$user->initRoles($uid);
} 
else {
	$err->notLoggedIn();
}

$siteTitle = "Employee Daily Report Manager";

?>