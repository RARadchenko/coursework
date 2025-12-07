<?php

require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';
require_once __DIR__ . '/../core/models/Token.php';
require_once __DIR__ . '/../core/models/Roles.php';

$db = DB::connect($config['db_path']);

$userId = UserToken::getUserIdByToken($db, $data['token']);
$role_id = User::getRoleById($db, $userId);
if($role_id == 3){
echo json_encode([
    "store" => "Магазин № " . rand(1, 20)
]);
}

else {
    echo json_encode([
    "store" => ""
]);
}