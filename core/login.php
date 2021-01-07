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
require_once dirname(__FILE__) . '/../main_classes/RegularUser.php';
require_once dirname(__FILE__) . '/../core/HTTP_Status_Codes.php';

//check POST for username and password
//$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$data = json_decode(file_get_contents("php://input"));

if(empty($data)){
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::BAD_REQUEST, "No data provided.");
    die;
}

if (empty($data->username) || empty($data->password)) {
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::BAD_REQUEST, "Not enough data provided.");
    die();
} else {
    $id = RegularUser::checkLogin($data->username, $data->password);

    if ($id >= 0) {
        $_SESSION['userid'] = $id;
        HTTP_Response::sendPlainMessage(HTTP_Status_Codes::OK, "Logged in.");
        die();
    }
}


HTTP_Response::sendPlainMessage(HTTP_Status_Codes::UNAUTHORIZED, "Username or password is wrong.");










//get User-Data to register

