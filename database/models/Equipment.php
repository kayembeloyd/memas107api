<?php

include_once "database/database.php";

include_once "database/models/TechnicalSpecification.php";

class Equipment {
    public static function create($fields, $sub_fields){        
        $kv = Database::getKeysValuesStatements($fields);

        $keys = $kv[0];
        $values = $kv[1];

        $insert_sql_statement = "INSERT INTO " . Database::$DATABASE_NAME . ".equipments (" . $keys . ") VALUES (" . $values . ")";
        $e_oid = Database::executeGettingLastID($insert_sql_statement);

        $technical_specification_oid = TechnicalSpecification::create($sub_fields, null);

        $update_sql_statement = "UPDATE " . Database::$DATABASE_NAME . ".equipments SET technical_specification_oid = " . $technical_specification_oid . " WHERE e_oid = " . $e_oid;
        Database::execute($update_sql_statement);

        return $e_oid;
    }

    public static function get($e_oid){
        $select_sql_statement = "SELECT * FROM " . Database::$DATABASE_NAME . ".equipments WHERE e_oid = " . $e_oid;
        $equipment_results = Database::execute($select_sql_statement);

        $equipment = null;

        if ($equipment_results){
            if ($equipment_object = mysqli_fetch_object($equipment_results)){
                $modified_equipment_object = array();

                foreach ($equipment_object as $key => $value)
                    $modified_equipment_object[$key] = $value;
                
                $equipment = $modified_equipment_object;
            }
        }

        return $equipment;
    }

    public static function index($fields){
        $select_sql_statement = "SELECT * FROM " . Database::$DATABASE_NAME . ".equipments WHERE uploaded_at > '" . $fields['uploaded_at'][0] . "' LIMIT " . $fields['number_of_equipments'][0] . " OFFSET " . ($fields['page'][0] - 1) * $fields['number_of_equipments'][0];  
        $equipments_results = Database::execute($select_sql_statement);

        $equipments = array();

        if ($equipments_results){
            while($equipment_object = mysqli_fetch_object($equipments_results)){
                $modified_equipment_object = array();
                
                foreach ($equipment_object as $key => $value)
                    $modified_equipment_object[$key] = $value;

                $modified_equipment_object['technical_specification'] = TechnicalSpecification::get(
                    $modified_equipment_object['technical_specification_oid']
                );

                array_push($equipments, $modified_equipment_object);
            }
        }

        return $equipments;
    }

    public static function update($fields){
        $equipments_to_update = json_decode($fields['equipments'][0]);
        $updated_equipments = array();

        foreach ($equipments_to_update as $eq_to_update) {
            $eq_in_database = self::get($eq_to_update->e_oid);

            if ($eq_in_database && ($eq_in_database['updated_at'] > $eq_to_update->updated_at))
                array_push($updated_equipments, $eq_in_database);
        }

        return $updated_equipments;
    }
}