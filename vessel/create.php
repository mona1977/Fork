<?php
/*
Developer : SURENDRA GUPTA
DATE : 25-SEP-2019
Objective : create new vessel details 
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

//set vessel values
$vessel->mmsi            = $data->mmsi;
$vessel->status          = $data->status;
$vessel->station         = $data->station;
$vessel->speed   = $data->speed;
$vessel->lon   = $data->lon;
$vessel->lat   = $data->lat;
$vessel->course   = $data->course;
$vessel->heading   = $data->heading;
$vessel->rot   = $data->rot;
$vessel->timestamp   = date('Y-m-d H:i:s');

//Create vessel details
if($vessel->create()){
    echo '{';
        echo '"message": "vessel was created."';
    echo '}';
}else{
    echo '{';
        echo '"message": "Unable to create vessel."';
    echo '}';
}

function create(){

    //query insert
    $query = "INSERT INTO
              ". $this->table_name ."
              SET
                mmsi=:mmsi, status=:status, station=:station, speed=:speed,lon=:lon,lat:=lat,course:=course,heading:=heading,rot:=rot, timestamp=:timestamp";

    //Prepare
    $stmt = $this->conn->prepare($query);

    //sanitize
    
    $this->mmsi=htmlspecialchars(strip_tags($this->mmsi));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->station=htmlspecialchars(strip_tags($this->station));
    $this->speed=htmlspecialchars(strip_tags($this->speed));
    $this->lon=htmlspecialchars(strip_tags($this->lon));
    $this->lat=htmlspecialchars(strip_tags($this->lat));
    $this->course=htmlspecialchars(strip_tags($this->course));
    $this->heading=htmlspecialchars(strip_tags($this->heading));
    $this->rot=htmlspecialchars(strip_tags($this->rot));
    $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));

    //Bind values
    
    $stmt->bindParam(":mmsi", $this->mmsi);
    $stmt->bindParam(":status", $this->status);
    $stmt->bindParam(":station", $this->station);
    $stmt->bindParam(":speed", $this->speed);
    $stmt->bindParam(":lon", $this->lon);
    
    $stmt->bindParam(":lat", $this->lat);
    $stmt->bindParam(":course", $this->course);
    $stmt->bindParam(":heading", $this->heading);
    $stmt->bindParam(":rot", $this->rot);
    $stmt->bindParam(":timestamp", $this->timestamp);

    //execute
    if($stmt->execute()){
        return true;
    }
    return false;
}
