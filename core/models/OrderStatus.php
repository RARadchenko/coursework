<?php

class OrderStatus
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT status FROM orders_status WHERE status_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function all($db) {
        return $db->query("SELECT * FROM orders_status")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allForProfider($db) {
        return $db->query("SELECT * FROM orders_status WHERE status_id != '1'")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($db, $id, $status) {
        $stmt = $db->prepare("INSERT INTO orders_status(status_id, status) VALUES(?, ?)");
        $stmt->execute([$id, $status]);
        return $db->lastInsertId();
    }

    public static function update($db, $id, $status){
        $stmt = $db->prepare("UPDATE orders_status SET status_id = ? WHERE status_id = ?");
        return $stmt->execute([$status, $id]);
    }

    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM orders_status WHERE status_id= ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}