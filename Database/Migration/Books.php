<?php

namespace Database\Migration; 
use Database\Database; // Database connection class

class Books 
{

	private $db;
	public function __construct()
	{
		$this->db = new Database();

	}

	public function migrate()
    {
        /*
        filename varchar(255) not null,
                foldername varchar(255) not null,
        */
        $pdo = $this->db->getConnect();
        $sql = "
            CREATE TABLE IF NOT EXISTS books (
                id SERIAL PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                author_id INT NOT NULL,
                
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE
            )
        ";

        // Execute the SQL query using the Database class
        $pdo->exec($sql);
      }
}
?>