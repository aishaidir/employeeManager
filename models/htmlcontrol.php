<?php

class HTMLControl {
	private $conn;
	private $error;

	public function __construct(){
		$database = new Config;
		$this->conn = $database->connect();
		$this->error = new Error;
    }
	
	public function select($sql, $id, $name, $required = "", $custom = "", $js="") {
			$value  = '<select onchange="'. $js .'" class="form_val '. $required . ' ' . $custom .'" id="'. $id .'" name="'. $name .'">';
			$value  .= '<option value="">-- Select --</option>';
			try {
				$query  = $this->conn->query($sql);
				
				if($query->rowCount() > 0) {
					while($row = $query->fetch(PDO::FETCH_ASSOC)) {
						$value .= "<option value='". $row['id']. "'>".$row['name']."</option>";
					}
				} 
			} catch(PDOException $e) {
				return $e->getMessage();
				exit;
			}
			$value .= "</select>";
			return $value;
	}

	public function filterSubCat($id, $tbl, $col) {
		$sql = "SELECT * FROM $tbl WHERE $col = ".$id;
		try {
			$query  = $this->conn->query($sql);
			$value = NULL;
			if($query->rowCount() > 0) {
				while($row = $query->fetch(PDO::FETCH_ASSOC)) {
					$value .= "<option value='". $row['id']. "'>".$row['name']."</option>";
				}
			} 
		} 
		catch(PDOException $e) {
			return $e->getMessage();
			exit;
		}
		return $value;
	}

	public function getSupervisors($id, $tbl, $col, $userId="") {
		try {
			if($userId == "") {
				$sql = "SELECT
						t1.id, concat(t1.firstname, ' ', t1.lastname) as name, 
						t2.grade
						FROM $tbl t1
						JOIN
						grades t2
						ON
						t1.grade_id = t2.id
						JOIN 
						user_role t3
						ON
						t1.id = t3.user_id
						JOIN
						role_perm t4
						ON 
						t3.role_id = t4.role_id
						JOIN
						permissions t5
						ON
						t4.perm_id = t5.id
						WHERE
						t1.grade_id > $id
						AND
						t5.permission = 'Supervision Privilege'";
			} else {
				$sql = "SELECT
						t1.id, concat(t1.firstname, ' ', t1.lastname) as name, 
						t2.grade
						FROM $tbl t1
						JOIN
						grades t2
						ON
						t1.grade_id = t2.id
						JOIN 
						user_role t3
						ON
						t1.id = t3.user_id
						JOIN
						role_perm t4
						ON 
						t3.role_id = t4.role_id
						JOIN
						permissions t5
						ON
						t4.perm_id = t5.id
						WHERE
						t1.grade_id > $id
						AND
						t1.id != $userId
						AND
						t5.permission = 'Supervision Privilege'";
			}
			$query  = $this->conn->query($sql);
			
			$value = "<option value=''>-- Select --</option>";
			if($query->rowCount() > 0) {
				while($row = $query->fetch(PDO::FETCH_ASSOC)) {
					$value .= "<option value='". $row['id']. "'>".$row['name']."</option>";
				}
			} 
		}
		catch(PDOException $e) {
			$this->error->logError("HTMLControl", "getSupervisors", $e->getMessage(), 1);
		}
		return $value;
	}	

	public function getPerms() {
		$sql = "SELECT * FROM permissions";
		try {
			$query  = $this->conn->query($sql);
			$library = new Library;
			$value = NULL;
			if($query->rowCount() > 0) {
				while($row = $query->fetch(PDO::FETCH_ASSOC)) {
					$value .= "<div class='column_6'>";
					$value .= "<div class='checkbox_elem clearfix'>";
					$value .= "<input class='check_elem' type='checkbox' value='". $row["id"] ."' ";
					$value .= "id='". $library->strNameID($row["permission"]) ."' ";
					$value .= "name='perm[]'>";
					$value .= "<label for='". $library->strNameID($row["permission"]) ."'>". $row["permission"] ."</label>";
					$value .= "</div>";
					$value .= "</div>";
				}
			} 
		} 
		catch (PDOException $e) {
			$this->error->logError('HTMLControl', 'getPerms', $e->getMessage(), 1);
		}
		return $value;
	}

	public function assignTaskTo($uid) {
		$sql = "SELECT * FROM users WHERE id <> ".$uid;
		try {
			$query  = $this->conn->query($sql);
			$value = NULL;
			if($query->rowCount() > 0) {
				while($row = $query->fetch(PDO::FETCH_ASSOC)) {
					$value .= "<option data-name='". $row['firstname']." ".$row['lastname'] ."' value='". $row['id']. "'>". $row['firstname']." ".$row['lastname'] ."</option>";
				}
			} 
		} 
		catch(PDOException $e) {
			return $e->getMessage();
			exit;
		}
		return $value;
	}

}

?>