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
        $content = [
            'Логін' => 'Введення логіну',
            'Пароль' => 'пароль',
            'Роль' => [1 => 'Адміністратор', 2 => 'Постачальник', 3 => 'Менеджер'],
            'action' => 'userAdd'
        ];
        break;

    case('deleteUser'):
        $logins = array_column($users, 'login');
        $id = array_column($users, 'user_id');
        $content = [
            'Логін' => array_combine($id, $logins),
            'action' => 'userDelete'
        ];
        break;

    case('editUser'):
        $logins = array_column($users, 'login');
        $id = array_column($users, 'user_id');
        $content = [
            'Логін' => array_combine($id, $logins),
            'Роль' => [1 => 'Адміністратор', 2 => 'Постачальник', 3 => 'Менеджер'],
            'action' => 'userEdit'
        ];
        break;
    default:
        break;
}
echo json_encode([
    "contentHeader" => array_search($data['action'], ACTION_MAP),
    "viewMap" => VIEW_MAP[$data['action']],
    "content" => $content
]);