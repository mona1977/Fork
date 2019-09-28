<?php
/**
DEVELOPER : Surendra Gupta
date : 25-sep-2019

*contains properties and methods for "vessels" database queries.
 */

class vessel
{

    //Db connection and table
    private $conn;
    private $table_name = 'vessel';

    //Object properties
    public $mmsi;
    public $status;
    public $station;
    public $speed;
    public $lon;
    public $lat;
    public $course;
    public $heading;
    public $rot;
    public $timestamp;

    //Constructor with db conn
    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Read vessel table data
    function read(){

        //select all
        $query = "SELECT *  FROM " . $this->table_name ;

        //prepare
        $stmt = $this->conn->prepare($query);

        //execute
        $stmt->execute();

        return $stmt;

    }


    //read single mmsi
    function readOne(){

        //read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE mmsi = ? LIMIT 0,1";

        //prepare
        $stmt = $this->conn->prepare($query);

        //bind mmsi of vessel
        $stmt->bindParam(1, $this->mmsi);

        //execute
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values to update
        $this->status=$row['status'];
        $this->station=$row['station'];
        $this->speed=$row['speed'];
        $this->lon=$row['lon'];
        $this->lat=$row['lat'];
        $this->course=$row['course'];
        $this->heading=$row['heading'];
        $this->rot=$row['rot'];
        $this->timestamp=$row['timestamp'];

    }



    //update vessel
    function update(){

        //update query
        $query = "UPDATE
                    " . $this->table_name. "
                    SET
                        status=:status,
                        station=:station,
                        speed=:speed,
                        lon=:lon,
                        lat=:lat,
                        course=:course,
                        heading=:heading,
                        rot=:rot,
                        timestamp=:timestamp
                    WHERE
                        mmsi=:mmsi";

        //prepare
        $stmt = $this->conn->prepare($query);

         

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

    //delete vessel
    function delete(){

        //delete query
        $query = " DELETE FROM " . $this->table_name . " WHERE mmsi = ?";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->mmsi=htmlspecialchars(strip_tags($this->mmsi));

        //bind id
        $stmt->bindParam(1, $this->mmsi);

        //execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //search vessels details
    function search($keywords){

        //select all query
        $query = "SELECT
                    status, station, speed, lon, lat
                  FROM " . $this->table_name. " 
                  WHERE
                    status LIKE ? OR station LIKE ? OR lon LIKE ?
                  ORDER BY
                    mmsi DESC";

        //prepare
        $stmt =$this->conn->prepare($query);

        //sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        //bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        //execute
        $stmt->execute();

        return $stmt;
    }

    //read vessels with pagination
    public function readPaging($from_record_num, $records_per_page){

        //select
        $query = "SELECT *
                  FROM " . $this->table_name . " 
                  ORDER BY status DESC
                  LIMIT ?, ?";

        //prepare
        $stmt = $this->conn->prepare($query);

        //bind
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        //execute
        $stmt->execute();

        //return values from db
        return $stmt;
    }


    //paging vessel
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];

    }
}
