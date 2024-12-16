<?php

/**
 * Migration to create the authors table.
 *
 * This class creates the 'authors' table in the database if it doesn't already exist. 
 * The table includes fields for the author's id, name, and timestamps for creation and updates.
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

class Author extends BaseConnection
{
    /**
     * Applies the migration to create the authors table.
     *
     * This method creates the 'authors' table with columns for the author's id, 
     * name, created_at, and updated_at. The table will only be created if it 
     * doesn't already exist.
     *
     * @return void
     */
    public function migrate()
    {
        $pdo = $this->db->getConnect();
        $sql = "
            CREATE TABLE IF NOT EXISTS authors (
                id serial PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ";
        // Execute the SQL query using the Database class
        $pdo->exec($sql);
    }
}
?>
