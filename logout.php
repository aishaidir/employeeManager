<?php

include_once('../models/init.php');

session_start();

session_destroy();

header("Location: ". $baseURL ."index");
exit();

?>	