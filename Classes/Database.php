<?php

class Database
{   
    protected static $pdo;
    protected static function connect(){
            $config = static::getConfig();
            static::$pdo = new PDO('mysql:host='. $config['db_host'] . ';dbname=' . $config['db_name'] ,
            $config['db_user'] ?? null, 
            $config['db_password'] ?? null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); //подключение
    }

    public static function query($sql){
        return static::getConnection()->query($sql);
    }

    public static function exec($prep, $vars = null){
        return $prep->execute($vars);
    }

    public static function prepare($sql){
        return static::getConnection()->prepare($sql);
    }

    protected static function getConfig()
    {
        return include 'config.php';
    }

    public static function getConnection(){
        if(!static::$pdo){
            static::connect();
        }

        return static::$pdo;
    }

    public static function select($sql, $className = null){
        
        $result = static::query($sql);
        if ($className)
        {
            return $result->fetchAll(PDO::FETCH_CLASS, $className);
        }
        else
        {
            return $result->fetchAll(PDO::FETCH_ASSOC);    
        }

    }
}