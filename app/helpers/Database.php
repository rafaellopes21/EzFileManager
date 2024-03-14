<?php

namespace App\helpers;

class Database{

    public function __construct(){
        $_SESSION['hasDatabase'] = true;
    }

    public static function isEnabled(){
        return isset($_SESSION['hasDatabase']) ? $_SESSION['hasDatabase'] : false;
    }

    private static function getConnection(){
        if(!self::isEnabled()){ return false; }

        return ['database' => []];
    }

    public static function query(){
        $conn = self::getConnection();
        return $conn ? "query" : $conn;
    }
}