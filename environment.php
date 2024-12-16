<?php

/**
 * Database Configuration Settings
 * 
 * This file returns an array with database connection details used for 
 * establishing a connection to the PostgreSQL database.
 *
 * @package    TransferMateExam
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 * @phpversion 8.0
 */

return [
    'DATABASE' => [
        'DB_HOST' => 'localhost', // Database server address
        'DB_PORT' => '5432',  // Default PostgreSQL port
        'DB_NAME' => 'book2',  // Database name
        'DB_USER' => 'user1', // Database user
        'DB_PASS' => 'password',  // Database password
    ]
];
?>
