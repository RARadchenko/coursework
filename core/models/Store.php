<?php

class Store
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM store WHERE store_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public static function all($db) {
        return $db->query("SELECT * FROM store")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($db, $name, $manager_id) {
        $stmt = $db->prepare("INSERT INTO store(name, manager_id) VALUES(?, ?)");
        $stmt->execute([$name, $manager_id]);
        return $db->lastInsertId();
    }

    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM store WHERE store_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    public static function updateManager($db, $id, $manager_id) {
        $stmt = $db->prepare("UPDATE store SET manager_id = ? WHERE store_id = ?");
        $stmt->execute([$manager_id, $id]);
        return $db->lastInsertId();
    }

    public static function getInfoStores($db){
            return $db->query("SELECT * FROM store_full_info")->fetchAll(PDO::FETCH_ASSOC);
    }
    
}