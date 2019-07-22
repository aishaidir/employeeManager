<?php

class Library{
	public $curPage;
    public $conn;
    public $err;
	
	public function __construct()
	{
        $database = new Config;
        $this->conn = $database->connect();
        $this->err = new Error;
		return $this->curPage();
	}
	
	public function curPage() {
    	return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/")+1);
	}

    public function strNameID($str) {
        $res = strtolower(str_replace(" ", "_", $str));
        $res = trim($res, " ");
        return $res;
    }
	
    public function breakString($string,  $group = 1, $delimeter = ' ', $reverse = true) {
        $string_length = strlen($string);
        $new_string = [];
        while($string_length > 0) {
            if($reverse) {
                array_unshift($new_string, substr($string, $group*(-1)));
            } 
            else {
            	array_unshift($new_string, substr($string, $group));
            }
                $string = substr($string, 0, ($string_length - $group));
                $string_length = $string_length - $group;
        }
        $result = '';
        foreach($new_string as $substr){
            $result.= $substr.$delimeter;
        }
        return trim($result, " ");
    }

    public function total($table, $id="") {
        $total = 0;
        try {
            if(!$id) {
                $sql = "SELECT * FROM ".$table." WHERE Deleted <> 1";
            }
            else {
                $sql = "SELECT * FROM ".$table." WHERE supervisor_id = ". $id ."";
            }
            $query = $this->conn->query($sql);
            $total = $query->rowCount();
        } 
        catch(PDOException $e) {
            $this->err->logError('Library', 'total', $e->getMessage());
        }
        return $total;
    }

    public function textTrunc($string, $limit, $more='') {
        $break =' ';
        $replace ='...';
        // Sanitize text variable
       // $string = filter_var($string, FILTER_SANITIZE_STRING);
        $stringLength = strlen($string);
        // Return with no change if string is shorter or equal to $limit
        if($stringLength <= $limit) {
            return $string;
        }
        $breakPoint = strpos($string, $break, $limit);
        if($breakPoint == true) {
            if($breakPoint < $stringLength - 1) {
                $string = substr($string, 0, $breakPoint) . ' ' . $replace;
            }
        }
        return $string . $more;
    }

    public function cleanURL($url){
        //Convert accented characters, and remove parentheses and apostrophes
        $from = explode(',', "ç,æ,oe,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
        $to = explode(',', 'c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
        //Do the replacements, and convert all other non-alphanumeric characters to spaces
        $url = preg_replace('~[^\w\d]+~', '-', str_replace ($from, $to, trim($url)));
        //Remove a hyphen (-) at the beginning or end and make lowercase
        return strtolower(preg_replace ('/^-/', '', preg_replace ('/-$/', '', $url)));
    }

}

?>