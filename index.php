<?php 

include_once "router/route.php";
include_once "router/cors.php";

include_once "controllers/EquipmentsController.php";

Cors::cors();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        Route::add('/', function(){ echo('welcome to Memas107'); });

        break;
    case 'POST':
        Route::add('/equipments', function() { EquipmentsController::create(); });

        break;
    default:
        echo 'unsupported method';
}

Route::submit();