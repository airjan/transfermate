<?php

/**
 * Migration to add new fields to the books table.
 *
 * This class adds the columns 'metadata', 'filename', and 'folder' to the 'books' table 
 * in the database. It is part of the migration process to update the database schema.
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

class AddfieldsBooksMetaData extends BaseConnection
{
    /**
     * Applies the migration to alter the 'books' table.
     *
     * Adds the 'metadata', 'filename', and 'folder' columns to the 'books' table.
     *
     * @return void
     */
    public function migrate()
    {
        $pdo = $this->db->getConnect();
        $sql = "
            ALTER TABLE books
            ADD COLUMN metadata JSON,
            ADD COLUMN filename VARCHAR(255),
            ADD COLUMN folder VARCHAR(255)
        ";
        // Execute the SQL query using the Database class
        $pdo->exec($sql);
    }
}
?>