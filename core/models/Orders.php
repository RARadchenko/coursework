<?php

class Orders
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findCreatingOrder($db, $id) {
        $stmt = $db->prepare("SELECT * FROM orders WHERE user_id = ? AND status_id = 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public static function all($db) {
        return $db->query("SELECT * FROM orders")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($db, $user_id, $store_id, $status_id) {
        $stmt = $db->prepare("INSERT INTO orders(user_id, store_id, status_id) VALUES(?, ?, ?)");
        $stmt->execute([$user_id, $store_id, $status_id]);
        return $db->lastInsertId();
    }

    public static function update($db,$user_id, $store_id, $status_id){
        $stmt = $db->prepare("UPDATE orders SET user_id = ?, store_id = ?, status_id = ?, WHERE order_id = ?");
        return $stmt->execute([$user_id, $store_id, $status_id]);
    }

    public static function updateStatus($db,$user_id, $store_id, $status_id){
        $stmt = $db->prepare("UPDATE orders SET status_id = ?, WHERE order_id = ?");
        return $stmt->execute([$status_id]);
    }


    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM orders WHERE order_id= ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}