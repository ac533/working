#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['feature']))
  {
    return "ERROR: unsupported function";
  }
  switch ($request['feature'])
  {
    case "1":
	require_once 'unirest-php/src/Unirest.php';
	$ingredients = $request['ingredient'];
	$dmzResponse = array();
	$APIresponse = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/search?offset=0&query=$ingredients",
  	array(
    	"X-RapidAPI-Key" => "f0de423a1fmshf077c4714bd76a2p131d6bjsn0818ef1f78e5"
 	)
	);
	for ($x = 0; $x <5; $x++)
	{
	  $id = $APIresponse->body->results[$x]->id;
	  $dmzResponse[$x]['id']=$APIresponse->body->results[$x]->id;
	  $dmzResponse[$x]['tittle']=$APIresponse->body->results[$x]->title;
	  $dmzResponse[$x]['readyin']=$APIresponse->body->results[$x]->readyInMinutes;
	  $dmzResponse[$x]['serving']=$APIresponse->body->results[$x]->servings;
//	  $dmzResponse[$x]['image']=$APIresponse->body->results[$x]->image;

	  $APIresponse2 = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/$id/information",
  	  array(
   	  "X-RapidAPI-Key" => "f0de423a1fmshf077c4714bd76a2p131d6bjsn0818ef1f78e5"
  	  )
	  );
	  $dmzResponse[$x]['instructions']=$APIresponse2->body->instructions;
	}
	return $dmzResponse;
    case "2":
        echo "case 2";
        break;
    case "3":
        echo "case 3";
        break;
    case "4":
        echo "case 4";
        break;
    case "5":
        echo "case 5";
        break;
    case "6":
        echo "case 6";
        break;
    case "7":
        echo "case 7";
	break;
  }
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
$server->process_requests('requestProcessor');

exit();
?>

