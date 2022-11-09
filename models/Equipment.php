<?php 

include_once "database/database.php";

class Equipment {
    public static function create($fields){
        $equipment_id = Database::execute_getting_last_id(
                "INSERT INTO " . Database::$DATABASE_NAME . ".equipments 
                (id, 
                name, 
                make, 
                model, 
                serial_number, 
                asset_tag, 
                department, 
                commission_date, 
                supplied_by, 
                created_at, 
                updated_at)  
                VALUES (" 
                . $fields['id'] . "," 
                . "'" . $fields['name'] . "'," 
                . "'" . $fields['make'] . "',"
                . "'" . $fields['model'] . "',"
                . "'" . $fields['serial_number'] . "',"
                . "'" . $fields['asset_tag']. "',"
                . "'" . $fields['department'] . "',"
                . "'" . $fields['commission_date'] . "',"
                . "'" . $fields['supplied_by'] . "'," 
                . "'" . $fields['created_at'] . "'," 
                . "'" . $fields['updated_at'] . "')");

        $technical_specification_json = json_decode($fields['technical_specifications']);

        $technical_specification_creation_sql_statement = '';
        $technical_specification_creation_results = true;

        foreach ($technical_specification_json as $technical_specification_json_object) {
            $technical_specification_creation_sql_statement = 
                "INSERT INTO " . Database::$DATABASE_NAME . ".technical_specifications (equipment_id, specification_name, specification_value) 
                VALUES (" . $equipment_id . ",'" . $technical_specification_json_object->specification_name . "','" . $technical_specification_json_object->specification_value . "'" . 
                ")";

            $technical_specification_creation_results = $technical_specification_creation_results && Database::execute($technical_specification_creation_sql_statement);
        } 

        return $equipment_id;
    }

    public static function all($group_length, $exceptions, $page){
        $exceptions_array = explode(',', $exceptions);
        $exception_statement = '';

        foreach ($exceptions_array as $exception) {
            $exception_statement = $exception_statement . "oid <> $exception AND ";    
        }

        $exception_statement = $exception_statement . "oid <> 0 ";

        /// SELECT * FROM `equipments` WHERE id <> 2 AND id <> 4 AND id <> 8 LIMIT 5 OFFSET 5
        $sqlResults = Database::execute(
            "SELECT * FROM " . Database::$DATABASE_NAME . ".equipments WHERE " . $exception_statement . "LIMIT " . $group_length . " OFFSET " . ($page - 1) * $group_length
        );

        return $sqlResults;
    }

    public static function getTechnicalSpecification($oid){
        return Database::execute("SELECT * FROM " . Database::$DATABASE_NAME . ".technical_specifications WHERE equipment_id = $oid");
    }

    public static function get($oid){
        return Database::execute("SELECT * FROM " . Database::$DATABASE_NAME . ".`equipments` WHERE oid = $oid");
    }

    public static function getAssetTag($asset_tag){
        return Database::execute("SELECT * FROM " . Database::$DATABASE_NAME . ".`equipments` WHERE asset_tag = '$asset_tag'");
    }

    public static function update($equipment){
        $online_equipment = Database::execute("SELECT * FROM " . Database::$DATABASE_NAME . ".equipments WHERE oid = $equipment->oid");

        $fields = array();

        $fields['id'] = $equipment->id;
        $fields['name'] = $equipment->name;
        $fields['make'] = $equipment->make;
        $fields['model'] = $equipment->model;
        $fields['serial_number'] = $equipment->serial_number;
        $fields['asset_tag'] = $equipment->asset_tag;
        $fields['department'] = $equipment->department;
        $fields['commission_date'] = $equipment->commission_date;
        $fields['supplied_by'] = $equipment->supplied_by;
        $fields['technical_specifications'] = $equipment->technical_specifications;
        $fields['created_at'] = $equipment->created_at;
        $fields['updated_at'] = $equipment->updated_at;

        if ($online_equipment){
            $online_equipment_object = mysqli_fetch_object($online_equipment);

            if ($online_equipment_object){
                if (new DateTime($online_equipment_object->updated_at) < new DateTime($equipment->updated_at)){
                    // Update the online database
                    $fields = array();
    
                    $fields['name'] = $equipment->name;
                    $fields['updated_at'] = $equipment->updated_at;
                    $fields['technical_specifications'] = $equipment->technical_specifications;
    
                    Database::execute("UPDATE " . Database::$DATABASE_NAME . ".equipments SET name = '" . $fields['name'] . "', updated_at = '" . $fields['updated_at'] . "' WHERE oid = " . $equipment->oid);
                
                    
                    // Updating the technical specifications
                    foreach ($fields['technical_specifications'] as $technical_specification) {
                        Database::execute("UPDATE " . Database::$DATABASE_NAME . ".technical_specifications SET specification_name = '" . $technical_specification->specification_name . "', specification_value = '" . $technical_specification->specification_value . "' WHERE id = " . $technical_specification->id);
                    }
                    
                    return self::get($online_equipment_object->oid);
                }
            } else {
                $fields['technical_specifications'] = json_encode($equipment->technical_specifications);
                return self::get(self::create($fields));
            }
        }

        return false;
    }
}