<?php
namespace Database\Migration; 
use Database\Database; // Database connection class

class AddfieldsBooksMetaData
{
	private $db;
	public function __construct()
	{
		$this->db = new Database();

	}

	public function migrate() 
	{
		
		$pdo = $this->db->getConnect();
		$sql ="
				ALTER TABLE books
				ADD COLUMN metadata JSON,
				ADD column filename VARCHAR(255),
				ADD COLUMN folder VARCHAR(255)
				
		";
		$pdo->exec($sql);
	}
}