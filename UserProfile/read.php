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
require_once dirname(__FILE__) . '/../main_classes/UserProfile.php';
require_once dirname(__FILE__) . '/../core/HTTP_Status_Codes.php';
require_once dirname(__FILE__) . '/../core/HTTP_Response.php';

//HTTP_Response::sendPlainMessage(HTTP_Status_Codes::NOT_FOUND, "Functionality not implemented yet");


//$_SESSION['userid'] = 1;
//UserProfile::setFirstname("user");
//UserProfile::setLastname("name");
//UserProfile::setDescription("desc");
//UserProfile::setGender("...");
//check if user is logged in

if (isset($_SESSION['userid'])) {
    UserProfile::fetchProfileDataByID($_SESSION['userid']);
    echo json_encode(UserProfile::getAttributes());
    http_response_code(HTTP_Status_Codes::OK);
    die;
} else {
    http_response_code(HTTP_Status_Codes::UNAUTHORIZED);
    die;
}