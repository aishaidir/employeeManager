<?php

class Role {
	public $id;
	public $role;
	public $description;
	public $perms;
	public $dateTime;
	public $conn;
	public $err;

	function __construct() {
		$this->perms = array();
		$config = new Config;
		$this->conn = $config::connect();
		$this->err = new Error;
		$this->dateTime = date_format(new DateTime('now'), "Y-m-d H:i:s");
	}

	public function createRole($role, $description, $perms) {
		$sql = "INSERT INTO roles (role, description, date_created) ";
		$sql .= "VALUES ( ";
		$sql .= "?, ";
		$sql .= "?, ";
		$sql .= "'". $this->dateTime ."') ";
		try {
			$query = $this->conn->prepare($sql);
			$query->bindParam(1, $role);
			$query->bindParam(2, $description);
			if($query->execute()) {
				$id = $this->conn->lastInsertId();
				if(count($perms) > 0) {

					$perm   = explode(',', $perms);
					$sql    = "INSERT INTO role_perm(role_id, perm_id) VALUES( ";
					$sql   .= "$id,".implode("),($id,", $perm) .")";
					$query  = $this->conn->query($sql);	
				}
			}
			echo 100;
		}
		catch(PDOException $e) {
			$this->err->logError('Role', 'createRole', $e->getMessage(), 1);
			echo 101;
		}
	}

	public function getRoles() {
		try {
			$sql = "SELECT * FROM roles WHERE deleted <> 1";
			$query = $this->conn->query($sql);
			$roles = $query->fetchAll(PDO::FETCH_ASSOC);
			return $roles;
		}
		catch (PDOException $e) {
			$this->err->logError('Role', 'getRoles', $e->getMessage(), 1);
		}
	}

	public function getRolePerm($roleId) {
		$role = new Role;
		
		$sql = "SELECT t2.permission FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.id
                WHERE t1.role_id = $roleId";
        $query  = $this->conn->query($sql);
        while($row = $query->fetch()) {
        	$role->perms[$row['permission']] = true;
        }
        return $role;
	}

	public function hasPerm($perm) {
        return isset($this->perms[$perm]);
    }
}

?>