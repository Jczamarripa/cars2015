<?php
	//allow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/make.php');
	require_once('classes/model.php');
	require_once('classes/catalogs.php');
	require_once('classes/generatetoken.php');
	//get headers
	$headers = getallheaders();
	//validate parameter and headers
	if (isset($_GET['makeid']) & isset($headers['user']) & isset($headers['token']))
	{
		//validate token
		if ($headers['token'] == generate_token($headers['user']))
		{
			try
			{
				//create make
				$make = new Make($_GET['makeid']);
				//start json
				$json = '{  "status" : 0, 
										"make" : {
											"id" : '.$make->get_id().',
											"name" : "'.$make->get_name().'"
										},
									  "models" : [';
				//read models
				$first = true;
				foreach($make->get_models() as $m)
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
			catch(RecordNotFountException $ex)
			{
				echo '{ "status" : 1, "errorMessage" : "Invalid Make Id" }';
			}
		}
		else
			echo '{ "status" : 3, "errorMessage" : "Invalid Token" }';
	}
	else
		echo '{ "status" : 2, "errorMessage" : "Invalid Parameters" }';
?>




