<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require_once dirname(__FILE__) . '/../core/Database.php';
require_once dirname(__FILE__) . '/../main_classes/RegularUser.php';
require_once dirname(__FILE__) . '/../core/HTTP_Status_Codes.php';
require_once dirname(__FILE__) . '/../core/HTTP_Response.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//$uri = parse_url(filter_input(INPUT_SERVER, "REQUEST_URI", FILTER_SANITIZE_STRING), PHP_URL_PATH);
//echo $uri . "\n";
//echo $_SERVER['SCRIPT_NAME'] . "\n"; //preferred
//echo $_SERVER['PHP_SELF'] . "\n";

$uri = str_replace($_SERVER['SCRIPT_NAME'], "", $uri);
$uri = explode('/', $uri);

// all of our endpoints start with /person
// everything else results in a 404 Not Found
//echo $uri[1];
if ($uri[1] !== 'user') { //for RegularUser's
    //respond with 404
    HTTP_Response::sendPlainMessage(HTTP_Status_Codes::NOT_FOUND, "Resource not found.");
    die;
}

// the user id is, of course, optional and must be a number:
$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

//$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestMethod = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_STRING);

// pass the request method and user ID to the PersonController and process the HTTP request:
//$controller = new PersonController($dbConnection, $requestMethod, $userId); //pass the arguments on to Regularuser-Controller
//$controller->processRequest(); //fetch data and respond accordingly

if ($userId == null) {
    echo json_encode(
            array(
                array(
                    "userId" => 12,
                    "username" => "Test1",
                    "password" => "Test1"
                ),
                array(
                    "userId" => 23,
                    "username" => "Test2",
                    "password" => "Test2"
                ),
                array(
                    "userId" => 1,
                    "username" => "Test3",
                    "password" => "Test3"
                ),
                array(
                    "userId" => 82,
                    "username" => "Test4",
                    "password" => "Test4"
                )
            )
    );
    http_response_code(HTTP_STATUS_CODES::OK);
    die;
}

echo json_encode(array(
    "username" => "Test",
    "password" => "Test"
));

http_response_code(HTTP_STATUS_CODES::OK);
die;