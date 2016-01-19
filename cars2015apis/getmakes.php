<?php
	//allow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/make.php');
	require_once('classes/catalogs.php');
	require_once('classes/generatetoken.php');
	//get headers
	$headers = getallheaders();
	//validate parameter and headers
	if (isset($headers['user']) & isset($headers['token']))
	{
		//validate token
		if ($headers['token'] == generate_token($headers['user']))
		{
			//start json
			$json = '{ "status" : 0, "makes" : [';
			//read makes
			$first = true;
			foreach(Catalogs::get_makes() as $m)
			{
				if($first) $first = false; else $json .= ',';
				$json .= '{
										"id" : '.$m->get_id().',
										"name" : "'.$m->get_name().'"
									}';
			}
			//end json
			$json .= '] }';
			//display json
			echo $json;
		}
		else
			echo '{ "status" : 2, "errorMessage" : "Invalid Token" }';
	}
	else
		echo '{ "status" : 1, "errorMessage" : "Invalid Parameters" }';
?>




