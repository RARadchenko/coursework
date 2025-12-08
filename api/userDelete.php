<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';

$db = DB::connect($config['db_path']);
$count = User::delete($db, $data['Логін']);

echo json_encode([    
    "Status" => $count
]);