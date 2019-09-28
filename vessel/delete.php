<?php
/*
Developer : SURENDRA GUPTA
DATE : 25-SEP-2019
Objective : delete vessel details 
*/


//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../config/database.php';
include_once '../objects/vessel.php';

//Db conn and instances
$database = new Database();
$db=$database->getConnection();

$vessel = new vessel($db);

//Get post data
$data = json_decode(file_get_contents("php://input"));

//set mmsi of vessel to be deleted
$vessel->mmsi = $data->mmsi;


//delete vessel
if($vessel->delete()){
    echo '{';
        echo '"message": "vessel was deleted."';
    echo '}';
}else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
