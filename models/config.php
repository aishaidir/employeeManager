<?php 

class Config {
	private static $host       = 'localhost';
	private static $user       = 'root';
	protected static $password = '';
	private static $database   = 'daily_report';
	public static $baseURL = 'http://localhost/employee_report_manager/';
	//public static $baseURL = 'http://192.168.8.106/task_manager/';

	
    public static function connect() {
		try {
			$conn = new PDO('mysql:host='. self::$host .';dbname='. self::$database .'', ''. self::$user .'', ''. self::$password .'');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		} 
		catch(Exception $e) {
			echo "Cannot connect to server: " . $e->getMessage();
			die();
		}
	}
}

?>