<?php
namespace Database;
use PDO;
use PDOException;

class Database
{
	private $dbConnection;

	public function __construct()
	{
		$config = include(__DIR__ . '/..' . '/environment.php');
		$dbConfig = $config['DATABASE'];
		$host = $dbConfig['DB_HOST'] ?? 'localhost';
		$port = $dbConfig['DB_PORT'] ?? '5432';
		$password = $dbConfig['DB_PASS'] ?? '';
		$user = $dbConfig['DB_USER'] ?? '';
		$dbName = $dbConfig['DB_NAME'] ?? '';
		$dsn = "pgsql:host=$host;port=$port;dbname=$dbName";
		 try {
		 	$this->dbConnection = new PDO($dsn, $user, $password);
		 	$this->dbConnection->exec("SET NAMES 'UTF8'");
		 }catch (PDOException $e) {
		 	die('Database connection failed ' . $e->getMessage());
		 }
	}

	public function getConnect()
	{
		return $this->dbConnection;
	}



}

?>