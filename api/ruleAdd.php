<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Rules.php';

$db = DB::connect($config['db_path']);
$lastId = Rules::create($db, $data['Мінімум'], $data['Максимум']);

echo json_encode([    
    "Status" => $lastId
]);