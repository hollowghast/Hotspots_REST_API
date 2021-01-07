<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once dirname(__FILE__) . '/./HTTP_Response.php';
require_once dirname(__FILE__) . '/./HTTP_Status_Codes.php';
require_once dirname(__FILE__) . '/../main_classes/RegularUser.php';
require_once dirname(__FILE__) . '/./Database.php';

$data = json_decode(file_get_contents("php://input"));
//echo $data->username;
if(empty($data)){
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::BAD_REQUEST, "No data provided.");
    die;
}

//get User-Data to register

if (empty($data->username) || empty($data->password)) {
    //can't create user
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::BAD_REQUEST, "Not enough data provided.");
} else {
    //create user
    //$u = new RegularUser(); //before making it static
    RegularUser::setUsername($data->username);
    RegularUser::setPassword($data->password); //hashing
    if (RegularUser::createNewUser()) {
        HTTP_Response::sendPlainMessage(HTTP_Status_Codes::OK, "User created.");
    } else {
        HTTP_Response::sendPlainMessage(HTTP_Status_Codes::INTERNAL_SERVER_ERROR, "User not created.");
    }
}