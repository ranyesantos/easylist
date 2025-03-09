<?php

namespace App\Db;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Connection 
{

    private static $pdo = null;

    public static function getPDO() 
    {
        $dotenv = Dotenv::createImmutable(__DIR__. '/../..');
        $dotenv->load();

        if (self::$pdo === null) {
            try {
                $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4";
                
                self::$pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
                
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        }
        
        return self::$pdo;
    }
}
