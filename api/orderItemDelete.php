<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/OrderItems.php';

$db = DB::connect($config['db_path']);

$stat = OrdersItems::delete($db, $data['orderItem']);

echo json_encode([    
    "Status" => $stat
]);