<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * The below status codes are defined by section 10 of RFC 2616.
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Status HTTP-Status-Codes
 * 
 * @author Daniel
 * @version 20.12.07
 */
class HTTP_Status_Codes {
    //Informational responses (100–199)
    //Successful responses (200–299)
    const OK = 200;
    //Redirects (300–399)
    //Client errors (400–499)
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const NOT_FOUND = 404;
    const TEAPOT = 418;

    //Server errors (500–599)
    const INTERNAL_SERVER_ERROR = 500;
}
