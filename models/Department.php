<?php 

include_once "database/database.php";

class Department {
    public static function create($fields){
    }

    public static function all(){
        $sqlResults = Database::execute(
            "SELECT * FROM " . Database::$DATABASE_NAME . ".departments"
        );

        return $sqlResults;
    }

    public static function get($oid){
    }

    public static function update($department){
    }
}