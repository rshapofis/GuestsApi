<?php 

namespace Apofis\Test;

use PDO;

class Connector
{
	private  $host = 'mysql:host=mariadb;dbname=test';
	private  $user = 'test';
	private  $pass = 'test';
	private  $charset = 'utf8';
	private  $options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_EMULATE_PREPARES   => false, PDO::ATTR_STRINGIFY_FETCHES  => false ];
	public function __construct()
	{
		try {
			$this->connection = new PDO($this->host, $this->user, $this->pass, $this->options);
		} catch (PDOException $e) {
			error_log('Подключение не удалось: ' . $e->getMessage());
		}
		return $this;
	}
	//функция добавления в базу гостя параметр телефон ключевой, остальные получаются из ассоциированного массива
	public function setGuest(string $telephone, array $arr)
	{
		try {
			$query = "INSERT INTO Guests (".implode(", ", array_keys($arr)).", telephone) value (:".implode(", :", array_keys($arr)).", :telephone)";
			$stmt = $this->connection->prepare($query);
			$stmt->execute($arr + array("telephone" => $telephone));
		} catch (\PDOException $e) {
			error_log('Транзакция не удалась: ' . $e->getMessage());
			if ($e->errorInfo[1] === 1062) {
				return ["Error" => "Гость с такими данными уже существует"];
			} else {
				return ["Error" => "Не удалось совершить транзакцию"];
			}
		}
		return ["Succes" => "Гость занесен в базу данных"];
	}
	//функция получения данных гостя по ключевому параметру телефон
	public function getGuest(string $telephone)
	{
		try {
			$stmt = $this->connection->query("SELECT * FROM Guests WHERE telephone like '$telephone'");
			$stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			error_log('Транзакция не удалась: ' . $e->getMessage());
			return ["Error" => "Не удалось совершить транзакцию"];
		}
		return ["Succes" => ["Result" => $user]];
	}
	//функция обновления данных для гостя с ключевым параметром телефон, параметры для замены получаются из ассоциированного массива, параметр new_telephone в этом массиве для замены телефона
	public function updateGuest(string $telephone, array $arr)
	{
		try {
			$query = "UPDATE Guests SET ".implode(", ", array_map(function ($item)
		 	{
		 		return "{$item} = :{$item}";
		 	},array_keys($arr)) )." WHERE telephone like :telephone";
			$query = str_replace(" new_telephone", " telephone", $query);
			$stmt = $this->connection->prepare($query);
			$stmt->execute($arr+['telephone' => $telephone]);
		} catch (\PDOException $e) {
			error_log('Транзакция не удалась: ' . $e->getMessage());
			if ($e->errorInfo[1] === 1062) {
				return ["Error" => "Гость с такими данными уже существует"];
			} else {
				return ["Error" => "Не удалось совершить транзакцию"];
			}
		}
		return ["Succes" => "Гость обновлен"];
	}
	//функция для удаления гостя из базы по ключевому параметру телефон
	public function deleteGuest(string $telephone)
	{
		try {
			$stmt = $this->connection->query("DELETE FROM Guests WHERE telephone LIKE '$telephone'");
			$stmt->execute();
		} catch (\PDOException $e) {
			error_log('Транзакция не удалась: ' . $e->getMessage());
			return ["Error" => "Не удалось совершить транзакцию"];
		}
		return ["Succes" => "Гость удален из базы данных"];
	}

}