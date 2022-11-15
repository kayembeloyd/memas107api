<?php 

include_once "database/models/Equipment.php";
class EquipmentsController {
    public static function create(){
        $fields = array();
        $sup_fields = array(); 

        // Define fields
        $fields['asset_tag'] = ['', 'string'];
        $fields['commission_date'] = ['', 'string'];
        $fields['department'] = ['', 'string'];
        $fields['e_id'] = [0, 'int'];
        $fields['make'] = ['', 'string'];
        $fields['model'] = ['', 'string'];
        $fields['name'] = ['', 'string'];
        $fields['serial_number'] = ['', 'string'];
        $fields['supplied_by'] = ['', 'string'];
        $fields['technical_specification_id'] = [0, 'int']; // Not Important
        // $fields['e_oid'] = [0, 'int']; // Automatic
        // $fields['technical_specification_oid'] = [0, 'int'] // Automatic;
        $fields['created_at'] = ['', 'string'];
        $fields['updated_at'] = ['', 'string'];

        $sup_fields['technical_specification'] = ['[]', 'string'];

        // Set essential fields
        foreach ($fields as $key => $value)
            $fields[$key][0] = isset($_POST[$key]) ? $_POST[$key] : $fields[$key][0];

        // Set sup fields
        foreach ($sup_fields as $key => $value)
            $sup_fields[$key][0] = isset($_POST[$key]) ? $_POST[$key] : $sup_fields[$key][0];

        $e_iod = Equipment::create($fields, $sup_fields);
    }

    public static function index(){
        $fields = array();

        $fields['number_of_equipments'] = [0, 'int'];
        $fields['page'] = [0, 'int'];
        $fields['created_at'] = ['', 'string'];
        
        foreach ($fields as $key => $value)
            $fields[$key][0] = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $fields[$key][0];         

        $equipments = Equipment::index($fields);
    }
}