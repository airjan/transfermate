<?php

/**
 * Database Class
 *
 * This class is responsible for establishing a connection to the PostgreSQL database 
 * using the PDO extension. It reads the database configuration from an external file 
 * and provides methods to retrieve the database connection instance.
 *
 * @package    TransferMateExam
 * @subpackage Database
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 * @phpversion 8.0
 */

namespace Database;

use PDO;
use PDOException;

class Database
{
    /**
     * @var PDO $dbConnection The PDO instance used to connect to the database.
     */
    private $dbConnection;

    /**
     * Database constructor.
     *
     * Initializes the connection to the PostgreSQL database by reading the 
     * configuration from an external file (`environment.php`). It creates a new 
     * PDO instance using the configuration values and sets the connection 
     * character set to UTF-8. If the connection fails, it throws an exception.
     *
     * @throws PDOException If the database connection fails.
     */
    public function __construct()
    {
        $config = include __DIR__ . '/..' . '/environment.php';
        $dbConfig = $config['DATABASE'];

        $host = $dbConfig['DB_HOST'] ?? 'localhost';
        $port = $dbConfig['DB_PORT'] ?? '5432';
        $password = $dbConfig['DB_PASS'] ?? '';
        $user = $dbConfig['DB_USER'] ?? '';
        $dbName = $dbConfig['DB_NAME'] ?? '';

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbName";
        try {
            $this->dbConnection = new PDO($dsn, $user, $password);
            $this->dbConnection->exec("SET NAMES 'UTF8'");
        } catch (PDOException $e) {
            die('Database connection failed ' . $e->getMessage());
        }
    }

    /**
     * Get the current database connection.
     *
     * @return PDO The PDO instance representing the current database connection.
     */
    public function getConnect()
    {
        return $this->dbConnection;
    }
}
?>
