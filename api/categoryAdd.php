<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Category.php';

$db = DB::connect($config['db_path']);
$lastId = Category::create($db, $data['Категорія']);

echo json_encode([    
    "Status" => $lastId
]);