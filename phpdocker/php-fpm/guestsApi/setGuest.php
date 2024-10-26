<?php
require __DIR__ . '/vendor/autoload.php';

use Ramapriya\Request\Request;
use Apofis\Test\Connector;

function insertGuest()
{
	$PostParams = Request::PostParams();
	$arr = [];
	$telephone = null;
	$params = ["name", "family", "email", "country", "telephone"];
	foreach ($PostParams as $param)
	{
		if (!in_array($param,$params))
		{
			continue;
		}
		if ($param != "telephone")
		{
			$request = Request::Post($param);
			$arr[$param] = $request;
		} else {
			$telephone = Request::Post($param);
		}
	}
	//проверки обязательных параметров
	if (!array_key_exists("name", $arr)){
		return ["Error" => "Нет обязательного параметра имя"];
	}
	if (!array_key_exists("family",$arr)){
		return ["Error" => "Нет обязательного параметра фамилия"];
	}
	if ($telephone == null){
		return ["Error" => "Нет обязательного параметра телефон"];
	}
	//проверка нужно ли подставлять страну от номера телефона
	if (!array_key_exists("country",$arr))
	{
		$temp = checkTelephone($telephone);
		if ($temp !== null) {
			$arr["country"] = $temp;
		}
	}
	//выполняем операцию на бд
	$connector = new Connector();
	return $connector->setGuest($telephone, $arr);
}

header("Content-Type: application/json");
echo json_encode(insertGuest());

