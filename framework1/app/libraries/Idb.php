<?php
	class Idb {
			private $db_host = DB_HOST;
		    private $db_user = DB_USER;
		    private $db_pass = DB_PASS;
		    private $db_name = DB_NAME;
			public $conn;
			private $last_result;
			
	    public function __construct(){
			$this->conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
			if ($this->conn->connect_error){
	    		$error = $this->conn->connect_error;
	   			 echo("Not connected: " . $error);
			}
		}
		
		public function query($sql){
			$result = mysqli_query($this->conn, $sql);
			if($result){
				$this->last_result = $result;
				return $result;
			}else 
				return false;
		}
		
		public function escape($var){
			$escaped_var = mysqli_real_escape_string($this->conn, $var);
			return $escaped_var;
		}
		
		public function rowCount(){
			$num = mysqli_num_rows($this->last_result);
			if($num > 0)
				return $num;
			else 
				return false;
		}
		
		public function getLastId(){
			$result = mysqli_insert_id($this->conn);
			
			if($result != 0)
				return $result;
			else
				return false;
		}
	}
?>
