<?php
namespace Database\Migration; 
use Database\baseConnection;

class AddfieldsAuthorMetaData  extends baseConnection
{
	
	public function migrate() 
	{
		
		$pdo = $this->db->getConnect();
		$sql ="
				ALTER TABLE authors
				ADD COLUMN metadata JSON,
				ADD column filename VARCHAR(255),
				ADD COLUMN folder VARCHAR(255)
				
		";
		$pdo->exec($sql);
	}
}