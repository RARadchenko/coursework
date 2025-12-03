<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Повернення базової сторінки при заході
if (!str_starts_with($uri, '/api')) {

    readfile(__DIR__ . '/../public/index.html');
    exit;
}