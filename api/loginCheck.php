<?php
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';
require_once __DIR__ . '/../core/models/Token.php';

$db = DB::connect($config['db_path']);

$user_id = UserToken::getUserIdByToken($db, $data['token']);

if($user_id != 0){
    echo json_encode([
        "status" => '1'
    ]);
}
else{
    echo json_encode([
        "status" => '0'
    ]);
}