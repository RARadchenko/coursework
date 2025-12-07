<?php

class User
{
    public static function find($db, $id) {
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public static function all($db) {
        return $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($db, $login, $password, $role) {
        $stmt = $db->prepare("INSERT INTO users(login, password_hash, role_id) VALUES(?, ?, ?)");
        $stmt->execute([$login, $password, $role]);
        return $db->lastInsertId();
    }

    public static function delete($db, $id) {
        $stmt = $db->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

        public static function updatePassword($db, $id, $password) {
        $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE user_id = ? VALUES(?, ?)");
        $stmt->execute([$login, $id, $password]);
        return $db->lastInsertId();
    }

        public static function getPasswordHashByLogin($db, $login) {
        $stmt = $db->prepare("SELECT password_hash FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $passwordHash = $stmt->fetchColumn(0);
        return $passwordHash; 
}

        public static function getIdByLogin($db, $login) {
        $stmt = $db->prepare("SELECT user_id FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $id = $stmt->fetchColumn(0);
        return $id; 
}

        public static function getRoleByLogin($db, $login) {
        $stmt = $db->prepare("SELECT role_id FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $roleId = $stmt->fetchColumn(0);
        return $roleId; 
}
        public static function getLoginById($db, $id) {
        $stmt = $db->prepare("SELECT login FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        $login = $stmt->fetchColumn(0);
        return $login; 
        }

        public static function getRoleById($db, $id) {
        $stmt = $db->prepare("SELECT role_id FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        $role_id = $stmt->fetchColumn(0);
        return $role_id; 
        }

        public static function getInfoUsers($db){
            return $db->query("SELECT * FROM user_full_info")->fetchAll(PDO::FETCH_ASSOC);
    }
        

}