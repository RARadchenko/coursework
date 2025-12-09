<?php

class Category
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM products_category WHERE category_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public static function all($db) {
        return $db->query("SELECT * FROM products_category")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($db, $name) {
        $stmt = $db->prepare("INSERT INTO products_category(name) VALUES(?)");
        $stmt->execute([$name]);
        return $db->lastInsertId();
    }

    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM products_category WHERE category_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

}
