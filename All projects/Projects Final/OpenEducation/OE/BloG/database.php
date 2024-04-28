<?php

class Database
{
    private static $dbHost = "sql302.unaux.com";
    private static $dbName = "unaux_29314915_bddopeneducation";
    private static $dbUsername = "unaux_29314915";
    private static $dbUserpassword = "0z3rikfs7pqle";
    
    private static $connection = null;
    
    public static function connect()
    {
        if(self::$connection == null)
        {
            try
            {
              self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName , self::$dbUsername, self::$dbUserpassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$connection;
    }
    
    public static function disconnect()
    {
        self::$connection = null;
    }

}
?>
