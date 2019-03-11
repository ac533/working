#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

$request1 = array();
$request1['type'] = "login";
$request1['username'] = "arturo";
$request1['password'] = "calvo";

$response = $client->send_request($request1);

var_dump($response);

return $response;

?>
