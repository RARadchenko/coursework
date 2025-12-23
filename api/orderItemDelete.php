<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Orders.php';
require_once __DIR__ . '/../core/models/OrderItems.php';

$db = DB::connect($config['db_path']);


$orderId = OrdersItems::find($db, $data['orderItem'])['order_id'];
$stat = OrdersItems::delete($db, $data['orderItem']);

if(!OrdersItems::findByOrder($db, $orderId)){
    Orders::delete($db, $orderId);
}

echo json_encode([    
    "Status" => $stat
]);