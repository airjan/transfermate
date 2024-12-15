<?php 
namespace Database\Migration; 
use Database\baseConnection;

class SearchAuthorIndex extends baseConnection
{
	

	public function migrate()
	{
		$pdo = $this->db->getConnect();
		$sql = "CREATE INDEX IF NOT EXISTS idx_author_name ON authors (name);";
		$pdo->exec($sql);
	}
}
?>