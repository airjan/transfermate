<?php

/**
 * BaseConnection Class
 *
 * This is an abstract class that serves as the foundation for all database-related 
 * operations. It initializes a connection to the database by instantiating the 
 * `Database` class, making the database connection available to subclasses.
 *
 * @package    TransferMateExam
 * @subpackage Database
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 * @phpversion 8.0
 */

namespace Database;

abstract class BaseConnection
{
    protected Database $db;

    /**
     * BaseConnection constructor.
     *
     * Initializes a new database connection by instantiating the `Database` class 
     * and storing the connection in the `$db` property.
     */

    public function __construct()
    {
        $this->db = new Database();
    }
}

?>
