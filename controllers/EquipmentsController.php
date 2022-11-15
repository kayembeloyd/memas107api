<?php 

include_once "database/models/Equipment.php";
class EquipmentsController {
    public static function create(){
        $fields = array();
        $sup_fields = array(); 

        // Define fields
        $fields['asset_tag'] = '';
        $fields['commission_date'] = '';
        $fields['department'] = '';
        $fields['e_id'] = 0;
        $fields['make'] = '';
        $fields['model'] = '';
        $fields['name'] = '';
        $fields['serial_number'] = '';
        $fields['supplied_by'] = '';
        $fields['technical_specification_id'] = 0; // Not Important
        // $fields['e_oid'] = ''; // Automatic
        // $fields['technical_specification_oid'] = '' // Automatic;
        $fields['created_at'] = '';
        $fields['updated_at'] = '';

        $sup_fields['technical_specifications'] = '[]';

        // Set essential fields
        foreach ($fields as $key => $value)
            $fields[$key] = isset($_POST[$key]) ? $_POST[$key] : $fields[$key];

        // Set sup fields
        foreach ($sup_fields as $key => $value)
            $sup_fields[$key] = isset($_POST[$key]) ? $_POST[$key] : $sup_fields[$key];

        
    }
}