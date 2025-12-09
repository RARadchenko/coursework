<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Store.php';

$db = DB::connect($config['db_path']);
$count = Store::delete($db, $data['Магазин']);

echo json_encode([    
    "Status" => $count
]);