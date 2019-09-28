<?php
/*
Developer : Surendra Gupta
Date : 25-sep-2019
Update Vessels records
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

//set Id and values of vessel details to be edited
$vessel->mmsi            = $data->mmsi;
$vessel->status          = $data->status;
$vessel->station         = $data->station;
$vessel->speed   = $data->speed;
$vessel->lon   = $data->lon;
$vessel->lat   = $data->lat;
$vessel->course   = $data->course;
$vessel->heading   = $data->heading;
$vessel->rot   = $data->rot;
$vessel->timestamp   = $data->timestamp;

//update vessel detals
if($vessel->update()){
    echo '{';
        echo '"message": "vessel details was updated."';
    echo '}';
}else{
    echo '{';
        echo '"message": "Unable to update vessel details."';
    echo '}';
}
