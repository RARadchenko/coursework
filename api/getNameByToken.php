<?php
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';

$db = DB::connect($config['db_path']);

$users = User::getLoginById($db, 1);
echo json_encode([
    "name" => $users
]);