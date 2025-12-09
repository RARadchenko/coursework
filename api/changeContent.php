<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';
require_once __DIR__ . '/../core/models/Store.php';

$db = DB::connect($config['db_path']);


switch($data['action']){
    case('userList'):
        $users = User::getInfoUsers($db);
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
        $users = User::getInfoUsers($db);
        $logins = array_column($users, 'login');
        $id = array_column($users, 'user_id');
        $content = [
            'Логін' => array_combine($id, $logins),
            'action' => 'userDelete'
        ];
        break;

    case('editUser'):
        $users = User::getInfoUsers($db);
        $logins = array_column($users, 'login');
        $id = array_column($users, 'user_id');
        $content = [
            'Логін' => array_combine($id, $logins),
            'Роль' => [1 => 'Адміністратор', 2 => 'Постачальник', 3 => 'Менеджер'],
            'action' => 'userEdit'
        ];
        break;
    case('storeList'):
        $stores = Store::getInfoStores($db);
        $content = $stores;
        break;
    case('addStore'):
        $users = User::getManagersWithoutStore($db);
        $logins = array_column($users, 'login');
        $id = array_column($users, 'user_id');
        $content = $content = [
            
            'Назва' => 'Назва магазину',
            'Менеджер' => [-1 => 'Відсутній'] + array_combine($id, $logins),
            'action' => 'storeAdd'
        ];
        break;

    case('deleteStore'):
        $store = Store::all($db);
        $name = array_column($store, 'name');
        $id = array_column($store, 'store_id');
        $content = [
            'Магазин' => array_combine($id, $name),
            'action' => 'storeDelete'
        ];
        break;
    case('editStore'):
        $store = Store::all($db);
        $name = array_column($store, 'name');
        $id = array_column($store, 'store_id');

        $users = User::getManagersWithoutStore($db);
        $logins = array_column($users, 'login');
        $user_id = array_column($users, 'user_id');
        $content = [
            'Магазин' => array_combine($id, $name),
            'Менеджер' => [-1 => 'Відсутній'] + array_combine($user_id, $logins),
            'action' => 'storeEdit'
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