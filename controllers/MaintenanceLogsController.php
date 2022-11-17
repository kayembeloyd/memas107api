<?php 

include_once "database/models/MaintenanceLog.php";

class MaintenanceLogsController {
    public static function create(){
        $fields = array();
        $sup_fields = array(); 

        // Define fields
        $fields['date'] = ['', 'string'];
        $fields['description'] = ['', 'string'];
        $fields['equipment_id'] = ['', 'int'];
        $fields['equipment_oid'] = [0, 'int'];
        $fields['maintenance_log_info_id'] = ['', 'int'];
        $fields['ml_id'] = ['', 'int'];
        $fields['type'] = ['', 'string'];
        // $fields['ml_oid'] = ['', 'int']; // Automatic
        // $fields['maintenance_log_info_oid'] = ['', 'int']; // Automatic
        $fields['created_at'] = ['', 'string'];
        $fields['uploaded_at'] = [date('Y-m-d H:i:s', time()), 'string'];
        $fields['updated_at'] = ['', 'string'];

        $sup_fields['maintenance_log_info'] = ['[]', 'string'];

         // Set essential fields
         foreach ($fields as $key => $value)
            $fields[$key][0] = isset($_POST[$key]) ? $_POST[$key] : $fields[$key][0];

    // Set sup fields
        foreach ($sup_fields as $key => $value)
            $sup_fields[$key][0] = isset($_POST[$key]) ? $_POST[$key] : $sup_fields[$key][0];

    
    }
}