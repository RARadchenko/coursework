<?php

class UserToken
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM user_tokens WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function all($db) {
        return $db->query("SELECT * FROM user_tokens")->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getUserIdByToken($db, $token) {
        $stmt = $db->prepare("SELECT user_id FROM user_tokens WHERE token = ?");
        $stmt->execute([$token]);
        return $stmt->fetchColumn(); 
    }

    public static function getTokenByUserId($db, $userId) {
        $stmt = $db->prepare("SELECT token FROM user_tokens WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn(); 
    }
    
    public static function create($db, $userId, $token) {
        $stmt = $db->prepare("INSERT INTO user_tokens(user_id, token) VALUES(?, ?)");
        $stmt->execute([$userId, $token]);
        return $db->lastInsertId();
    }

    public static function updateToken($db, $userId, $newToken) {
        $stmt = $db->prepare("UPDATE user_tokens SET token = ? WHERE user_id = ?");
        $stmt->execute([$newToken, $userId]);
        return $stmt->rowCount(); 
    }


    public static function setTokenForUser($db, $userId, $token) {
        $sql = "
            INSERT INTO user_tokens (user_id, token) 
            VALUES (?, ?)
            ON CONFLICT(user_id) DO UPDATE SET 
                token = excluded.token;
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId, $token]);
        return true; 
    }
}
    