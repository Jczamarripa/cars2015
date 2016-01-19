<?php
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	require_once('make.php');
	
	class Model extends Connection
	{
		//attributes
		private $id;
		private $name;
		private $make;
		
		//methods
		public function get_id() { return $this->id; }
		public function set_id($value) { $this->id = $value; }
		public function get_name() { return $this->name; }
		public function set_name($value) { $this->name = $value; }
		public function get_make() { return $this->make; }
		
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
				$query = "select mod_id, mod_name, mod_id_make from models where mod_id = ?";
				//prepare command
				$command = parent::$connection->prepare($query);
				//link parameters
				$command->bind_param('s', $id);
				//execute command
				$command->execute();
				//link results to class attributes
				$command->bind_result($id, $name, $make);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if($found) 
				{
					$this->id = $id;
					$this->name = $name;
					$this->make = new Make($make);
				}
				else
					throw(new RecordNotFoundException());	
			}
		}	
		
		//get cars
		function get_cars($min_year, $max_year, $min_price, $max_price, $order_by, $page_number, $rows_per_page)
		{
			//open connection to MySql
			parent::open_connection();
			//initialize arrays
			$ids = array(); //array for ids
			$list = array(); //array for objects
			//query
			$query = 'select car_id from cars where car_id_model = ?';
			if ($min_year != null) $query .= ' and car_year >= '.$min_year;
		  if ($max_year != null) $query .= ' and car_year <= '.$max_year;
		  if ($min_price != null) $query .= ' and car_price >= '.$min_price; 
			if ($max_price != null) $query .= ' and car_price <= '.$max_price;
			//order by
			$order_by_options = array('car_year asc', 'car_year desc', 'car_price asc', 'car_price desc');
			if ($order_by < 0 | $order_by > 3) $order_by = 0;
			$query .= ' order by '.$order_by_options[$order_by];
			//paging
			$start_row = ($page_number - 1) * $rows_per_page;
			if ($rows_per_page > 0)
				$query .= ' limit '.$start_row.','.$rows_per_page;
			//prepare command
			$command = parent::$connection->prepare($query);
			//parameters
			$command->bind_param('s', $this->id);
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
			for ($i=0; $i < count($ids); $i++) array_push($list, new Car($ids[$i]));
			//return array
			return $list;
		}
		
		//gets the number of cars returned by the search
		function get_car_count($min_year, $max_year, $min_price, $max_price)
		{
			//open connection to MySql
			parent::open_connection();
			//query
			$query = 'select count(*) from cars where car_id_model = ?';
			if ($min_year != null) $query .= ' and car_year >= '.$min_year;
		  if ($max_year != null) $query .= ' and car_year <= '.$max_year;
		  if ($min_price != null) $query .= ' and car_price >= '.$min_price; 
			if ($max_price != null) $query .= ' and car_price <= '.$max_price;
			//prepare command
			$command = parent::$connection->prepare($query);
			//parameters
			$command->bind_param('s', $this->id);
			//execute command
			$command->execute();
			//link results
			$command->bind_result($count);
			//read count
			$command->fetch();
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//return count
			return $count;
		}
	}
?>


