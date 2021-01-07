<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User{
    private static $unique;
    
    final public static function setUnique($u):void
    {
        User::$unique = $u;
    }
    final public static function getUnique()
    {
        return User::$unique;
    }
}

$u = $_GET['test'];

User::setUnique($u);

http_response_code(200);
echo User::getUnique();