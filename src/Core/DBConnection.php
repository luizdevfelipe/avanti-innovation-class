<?php

namespace App\Core;

use PDO;
use PDOException;

class DBConnection
{
    protected static ?PDO $connection = null;

    public function __construct()
    {
        try {
            static::$connection = new PDO(
                'mysql:host='. $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public static function isInitialized(): bool
    {
        return static::$connection !== null;
    }

    public static function getConnection(): PDO
    {
        return static::$connection;
    }
}