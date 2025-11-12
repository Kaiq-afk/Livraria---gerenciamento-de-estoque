<?php

class Database {
    public static function getConnection() {
        $host = 'localhost';
        $port = 3306;
        $db   = 'Livraria';
        $user = 'root';
        $pass = 'Sameki017';

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        return new PDO($dsn, $user, $pass, $options);
    }
}
