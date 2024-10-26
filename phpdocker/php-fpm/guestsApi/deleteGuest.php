<?php
require __DIR__ . '/vendor/autoload.php';

use Ramapriya\Request\Request;
use Apofis\Test\Connector;

function deleteGuest()
{
	$PostParams = Request::PostParams();
	$arr=[];
	$telephone=null;
	foreach ($PostParams as $param)
	{
		if ($param != "telephone")
		{
			$request = Request::Post($param);
			$arr[$param] = $request;
		} else {
			$telephone = Request::Post($param);
		}
	}
	//проверка обязательного параметра
	if ($telephone==null){
		return ["Error" => "Нет обязательного параметра телефон"];
	}
	//выполняем операцию на бд
	$connector= new Connector();
	return $connector->deleteGuest($telephone);
}

header("Content-Type: application/json");
echo json_encode(deleteGuest());
