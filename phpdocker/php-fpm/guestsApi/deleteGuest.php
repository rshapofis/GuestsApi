<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Apofis\Test\Connector;

function deleteGuest()
{
	$request = new Request($_GET,$_POST,[],$_COOKIE,$_FILES,$_SERVER);
	$PostParams = $request->request;
	$arr=[];
	$telephone=null;
	foreach ($PostParams->keys() as $param)
	{
		if ($param != "telephone")
		{
			$arr[$param] = $PostParams->get($param);
		} else {
			$telephone = $PostParams->get($param);
		}
	}
	if ($telephone==null){
		return ["Error" => "Нет обязательного параметра телефон"];
	}
	$connector= new Connector();
	return $connector->deleteGuest($telephone);
}

$startTime = microtime(true);
$memory = memory_get_usage();
$result = json_encode(deleteGuest());
$response = new Response(
    $result,
    Response::HTTP_OK,
    ['content-type' => 'application/json','X-Debug-Time' => (microtime(true) - $startTime) / 1000 . ' ms', 'X-Debug-Memory' => (memory_get_usage() - $memory) / 1024 . ' kb']
);
$response->send();