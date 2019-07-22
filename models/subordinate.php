<?php

class Subordinate extends User {

	public function __construct() {
		parent::__construct();
	}

	public function getSubordinates($uid) {
		try {
			$sql  = "SELECT * FROM `view subordinates` WHERE supervisor_id = ". $uid ."";
			$query = $this->conn->query($sql);
			$users = $query->fetchAll(PDO::FETCH_ASSOC);
			return $users;
		}
		catch(PDOException $e) {
			$this->err->logError("Subordinate", "getSubordinates", $e->getMessage(), 1);
		}
	}
}

?>