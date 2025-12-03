<?php
$names = ['Альфа', 'Бета', 'Сігма'];
echo json_encode([
    "name" => $names[array_rand($names)]
]);