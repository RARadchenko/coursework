<?php
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';
require_once __DIR__ . '/../core/models/Token.php';

$db = DB::connect($config['db_path']);

$password = User::getPasswordHashByLogin($db, $data['login']);
if ($password == $data['password_hash']){
    $id = User::getIdByLogin($db, $data['login']);
    $user_token = rand(10000000000000, 99999999999999);

    UserToken::setTokenForUser($db, $id, $user_token);

    echo json_encode([
        "token" => $user_token
    ]);
}
else{
    http_response_code(401);
    echo json_encode(["error" => "Невірний логін або пароль."]);
}

