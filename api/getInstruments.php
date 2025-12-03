<?php

const ACTION_MAP = [
    'Додати користувача' => 'addUser',
    'Видалити користувача' => 'deleteUser',
    'Додати магазин' => 'addStore',
    'Видалити магазин' => 'deleteStore',
    
    'Переглянути замовлення' => 'viewOrders',
    'Сума замовлень' => 'sumOrders',
    'Додати категорію' => 'addCategory',
    'Видалити категорію' => 'deleteCategory',
    'Редагувати категорію' => 'editCategory',
    'Редагувати позицію' => 'editItem',
    'Додати позицію' => 'addItem',
    'Видалити позицію' => 'deleteItem',
    
    'Історія замовлень' => 'orderHistory',
    'Каталог товарів' => 'productCatalog',
    'Поточне замовлення' => 'currentOrder',
];

$tools = [['Додати користувача', 'Видалити користувача', 'Додати магазин', 'Видалити магазин'], ['Переглянути замовлення', 'Сума замовлень', 'Додати категорію', 'Видалити категорію', 'Редагувати позицію', 'Додати позицію', 'Видалити позицію', 'Редагувати позицію'], ['Історія замовлень', 'Каталог товарів', 'Поточне замовлення']];
$selected_tools = $tools[array_rand($tools)];
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