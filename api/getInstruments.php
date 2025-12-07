<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';
require_once __DIR__ . '/../core/models/Token.php';
require_once __DIR__ . '/../core/models/Roles.php';

$db = DB::connect($config['db_path']);

$userId = UserToken::getUserIdByToken($db, $data['token']);
$role_id = User::getRoleById($db, $userId);



$tools = [['Список користувачів', 'Додати користувача', 'Видалити користувача', 'Редагувати користувача', 'Додати магазин', 'Видалити магазин', 'Редагувати магазин'], ['Переглянути замовлення', 'Сума замовлень', 'Додати категорію', 'Видалити категорію', 'Редагувати позицію', 'Додати позицію', 'Видалити позицію', 'Редагувати позицію'], ['Історія замовлень', 'Каталог товарів', 'Поточне замовлення']];
$selected_tools = $tools[$role_id - 1];
$actions = [];

foreach($selected_tools as $tool){
    $action_id = ACTION_MAP[$tool] ?? null;
    if ($action_id !== null) {
        $actions[] = $action_id;
    }
}

echo json_encode([
    "tools" => $selected_tools,
    "action_view" => $actions
]);