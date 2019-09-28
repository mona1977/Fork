<?php
/*
Developer : SURENDRA GUPTA
DATE : 25-SEP-2019
Objective : read one vessel details according log, lat 
*/
//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: access");

//Include db and object

include_once '../config/database.php';
include_once '../objects/vessel.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$vessel = new vessel($db);

//Set mmsi of vessel to be edited
$vessel->mmsi = isset($_GET['mmsi']) ? $_GET['mmsi']: die;

//Read details of edited vessel
$vessel->readOne();

//Create array
$vessel_arr = array(
    "mmsi" => $vessel->mmsi,
    "status" => $vessel->status,
    "station" => $vessel->station,
    "speed" => $vessel->speed,
    "lon" => $vessel->lon,
    "lat" => $vessel->lat,
    "course" => $vessel->course,
    "heading" => $vessel->heading,
    "rot" => $vessel->rot
    
);

print_r(json_encode($vessel_arr));
