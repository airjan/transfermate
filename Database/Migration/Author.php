<?php
namespace Database\Migration; 
use Database\Database; // Database connection class

class Author
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
			CREATE TABLE IF not exists authors (
				id serial primary key,
				name varchar(255) not null,
				
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
				);
		";
		$pdo->exec($sql);
	}
}
?>