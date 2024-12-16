<?php

/**
 * Migration to create an index on the 'name' column in the 'authors' table.
 *
 * This class creates an index on the 'name' column of the 'authors' table to 
 * improve search performance for the 'name' field. If the index already exists, 
 * this migration does nothing.
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

class SearchAuthorIndex extends BaseConnection
{
    /**
     * Applies the migration to create the index on the 'name' column in the 'authors' table.
     *
     * This method creates an index named 'idx_author_name' on the 'name' column of the 
     * 'authors' table to optimize search operations. If the index already exists, 
     * the method does nothing.
     *
     * @return void
     */
    public function migrate()
    {
        $pdo = $this->db->getConnect();
        $sql = "CREATE INDEX IF NOT EXISTS idx_author_name ON authors (name);";
        // Execute the SQL query using the Database class
        $pdo->exec($sql);
    }
}
?>
