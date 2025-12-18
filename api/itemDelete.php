<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/Products.php';

$db = DB::connect($config['db_path']);
$photoName = Products::find($db, $data['Продукт'])['image_url'];
$count = Products::delete($db, $data['Продукт']);

#видалення зображення видаляємого продукту
unlink('.\/img\/' . $photoName);

echo json_encode([    
    "Status" => $count
]);