<?php 

class Database {
    /*

    public static $servername = "localhost";
    public static $username = "id19693607_memas";
    public static $password = "2S9Ahy_@(EyFZgde";

    public static $DATABASE_NAME = "id19693607_memas106";
    
    */

    public static $servername = "localhost";
    public static $username = "root";
    public static $password = "";

    public static $DATABASE_NAME = "memas106";
    

    public static function checkConnection(){
        // Make connection 
        $conn = new mysqli(self::$servername, self::$username, self::$password);
        
        // Check connection
        if ($conn->connect_error) {
            return ($conn->connect_error);
        }

        $conn->close();

        return ('connected');
    }

    public static function execute($sql_statement){
        // Make connection 
        $conn = new mysqli(self::$servername, self::$username, self::$password);
        
        // Check connection
        if ($conn->connect_error) {
            return ($conn->connect_error);
        }

        $results = $conn->query($sql_statement);

        $conn->close();

        return $results;
    }

    public static function execute_getting_last_id($sql_statement){
        // Make connection 
        $conn = new mysqli(self::$servername, self::$username, self::$password);
        
        // Check connection
        if ($conn->connect_error) {
            return ($conn->connect_error);
        }

        $results = $conn->query($sql_statement);

        $last_id = $conn->insert_id;

        $conn->close();

        return $last_id;
    }

    public static function migrate(){
        Migration::runMigration();
    }
}