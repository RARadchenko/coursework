<?php
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';
require_once __DIR__ . '/../core/models/Token.php';

$db = DB::connect($config['db_path']);

$userId = UserToken::getUserIdByToken($db, $data['token']);
$users = User::getLoginById($db, $userId);
echo json_encode([
    "name" => $users
]);