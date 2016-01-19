<?php
	//use files
	require_once('classes/make.php');
	require_once('classes/exceptions.php');
	require_once('classes/catalogs.php');
	//make
	/*try
	{
		$mk = new Make('CAD');
		echo '{ "id" : "'.$mk->get_id().'", "name" : "'.$mk->get_name().'" }';
	}
	catch(RecordNotFoundException $ex)
	{
		echo '{ "error" : "'.$ex->get_message().'" }';
	}*/
	//get makes
	$json = '{ "makes" : [';
	$first = true;
	foreach(Catalogs::get_makes() as $mk)
	{
		if ($first) $first = false; else $json .= ',';
		$json .= '{
					"id" : "'.$mk->get_id().'",
					"name" : "'.$mk->get_name().'"
				  }';
	}
	$json .= '] }';
	echo $json;
?>




