<?php
namespace Database\Migration; 
use Database\baseConnection;

class AddfieldsBooksMetaData extends baseConnection
{
	

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