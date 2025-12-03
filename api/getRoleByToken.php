<?php
$roles = ['Адміністратор', 'Постачальник', 'Менеджер'];
echo json_encode([
    "role" => $roles[array_rand($roles)]
]);