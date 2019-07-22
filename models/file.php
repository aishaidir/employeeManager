<?php

class File
{
	public $filename;
	public $exts = array('image/jpeg','image/png', 'image/jng');
	public $caption;
	public $authorId;
	public $dir = '../imgs/uploads/';
	public $max_size;
	public $date_uploaded;
	public $error = '';
	public $conn;
	public $err;

	function __construct()
	{
		$config = new Config;
		$this->conn = $config::connect();
		$this->err = new Error;
		$this->date_uploaded = date_format(new DateTime('now'), "Y-m-d H:i:s");
	}

	public function set_filename($filename)
	{
		$this->filename = $filename;
	}

	public function set_dir($new_dir)
	{
		$this->dir = $new_dir;
	}

	public function set_max_size($max_size)
	{
		$this->max_size = $max_size;
	}

	public function set_allowed_extensions($new_exts)
	{
		if(is_array($new_exts))
		{
			$this->exts = $new_exts;
		} else
		{
			$this->exts = array($new_exts);
		}
	}

	public function get_extension($file) 
	{
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $ext   = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        return $ext;
    }

    public function validate_file($file)
    {
    	$error = '';
    	
    	if(empty($file['name'][0]))
    	{ 
    		$error .= 'No file found. <br />';
    	}

    	if(!in_array($this->get_extension($file), $this->exts))
    	{
    		$error .= 'Extension is not allowed. <br />';	
    	} 

    	if($file['size'][0] > $this->max_size)
    	{
    		$error .= 'Max File Size Exceeded. Limit: '. $this->max_size.' bytes. <br />';	
    	} 

    	$this->error = $error;
    }

	public function upload_file($file, $caption)
	{
		$this->validate_file($file);

		if($this->error) 
		{
			print $this->error;
		} else
		{
			$status = false;
			$new_dir = $this->dir.$this->filename;
			$this->caption = $caption;
			$this->authorId = $authorId;
			try
			{
				move_uploaded_file($file["tmp_name"], $new_dir);

				$sql  = "INSERT INTO photos (filename, caption, author_id, date_uploaded) ";
				$sql .= "VALUES ( ";
				$sql .= "?, ";
				$sql .= "?, ";
				$sql .= "?, ";
				//$sql .= "'". 1 ."', ";
				$sql .= "'". $this->date_uploaded ."') ";
				$query  = $this->conn->prepare($sql);
				$query->bindParam(1, $this->filename);
				$query->bindParam(2, $this->caption);
				$query->bindParam(3, $this->authorId);
				$query->execute();
				$status = true;
			} catch(PDOException $e)
			{
				$this->err->log_error('Files', 'upload_file', $e->getMessage());
			}
		}
		return $status;
	}

	public function get_all_photos()
    {
    	try
    	{
    		$sql = "SELECT * FROM photos WHERE Deleted <> 1";
    		$query = $this->conn->query($sql);
    		$all_photos = $query->fetchAll(PDO::FETCH_ASSOC);
    		return $all_photos;
    	} catch(PDOException $e)
    	{
    		$this->err->log_error("File", "get_all_photos", $e->getMessage());
    	}
    }

    public function get_file_details($id)
    {
    	try
    	{
    		$sql = "SELECT * FROM photos WHERE id = ?";
    		$query = $this->conn->prepare($sql);
    		$query->bindParam(1, $id);
    		$query->execute();
			$res = $query->fetch(PDO::FETCH_ASSOC);
			return json_encode($res);
    	} catch(PDOException $e)
    	{
    		$this->err->log_error("File", "edit_file", $e->getMessage());
    	}
    }

}

?>