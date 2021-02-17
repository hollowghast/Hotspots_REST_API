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
require_once dirname(__FILE__) . '/../main_classes/FeedEntry.php';
require_once dirname(__FILE__) . '/../core/HTTP_Status_Codes.php';
require_once dirname(__FILE__) . '/../core/HTTP_Response.php';

//$_SESSION['userid'] = 1;

if (isset($_SESSION['userid'])) {
    $placeid = filter_input(INPUT_GET, "placeid", FILTER_VALIDATE_INT);

    if (isset($placeid)) {
        http_response_code(HTTP_Status_Codes::OK);
        echo json_encode(FeedEntry::getAllEntriesFor($placeid));
        die();
    }
    http_response_code(HTTP_Status_Codes::OK);
    echo json_encode(FeedEntry::getAllEntries());
    die();
} else {
    http_response_code(HTTP_Status_Codes::BAD_REQUEST);
    die;
}