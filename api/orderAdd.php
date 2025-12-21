<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';
require_once __DIR__ . '/../core/models/Token.php';
require_once __DIR__ . '/../core/models/Orders.php';
require_once __DIR__ . '/../core/models/OrderItems.php';
require_once __DIR__ . '/../core/models/Store.php';
require_once __DIR__ . '/../core/models/Products.php';

$db = DB::connect($config['db_path']);
$userId = UserToken::getUserIdByToken($db, $data['token']);
$user = User::find($db, $userId);


//якщо нема замовлення воно автоматично створюється
if(!Orders::findCreatingOrder($db, $userId)){
$store = Store::findByManager($db, $user['user_id']);
$stat = Orders::create($db, $userId, $store['store_id'], 1);
};

$orderId = Orders::findCreatingOrder($db, $userId)['order_id'];

//додавання до поточної позиції коли товар вже куплено
if(!OrdersItems::findByOrderItem($db, $orderId, $data['product_id'])){
    OrdersItems::create($db, $orderId, $data['product_id'], $data['amount'], $data['price']);
}

else{
    $order = OrdersItems::findByOrderItem($db, $orderId, $data['product_id']);
    OrdersItems::updateAmount($db, $data['amount'] + $order['amount'], $order['item_id']);
}

echo json_encode([    
    "Status" => $orderId 
]);