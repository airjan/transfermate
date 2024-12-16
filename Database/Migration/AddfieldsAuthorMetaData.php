<?php

/**
 * Migration to add new fields to the authors table.
 *
 * This class adds the columns 'metadata', 'filename', and 'folder' to the 'authors' table 
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

class AddfieldsAuthorMetaData  extends BaseConnection
{
     /**
      * Applies the migration to alter the 'authors' table.
      *
      * Adds the 'metadata', 'filename', and 'folder' columns to the 'authors' table.
      *
      * @return void
      */
    public function migrate() 
    {
       
        $pdo = $this->db->getConnect();
        $sql ="
				ALTER TABLE authors
				ADD COLUMN metadata JSON,
				ADD column filename VARCHAR(255),
				ADD COLUMN folder VARCHAR(255)
				";
        // Execute the SQL query using the Database class
        $pdo->exec($sql);
    }
}
?>
