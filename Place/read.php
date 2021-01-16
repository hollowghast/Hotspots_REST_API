<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once dirname(__FILE__) . '/../core/Database.php';
require_once dirname(__FILE__) . '/../main_classes/Place.php';
require_once dirname(__FILE__) . '/../core/HTTP_Status_Codes.php';
require_once dirname(__FILE__) . '/../core/HTTP_Response.php';

//HTTP_Response::sendPlainMessage(HTTP_Status_Codes::NOT_FOUND, "Functionality not implemented yet");

//test data
//$places = array();
//$places['default place'] = array("long" => 12.21221,
//    "lat" => 24.27187);
//echo json_encode($places);
//$_SESSION['userid'] = 1;

//Place::getAllPlaces();


//check if user is logged in

if (isset($_SESSION['userid'])) {
//logged in
//if no context given, return all entries
    $long = filter_input(INPUT_GET, "long", FILTER_VALIDATE_FLOAT);
    $lat = filter_input(INPUT_GET, "lat", FILTER_VALIDATE_FLOAT);
    $radius = filter_input(INPUT_GET, "radius", FILTER_VALIDATE_FLOAT);

    if (isset($long) && isset($lat) && isset($radius)) {
//context given
//return specific places in that area

        //HTTP_Response::sendPlainMessage(HTTP_Status_Codes::NOT_FOUND, "Functionality not implemented yet");
        $places = array();
        $places['default place 1'] = array("long" => 12.21221,
            "lat" => 24.27187);
        $places['default place 2'] = array("long" => 74.21221,
            "lat" => 12.27187);
        echo json_encode(array($places));
        die();
        //echo json_encode($user_arr);
    }
//if user found
//testdata
    



//testdata
    echo json_encode(
            array(
                "lat" => 27.2251,
                "lon" => 33.2617,
                "name" => "Some Place"
            )
    );
    http_response_code(HTTP_Status_Codes::OK);
} else {
    http_response_code(HTTP_Status_Codes::BAD_REQUEST);
    die;
}