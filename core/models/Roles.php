<?php

class Roles
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM roles WHERE role_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public static function all($db) {
        return $db->query("SELECT * FROM roles")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRoleById($db, $id){
        $stmt = $db->prepare("SELECT name FROM roles WHERE role_id = ?");
        $stmt->execute([$id]);
        $name = $stmt->fetchColumn(0);
        return $name; 
    }

    public static function geIdByrole($db, $role){
        $stmt = $db->prepare("SELECT role_id FROM roles WHERE name = ?");
        $stmt->execute([$id]);
        $id = $stmt->fetchColumn(0);
        return $id; 
    }
}