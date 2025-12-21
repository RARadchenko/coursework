<?php

class Products
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public static function all($db) {
        return $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allForProvider($db) {
        return $db->query("SELECT * FROM products ORDER BY category_id")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allForManager($db) {
        return $db->query("SELECT * FROM products WHERE is_active = 1 ORDER BY category_id")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($db, $name, $price, $image_url, $unit_id, $category_id, $rule_id) {
        $stmt = $db->prepare("INSERT INTO products(name, price, image_url, unit_id, category_id, rule_id) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $price, $image_url, $unit_id, $category_id, $rule_id]);
        return $db->lastInsertId();
    }

    public static function update($db, $id, $name, $price, $unit_id, $category_id, $rule_id, $is_active){
    $stmt = $db->prepare("UPDATE products SET name = ?, price = ?, unit_id = ?, category_id = ?, rule_id = ?, is_active = ?WHERE product_id = ?");
    return $stmt->execute([$name, $price, $unit_id, $category_id, $rule_id, $is_active, $id]);
    }


    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}