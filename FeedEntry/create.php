<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
require_once dirname(__FILE__) . '/../core/HTTP_Response.php';
require_once dirname(__FILE__) . '/../core/HTTP_Status_Codes.php';
require_once dirname(__FILE__) . '/../main_classes/FeedEntry.php';
require_once dirname(__FILE__) . '/../core/Database.php';

//$_SESSION['userid'] = 85;


if(!isset($_SESSION['userid'])){
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::UNAUTHORIZED, "Not logged in.");
    die;
}

$data = json_decode(file_get_contents("php://input"));

if(empty($data)){
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::BAD_REQUEST, "No data provided.");
    die;
}


//createNewEntry($userId, $title, $content, $placeId):bool
if (empty($data->title) || empty($data->content) || empty($data->placeid)) {
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::BAD_REQUEST, "Not enough data provided.");
    die;
} else {
    if (FeedEntry::createNewEntry($_SESSION['userid'], $data->title, $data->content, $data->placeid)) {
        HTTP_Response::sendPlainMessage(HTTP_Status_Codes::OK, "Entry created.");
        die;
    } else {
        HTTP_Response::sendPlainMessage(HTTP_Status_Codes::INTERNAL_SERVER_ERROR, "Entry not created.");
        die;
    }
}