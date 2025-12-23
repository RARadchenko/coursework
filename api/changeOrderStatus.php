<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Token.php';
require_once __DIR__ . '/../core/models/Orders.php';


$db = DB::connect($config['db_path']);


$stat = Orders::updateStatus($db, $data['status'], $data['order']);


echo json_encode([    
    "Status" => $stat 
]);