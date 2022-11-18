<?php 

include_once "database/database.php";
class MaintenanceLogInfo {
    public static function create($fields, $sub_fields){
        $kv = Database::getKeysValuesStatements($fields);

        $keys = $kv[0];
        $values = $kv[1];

        $insert_sql_statement = "INSERT INTO " . Database::$DATABASE_NAME . ".maintenance_log_infos (" . $keys . ") VALUES (" . $values . ")";

        $mli_oid = Database::executeGettingLastID($insert_sql_statement);

        return $mli_oid;
    }

    public static function get($mli_oid){
        $select_sql_statement = "SELECT * FROM " . Database::$DATABASE_NAME . ".maintenance_log_infos WHERE mli_oid = " . $mli_oid;
        $maintenance_log_info_results = Database::execute($select_sql_statement);

        $maintenance_log_info = null;

        if ($maintenance_log_info_results){
            if ($maintenance_log_info_object = mysqli_fetch_object($maintenance_log_info_results)){
                $modified_maintenance_log_info_object = array();

                foreach ($maintenance_log_info_object as $key => $value)
                    $modified_maintenance_log_info_object[$key] = $value;
                
                $maintenance_log_info = $modified_maintenance_log_info_object;
            }
        }

        return $maintenance_log_info;
    }

    
}