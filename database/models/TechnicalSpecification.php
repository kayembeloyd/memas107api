<?php 

include_once "database/database.php";
class TechnicalSpecification {
    public static function create($fields, $sub_fields){        
        $kv = Database::getKeysValuesStatements($fields);

        $keys = $kv[0];
        $values = $kv[1];

        $insert_sql_statement = "INSERT INTO " . Database::$DATABASE_NAME . ".technical_specifications (" . $keys . ") VALUES (" . $values . ")";

        $tss_oid = Database::executeGettingLastID($insert_sql_statement);

        return $tss_oid;
    }

    public static function get($tss_oid){
        $select_sql_statement = "SELECT * FROM " . Database::$DATABASE_NAME . ".technical_specifications WHERE tss_oid = " . $tss_oid;
        $technical_specification_results = Database::execute($select_sql_statement);

        $technical_specification = null;

        if ($technical_specification_results){
            if ($technical_specification_object = mysqli_fetch_object($technical_specification_results)){
                $modified_technical_specification = array();

                foreach ($technical_specification_object as $key => $value)
                    $modified_technical_specification[$key] = $value;
                
                $technical_specification = $modified_technical_specification;
            }
        }

        return $technical_specification;
    }
}