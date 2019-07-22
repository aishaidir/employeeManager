<?php

class User {
	public $id;
	public $staffId;
	public $firstName;
	public $lastName;
	public $email;
	public $phoneNo;
	public $deparment;
	public $filename;
	public $caption;
	public $designation;
	public $grade;
	public $role;
	public $supervisor;
	public $authorId;
	public $dateCreated;
	public $status;
	public $roles = array();
	public $err;
	public $dateTime;
	public $conn;

	function __construct() {
		$config = new Config;
		$this->conn = $config->connect();
		$this->dateTime = date_format(new DateTime('now'), "Y-m-d H:i:s");
		$this->err = new Error;
    }

    public function phoneNoExist($phoneNo, $id = "") {
		try {
			if($id == "") {
				$sql = "SELECT * FROM users WHERE phone = ?";
				$query = $this->conn->prepare($sql);
				$query->bindParam(1, $phoneNo);
			} 
			else {
				$sql = "SELECT * FROM users WHERE phone = ? AND id <> ?";
				$query = $this->conn->prepare($sql);
				$query->bindParam(1, $phoneNo, PDO::PARAM_INT);
				$query->bindParam(2, $id, PDO::PARAM_STR);
			}
			
			$query->execute();
			
			if($query->rowCount() > 0)
				return true;
			else
				return false;
		
		} 
		catch(PDOException $e) {
			$this->err->logError("User", "phoneNoExist", $e->getMessage(), 1);
			return false;
		}
	}

	public function emailExist($email, $id = "") {
		try {
			if($id == "") {
				$sql = "SELECT * FROM USERS WHERE Email = ?";
				$query = $this->conn->prepare($sql);
				$query->bindParam(1, $email);
			} 
			else {
				$sql = "SELECT * FROM USERS WHERE Email = ? AND ID <> ?";
				$query = $this->conn->prepare($sql);
				$query->bindParam(1, $email, PDO::PARAM_STR);
				$query->bindParam(2, $id, PDO::PARAM_INT);
			}
			
			$query->execute();
			
			if($query->rowCount() > 0) {
				return true;
			} 
			else {
				return false;
			} 
		
		} 
		catch(PDOException $e) {
			$this->err->logError("User", "emailExist", $e->getMessage(), 1);
			return false;
		}
	}

	public function checkPassword($password, $id) {

		try {
			$sql = "SELECT * FROM users WHERE password = ? AND id = ?";
			$query = $this->conn->prepare($sql);
			$query->bindParam(1, $password);
			$query->bindParam(2, $id, PDO::PARAM_INT);
			$query->execute();
			$count = $query->rowCount();
			return $count;
		} 
		catch(PDOException $e) {
			$this->err->logError("User", "checkPassword", $e->getMessage(), 1);
		}
	}

	public function changePassword($user) {
		
		if(!self::checkPassword(hash('sha256',$user->password), $user->id)) { echo 201; exit; }
		if($user->n_password !== $user->c_password) { echo 202; exit; }
		$encrypted = hash('sha256', $user->c_password);
		
		try {				
			$sql  = "UPDATE users SET ";
			$sql .= "password = ?, ";
			$sql .= "password_changed_on = '". $this->dateTime ."' ";
			$sql .= "WHERE id = ?";
			$query  = $this->conn->prepare($sql);
			$query->bindParam(1, $encrypted);
			$query->bindParam(2, $user->id);
			$query->execute();
			echo 100;			
		} 
		catch(PDOException $e) {
			$this->err->log_error("User", "changePassword", $e->getMessage(), 1);
			echo 101;	
		}
	}

	public function createUser($user) {
		
		if(self::phoneNoExist($user->phoneNo)) { echo 201; exit; }
		if(self::emailExist($user->email)) { echo 202; exit; }

		try {
			$sql  = "INSERT INTO users ";
			$sql .= "(staffid, ";
			$sql .= "firstname, ";
			$sql .= "lastname, ";
			$sql .= "email, ";
			$sql .= "phone, ";
			$sql .= "password, ";
			$sql .= "designation_id, ";
			$sql .= "grade_id, ";
			$sql .= "author_id, ";
			$sql .= "date_created) ";
			$sql .= "VALUES (";
			$sql .= "?, ";
			$sql .= "?, ";
			$sql .= "?, ";
			$sql .= "?, ";
			$sql .= "?, ";
			$sql .= "?, ";
			$sql .= "?, ";
			$sql .= "?, ";
			$sql .= "?, ";
			$sql .= "'". $this->dateTime ."') ";
			
			$query = $this->conn->prepare($sql);
			$query->bindParam(1, $user->staffId, PDO::PARAM_STR);
			$query->bindParam(2, $user->firstName, PDO::PARAM_STR);
			$query->bindParam(3, $user->lastName, PDO::PARAM_STR);
			$query->bindParam(4, $user->email);
			$query->bindParam(5, $user->phoneNo, PDO::PARAM_STR);
			$query->bindParam(6, $user->password, PDO::PARAM_STR);
			$query->bindParam(7, $user->designation);
			$query->bindParam(8, $user->grade);
			$query->bindParam(9, $user->authorId);
			if($query->execute()) {
				$id = $this->conn->lastInsertId();
				$sql = "INSERT INTO user_role (user_id, role_id) VALUES('". $id ."', '".$user->role."')";
				$this->conn->query($sql);
				$sql1 = "INSERT INTO subordinates (subordinate_id, supervisor_id, date_assigned) VALUES('". $id ."', '".$user->supervisor."', '". $this->dateTime ."')";
				$this->conn->query($sql1);
				$sql2 = "INSERT INTO photos(filename, caption, author_id, date_uploaded) VALUES ('".$filename."', '".$author_id."', '".$this->dateTime."')";
				$this->conn->query($sql2);
			}
			echo 100;
		} 
		catch(Exception $e) {
			$this->err->logError("User","createUser", $e->getMessage(), 1);	
			echo 101;
		}
		
	}
	public function editUser($user) {
		if(self::phoneNoExist($user->phone, $user->id)) { echo 201; exit; }
		
		if(self::emailExist($user->email, $user->id)){ echo 202; exit; }
		
		try {
			$sql  = "UPDATE users SET ";
			$sql .= "staffid = ?, ";
			$sql .= "firstname = ?, ";
			$sql .= "lastname = ?, ";
			$sql .= "email = ?, ";
			$sql .= "phone = ?, ";
			$sql .= "designation_id = ?, ";
			$sql .= "grade_id = ? ";			
			$sql .= "WHERE id = ?";
			$query = $this->conn->prepare($sql);
			$query->bindParam(1, $user->staffId);
			$query->bindParam(2, $user->firstname);
			$query->bindParam(3, $user->lastname);
			$query->bindParam(4, $user->email);
			$query->bindParam(5, $user->phone);
			$query->bindParam(6, $user->designationId);
			$query->bindParam(7, $user->gradeId);
			$query->bindParam(8, $user->id);
			
			if($query->execute()) {
				$sql = "UPDATE user_role SET role_id =".$user->roleId. " WHERE user_id =". $user->id;
				$this->conn->query($sql);

				if($user->supervisorId != "") {
					$sql = "SELECT * FROM subordinates WHERE subordinate_id =".$user->id;
					$query = $this->conn->query($sql);

					if($query->rowCount() > 0) {
						$sql_ = "UPDATE subordinates SET supervisor_id =".$user->supervisorId. ", date_assigned = '". $this->dateTime."'";
						$sql_ .= " WHERE subordinate_id = ".$user->id;
					} else {
						$sql_ = "INSERT INTO subordinates (subordinate_id, supervisor_id, date_assigned) ";
						$sql_ .= "VALUES('". $user->id ."', '". $user->supervisorId ."', '". $this->dateTime ."')";
					}
					$query = $this->conn->query($sql_);
				}
			}
			
			echo 100;
		} 
		catch(Exception $e) {
			$this->err->logError('User','editUser', $e->getMessage(), 1);	
			echo 101;
		}
	}

	public function editProfile($user) {
		if(self::phoneNoExist($user->phone, $user->id)) { echo 201; exit; }
		if(self::emailExist($user->email, $user->id)) { echo 202; exit; }

		try {
			$sql  = "UPDATE users SET ";
			$sql .= "staffid = ?, ";
			$sql .= "firstname = ?, ";
			$sql .= "lastname = ?, ";
			$sql .= "phone = ?, ";
			$sql .= "email = ? ";
			$sql .= "WHERE id = ?";
			$query = $this->conn->prepare($sql);
			$query->bindParam(1, $user->staffId);
			$query->bindParam(2, $user->firstName);
			$query->bindParam(3, $user->lastName);
			$query->bindParam(4, $user->phone);
			$query->bindParam(5, $user->email);
			$query->bindParam(6, $user->id);
			$query->execute();
			echo 100;
		
		} 
		catch(Exception $e) {
			$this->err->logError('User','editProfile', $e->getMessage(), 1);
			echo 101;	
		}
	}
	
	public function getUsers() {
		try {
			$sql  = "SELECT * FROM `view users`";
			$query = $this->conn->query($sql);
			$users = $query->fetchAll(PDO::FETCH_ASSOC);
			return $users;
		} 
		catch(PDOException $e) {
			$this->err->logError("User", "getUsers", $e->getMessage(), 1);	
		}
	}

	public function getUserURL($userId) {
	    try {
	        $sql = "SELECT id, concat(firstname,' ',lastname) as name FROM users WHERE id = ".$userId;
	        $query = $this->conn->query($sql);
	        $res = $query->fetch(PDO::FETCH_ASSOC);
	        $config = new Config();
	        $baseURL = $config::$baseURL;
	        $library = new Library();
	        $id = $res["id"];
	        $name = $library->cleanURL($res["name"]);
	        $url = $baseURL."view/".$name."/".$id;
	        return $url;
        } catch(PDOException $e) {
            $this->err->logError("User", "getUserURL", $e->getMessage(), 1);
            return false;
        }
    }
	
	public function login($phone_email, $password) {
		try {
			$sql  = "SELECT * FROM users WHERE ";
			$sql .= "(phone = :phone_email OR email = :phone_email)  ";
			$sql .= "AND password = :password AND deleted <> 1";
			$query = $this->conn->prepare($sql);
			$query->bindParam(':phone_email', $phone_email);
			$query->bindParam(':password', $password);
			$query->execute();
			$count = $query->rowCount();
			$res = $query->fetch(PDO::FETCH_ASSOC);
			if($count) {
				$_SESSION['is_logged_in'] = $res['id'];
				$sql  = "UPDATE users SET ";
				$sql .= "last_login = '". $this->dateTime ."' ";
				$sql .= "WHERE id = ". $res['id'] ."";
				$query = $this->conn->query($sql);

				echo 100;
			} 
			else
				echo 101;
		} catch(PDOException $e) {
			$this->err->logError('User','login', $e->getMessage(), 1);
			echo 201;
		}
	}
    
    public function isLoggedIn() {
		if(isset($_SESSION['is_logged_in'])){
			
			$uid = $_SESSION['is_logged_in'];
			
			$sql  = "SELECT * FROM users WHERE id = ? AND Deleted <> 1";
			$query = $this->conn->prepare($sql);
			$query->bindParam(1, $uid);
			$query->execute();
			
			$count = $query->rowCount();
			
			if($count){
				$row = $query->fetch(PDO::FETCH_ASSOC);
				$user = new User;
				$user->id = $row['id'];
				$user->firstName = $row['firstname'];
				$user->lastName = $row['lastname'];
				$user->email = $row['email'];
				$user->phone = $row['phone'];
				$user->dateCreated = $row['date_created'];
				$user->initRoles($uid);
				return $user;
			} else{
				return false;
			}
		}
	}

	public function initRoles($uid) {
		$role = new Role;
        $sql  = "SELECT t1.role_id, t2.role ";
		$sql .= "FROM user_role as t1 ";
		$sql .= "JOIN roles as t2 ";
		$sql .= "ON t1.role_id = t2.id ";
		$sql .= "WHERE t1.user_id = $uid";
        $query = $this->conn->query($sql);
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $this->roles[$row["role"]] = $role->getRolePerm($row["role_id"]);
        }
    }

    public function hasPrivilege($perm) {
    	$role = new Role;
    	$res = false;
        foreach($this->roles as $role) {
            if($role->hasPerm($perm)) {
                $res = true;
            }
        }
        return $res;
    }

	public function userDetails($userId) {
		$sql = "SELECT * FROM users WHERE id = ? AND deleted <> 1";
		$query = $this->conn->prepare($sql);
		$query->bindParam(1, $userId);
		$query->execute();
		$row = NULL;
		if($query->rowCount() > 0) {
			$row = $query->fetch(PDO::FETCH_ASSOC);
		}
		return $row;
	}

	public function getRole($userId) {
		try {
			$sql = "SELECT * FROM user_role WHERE user_id = ".$userId;
			$query = $this->conn->query($sql);
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$roleId = $res["role_id"];
			$sql = "SELECT * FROM roles WHERE id = ".$roleId;
			$query = $this->conn->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

			return $row;

		} catch(PDOException $e) {
			$this->err->logError('User','getRole', $e->getMessage(), 1);
		}
	}

	public function getDepartment($designationId) {
		$res[] = "";
		try {
			$sql = "SELECT department_id, name FROM designations WHERE id=".$designationId;
			$query = $this->conn->query($sql);
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$departmentId = $res["department_id"];
			$sql = "SELECT name FROM departments WHERE id=".$departmentId;
			$query = $this->conn->query($sql);
			$res_ = $query->fetch(PDO::FETCH_ASSOC);
			$department = $res_["name"];
			$res["department"] = $department;
			return $res;

		} catch(PDOException $e) {
			$this->err->logError('User','getDepartment', $e->getMessage(), 1);
		}	
	}

	public function getGrade($gradeId) {
		try {
			$sql = "SELECT grade FROM grades WHERE id=".$gradeId;
			$query = $this->conn->query($sql);
			$res = $query->fetch(PDO::FETCH_ASSOC);
			return $res["grade"];
		} catch(PDOException $e) {
			$this->err->logError('User','getGrade', $e->getMessage(), 1);
		}
	}

	public function getSupervisor($userId) {
		try {
			$sql  = "SELECT t2.supervisor_id ";
			$sql .= "FROM users t1 ";
			$sql .= "JOIN subordinates t2 ON ";
			$sql .= "t1.id = t2.subordinate_id ";
			$sql .= "WHERE t1.id = ".$userId;

			$query = $this->conn->query($sql);
			$supervisor = NULL;
			if($query->rowCount() > 0) {
				
				$row = $query->fetch(PDO::FETCH_ASSOC);
				$supervisorId = $row["supervisor_id"];
				
				$sql = "SELECT id, firstname, lastname, email, phone FROM users WHERE id = ".$supervisorId;
				$query = $this->conn->query($sql);
	
				$row = $query->fetch(PDO::FETCH_ASSOC);
				$supervisor = $row;

			}
			return $supervisor;

		} catch(PDOException $e) {
			//	echo $e;
		$this->err->logError('User','getSupervisor', $e->getMessage(), 1);
		}
	}

	public function isSupervisor($userId, $uid) {
		try {
			$sql  = "SELECT * FROM subordinates WHERE subordinate_id = ".$userId. " AND supervisor_id = ".$uid; 
			$query = $this->conn->query($sql);
			$bool = false;
			if($query->rowCount() > 0) {
				$bool = true;
			} 
			return $bool;

		} catch(PDOException $e) {
			$this->err->logError("User", "isSupervisor", $e->getMessage(), 1);
		}

	}
    
}

?>