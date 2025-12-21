<?php

class OrdersItems
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM order_items WHERE item_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByOrderItem($db, $order_id, $product_id) {
        $stmt = $db->prepare("SELECT * FROM order_items WHERE order_id = ? AND product_id = ?");
        $stmt->execute([$order_id, $product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByOrder($db, $order_id) {
        $stmt = $db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public static function all($db) {
        return $db->query("SELECT * FROM order_items")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($db, $order_id, $product_id, $amount, $price) {
        $stmt = $db->prepare("INSERT INTO order_items(order_id, product_id, amount, price) VALUES(?, ?, ?, ?)");
        $stmt->execute([$order_id, $product_id, $amount, $price]);
        return $db->lastInsertId();
    }

    public static function update($db, $order_id, $product_id, $amount, $price, $item_id){
        $stmt = $db->prepare("UPDATE order_items SET order_id = ?, product_id = ?, amount = ?, price = ?, WHERE item_id = ?");
        return $stmt->execute([$order_id, $product_id, $amount, $price, $item_id]);
    }

    public static function updateAmount($db, $amount, $item_id){
        $stmt = $db->prepare("UPDATE order_items SET amount = ? WHERE item_id = ?");
        return $stmt->execute([$amount, $item_id]);
    }

    public static function updatePrice($db, $price, $item_id){
        $stmt = $db->prepare("UPDATE order_items SET price = ? WHERE item_id = ?");
        return $stmt->execute([$price, $item_id]);
    }

    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM order_items WHERE item_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}