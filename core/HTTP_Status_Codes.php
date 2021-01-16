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
    /**
     * Everything is fine.<br/>
     * Client may continue its request
     * or ignore this if everything's fine.<br/>
     */
    const CONTINUE = 100;
    /**
     * Indicates a protocol switch after
     * the client requested an Upgrade. <br/>
     */
    const SWITCHING = 101;
    /**
     * The server is still processing the 
     * request but has no response available 
     * yet. <br/>
     */
    const PROCESSING = 102;
    /**
     * Used together with the Link Header to 
     * enable preloading resources until
     * the response is ready. <br/>
     */
    const EARLY_HINTS = 103;
    
    //Successful responses (200–299)
    /**
     * This API always responds with Code 
     * 200 after a request has been
     * successfully been worked on. <br/>
     */
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
