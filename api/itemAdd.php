<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Products.php';

$db = DB::connect($config['db_path']);

$image = null;

if (!empty($_FILES['Фото']['tmp_name'])) {
    $imageName = time() . "_" . $_FILES['Фото']['name'];
    $uploadPath = __DIR__ . '/../public/img/png' . $imageName;

    move_uploaded_file($_FILES['Фото']['tmp_name'], $uploadPath);

    $image = $imageName;
}

$lastId = Products::create($db, $_POST['Назва'], $_POST['Ціна'], $image,  $_POST['Одиниці'], $_POST['Категорія'], $_POST['Правило']);

echo json_encode([    
    "Status" => $lastId
]);