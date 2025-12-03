<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Повернення базової сторінки при заході
if (!str_starts_with($uri, '/api')) {

    readfile(__DIR__ . '/../public/index.html');
    exit;
}


//обробка запитів до апі
$path = trim(str_replace('/api', '', $uri), '/');

$script = __DIR__ . '/../api/' . $path . '.php';


header('Content-Type: application/json');

if (!file_exists($script)) {
    http_response_code(404);
    echo json_encode(["error" => "API endpoint not found"]);
    exit;
}

//отримання даних та типу запиту
$method = $_SERVER['REQUEST_METHOD'];
$data = [];

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true) ?? [];
} elseif ($method === 'GET') {
    $data = $_GET;
}

global $data;

//перенаправлення на скрипт апі
require $script;
exit;