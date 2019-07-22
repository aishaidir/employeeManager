<?php

class Delete
{
	public $id;
	public $table;
	public $err;
	public $conn;

	function __construct()
	{
		$database   = new Config;
		$this->conn = $database->connect();
		$this->err = new Error;
    }

	public function delete($table, $id)
	{	
		try
		{
			$sql  = "UPDATE ". $table ." SET ";
			$sql .= "Deleted = '". 1 ."' ";
			$sql .= "WHERE ID = ". $id ."";
			$query  = $this->conn->query($sql);
			$query->bindParam(1, $table);
			$query->bindParam(2, $id);
			$query->execute();
			return true;
		} catch(Exception $e)
		{
			$this->err->log_error('Delete','delete', $e->getMessage());	
			return false;
		}
	}

}

?>