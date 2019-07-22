<?php

class Error{
	private $id;
	private $class;
	private $method;
	private $stackMessage;
	private $errorTime;
	private $user;
	private $dateTime;
	private $baseURL;
	private $conn;

	function __construct() {
		$config = new Config;
		$this->baseURL = $config::$baseURL;
		$this->conn = $config->connect();
		$this->dateTime = date_format(new DateTime('now'), "Y-m-d H:i:s");
    }
	
	public function logError($class, $method, $stackMessage, $user) {
		try {
			$sql   = "INSERT INTO errors (class, method, stack_message, user, error_time) ";
			$sql  .= "VALUES (?, ?, ?, ?, '".$this->dateTime."')";
			$query = $this->conn->prepare($sql);
			$query->bindParam(1, $class); 
			$query->bindParam(2, $method); 
			$query->bindParam(3, $stackMessage);
			$query->bindParam(4, $user);
			$query->execute(); 
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		
	}
	
	public function pageNotFound($url) {
		header('HTTP/1.0 404 Not Found');
	    require_once $url;
	    exit;
	}

	public function notLoggedIn() {
		header('HTTP/1.0 404 Not Found');
	    header('Location: '. $this->baseURL .'login');
	    exit;
	}
	
}

?>