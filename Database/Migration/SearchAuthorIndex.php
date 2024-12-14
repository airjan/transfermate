<?php 
namespace Database\Migration; 
use Database\Database; // Database connection class

class SearchAuthorIndex
{
	private $db;
	public function __construct()
	{
		$this->db = new Database();

	}

	public function migrate()
	{
		$pdo = $this->db->getConnect();
		$sql = "CREATE INDEX IF NOT EXISTS idx_author_name ON authors (name);";
		$pdo->exec($sql);
	}
}
?>