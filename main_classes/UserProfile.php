<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class UserProfile{
    const TABLE_NAME = "UserProfile";
    
    private static $profileId;
    private static $firstname;
    private static $lastname;
    private static $description;
    private static $gender;
    
    static function getProfileId() {
        return self::$profileId;
    }

    static function getFirstname() {
        return self::$firstname;
    }

    static function getLastname() {
        return self::$lastname;
    }

    static function getDescription() {
        return self::$description;
    }

    static function getGender() {
        return self::$gender;
    }

    static function setProfileId($profileId): void {
        self::$profileId = $profileId;
    }

    static function setFirstname($firstname): void {
        self::$firstname = $firstname;
    }

    static function setLastname($lastname): void {
        self::$lastname = $lastname;
    }

    static function setDescription($description): void {
        self::$description = $description;
    }

    static function setGender($gender): void {
        self::$gender = $gender;
    }

    public static function fetchProfileDataByID() {
        $query = 'SELECT "Firstname", "Lastname", "Description", "Gender"
                FROM "UserProfile" WHERE "ProfileId" = :id;';

        $stmt = Database::getConnection()->prepare($query);

        $stmt->bindParam(":id", self::$profileId);

        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        self::$firstname = $rows['Firstname'];
        self::$lastname = $rows['Lastname'];
        self::$description = $rows['Description'];
        self::$gender = $rows['Gender'];
    }

    public static function getAttributes():Array{
        return array(
            "Firstname" => self::$firstname,
            "Lastname" => self::$lastname,
            "Description" => self::$description,
            "Gender" => self::$gender
        );
    }
    
}