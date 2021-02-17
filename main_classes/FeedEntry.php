<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FeedEntry
 *
 * @author owner
 */
class FeedEntry {
    private $entryId;
    private $title;
    private $content;
    private $userId;
    private $placeId;
    
    
    
    public static function getAllEntries(){
        $query = 'SELECT "EntryId", "Title", "Content", "UserId", "PlaceId" FROM "FeedEntry";';
        $stmt = Database::getConnection()->prepare($query);
        
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            return;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getAllEntriesFor($id){
        $query = 'SELECT "EntryId", "Title", "Content", "UserId", "PlaceId" FROM "FeedEntry"'
                . ' WHERE "EntryId" = :id;';
        $stmt = Database::getConnection()->prepare($query);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            return;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function createNewEntry($userId, $title, $content, $placeId):bool
    {
        $query = 'INSERT INTO "FeedEntry"'
                . ' ("UserId", "Title", "Content", "PlaceId")' .
                ' VALUES(:uid, :title, :content, :pid);';

        $stmt = Database::getConnection()->prepare($query);
        
        $stmt->bindValue(":uid", $userId, PDO::PARAM_INT);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":content", $content, PDO::PARAM_STR);
        $stmt->bindValue(":pid", $placeId, PDO::PARAM_INT);
        
        try{
            $successful = $stmt->execute();
        } catch (Exception $ex) {
            print_r($stmt->errorInfo());
            return FALSE;
        }

        return $successful;
    }
    
    public static function deleteEntryById($id):bool
    {
        $query = 'DELETE FROM "FeedEntry"'
                . ' WHERE "EntryId" = :id;';

        $stmt = Database::getConnection()->prepare($query);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        try{
            $successful = $stmt->execute();
        } catch (Exception $ex) {
            print_r($stmt->errorInfo());
            return FALSE;
        }

        return $successful;
    }
    
    
    
    
    
    function getEntryId() {
        return $this->entryId;
    }

    function getTitle() {
        return $this->title;
    }

    function getContent() {
        return $this->content;
    }

    function getUserId() {
        return $this->userId;
    }

    function getPlaceId() {
        return $this->placeId;
    }


}
