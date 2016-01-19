<?php
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	
	class Make extends Connection
	{
		//attributes
		private $id;
		private $name;
		
		//methods
		public function get_id() { return $this->id; }
		public function set_id($value) { $this->id = $value; }
		public function get_name() { return $this->name; }
		public function set_name($value) { $this->name = $value; }
		
		//constructor
		function __construct()
		{
			//if no arguments received, create empty object
			if(func_num_args() == 0) 
			{
				$this->id = '';
				$this->name = '';
			}
			//if one argument received create object with data
			if(func_num_args() == 1)
			{
				//receive arguments into an array
				$args = func_get_args();
				//id
				$id = $args[0];
				//open connection to MySql
				parent::open_connection();
				//query
				$query = "select mak_id, mak_name from makes where mak_id = ?";
				//prepare command
				$command = parent::$connection->prepare($query);
				//link parameters
				$command->bind_param('s', $id);
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
		//get models
		public function get_models()
		{
			//open connection to MySql
			parent::open_connection();
			//initialize arrays
			$ids = array(); //array for ids
			$list = array(); //array for objects
			//query
			$query = "select mod_id from models where mod_id_make = ?";
			//prepare command
			$command = parent::$connection->prepare($query);
			//bind params
			$command->bind_param('i', $this->id);
			//execute command
			$command->execute();
			//link results
			$command->bind_result($id);
			//fill ids array
			while ($command->fetch()) array_push($ids, $id);
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//fill object array
			for ($i=0; $i < count($ids); $i++) array_push($list, new Model($ids[$i]));
			//return array
			return $list;
		}
	}
?>


