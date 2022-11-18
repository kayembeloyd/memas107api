<?php 

include_once "database/database.php";

include_once "database/models/MaintenanceLogInfo.php";

class MaintenanceLog {
    public static function create($fields, $sub_fields){
        $kv = Database::getKeysValuesStatements($fields);

        $keys = $kv[0];
        $values = $kv[1];

        $insert_sql_statement = "INSERT INTO " . Database::$DATABASE_NAME . ".maintenance_logs (" . $keys . ") VALUES (" . $values . ")";
        $ml_oid = Database::executeGettingLastID($insert_sql_statement);

        $maintenance_log_info_oid = MaintenanceLogInfo::create($sub_fields, null);
        
        $update_sql_statement = "UPDATE " . Database::$DATABASE_NAME . ".maintenance_logs SET maintenance_log_info_oid = " . $maintenance_log_info_oid . " WHERE ml_oid = " . $ml_oid;
        Database::execute($update_sql_statement);

        return $ml_oid;
    }

    public static function get($ml_oid){
        $select_sql_statement = "SELECT * FROM " . Database::$DATABASE_NAME . ".maintenance_logs WHERE ml_oid = " . $ml_oid;
        $maitenance_log_results = Database::execute($select_sql_statement);

        $maintenance_log = null;

        if ($maitenance_log_results){
            if ($maintenance_object = mysqli_fetch_object($maitenance_log_results)){
                $modified_maintenance_log_object = array();

                foreach ($maintenance_object as $key => $value)
                    $modified_maintenance_log_object[$key] = $value;
                
                $maintenance_log = $modified_maintenance_log_object;
            }
        }

        return $maintenance_log;
    }

    public static function index($fields){
        $select_sql_statement = "SELECT * FROM " . Database::$DATABASE_NAME . ".maintenance_logs WHERE uploaded_at > '" . $fields['uploaded_at'][0] . "' LIMIT " . $fields['number_of_maintenance_logs'][0] . " OFFSET " . ($fields['page'][0] - 1) * $fields['number_of_maintenance_logs'][0];  
        $maintenance_logs_results = Database::execute($select_sql_statement);

        $maintenance_logs = array();

        if ($maintenance_logs_results){
            while($maintenance_log_object = mysqli_fetch_object($maintenance_logs_results)){
                $modified_maintenance_log_object = array();
                
                foreach ($maintenance_log_object as $key => $value)
                    $modified_maintenance_log_object[$key] = $value;

                $modified_maintenance_log_object['maintenance_log_info'] = MaintenanceLogInfo::get(
                    $modified_maintenance_log_object['maintenance_log_info_oid']
                );

                array_push($maintenance_logs, $modified_maintenance_log_object);
            }
        }

        return $maintenance_logs;
    }

    public static function update($fields){
        $maintenance_logs_to_update = json_decode($fields['maintenance_logs'][0]);
        $updated_maintenance_logs = array();

        foreach ($maintenance_logs_to_update as $ml_to_update) {
            $ml_in_database = self::get($ml_to_update->ml_oid);

            if ($ml_in_database && ($ml_in_database['updated_at'] > $ml_to_update->updated_at))
                array_push($updated_maintenance_logs, $ml_in_database);
            else if ($ml_in_database && ($ml_in_database['updated_at'] < $ml_to_update->updated_at)){
                $count = 0;
                $update_sql_statement_set_element = '';

                foreach ($ml_to_update as $key => $value) {
                    if ($key == 'ml_id' || $key == 'ml_oid' || $key == 'maintenance_log_info_id' || $key == 'maintenance_log_info_oid') continue;
                    
                    if ($count == 0) {$update_sql_statement_set_element .= $key . "='" . $value . "'"; $count++;}
                    else {$update_sql_statement_set_element .= ', ' . $key . "='" . $value . "'"; $count++;}
                }

                $update_sql_statement = "UPDATE " . Database::$DATABASE_NAME . ".maintenance_logs SET " . $update_sql_statement_set_element . " WHERE ml_oid = " . $ml_to_update->ml_oid; 
                Database::execute($update_sql_statement);
            }
        }

        return $updated_maintenance_logs;
    }
}