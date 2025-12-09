<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';
require_once __DIR__ . '/../core/models/Store.php';
require_once __DIR__ . '/../core/models/Category.php';
require_once __DIR__ . '/../core/models/Rules.php';
require_once __DIR__ . '/../core/models/Units.php';

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
        $content = [
            
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


        case('addCategory'):
        $content = [
            'Категорія' => 'Назва категорії',
            'action' => 'categoryAdd'
        ];
        break;
        case('deleteCategory'):
        $categories = Category::all($db);
        $name = array_column($categories, 'name');
        $id = array_column($categories, 'category_id');
        $content = [
            'Категорія' => array_combine($id, $name),
            'action' => 'categoryDelete'
        ];
        break;

        case('addRule'):
        $content = [
            'Мінімум' => '1',
            'Максимум' => '999',
            'action' => 'ruleAdd'
        ];
        break;
        case('deleteRule'):
        $rule = Rules::all($db);
        $id = array_column($rule, 'rule_id');

        $mins = array_column($rule, 'min');
        $maxs = array_column($rule, 'max');
        $rule_values = array_map(function ($min, $max) {
            return $min . ' - ' . $max;
            }, $mins, $maxs);

        $content = [
            'Правило' => array_combine($id, $rule_values),
            'action' => 'ruleDelete'
        ];
        break;

        case('addItem'):

        $categories = Category::all($db);
        $cat_name = array_column($categories, 'name');
        $cat_id = array_column($categories, 'category_id');

        $rule = Rules::all($db);
        $rule_id = array_column($rule, 'rule_id');

        $units = Units::all($db);
        $unit_id = array_column($units, 'unit_id');
        $unit_name = array_column($units, 'name');

        $mins = array_column($rule, 'min');
        $maxs = array_column($rule, 'max');
        $rule_values = array_map(function ($min, $max) {
            return $min . ' - ' . $max;
            }, $mins, $maxs);

        $content = [
            'Категорія' => array_combine($cat_id, $cat_name),
            'Назва'=> 'назва товару',
            'Ціна'=> '9.99',
            'Одиниці' => array_combine($unit_id, $unit_name),
            'Правило' => array_combine($rule_id, $rule_values),
            'Фото'=> '',
            'action'=> 'upload-image',
        'action' => 'itemAdd'
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