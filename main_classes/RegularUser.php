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

    public function createNewUser():bool
    {
        $query = 'INSERT INTO "RegularUser" ("Username", "Password")' .
                ' VALUES(:username, :password);';

        $stmt = Database::getConnection()->prepare($query);
        
        //RegularUser::$username = htmlspecialchars(strip_tags(RegularUser::$username));
        //RegularUser::$password = htmlspecialchars(strip_tags(RegularUser::$password));

        $stmt->bindParam(":username", RegularUser::$username, PDO::PARAM_STR, 255);
        //$stmt->bindValue(":username", '%{RegularUser::$username}%');
        
//$stmt->bindValue(":username", RegularUser::$username);

        $stmt->bindParam(":password", RegularUser::$password, PDO::PARAM_STR, 255);
        //$stmt->bindValue(":password", '%{RegularUser::$password}%');

//$stmt->bindValue(":password", RegularUser::$password);
        
        try{
            $success = $stmt->execute();
        } catch (Exception $ex) {
            HTTP_Response::sendPlainMessage(HTTP_Status_Codes::BAD_REQUEST, "Username probably exists already.");
            die;
        }
            
        
        return $success;
    }
    
    public function checkIfUsernameExists($username):bool
    {
        $query = 'SELECT "UserId" FROM "RegularUser" '
                . ' WHERE "Username" = :username;';

        $stmt = Database::getConnection()->prepare($query);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        
        try{
            $stmt->execute();
            $rowsAffected = $stmt->rowCount(); //may only result in 0 or 1
            if($rowsAffected){ //0 -> false ; 1 -> true
                return false;
            }
            return true;
        } catch (Exception $ex) {
            HTTP_Response::sendPlainMessage(HTTP_Status_Codes::INTERNAL_SERVER_ERROR,
                    "Connectivity problems with our database.");
            die;
        }
    }

    /**
     * @deprecated
     * @param type $id
     */
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
        $query = 'SELECT "UserId" FROM "RegularUser" WHERE "Username" = :username AND'
                . ' "Password" = :password;';

        $stmt = Database::getConnection()->prepare($query);
        //$username = htmlspecialchars(strip_tags($username));
        //$password = htmlspecialchars(strip_tags($password));
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rows){ //on success
            if(isset($rows['UserId'])){
                return $rows['UserId'];
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