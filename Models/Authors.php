<?php
namespace Models;

use Database\Database;
use Traits\DBExecution;
use Exception;
use PDO;
class Authors
{
	use DBExecution;
	protected $db;
	protected $tableName = 'authors';
	protected $allowFields =['name','metadata','filename','folder'];
	protected $fields =[];
	public function __construct()
	{
		$this->db = new Database();
	}

	public function findAuthor($name) {
		$sql ="SELECT * FROM {$this->tableName} where name=:name  LIMIT 1";
		$connection = $this->db->getConnect();
		
		$prep = $connection->prepare($sql);
		$prep->bindValue(":name", $name,PDO::PARAM_STR);
		$prep->execute();
		$result = $prep->fetch(PDO::FETCH_ASSOC);
		return $result ?: null;
	}
	

	
	
}
?>