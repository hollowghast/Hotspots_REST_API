<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("TABLE_NAME", "Place");

/**
 * Description of Place
 *
 * @author Daniel
 * @version 20.12.07
 */
class Place {
    //TABLE_NAME = "Place";
    
    private $PlaceId;
    private $Latitude;
    private $Longitude;
    private $Name;
    private $Description;
    
//    public function __construct($palceid, $lat, $long, $name, $description) {
//        $this->PlaceId = $palceid;
//        $this->Latitude = $lat;
//        $this->Longitude = $long;
//        $this->Name = $name;
//        $this->Description = $description;
//    }
    
    function __construct() {
        
    }

    
    public function __set($name, $value) {}
    
    /**
     * 
     * @return array Containing latitude and longitude in this order.
     */
    final public function getLatLon():array
    {
        return array($this->Latitude, $this->Longitude);
    }
    
    public function getName():string
    {
        return $this->Name;
    }
    
    public function getDescription():string
    {
        return $this->Description;
    }
    
    public function getPlaceId():int
    {
        return $this->PlaceId;
    }
    
    public static function getAllPlaces(){
        $query = 'SELECT "PlaceId", "Latitude", "Longitude", "Name", "Description" FROM "Place";';
        $stmt = Database::getConnection()->prepare($query);
        
        //$stmt->bindValue(":TABLE_NAME", TABLE_NAME);
        
        if(!$stmt->execute()){
            //echo "Failure!";
            //print_r(Database::getConnection()->errorInfo());
            print_r($stmt->errorInfo());
            //http_response_code(HTTP_Status_Codes::INTERNAL_SERVER_ERROR);
            return;
        }
//        $rowCount = $stmt->rowCount();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //
        //echo "Elements: " . $rowCount;
        //print_r($places);
//        $places = array();
//        
//        for($i = 0; i < $rowCount; $i++){
//            $place = $stmt->fetch();
//        }
//        
//        $places = array();
//        foreach($rows as $place_raw){
//            $place = 
//            $places[$place_raw->]
//        }
        
        
    }
    
    
    public static function createNewPlace($lat, $long, $name, $desc):bool
    {
        $query = 'INSERT INTO "Place"'
                . ' ("Latitude", "Longitude", "Name", "Description")' .
                ' VALUES(:lat, :long, :name, :desc);';

        $stmt = Database::getConnection()->prepare($query);
        
//        $stmt->bindParam(":lat", (double)$lat, PDO::PARAM_STR);
//        $stmt->bindParam(":long", (double)$long, PDO::PARAM_STR);
//        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
//        $stmt->bindParam(":desc", $desc, PDO::PARAM_STR);
        
        $stmt->bindValue(":lat", (real)$lat, PDO::PARAM_STR);
        $stmt->bindValue(":long", (real)$long, PDO::PARAM_STR);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":desc", $desc, PDO::PARAM_STR);
        
        try{
            $successful = $stmt->execute();
        } catch (Exception $ex) {
            print_r($stmt->errorInfo());
            return FALSE;
        }

        return $successful;
    }
    
    public static function deletePlaceById($id):bool
    {
        $query = 'DELETE FROM "Place"'
                . ' WHERE "PlaceId" = :id;';

        $stmt = Database::getConnection()->prepare($query);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        try{
            $successful = $stmt->execute();
        } catch (Exception $ex) {
            print_r($stmt->errorInfo());
            return FALSE;
        }

        return $successful;
    }
}
