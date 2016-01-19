<?php
	//allow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/model.php');
	require_once('classes/car.php');
	require_once('classes/exceptions.php');
	require_once('classes/generatetoken.php');
	//get headers
	$headers = getallheaders();
	//validate parameter and headers
	if (isset($_GET['id']) & isset($headers['user']) & isset($headers['token']))
	{
		//validate token
		if ($headers['token'] == generate_token($headers['user']))
		{
			//search parameters
			$min_year = null;
			$max_year = null;
			$min_price = null;
			$max_price = null;
			$order_by = 0;
			if (isset($_GET['minyear'])) $min_year = $_GET['minyear'];
			if (isset($_GET['maxyear'])) $max_year = $_GET['maxyear'];
			if (isset($_GET['minprice'])) $min_price = $_GET['minprice'];
			if (isset($_GET['maxprice'])) $max_price = $_GET['maxprice'];
			if (isset($_GET['orderby'])) $order_by = $_GET['orderby'];
			//paging parameters
			$page_number = 1;
			$rows_per_page = 0;
			$page_count = 0;
			if (isset($_GET['pagenumber'])) $page_number = $_GET['pagenumber'];
			if (isset($_GET['rowsperpage'])) $rows_per_page = $_GET['rowsperpage'];
			//model
			try
			{
				$m = new Model($_GET['id']);
				$json = '{ "status" : 0,
								"id" : "'.$m->get_id().'", 
								"name" : "'.$m->get_name().'",';
				//search options				
				$json .= ' "searchOptions" : {';
				if ($min_year != null) $json .= '"minYear" : '.$min_year.',';
				if ($max_year != null) $json .= '"maxYear" : '.$max_year.',';
				if ($min_price != null) $json .= '"minPrice" : '.$min_price.',';
				if ($max_price != null) $json .= '"maxPrice" : '.$max_price.',';
				//order by
				$order_by_options = array('Year Low to High', 'Year High to Low', 'Price Low to High', 'Price High to Low');
				if ($order_by < 0 | $order_by > 3) $order_by = 0;
				$json .= '"orderBy" : "'.$order_by_options[$order_by].'"';
				$json .= '},';
				//paging
				$row_count = $m->get_car_count($min_year, $max_year, $min_price, $max_price);
				if ($rows_per_page > 0)
					$page_count = ceil($row_count/$rows_per_page);
				else
					$page_count = 1;
				$json .= '"paging" : {
									"rowCount" : '.$row_count.',
									"rowsPerPage" : '.$rows_per_page.',
									"pageNumber" : '.$page_number.',
									"pageCount" : '.$page_count.'
								},';



				
				$json .= '"cars" : [';
				//get cars
				$first = true;
				$cars = $m->get_cars($min_year, $max_year, $min_price, $max_price, $order_by, $page_number, $rows_per_page);
				foreach($cars as $c)
				{
					if ($first) $first=false; else $json .=',';
					$json .= '{ "id" : "'.$c->get_id().'",
								"description" : "'.$c->get_year().' '.$m->get_make()->get_name().' '.$m->get_name().'", 
								"year" : '.$c->get_year().',
								"price" : '.$c->get_price().',
								"color" : "'.$c->get_color().'",
								"image" : "'.$c->get_image().'"
								}';
				}
				
				$json .= ']}';
				echo $json;
			}
			catch(RecordNotFoundException $ex)
			{
				echo '{ "status" : 1, "error" : "'.$ex->get_message().'" }';
			}
		}
		else
			echo '{ "status" : 3, "errorMessage" : "Invalid Token" }';
	}
	else
		echo '{ "status" : 2, "errorMessage" : "Invalid Parameters" }';
?>




