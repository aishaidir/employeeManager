<?php

class Task {
	public $title;
	public $description;
	public $startDate;
	public $dueDate;
	public $assignTo = array();
	public $priority;
	public $author;
	public $dateCreated;
	public $mail;
	private $conn;
	private $dateTime;
	private $err;

	function __construct() {
		$config = new Config;
		$this->conn = $config->connect();
		$this->mail = new PHPMailer;
		$this->dateTime = date_format(new DateTime('now'), "Y-m-d H:i:s");
		$this->err = new Error;
    }

    public function createTask($task) {
    	try {
    		$sql  = "INSERT INTO task (author, title, description, start_date, due_date, priority, date_created) ";
    		$sql .= "VALUES ( ";
    		$sql .= "?, ";
    		$sql .= "?, ";
    		$sql .= "?, ";
    		$sql .= "?, ";
    		$sql .= "?, ";
    		$sql .= "?, ";
    		$sql .= "'". $this->dateTime ."')";
    		$query = $this->conn->prepare($sql);
			$query->bindParam(1, $task->author, PDO::PARAM_INT);
			$query->bindParam(2, $task->title, PDO::PARAM_STR);
			$query->bindParam(3, $task->description, PDO::PARAM_STR);
			$query->bindParam(4, $task->startDate, PDO::PARAM_INT);
			$query->bindParam(5, $task->dueDate, PDO::PARAM_INT);
			$query->bindParam(6, $task->priority, PDO::PARAM_STR);
			if($query->execute()) {
				$id = $this->conn->lastInsertId();
				if(count($task->participants) > 0) {
					$task->participant  = explode(',', $task->participants);
					$sql = "INSERT INTO task_participant (task_id, participant_id) VALUES( ";
					$sql .= "$id,".implode("),($id,", $task->participant) .")";
					$query  = $this->conn->query($sql);	
                    $this->sendEmailToParticipant($id, $task->title, implode(",", $task->participant), $task->author);
				}
			}
			echo 100;
    	} catch (PDOException $e) {
    		$this->err->logError("Task", "createTask", $e->getMessage(), 1);	
			echo 101;
    	}
    }

    public function sendEmailToParticipant($taskId, $title, $participantId, $authorId) {
        try {
            $sql = "SELECT firstname, concat(firstname,' ',lastname) as name, email ";
            $sql .= "FROM users WHERE id IN (".$participantId.")";
            $query = $this->conn->query($sql);
            
            $library = new Library;
            $config = new Config;

            $taskURL = $config::$baseURL."task/".$taskId."/".$library->cleanURL($title)."";

            $author = $this->getAuthor($authorId);
            

            $this->mail->IsSMTP(); // telling the class to use SMTP
            $this->mail->SMTPAuth = true; // enable SMTP authentication
            $this->mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $this->mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
            $this->mail->Port = 465; // set the SMTP port for the GMAIL server
            $this->mail->Username = "Aisha.employeereportmanager@gmail.com"; 
            $this->mail->Password = "%Security1"; 
        
            $this->mail->FromName = "Employee daily report manager";
            $this->mail->isHTML(true);
            $this->mail->Subject = "A task has been assigned to you";

            while($res = $query->fetchAll(PDO::FETCH_ASSOC)) {

                $authorName = $author["name"];
                $authorFirstName = $author["firstname"];
                $authorEmail = $author["email"];
                
                $name = $res["name"];
                $firstName = $res["firstname"];
                $email = $res["email"];

                include('../emails/task.php');

                $this->mail->addAddress($email, $name);
                $this->mail->Body = $emailBody;
                $this->mail->send();
                
            }

        } catch (PDOException $e) {
            $this->err->logError("Task", "sendEmailToParticipant", $e->getMessage(), 1);    
        }
    }

    public function getAuthor($authorId) {
        try {
            $sql = "SELECT id, firstname, concat(firstname, ' ',lastname) as name, email FROM users WHERE id =" .$authorId;
            $query = $this->conn->query($sql);
            $res = $query->fetch(PDO::FETCH_ASSOC); 

            return $res;

        } catch (PDOException $e) {
            $this->err->logError("Task", "getAuthor", $e->getMessage(), 1);    
        }
    }

    public function getTasks($uid) {
    	try {
			$sql  = "SELECT t1.*, t2.id as author_id, t2.firstname, t2.lastname ";
			$sql .= "FROM task t1 ";
			$sql .= "INNER JOIN users AS t2 ON ";
			$sql .= "t1.author = t2.id ";
			$sql .= "WHERE EXISTS (SELECT * FROM task_participant WHERE participant_id = ". $uid .") OR t2.id = ".$uid." ";
			$sql .= "AND t1.status = 0";
			$query = $this->conn->query($sql);
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		} 
		catch(PDOException $e) {
			$this->err->logError("Task", "getTasks", $e->getMessage(), 1);	
		}
    }

    public function getAllTasks($uid) {
        try {
            $sql  = "SELECT t1.*, t2.id as author_id, t2.firstname, t2.lastname ";
            $sql .= "FROM task t1 ";
            $sql .= "INNER JOIN users AS t2 ON ";
            $sql .= "t1.author = t2.id ";
            $sql .= "WHERE EXISTS (SELECT * FROM task_participant WHERE participant_id = ". $uid .") OR t2.id = ".$uid."";
            $query = $this->conn->query($sql);
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        catch(PDOException $e) {
            $this->err->logError("Task", "getTasks", $e->getMessage(), 1);
        }
    }

    public function getTaskDetailsById($taskId) {
        try {
            $sql = "SELECT * FROM tasks WHERE id =" .$taskId;
            $query = $this->conn->query($sql);
            $res = $query->fetch(PDO::FETCH_ASSOC); 

            return $res;

        } catch (PDOException $e) {
            $this->err->logError("Task", "getAuthor", $e->getMessage(), 1);    
        }
    }

    public function taskParticipants($taskId) {
    	try {
    		$sql  = "SELECT t1.id, t1.firstname, t1.lastname ";
    		$sql .= "FROM users t1 INNER JOIN task_participant t2 ON ";
    		$sql .= "t1.id = t2.participant_id ";
    		$sql .= "WHERE t2.task_id = ".$taskId; 
    		$query = $this->conn->query($sql);
    		$res = "";
    		$config = new Config;
    
    		while($row = $query->fetch(PDO::FETCH_ASSOC)) {
    			$userProfile = strtolower($row["firstname"]. " " .$row["lastname"])."/".$row["id"];
    			$userProfile = str_replace(" ", "-", $userProfile);
    			$res .= "<li><a href='". $config::$baseURL ."view/". $userProfile ."'>". $row["firstname"].' '.$row["lastname"] ."</a></li>";
    		}
    		return $res;
    	} catch (Exception $e) {
    		$this->err->logError("Task", "taskParticipants", $e->getMessage(), 1);	
    	}
    }

    public function getTaskDetails($taskId, $uid) {
    	$res = 0;
    	try {
    	
			$sql  = "SELECT t1.*, t2.id as author_id, t2.firstname, t2.lastname ";
			$sql .= "FROM task t1 ";
			$sql .= "INNER JOIN users AS t2 ON ";
			$sql .= "t1.author = t2.id ";
			$sql .= "WHERE EXISTS (SELECT * FROM task_participant WHERE participant_id = ". $uid .") ";
			$sql .= "OR EXISTS (SELECT * FROM task WHERE author = ". $uid .") ";
			$sql .= "AND t1.id = ". $taskId;
			$query = $this->conn->query($sql);
			$res = $query->fetch(PDO::FETCH_ASSOC);
			return $res;
		} 
		catch(PDOException $e) {
			$this->err->logError("Task", "getTasks", $e->getMessage(), 1);	
		}
    }

    public function taskParticipantForReview($taskId, $authorId) {
    	try {
    		$sql  = "SELECT t1.id, t1.firstname, t1.lastname ";
    		$sql .= "FROM users t1 INNER JOIN task_participant t2 ON ";
    		$sql .= "t1.id = t2.participant_id ";
    		$sql .= "WHERE t2.task_id = ".$taskId; 
    		$query = $this->conn->query($sql);
    		
    		$res = "";
    		$config = new Config();
    		$user = new User();

    		$reviewParticipant = $this->isAuthor($taskId, $authorId) ? "class='view_participant_perf'" : "";
    
    		while($row = $query->fetch(PDO::FETCH_ASSOC)) {

    			$redirectToProfile = !$this->isAuthor($taskId, $authorId) ? "href='". $user->getUserURL($row["id"]) ."'" : "href='#' data-id='". $row["id"] ."' data-task-id='". $taskId ."'";
    			
    			$res .= "<li>";
    			$res .= "<a ". $reviewParticipant ."  ". $redirectToProfile .">". $row["firstname"].' '.$row["lastname"] ."</a>";
    			$res .= "</li>";
    		}
    		return $res;
    	} catch (Exception $e) {
    		$this->err->logError("Task", "taskParticipantForReview", $e->getMessage(), 1);	
    	}
    }

    public function isParticipant($taskId, $uid) {
    	$bool = false;
    	try {
    		$sql = "SELECT * FROM task_participant WHERE task_id = ".$taskId." AND participant_id = ".$uid;
    		$query = $this->conn->query($sql);
    		if($query->rowCount() > 0) {
				$bool = true;
			}
			return $bool;
    	} catch (Exception $e) {
    		$this->err->logError("Task", "isParticipant", $e->getMessage(), 1);
    	}
    }

     public function isAuthor($taskId, $authorId) {
    	$bool = false;
    	try {
    		$sql = "SELECT * FROM task WHERE id = ".$taskId." AND author = ".$authorId;
    		$query = $this->conn->query($sql);
    		if($query->rowCount() > 0) {
				$bool = true;
			}
			return $bool;
    	} catch (Exception $e) {
    		$this->err->logError("Task", "isAuthor", $e->getMessage(), 1);
    		return $bool;
    	}
    }

    public function updateTaskStatus($taskId, $authorId, $status) {
    	$res = 101;
    	try {
    		$sql = "UPDATE task SET status =".$status ." WHERE author = ".$authorId. " AND id =" .$taskId;
    		$query = $this->conn->query($sql);
    		if($query->rowCount() > 0) {
    			if($status == 1)
					$res = 100;
				else
					$res = 200;
			}
			return $res;
    	} catch (Exception $e) {
    		$this->err->logError("Task", "updateTaskStatus", $e->getMessage(), 1);
    		return 101;
    	}
    }

    public function updateParticipantStatus($taskId, $authorId, $participantId, $remarks, $status) {
    	$res = 101;
    	try {
    		$sql = "UPDATE task_participant SET status =".$status .", remarks = '". $remarks. "', date_updated = '". $this->dateTime ."' WHERE participant_id = ".$participantId. " AND task_id =" .$taskId;
    		$query = $this->conn->query($sql);
    		if($query->rowCount() > 0) {

                $config = new Config;
                $library = new Library;

                $task = $this->getTaskDetailsById($taskId);
                $title = $task["title"];
                $authorId = $task["author"];

                $taskURL = $config::$baseURL."task/".$taskId."/".$library->cleanURL($title)."";
                
                $author = $this->getAuthor($authorId);
                $authorName = $author["name"];
                $authorFirstName = $author["firstname"];
                $authorEmail = $author["email"];

                $participant = $this->getAuthor($participantId);
                $participantName = $participant["name"];
                $participantFirstName = $participant["firstname"];
                $participantEmail = $participant["email"];

                include('../emails/participant_task_update.php');

                $this->mail->IsSMTP(); // telling the class to use SMTP
                $this->mail->SMTPAuth = true; // enable SMTP authentication
                $this->mail->SMTPSecure = "ssl"; // sets the prefix to the servier
                $this->mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
                $this->mail->Port = 465; // set the SMTP port for the GMAIL server
                $this->mail->Username = "stetis.taskmanager@gmail.com"; 
                $this->mail->Password = "%Security1"; 
            
                $this->mail->FromName = "STETiS Task Manager";
                $this->mail->isHTML(true);
                $this->mail->Subject = "Someone has updated their status on the task you assigned them";


                $this->mail->addAddress($authorEmail, $authorName);
                $this->mail->Body = $emailBody;
                $this->mail->send();
    			
                if($status == 1)
					$res = 100;
				else
					$res = 200;
			}
			return $res;
    	} catch (Exception $e) {
    		$this->err->logError("Task", "updateParticipantStatus", $e->getMessage(), 1);
    		return $res;
    	}
    }

    public function getParticipantDetails($taskId, $participantId) {
    	try {
    		$sql  = "SELECT t1.id, concat(`t1`.`firstname`,' ',`t1`.`lastname`) as name, "; 
    		$sql .= "t2.task_id, t2.remarks, t2.status, t2.date_updated, t2.author_rating, t2.author_remarks ";
    		$sql .= "FROM users t1 INNER JOIN task_participant t2 ON ";
    		$sql .= "t1.id = t2.participant_id ";
    		$sql .= "WHERE task_id = ".$taskId. " AND participant_id = ".$participantId;
    		$query = $this->conn->query($sql);
    		$res = $query->fetch(PDO::FETCH_ASSOC);
    		return $res;
    	} catch (PDOException $e) {
    		$this->err->logError("Task", "getParticipantDetails", $e->getMessage(), 1);	
    	}
    }

    public function reviewParticipant($taskId, $participantId, $authorRating, $authorRemarks) {
    	$res = 101;
    	try {
    		$sql = "UPDATE task_participant SET author_rating ='".$authorRating ."', author_remarks = '". $authorRemarks. "', date_reviewed = '". $this->dateTime ."' WHERE participant_id = ".$participantId. " AND task_id =" .$taskId;
    		$query = $this->conn->query($sql);
    		if($query->rowCount() > 0) {
    			$res = 100;
			}
			return $res;
    	} catch (Exception $e) {
    		$this->err->logError("Task", "reviewParticipant", $e->getMessage(), 1);
    		return $res;
    	}
    }


}

?>