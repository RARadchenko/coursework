<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Store.php';

$db = DB::connect($config['db_path']);
$lastId = Store::create($db, $data['Назва'], $data['Менеджер'] == '-1' ? 'null' :  $data['Менеджер']);

echo json_encode([    
    "Status" => $lastId
]);