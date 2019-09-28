<?php

/*
Developer : SURENDRA GUPTA
DATE : 25-SEP-2019
Objective : search multiple mmsi 
*/

//Required headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include db and object

include_once '../config/database.php';
include_once '../objects/vessel.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$vessel = new vessel($db);

//Query vessel
$stmt = $vessel->read();
$num = $stmt->rowCount();

//Check if more than 0 record found
if($num > 0){

    //vessel array
    $vessel_arr = array();
    $vessel_arr["records"] = array();

    //retrieve table content
    // Difference fetch() vs fetchAll()

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // extract row
        // this will make $row['mmsi'] to
        // just $mmsi only
        extract($row);

        $vessel_item = array(
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

        array_push($vessel_arr["records"], $vessel_item);
    }

    echo json_encode($vessel_arr);
}else{
    echo json_encode(
        array("messege" => "No vessel details found.")
    );
}
