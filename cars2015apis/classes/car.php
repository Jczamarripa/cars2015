<?php
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	
	class Car extends Connection
	{
		//attributes
		private $id;
		private $year;
		private $price;
		private $color;
		private $image;
		
		//methods
		public function get_id() { return $this->id; }
		public function set_id($value) { $this->id = $value; }
		public function get_name() { return $this->name; }
		public function set_name($value) { $this->name = $value; }
		public function get_year() { return $this->year; }
		public function set_year($value) { $this->year = $value; }
		public function get_price() { return $this->price; }
		public function set_price($value) { $this->price = $value; }
		public function get_color() { return $this->color; }
		public function set_color($value) { $this->color = $value; }
		public function get_image() { return $this->image; }
		public function set_image($value) { $this->image = $value; }
		
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
				$query = "select car_id, car_year, car_price, car_color, car_image from cars where car_id = ?";
				//prepare command
				$command = parent::$connection->prepare($query);
				//link parameters
				$command->bind_param('i', $id);
				//execute command
				$command->execute();
				//link results to class attributes
				$command->bind_result($this->id, $this->year, $this->price, $this->color, $this->image);
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


