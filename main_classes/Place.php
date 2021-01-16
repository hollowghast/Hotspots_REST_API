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
    
    private $placeid;
    private $lat;
    private $long;
    private $name;
    private $description;
    
    public function __construct($palceid, $lat, $long, $name, $description) {
        $this->placeid = $palceid;
        $this->lat = $lat;
        $this->long = $long;
        $this->name = $name;
        $this->description = $description;
    }
    
    public function __set($name, $value) {}
    
    /**
     * 
     * @return array Containing latitude and longitude in this order.
     */
    final public function getLatLon():array
    {
        return array($this->lat, $this->long);
    }
    
    public function getName():string
    {
        return $this->name;
    }
    
    public function getDescription():string
    {
        return $this->description;
    }
    
    public function getPlaceId():int
    {
        return $this->placeid;
    }
    
    public static function getAllPlaces() {
        $query = 'SELECT * FROM ":TABLE_NAME";';
        $stmt = Database::getConnection()->prepare($query);
        
        $stmt->bindValue(":TABLE_NAME", TABLE_NAME);
        
        if(!$stmt->execute()){
            echo "Failure!";
            //print_r(Database::getConnection()->errorInfo());
            print_r($stmt->errorInfo());
            die();
        }
        $rowCount = $stmt->rowCount();
        //$places = $stmt->fetchAll();
        echo "Elements: " . $rowCount;
        //print_r($places);
        
//        for($i = 0; i < $rowCount; $i++){
//            $place = $stmt->
//        }
//        
//        $places = array();
//        foreach($rows as $place_raw){
//            $place = 
//            $places[$place_raw->]
//        }
        
        
    }
}
