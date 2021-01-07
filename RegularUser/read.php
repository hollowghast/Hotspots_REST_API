<?php
/**
 * need to remove this page after reviewing it (functionality moved to RegularUser class)
 */


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../core/Database.php';
include_once '../main_classes/RegularUser.php';
include_once '../core/HTTP_Status_Codes.php';



$database = new Database();
$conn = $database->getConnection();

$user = new RegularUser($conn);

$userid = filter_input(INPUT_GET, "userid", FILTER_VALIDATE_INT);

if ($userid != null) {
    //access to user view (id, username, creation_tstmp)
    if ($userid >= 0) {
        $u = new RegularUser($conn);
        $u->getUserByID($userid);
        http_response_code(HTTP_STATUS_CODES::OK);
//            echo json_encode($u);
        $user_arr = array(
            'id' => $u->getUserID(),
            'username' => $u->getUsername(),
            'creation' => $u->getCreation(),
            'last_modified' => $u->getLastModified()
        );
        echo json_encode($user_arr);
    }
    //if user found
    //testdata
    else if ($userid == "-1") {
        http_response_code(HTTP_STATUS_CODES::OK);
        echo json_encode(
                array(
                    array(
                        "id" => "$userid",
                        "username" => "some fictional user",
                        "created" => "267436276276"
                    )
                )
        );
    } else {
        http_response_code(404);
        echo json_encode(
                array(
                    "message" => "User not found."
                )
        );
    }
}