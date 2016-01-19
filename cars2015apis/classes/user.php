<?php
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	
	class User extends Connection
	{
		//attributes
		private $id;
		private $name;
		private $password;
		
		//methods
		public function get_id() { return $this->id; }
		public function set_id($value) { $this->id = $value; }
		public function get_name() { return $this->name; }
		public function set_name($value) { $this->name = $value; }
		public function set_password($value) { $this->password = $value; }
		
		//constructor
		function __construct()
		{
			//if no arguments received, create empty object
			if(func_num_args() == 0) 
			{
				$this->id = '';
				$this->name = '';
				$this->password = '';
			}
			//if two argument received create object with data
			if(func_num_args() == 2)
			{
				//receive arguments into an array
				$args = func_get_args();
				//get arguments
				$id = $args[0];
				$password = $args[1];
				//open connection to MySql
				parent::open_connection();
				//query
				$query = "select usr_id, usr_name from users
									where usr_id = ? and usr_password = sha1(?);";
				//prepare command
				$command = parent::$connection->prepare($query);
				//link parameters
				$command->bind_param('ss', $id, $password);
				//execute command
				$command->execute();
				//link results to class attributes
				$command->bind_result($this->id, $this->name);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if(!$found) throw(new RecordNotFoundException());	
			}
		}	
	}
?>


