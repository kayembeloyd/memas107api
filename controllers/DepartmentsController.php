<?php

include_once "models/Department.php";

class DepartmentsController {
    static function index(){ 
        $departments = Department::all();

        $departments_array = array();

        if ($departments){
            while($department_object = mysqli_fetch_object($departments)){
                $modified_department_object = array();
                $modified_department_object['id'] = $department_object->id;
                $modified_department_object['oid'] = $department_object->oid;
                $modified_department_object['name'] = $department_object->name;

                array_push($departments_array, $modified_department_object);                
            }
        }

        echo json_encode($departments_array);
    }

    static function show($id){
    }

    static function create(){
    }

    static function update(){
    }
}