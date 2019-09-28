<?php
/*
Developer : SURENDRA GUPTA
DATE : 25-SEP-2019
Objective : search vessel details 
*/

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");

//Req includes
include_once '../config/database.php';
include_once '../objects/vessel.php';

//Db conn and instances
$database = new Database();
$db=$database->getConnection();

$vessel = new vessel($db);

//get keywords
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";

//query vessel  details
$stmt=$vessel->search($keywords);
$num=$stmt->rowCount();

//check if more than 0 record found
if($num>0){

  //vessel array
    $vessel_arr = array();
    $vessel_arr["records"] = array();

    //retrieve table contents
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['vessel'] to
        // just $vessel only
        extract($row);

        $vessel_item=array(
            "mmsi"            =>$mmsi,
            "status"          =>$status,
            "station"   =>html_entity_decode($station),
            "speed"         =>$speed,
            "lon"   =>$lon,
            "lat" =>$lat,
            "course" =>$course,
            "heading" =>$heading
        );

        array_push($vessel_arr["records"], $vessel_item);
    }

    echo json_encode($vessel_arr);
}else{
    echo json_encode(
        array("message" => "No vessel details found.")
    );
}
