<?php 

/* Ready for Testing PHASE 1 20-Nov-2022 */

include_once "router/route.php";
include_once "router/cors.php";

include_once "controllers/EquipmentsController.php";
include_once "controllers/MaintenanceLogsController.php";

Cors::cors();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        Route::add('/', function(){ echo('welcome to Memas107'); });
        Route::add('/equipments', function() { EquipmentsController::index(); });
        Route::add('/maintenance-logs', function() { MaintenanceLogsController::index(); });
        break;
    case 'POST':
        Route::add('/equipments', function() { EquipmentsController::create(); });
        Route::add('/equipments/update', function() { EquipmentsController::update(); });
        Route::add('/maintenance-logs', function() { MaintenanceLogsController::create(); });
        Route::add('/maintenance-logs/update', function() { MaintenanceLogsController::update(); });

        break;
    default:
        echo 'unsupported method';
}

Route::submit();