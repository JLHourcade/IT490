<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (!isset($_POST))
{
	$msg = "...enter your credentials. It's not optional";
	echo json_encode($msg);
	exit(0);
}
else 
$request = $_POST;
$response = "Please leave";
switch ($request["type"])
{
	case "login":
		$response = "login accepted";
		$login_request = array();
		$login_request["type"] = "login";
	        $login_request["username"] = $request["uname"];
		$login_request["password"] = $request["pword"];
		$response = $client->send_request($login_request);

		if($response){
			$response=true;
			echo $response;
			exit(0);
		}//user was found in the database
		else{
			$response=false;
			echo $response;
			exit(0);
		} //user was not found in the database	
	break;
}
echo json_encode($response);
exit(0);
