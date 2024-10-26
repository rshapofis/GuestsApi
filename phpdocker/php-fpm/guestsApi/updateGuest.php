<?php
require __DIR__ . '/vendor/autoload.php';

use Ramapriya\Request\Request;
use Apofis\Test\Connector;


function updateGuest()
{
	$PostParams = Request::PostParams();
	$arr = [];
	$telephone = null;
	$params = ["name", "family", "email", "country", "telephone", "new_telephone"];
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
	//проверка обязательного параметра
	if ($telephone == null){
		return ["Error" => "Нет обязательного параметра телефон"];
	}
	//проверка нужно ли подставлять страну от номера телефона
	if (array_key_exists("new_telephone",$arr) && !array_key_exists("country",$arr))
	{
		$temp = checkTelephone($telephone);
		if ($temp !== null) {
			$arr["country"] = $temp;
		}
	}
	//выполняем операцию на бд
	$connector = new Connector();
	return $connector->updateGuest($telephone, $arr);
}

header("Content-Type: application/json");
echo json_encode(updateGuest());

