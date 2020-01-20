<?php
    // Funktion som skapar kontakt med databasen med hjälp av PDO.
    function login() {
        $hostname = "localhost";
        $database = "CARRENTAL";
        $username = "root";
        $password = "secret";

        $connection = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    if (!$connection) die($connection->errorInfo()[2]);
    return $connection;
    }
?>