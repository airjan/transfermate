<?php

/**
 * Migration to create the books table.
 *
 * This class creates the 'books' table in the database if it doesn't already exist. 
 * The table includes fields for the book's id, title, author_id (foreign key), and 
 * timestamps for creation and updates. The 'author_id' field references the 'authors' table.
 *
 * @package    TransferMateExam
 * @subpackage Database\Migration
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 * @phpversion 8.0
 */

namespace Database\Migration;

use Database\BaseConnection;

class Books extends BaseConnection
{
    /**
     * Applies the migration to create the books table.
     *
     * This method creates the 'books' table with columns for the book's id, title, author_id, 
     * created_at, and updated_at. The 'author_id' column is a foreign key that references 
     * the 'authors' table. If the 'books' table already exists, this method does nothing.
     *
     * @return void
     */
    public function migrate()
    {
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
