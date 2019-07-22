<?php

class FileManager
{
	public $caption;
	public $date_uploaded;
	public $dir = 'imgs/uploads/';
	public $file_name;
	public $max_size;
	public $exts = array('image/jpeg','image/png','image/gif');
	public $printError = TRUE;
	public $error = '';

	function __construct()
	{
		$database = new Config;
		$this->conn = $database->connect();
		$this->date_uploaded = date_format(new DateTime('now'), "Y-m-d H:i:s");
	}

	public function setDir($new_dir) {
    	$this->dir = $new_dir;
  	}
  	public function setFileName($new_filename) {
    	$this->file_name = $new_filename;
  	}
  	public function setMaxSize($new_size) {
    	$this->max_size = $new_size;
  	}
  	public function setAllowedExtensions($new_exts) {
	    if(is_array($new_exts)) 
	    {
	        $this->exts = $new_exts;
	    }
	    else 
	    {
	        $this->exts = array($new_exts);
	    }
  	}
  	public function upload($file, $caption) 
  	{
  		$this->caption = $caption;
  		$this->validate($file);
	    if ($this->error) {
	      if ($this->printError) print $this->error;
	    }
	    else {
	    	move_uploaded_file($file['tmp_name'], $this->dir.$this->file_name);
			if ($this->error && $this->printError){
				print $this->error;
			} else{
				
				$sql  = "INSERT INTO photos (name, caption, author_id, date_uploaded) ";
				$sql .= "VALUES(?, ?, 1, '". $this->date_uploaded ."')"
				$query = $this->conn->prepare($sql);
				$query->bindParam(1, $this->file_name);
				$query->bindParam(2, $this->caption);
				$query->execute();
				
					print "Upload was successful";
			}
		}
  	}
  	public function validate($file) {
		$error = '';
	    //check file exist
	    if (empty($file['name'][0])) $error .= 'No file found.<br />';
	    //check allowed extensions
	    if (!in_array($this->getExtension($file),$this->exts)) $error .= 'Extension is not allowed.<br />';
	    //check file size
	    if ($file['size'][0] > $this->max_size) $error .= 'Max File Size Exceeded. Limit: '.$this->max_size.' bytes.<br />';
	 
	    $this->error = $error;
    }
    public function getExtension($file) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $ext = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        return $ext;
    }
    public function getPhotos()
    {
    	$sql = "SELECT * FROM IMAGES WHERE Deleted <> 1";
    	$query = $this->conn->query($sql);
		if(mysqli_num_rows($query) > 0){
			while($row = $query->fetch_assoc()){
				$photos[] = $row;
			}
			return $photos;
		}
    }

}

?>