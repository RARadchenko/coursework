<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';

$db = DB::connect($config['db_path']);
$lastId = User::updateRole($db, $data['Логін'], $data['Роль']);

echo json_encode([    
    "Status" => $lastId
]);