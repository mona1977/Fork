<?php
/*
Developer : SURENDRA GUPTA
DATE : 25-SEP-2019
Objective : display according paging wise for vessel details 
*/


//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");

//Req includes
include_once '../config/core.php';
include_once '../shared/Utilities.php';
include_once '../config/database.php';
include_once '../objects/vessel.php';

//utilities
$utilities = new Utilities();

//Db conn and instances
$database = new Database();
$db=$database->getConnection();

$vessel = new vessel($db);


//query vessel
$stmt = $vessel->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();


print_r($stmt);
echo $num;



//If more than 0 records
if($num>0){

    //vessel array
    $vessel_arr=array();
    $vessel_arr["records"]=array();
    $vessel_arr["paging"]=array();

    //retrieve table content
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //extract row
        extract($row);

        $vessel_item = array(
            "mmsi"            =>  $mmsi,
            "status"          =>  $status,
            "station"   =>  html_entity_decode($station),
            "speed"         =>  $speed,
            "lon"   =>  $lon,
            "lat" =>  $lat,
            "course" =>$course,
            "heading" =>$heading,
            "rot" =>$rot,
        );

        array_push($vessel_arr["records"], $vessel_item);
    }

    //include paging
    $total_rows=$vessel->count();
    $page_url="{$home_url}/vessel/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $vessel_arr["paging"]=$paging;

    echo json_encode($vessel_arr);
}else{
    echo json_encode(array(
        "message" => "No vessel  details found.")
    );
}
