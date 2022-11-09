<?php 

include_once "database/database.php";

class MaintenanceLog {
    public static function create($fields){
        $maintenance_log_id = Database::execute_getting_last_id(
            "INSERT INTO " . Database::$DATABASE_NAME . ".maintenance_logs (id, type, equipment_oid, equipment_id, description, created_at, updated_at)  
            VALUES (" . $fields['id'] . ",'" . $fields['type'] . "'," . $fields['equipment_oid'] . "," . $fields['equipment_id'] . ",'" . $fields['description'] . "','" . $fields['created_at'] . "','" . $fields['updated_at'] . "'"
            . ")" );

        return $maintenance_log_id;
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
            "SELECT * FROM " . Database::$DATABASE_NAME . ".maintenance_logs WHERE " . $exception_statement . "LIMIT " . $group_length . " OFFSET " . ($page - 1) * $group_length
        );

        return $sqlResults;
    }

    public static function get($oid){
        return Database::execute("SELECT * FROM " . Database::$DATABASE_NAME . ".`maintenance_logs` WHERE oid = $oid");
    }

    public static function update($maintenance_log){
        $online_maintenance_log = Database::execute("SELECT * FROM " . Database::$DATABASE_NAME . ".maintenance_logs WHERE oid = $maintenance_log->oid");

        $fields = array();

        $fields['id'] = $maintenance_log->id;
        $fields['type'] = $maintenance_log->type;
        $fields['equipment_oid'] = $maintenance_log->equipment_oid;
        $fields['equipment_id'] = $maintenance_log->equipment_id;
        $fields['description'] = $maintenance_log->description;
        $fields['created_at'] = $maintenance_log->created_at;
        $fields['updated_at'] = $maintenance_log->updated_at;

        if ($online_maintenance_log){
            $online_maintenance_log_object = mysqli_fetch_object($online_maintenance_log);

            if ($online_maintenance_log_object){
                if (new DateTime($online_maintenance_log_object->updated_at) < new DateTime($maintenance_log->updated_at)){
                    // Update the online database
                    $fields = array();
    
                    $fields['description'] = $maintenance_log->description;
                    $fields['type'] = $maintenance_log->type;
                    $fields['updated_at'] = $maintenance_log->updated_at;
    
                    Database::execute("UPDATE " . Database::$DATABASE_NAME . ".maintenance_logs SET description = '" . $fields['description'] . "', type = '" . $fields['type'] . "', updated_at = '" . $fields['updated_at'] . "' WHERE oid = " . $maintenance_log->oid);
                
                    return self::get($online_maintenance_log_object->oid);
                }
            } else {
                return self::get(self::create($fields));
            }
        }

        return false;
    }
}