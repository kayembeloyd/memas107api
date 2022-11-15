<?php

include_once "database/database.php";

include_once "database/models/TechnicalSpecification.php";

class Equipment {
    public static function create($fields, $sub_fields){        
        // Creating the essential SQL statement elements
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
        // Creating the essential SQL statement elements

        $insert_sql_statement = "INSERT INTO " . Database::$DATABASE_NAME . ".equipments (" . $keys . ") VALUES (" . $values . ")";

        echo "</br></br>insert_sql_statement = " . $insert_sql_statement;
        $e_oid = 0; // After sql execution

        $technical_specification_oid = TechnicalSpecification::create($sub_fields, null);

        // UPDATE the equipment
        $update_sql_statement = "UPDATE " . Database::$DATABASE_NAME . ".equipments technical_specification_oid = " . $technical_specification_oid . " WHERE e_oid = " . $e_oid;
        echo "</br></br>update_sql_statement = " . $update_sql_statement;

        return $e_oid;
    }

    public static function index($fields){
        /// SELECT * FROM `equipments` WHERE id <> 2 AND id <> 4 AND id <> 8 LIMIT 5 OFFSET 5

        $select_sql_statement = "SELECT * FROM " . Database::$DATABASE_NAME . ".equipments WHERE created_at > '" . $fields['created_at'][0] . "' LIMIT " . $fields['number_of_equipments'][0] . " OFFSET " . ($fields['page'][0] - 1) * $fields['number_of_equipments'][0];  
        echo "</br></br>select_sql_statement = " . $select_sql_statement;

        return array();
    }
}