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

        $ml_oid = MaintenanceLog::create($fields, $sup_fields);

        echo json_encode(MaintenanceLog::get($ml_oid));
    }

    public static function index(){
        $fields = array();

        $fields['number_of_maintenance_logs'] = [0, 'int'];
        $fields['page'] = [0, 'int'];
        $fields['uploaded_at'] = ['', 'string'];
        
        foreach ($fields as $key => $value)
            $fields[$key][0] = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $fields[$key][0];         

        $maintenance_logs = MaintenanceLog::index($fields);

        echo json_encode($maintenance_logs);
    }

    public static function update(){
        $fields = array();

        $fields['maintenance_logs'] = ['[]', 'string'];
    
        foreach ($fields as $key => $value)
            $fields[$key][0] = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $fields[$key][0];         

        $updated_maintenance_logs = MaintenanceLog::update($fields);

        echo json_encode($updated_maintenance_logs);
    }
}