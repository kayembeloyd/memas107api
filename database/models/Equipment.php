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
        // echo "</br></br>insert_sql_statement = " . $insert_sql_statement;
        $e_oid = Database::execute_getting_last_id($insert_sql_statement);

        $technical_specification_oid = TechnicalSpecification::create($sub_fields, null);

        // UPDATE the equipment
        $update_sql_statement = "UPDATE " . Database::$DATABASE_NAME . ".equipments SET technical_specification_oid = " . $technical_specification_oid . " WHERE e_oid = " . $e_oid;
        // echo "</br></br>update_sql_statement = " . $update_sql_statement;
        Database::execute($update_sql_statement);

        return $e_oid;
    }

    public static function index($fields){
        $select_sql_statement = "SELECT * FROM " . Database::$DATABASE_NAME . ".equipments WHERE uploaded_at > '" . $fields['uploaded_at'][0] . "' LIMIT " . $fields['number_of_equipments'][0] . " OFFSET " . ($fields['page'][0] - 1) * $fields['number_of_equipments'][0];  
        // echo "</br></br>select_sql_statement = " . $select_sql_statement;
        $equipments_results = Database::execute($select_sql_statement);

        $equipments = array();

        if ($equipments_results){
            while($equipment_object = mysqli_fetch_object($equipments_results)){
                
                $modified_equipment_object = array();
                
                foreach ($equipment_object as $key => $value) {
                    $modified_equipment_object[$key] = $value;
                }
                
                array_push($equipments, $modified_equipment_object);
            }
        }

        return $equipments;
    }
}