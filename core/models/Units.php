<?php

class Units
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM units WHERE unit_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public static function all($db) {
        return $db->query("SELECT * FROM units")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($db, $name) {
        $stmt = $db->prepare("INSERT INTO units(name) VALUES(?)");
        $stmt->execute([$name]);
        return $db->lastInsertId();
    }

    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM units WHERE unit_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

}