<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HTTP_Response
 *
 * @author Daniel
 * @version 20.12.07
 */
class HTTP_Response {
    /**
     * Shall be used for informational tasks.<br>
     * Do  <b>not</b>  try to send objects.
     * 
     * @param HTTP_Status_Code $code Probably 200 for >OK< or 401 for >Not Authorized<
     * @param String $msg Some message you want your client to receive.
     * @return void
     */
    final public static function sendPlainMessage($code, $msg):void
    {
        http_response_code($code);
        echo json_encode(array(
            "message" => "" . $msg
        ));
    }
}

//Test
//HTTP_Response::sendPlainMessage(200, "Some text");
