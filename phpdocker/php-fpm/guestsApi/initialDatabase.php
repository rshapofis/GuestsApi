<?php

use PDO;

$host = 'mysql:host=mariadb;dbname=test';
$user = 'test';
$pass = 'test';
$charset = 'utf8';
$options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_EMULATE_PREPARES   => false, PDO::ATTR_STRINGIFY_FETCHES  => false ];
$connection = new PDO($host, $user, $pass, $options);
$query = <<<END
 CREATE TABLE IF NOT EXISTS test.Guests (
	name varchar(100) NOT NULL,
	family varchar(100) NOT NULL,
	telephone varchar(100) UNIQUE NOT NULL,
	email varchar(100) UNIQUE NULL,
	country varchar(100) NULL
);
END;
$stmt = $connection->prepare($query);
$stmt->execute();