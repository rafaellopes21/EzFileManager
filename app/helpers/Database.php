<?php

namespace App\helpers;

class Database{

    public function __construct(){
        try {
            $_SESSION['hasDatabase'] = true;
            self::databaseChecker();
        } catch (\Exception $exception){
            throw new \Exception();
        }
    }

    public static function isEnabled(){
        return isset($_SESSION['hasDatabase']) ? $_SESSION['hasDatabase'] : false;
    }

    private static function getConnection(){
        try {
            if(!self::isEnabled()){ return false; }

            $dbFile = __DIR__."/../../database.db";
            $pdo = new \PDO("sqlite:$dbFile");
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (\Exception $exception){
            throw new \Exception();
        }
    }

    public static function query($rawQuery){
        $pdo = self::getConnection();
        if(!$pdo){  return new ZQuery(false); }

        $sql = $pdo->prepare($rawQuery);
        $sql->execute();
        return new ZQuery($sql);
    }

    private static function databaseChecker(){
        $pdo = self::getConnection();
        if(!$pdo){ return false; }

        $pdo->exec(
            "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user VARCHAR(255) NOT NULL,
            password TEXT NOT NULL
        )");

        $pdo->exec(
            "INSERT INTO users (user, password) SELECT 'admin', '".md5('admin')."'
         WHERE NOT EXISTS (SELECT 1 FROM users WHERE user = 'admin')"
        );

        $pdo->exec(
            "CREATE TABLE IF NOT EXISTS settings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            storage_limit TEXT,
            expire_date DATE NULL
        )");

        return true;
    }
}

class ZQuery{
    private $sql;

    public function __construct($sql){
        $this->sql = $sql;
    }

    public function first($pdoType = \PDO::FETCH_ASSOC){
        return $this->sql ? $this->sql->fetch($pdoType) : false;
    }

    public function get($pdoType = \PDO::FETCH_ASSOC){
        return $this->sql ? $this->sql->fetchAll($pdoType) : false;
    }
}