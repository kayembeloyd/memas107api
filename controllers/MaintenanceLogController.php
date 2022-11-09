<?php


include_once "models/MaintenanceLog.php";
include_once "models/Equipment.php";

class MaintenanceLogController {
    static function index(){
        $group_length = isset($_REQUEST['group_length']) ? $_REQUEST['group_length'] : 5;
        $exceptions = isset($_REQUEST['exceptions']) ? $_REQUEST['exceptions'] : '';
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;

        $maintenance_logs = MaintenanceLog::all($group_length, $exceptions, $page);
        $maintenance_logs_array = array();

        if ($maintenance_logs){
            while($maintenance_log_object = mysqli_fetch_object($maintenance_logs)){

                $modified_maintenance_log_object = array();

                $modified_maintenance_log_object['id'] = $maintenance_log_object->id;
                $modified_maintenance_log_object['oid'] = $maintenance_log_object->oid;
                $modified_maintenance_log_object['type'] = $maintenance_log_object->type;
                $modified_maintenance_log_object['equipment_oid'] = $maintenance_log_object->equipment_oid;
                $modified_maintenance_log_object['equipment_id'] = $maintenance_log_object->equipment_id;
                $modified_maintenance_log_object['description'] = $maintenance_log_object->description;
                $modified_maintenance_log_object['created_at'] = $maintenance_log_object->created_at;
                $modified_maintenance_log_object['updated_at'] = $maintenance_log_object->updated_at;

                // Get equipment information
                $equipment = Equipment::get($modified_maintenance_log_object['equipment_oid']);

                if ($equipment){
                    $equipment_object = mysqli_fetch_object($equipment);

                    $modified_maintenance_log_object['equipment_name'] = $equipment_object->name;
                    $modified_maintenance_log_object['equipment_asset_tag'] = $equipment_object->asset_tag;
                }


                array_push($maintenance_logs_array, $modified_maintenance_log_object);                
            }
        }

        echo json_encode($maintenance_logs_array);
    }

    static function show($id){
    }

    static function create(){
        $fields = array();

        $fields['id'] = isset($_POST['id']) ? $_POST['id'] : 0 ;
        $fields['type'] = isset($_POST['type']) ? $_POST['type'] : '';
        $fields['equipment_oid'] = isset($_POST['equipment_oid']) ? $_POST['equipment_oid'] : '';
        $fields['equipment_id'] = isset($_POST['equipment_id']) ? $_POST['equipment_id'] : '';
        $fields['description'] = isset($_POST['description']) ? $_POST['description'] : '';
        $fields['created_at'] = isset($_POST['created_at']) ? $_POST['created_at'] : '2022-10-26 04:27' ;
        $fields['updated_at'] = isset($_POST['updated_at']) ? $_POST['updated_at'] : '2022-10-26 04:27' ;

        $status = MaintenanceLog::create($fields);

        $response = array();

        $response['status'] = $status ? 'successfull' : 'failed';
        $response['reason'] = $status ? 'successfully created maintenance log' : 'ERR1'; 

        echo (json_encode($response));
    }

    static function update(){
        $fields = array();

        $fields['maintenance_logs'] = isset($_POST['maintenance_logs']) ? $_POST['maintenance_logs'] : '';

        $maintenance_logs_to_sync = json_decode($fields['maintenance_logs']);

        $update_results = array();

        foreach ($maintenance_logs_to_sync as $maintenance_log) {
            $update_result = MaintenanceLog::update($maintenance_log);

            if ($update_result){
                $update_result_object = mysqli_fetch_object($update_result);
                
                $modified_maintenance_log_object = array();

                $modified_maintenance_log_object['id'] = $maintenance_log->id;
                $modified_maintenance_log_object['oid'] = $update_result_object->oid;
                $modified_maintenance_log_object['type'] = $update_result_object->type;
                $modified_maintenance_log_object['equipment_oid'] = $update_result_object->equipment_oid;
                $modified_maintenance_log_object['equipment_id'] = $update_result_object->equipment_id;
                $modified_maintenance_log_object['description'] = $update_result_object->description;
                $modified_maintenance_log_object['created_at'] = $update_result_object->created_at;
                $modified_maintenance_log_object['updated_at'] = $update_result_object->updated_at;

                // Get equipment information
                $equipment = Equipment::get($modified_maintenance_log_object['equipment_oid']);

                if ($equipment){
                    $equipment_object = mysqli_fetch_object($equipment);

                    $modified_maintenance_log_object['equipment_name'] = $equipment_object->name;
                    $modified_maintenance_log_object['equipment_asset_tag'] = $equipment_object->asset_tag;
                }

                array_push($update_results, $modified_maintenance_log_object);
            }
        }

        echo (json_encode($update_results));
    }
}