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

//$_SESSION['userid'] = 1;




/*********
 * 
 * NOT READY YET
 * 
 * needs approval if the user is owner of specific post before deletion
 * 
 */





if (!isset($_SESSION['userid'])) {
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::UNAUTHORIZED, "Not logged in.");
    die;
}

$entryid = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (empty($placeid)) {
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::BAD_REQUEST, "No ID provided.");
    die;
}

if (Place::deletePlaceById($placeid)) {
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::OK, "Place deleted.");
    die;
} else {
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::INTERNAL_SERVER_ERROR, "Place not deleted.");
    die;
}