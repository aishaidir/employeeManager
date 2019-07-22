<?php

class Report {
    public $year;
    public $month;
    public $week;
    public $day;
    public $activity;
    public $milestone;
    public $userId;
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

    private function isWeekCreated($year, $month, $week, $userId) {
        $weeklyId = 0;
        try {
            $sql = "SELECT * FROM weekly WHERE year = ? AND month = ? AND week = ? AND user_id = ? AND deleted <> 1";
            $query = $this->conn->prepare($sql);
            $query->bindParam(1, $year, PDO::PARAM_INT);
            $query->bindParam(2, $month, PDO::PARAM_STR);
            $query->bindParam(3, $week, PDO::PARAM_INT);
            $query->bindParam(4, $userId, PDO::PARAM_INT);

            $query->execute();

            if($query->rowCount() > 0) {
                $row = $query->fetch(PDO::FETCH_ASSOC);
                $weeklyId = $row["id"];
            }

            return $weeklyId;

        } catch(PDOException $e) {
            $this->err->logError("Report", "isWeekCreated", $e->getMessage(), 1);
        }

    }

    private function preventDuplicateReport($weeklyId, $day, $userId) {
        try {
            $sql = "SELECT t1.*, t2.* ";
            $sql .= "FROM weekly t1, daily t2 ";
            $sql .= "WHERE t2.weekly_id = t1.id ";
            $sql .= "AND t2.weekly_id = $weeklyId AND t2.day = $day AND t1.user_id = $userId";
            $query = $this->conn->prepare($sql);
            $query->bindParam(1, $weeklyId, PDO::PARAM_INT);
            $query->bindParam(2, $day, PDO::PARAM_INT);
            $query->bindParam(3, $userId, PDO::PARAM_INT);

            $query->execute();

            if($query->rowCount() > 0)
                return true;
            else
                return false;

        } catch(PDOException $e) {
            $this->err->logError("Report", "preventDuplicateReport", $e->getMessage(), 1);
        }

    }

    public function createDailyReport($report) {

        $id = 0;

        if(self::isWeekCreated($report->year, $report->month, $report->week, $report->userId) != 0) {
            $id = self::isWeekCreated($report->year, $report->month, $report->week, $report->userId);

            if(self::preventDuplicateReport($id, $report->day, $report->userId)) { echo 201;exit; }

            try {
                $sql  = "INSERT INTO daily (weekly_id, day, activity, milestone, date_created) ";
                $sql .= "VALUES('". $id ."', '".$report->day."', '".$report->activity."', '".$report->milestone."', '". $this->dateTime ."')";
                $query = $this->conn->query($sql);

                $_SESSION["success"] = md5(time());
                echo 100;
                exit;
            } catch(PDOException $e) {
                $this->err->logError("Report", "createDailyReport", $e->getMessage(), 1);
                echo 101;
            }

        } else {
            try {
                $sql  = "INSERT INTO weekly ";
                $sql .= "(user_id, ";
                $sql .= "year, ";
                $sql .= "month, ";
                $sql .= "week, ";
                $sql .= "date_created) ";
                $sql .= "VALUES (";
                $sql .= "?, ";
                $sql .= "?, ";
                $sql .= "?, ";
                $sql .= "?, ";
                $sql .= "'". $this->dateTime ."') ";
                $query = $this->conn->prepare($sql);
                $query->bindParam(1, $report->userId, PDO::PARAM_INT);
                $query->bindParam(2, $report->year, PDO::PARAM_INT);
                $query->bindParam(3, $report->month, PDO::PARAM_STR);
                $query->bindParam(4, $report->week, PDO::PARAM_INT);

                if($query->execute()) {
                    $id = $this->conn->lastInsertId();
                    $sql  = "INSERT INTO daily (weekly_id, day, activity, milestone, date_created) ";
                    $sql .= "VALUES('". $id ."', '".$report->day."', '".$report->activity."', '".$report->milestone."', '". $this->dateTime ."')";
                    $this->conn->query($sql);
                }

                $_SESSION["success"] = md5(time());
                echo 100;
            } catch(Exception $e) {
                $this->err->logError("Report", "createDailyReport", $e->getMessage(), 1);
                echo 101;
            }
        }

    }

    public function editDayReport($report) {
        try {
            $sql = "UPDATE daily SET activity = ?, milestone = ? WHERE id = ?";
            $query = $this->conn->prepare($sql);
            $query->bindParam(1, $report->activity, PDO::PARAM_STR);
            $query->bindParam(2, $report->milestone, PDO::PARAM_STR);
            $query->bindParam(3, $report->id, PDO::PARAM_INT);

            $query->execute();

            echo 100;

        } catch(PDOException $e) {
            $this->err->logError("Report", "editDayReport", $e->getMessage(), 1);
            echo 101;
        }
    }

    public function getWeek($date, $rollover) {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $weeks = 1;

        for ($i = 1; $i <= $elapsed; $i++) {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));
            if($day == strtolower($rollover))  $weeks ++;
        }

        return $weeks;
    }

    public function getWeekReport($userId, $submitted="") {
        try {
            if($submitted) {
                $sql  = "SELECT * FROM weekly WHERE user_id = ". $userId ." AND submitted = 1 AND deleted <> 1 GROUP BY week";
            } else {
                $sql  = "SELECT * FROM weekly WHERE user_id = ". $userId ." AND deleted <> 1 GROUP BY week";
            }
            $query = $this->conn->query($sql);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
        catch(PDOException $e) {

            $this->err->logError("Report", "getWeekReport", $e->getMessage(), 1);
        }
    }

    public function weekReportDetails($weeklyId) {
        try {
            $sql  = "SELECT * FROM weekly WHERE id = ".$weeklyId;
            $query = $this->conn->query($sql);
            $results = $query->fetch(PDO::FETCH_ASSOC);
            return $results;
        }
        catch(PDOException $e) {
            $this->err->logError("Report", "weekReportDetails", $e->getMessage(), 1);
        }
    }

    public function getWeeksDailySummary($month, $year, $week, $id, $userId) {
        // First check if all the parameters match a record in the database
        try {
            $sql  = "SELECT * FROM weekly WHERE ";
            $sql .= "month = ? AND ";
            $sql .= "year = ? AND ";
            $sql .= "week = ? AND ";
            $sql .= "id = ? AND ";
            $sql .= "user_id = ?";
            $query = $this->conn->prepare($sql);
            $query->bindParam(1, $month, PDO::PARAM_STR);
            $query->bindParam(2, $year, PDO::PARAM_INT);
            $query->bindParam(3, $week, PDO::PARAM_INT);
            $query->bindParam(4, $id, PDO::PARAM_INT);
            $query->bindParam(5, $userId, PDO::PARAM_INT);

            $query->execute();

            $row = NULL;

            if($query->rowCount() > 0) {
                $sql = "SELECT * FROM daily WHERE weekly_id = $id";
                $query = $this->conn->query($sql);
                $row = $query->fetchAll(PDO::FETCH_ASSOC);
            }

            return $row;

        } catch(PDOException $e) {
            $this->err->logError("Report", "getWeeksDailySummary", $e->getMessage(), 1);
        }
    }

    public function submitWeeklyReport($report) {
        try {
            $sql = "INSERT INTO report_summary ";
            $sql .= "(weekly_id, ";
            $sql .= "key_challenges, ";
            $sql .= "recommendations, ";
            $sql .= "date_submitted) ";
            $sql .= "VALUES (";
            $sql .= "?, ";
            $sql .= "?, ";
            $sql .= "?, ";
            $sql .= "'". $this->dateTime ."') ";
            $query = $this->conn->prepare($sql);
            $query->bindParam(1, $report->weekly_id, PDO::PARAM_INT);
            $query->bindParam(2, $report->key_challenges, PDO::PARAM_STR);
            $query->bindParam(3, $report->recommendations, PDO::PARAM_STR);

            if($query->execute()) {
                $sql  = "UPDATE weekly SET submitted = 1, date_submitted = '".$this->dateTime."' WHERE id = ".$report->weekly_id;
                $this->conn->query($sql);
            }

            $_SESSION["week_report_submitted"] = md5(time());

            $library = new Library();

            $user = new User;
            $supervisor = $user->getSupervisor($report->uid);
            $supervisorFirstName = $supervisor["firstname"];
            $supervisorEmail = $supervisor["email"];
            $supervisorPhone = $supervisor["phone"];

            $subordinate = $user->userDetails($report->uid);
            $firstname = $subordinate["firstname"];
            $lastname = $subordinate["lastname"];
            $name = $firstname. " " .$lastname;
            $username = $library->cleanURL($firstname. " " .$lastname);
            $email = $subordinate["email"];
            $phone = $subordinate["phone"];

            $weeklyReport = $this->weekReportDetails($report->weekly_id);
            $weeklyId = $report->weekly_id;
            $year = $weeklyReport["year"];
            $month = $weeklyReport["month"];
            $week = $weeklyReport["week"];

            $emailBody = "";

            include_once('../emails/weekly_report.php');

            $this->mail->IsSMTP(); // telling the class to use SMTP
            $this->mail->SMTPAuth = true; // enable SMTP authentication
            $this->mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $this->mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
            $this->mail->Port = 465; // set the SMTP port for the GMAIL server
            $this->mail->Username = "stetis.taskmanager@gmail.com";
            $this->mail->Password = "%Security1";

            $this->mail->FromName = "STETiS Task Manager";

            $this->mail->addAddress($supervisorEmail, $name);
            $this->mail->isHTML(true);
            $this->mail->Subject = "You have a report to review";
            $this->mail->Body = $emailBody;

            $this->mail->send();

            echo 100;


        } catch(PDOException $e) {
            $this->err->logError("Report", "submitWeeklyReport", $e->getMessage(), 1);
            return 101;
        }
    }

    public function checkSubmitStatus($weeklyId) {
        $bool = false;
        try {
            $sql = "SELECT * FROM weekly WHERE submitted = 1 AND id = ".$weeklyId;
            $query = $this->conn->query($sql);

            if($query->rowCount() > 0) {
                $bool = true;
            }
            return $bool;

        } catch(PDOException $e) {
            $this->err->logError("Report", "checkSubmitStatus", $e->getMessage(), 1);
        }
    }

    public function weeklyReportSubmitDate($weeklyId) {
        try {
            $sql = "SELECT date_submitted FROM weekly WHERE submitted = 1 AND id = ".$weeklyId;
            $query = $this->conn->query($sql);
            $dateSubmitted = NULL;
            if($query->rowCount() > 0) {
                $row = $query->fetch(PDO::FETCH_ASSOC);
                $dateSubmitted = $row["date_submitted"];
            }
            return $dateSubmitted;
        } catch(PDOException $e) {
            $this->err->logError("Report", "reportSubmitDate", $e->getMessage(), 1);
        }
    }

    public function getKeyChallengesRecomm($str, $weeklyId) {
        $res = NULL;
        try {
            $sql = "SELECT $str FROM report_summary WHERE weekly_id = ".$weeklyId;
            $query = $this->conn->query($sql);

            if($query->rowCount() > 0) {
                $row = $query->fetch(PDO::FETCH_ASSOC);
                $res = $row[$str];
            }
            return $res;

        } catch(PDOException $e) {
            $this->err->logError("Report", "getKeyChallengesRecomm", $e->getMessage(), 1);
        }
    }

    public function reviewReport($report) {
        try {
            $sql  = "UPDATE report_summary SET rating_id = ?, ";
            $sql .= "remarks = ?, reviewed_by = ?, date_reviewed = '".$this->dateTime. "' ";
            $sql .= "WHERE weekly_id = ?";
            $query = $this->conn->prepare($sql);
            $query->bindParam(1, $report->ratingId, PDO::PARAM_INT);
            $query->bindParam(2, $report->remarks, PDO::PARAM_STR);
            $query->bindParam(3, $report->remarkedBy, PDO::PARAM_INT);
            $query->bindParam(4, $report->weeklyId, PDO::PARAM_INT);

            if($query->execute()) {
                $_SESSION["week_report_reviewed"] = md5(time());

                $library = new Library();

                $user = new User;
                $supervisor = $user->getSupervisor($report->userId);
                $supervisorName = $supervisor["firstname"]. " " .$supervisor["lastname"];
                $supervisorEmail = $supervisor["email"];
                $supervisorPhone = $supervisor["phone"];

                $subordinate = $user->userDetails($report->userId);
                $firstname = $subordinate["firstname"];
                $lastname = $subordinate["lastname"];
                $name = $firstname. " " .$lastname;
                $username = $library->cleanURL($firstname. " " .$lastname);
                $email = $subordinate["email"];
                $phone = $subordinate["phone"];

                $weeklyReport = $this->weekReportDetails($report->weeklyId);
                $weeklyId = $report->weeklyId;
                $year = $weeklyReport["year"];
                $month = $weeklyReport["month"];
                $week = $weeklyReport["week"];

                include_once('../emails/reviewed_report.php');

                $this->mail->IsSMTP(); // telling the class to use SMTP
                $this->mail->SMTPAuth = true; // enable SMTP authentication
                $this->mail->SMTPSecure = "ssl"; // sets the prefix to the servier
                $this->mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
                $this->mail->Port = 465; // set the SMTP port for the GMAIL server
                $this->mail->Username = "stetis.taskmanager@gmail.com";
                $this->mail->Password = "%Security1";

                $this->mail->FromName = "STETiS Task Manager";

                $this->mail->addAddress($email, $name);
                $this->mail->isHTML(true);
                $this->mail->Subject = "You report has been reviewed";
                $this->mail->Body = $emailBody;

                $this->mail->send();

                echo 100;
            }

        } catch(PDOException $e) {
            $this->err->logError("Report", "reviewReport", $e->getMessage(), 1);
            echo 101;
        }
    }

    public function reviewStatus($weeklyId) {
        $bool = false;
        try {
            $sql = "SELECT * FROM report_summary WHERE rating_id <> 0 AND weekly_id = ".$weeklyId;
            $query = $this->conn->query($sql);

            if($query->rowCount() > 0) {
                $bool = true;
            }
            return $bool;

        } catch(PDOException $e) {
            $this->err->logError("Report", "reviewStatus", $e->getMessage(), 1);
        }
    }

    public function getReportSummary($weeklyId) {
        try {
            $sql = "SELECT * FROM `view report summary` WHERE weekly_id =".$weeklyId;
            $query = $this->conn->query($sql);
            $res = NULL;
            if($query->rowCount() > 0) {
                $res = $query->fetch(PDO::FETCH_ASSOC);
            }
            return $res;
        } catch(PDOException $e) {
            $this->err->logError("Report", "getReportSummary", $e->getMessage(), 1);
        }
    }

}

?>