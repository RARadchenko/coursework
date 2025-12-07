<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';

$db = DB::connect($config['db_path']);
$users = User::getInfoUsers($db);

switch($data['action']){
    case('userList'):
        $content = $users;
        break;
    case('addUser'):
        break;
    default:
        break;
}
echo json_encode([
    "contentHeader" => array_search($data['action'], ACTION_MAP),
    "viewMap" => VIEW_MAP[$data['action']],
    "content" => $content
]);