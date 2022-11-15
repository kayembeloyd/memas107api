<?php 

class Database {
    /* ONLINE
    public static $servername = "localhost";
    public static $username = "id19693607_memas";
    public static $password = "2S9Ahy_@(EyFZgde";
    public static $DATABASE_NAME = "id19693607_memas106"; */

    /* OFFLINE */
    public static $servername = "localhost";
    public static $username = "root";
    public static $password = "";
    public static $DATABASE_NAME = "memas107";
    

    public static function checkConnection(){
        $conn = new mysqli(self::$servername, self::$username, self::$password);
        
        if ($conn->connect_error)
            return ($conn->connect_error);
        
        $conn->close();

        return ('connected');
    }

    public static function execute($sql_statement){
        $conn = new mysqli(self::$servername, self::$username, self::$password);
        
        if ($conn->connect_error) 
            return ($conn->connect_error);
        
        $results = $conn->query($sql_statement);

        $conn->close();

        return $results;
    }

    public static function executeGettingLastID($sql_statement){
        $conn = new mysqli(self::$servername, self::$username, self::$password);
        
        if ($conn->connect_error)
            return ($conn->connect_error);

        $results = $conn->query($sql_statement);

        $last_id = $conn->insert_id;

        $conn->close();

        return $last_id;
    }

    public static function getKeysValuesStatements($fields){
        $keys = '';
        $values = '';

        $count = 0;
        foreach ($fields as $key => $value) {
            if ($count <= 0){
                $keys = $key;
                if ($value[1] === 'string') $values .= "'" . $value[0] . "'";
                else if ($value[1] === 'int') $values .= $value[0]; 
            } else {
                $keys .= (',' . $key);
                if ($value[1] === 'string') $values .= ",'" . $value[0] . "'";
                else if ($value[1] === 'int') $values .= ',' . $value[0]; 
            }

            $count++;
        }

        return [$keys, $values];
    }
}