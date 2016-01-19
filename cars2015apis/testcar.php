<?php
	//use files
	require_once('classes/car.php');
	require_once('classes/exceptions.php');
	//parameters
	if (isset($_GET['id']))
	{
		//car
		try
		{
			$c = new Car($_GET['id']);
			echo '{ "id" : "'.$c->get_id().'", 
							"year" : '.$c->get_year().',
							"price" : '.$c->get_price().',
							"color" : "'.$c->get_color().'",
							"image" : "'.$c->get_image().'"
							}';
		}
		catch(RecordNotFoundException $ex)
		{
			echo '{ "error" : "'.$ex->get_message().'" }';
		}
	}
	else
		echo '{ "error" : "Invalid Parameters" }';
?>




