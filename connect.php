<?php
try {
    $dsn = 'pgsql:host=localhost;port=5432;dbname=books';
    $username = 'user1';
    $password = 'password';

    $pdo = new PDO($dsn, $username, $password);
    echo "Connected to PostgreSQL successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>