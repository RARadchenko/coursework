<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Products.php';

$db = DB::connect($config['db_path']);
$editedProd = Products::update($db, $data['product_id'], $data['Назва'], $data['Ціна'], $data['Одиниці'] +1, $data['Категорія'], $data['Правило'], $data['Відображення']);

echo json_encode([    
    "Status" => $editedProd
]);