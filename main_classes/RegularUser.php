<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegularUser
 *
 * TODO:
 * Make static? Check
 * Test it.
 * 
 * @author Daniel
 * @version 21.01.02
 */
//$u = new RegularUser(null);
//$u->getUserID();

class RegularUser {

    const TABLE_NAME = "RegularUser";
    
    private static $userid;
    private static $username;
    private static $password;
    private static $creation;
    private static $last_modified;
    

    public static function getUserID() {
        return RegularUser::$userid;
    }

    public function getUsername() {
        return RegularUser::$username;
    }

    public function getPassword() {
        return RegularUser::$password;
    }

    public function getCreation() {
        return RegularUser::$creation;
    }

    public function getLastModified() {
        return RegularUser::$last_modified;
    }

    public function createNewUser() {
        $query = 'INSERT INTO \"RegularUser\"(username, pass)' .
                ' VALUES(:username, :pass);';

        $stmt = Database::getConnection()->prepare($query);

        RegularUser::$username = htmlspecialchars(strip_tags(RegularUser::$username));
        RegularUser::$password = htmlspecialchars(strip_tags(RegularUser::$password));

        $stmt->bindParam(":username", RegularUser::$username, PDO::PARAM_STR);
        $stmt->bindParam(":pass", RegularUser::$password, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getUserByID($id) {
        $query = 'SELECT * FROM \"RegularUser\" WHERE userid = :id;';

        $stmt = Database::getConnection()->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        RegularUser::$userid = $rows['userid'];
        RegularUser::$username = $rows['username'];
        RegularUser::$creation = $rows['creation'];
        RegularUser::$last_modified = $rows['last_modified'];
    }

    public static function checkLogin($username, $password) {
        $query = 'SELECT userid FROM \"RegularUser\" WHERE username = :username AND'
                . ' pass = :password;';

        $stmt = Database::getConnection()->prepare($query);
        //$username = htmlspecialchars(strip_tags($username));
        //$password = htmlspecialchars(strip_tags($password));
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(count($rows) == 1){ //either 0 or 1
            if(isset($rows['userid'])){
                return $rows['userid'];
            }
        }
        
        return -1; //not a possible id
    }

    public static function setUsername($username) {
        RegularUser::$username = $username;
    }

    public static function setPassword($password) {
        RegularUser::$password = $password; //needs hashing
    }

}