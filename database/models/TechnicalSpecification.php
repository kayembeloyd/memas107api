<?php 

class TechnicalSpecification {
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

        $insert_sql_statement = "INSERT INTO " . Database::$DATABASE_NAME . ".technical_specifications (" . $keys . ") VALUES (" . $values . ")";

        echo "</br></br>insert_sql_statement = " . $insert_sql_statement;
        $tss_oid = 0; // After sql execution

        return $tss_oid;
    }
}