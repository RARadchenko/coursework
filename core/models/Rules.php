<?php

class Rules
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM products_rules WHERE rule_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function all($db) {
        return $db->query("SELECT * FROM products_rules")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($db, $min, $max) {
        $stmt = $db->prepare("INSERT INTO products_rules(min, max) VALUES(?, ?)");
        $stmt->execute([$min, $max]);
        return $db->lastInsertId();
    }

    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM products_rules WHERE rule_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

}
