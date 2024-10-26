<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Apofis\Test\Connector;

function insertGuest()
{
	$request = new Request($_GET,$_POST,[],$_COOKIE,$_FILES,$_SERVER);
	$PostParams = $request->request;
	$arr = [];
	$telephone = null;
	$params = ["name", "family", "email", "country", "telephone"];
	foreach ($PostParams->keys() as $param)
	{
		if (!in_array($param,$params))
		{
			continue;
		}
		if ($param != "telephone")
		{
			$arr[$param] = $PostParams->get($param);
		} else {
			$telephone = $PostParams->get($param);
		}
	}
	if (!array_key_exists("name", $arr)){
		return ["Error" => "Нет обязательного параметра имя"];
	}
	if (!array_key_exists("family",$arr)){
		return ["Error" => "Нет обязательного параметра фамилия"];
	}
	if ($telephone == null){
		return ["Error" => "Нет обязательного параметра телефон"];
	}
	$temp = checkTelephone($telephone);
	if ($temp!==null) {
		$arr["country"] = $temp;
	}
	$connector = new Connector();
	return $connector->setGuest($telephone, $arr);
}

$startTime = microtime(true);
$memory = memory_get_usage();
$result = json_encode(insertGuest());
$response = new Response(
    $result,
    Response::HTTP_OK,
    ['content-type' => 'application/json','X-Debug-Time' => (microtime(true) - $startTime) / 1000 . ' ms', 'X-Debug-Memory' => (memory_get_usage() - $memory) / 1024 . ' kb']
);
$response->send();

