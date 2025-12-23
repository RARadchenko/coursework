<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Token.php';
require_once __DIR__ . '/../core/models/Orders.php';


$db = DB::connect($config['db_path']);
$userId = UserToken::getUserIdByToken($db, $data['token']);


$stat = Orders::updateStatus($db, 2, Orders::findCreatingOrder($db, $userId)['order_id']);


echo json_encode([    
    "Status" => $stat 
]);