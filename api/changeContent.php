<?php
require_once __DIR__ . '/const.php';
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../core/models/User.php';
require_once __DIR__ . '/../core/models/Token.php';
require_once __DIR__ . '/../core/models/Store.php';
require_once __DIR__ . '/../core/models/Category.php';
require_once __DIR__ . '/../core/models/Rules.php';
require_once __DIR__ . '/../core/models/Units.php';
require_once __DIR__ . '/../core/models/Products.php';
require_once __DIR__ . '/../core/models/Orders.php';
require_once __DIR__ . '/../core/models/OrderItems.php';
require_once __DIR__ . '/../core/models/OrderStatus.php';

$db = DB::connect($config['db_path']);


switch($data['action']){
    case('userList'):
        $users = User::getInfoUsers($db);
        $content = $users;
        break;
    case('addUser'):
        $content = [
            'Логін' => 'Введення логіну',
            'Пароль' => 'пароль',
            'Роль' => [1 => 'Адміністратор', 2 => 'Постачальник', 3 => 'Менеджер'],
            'action' => 'userAdd'
        ];
        break;

    case('deleteUser'):
        $users = User::getInfoUsers($db);
        $logins = array_column($users, 'login');
        $id = array_column($users, 'user_id');
        $content = [
            'Логін' => array_combine($id, $logins),
            'action' => 'userDelete'
        ];
        break;

    case('editUser'):
        $users = User::getInfoUsers($db);
        $logins = array_column($users, 'login');
        $id = array_column($users, 'user_id');
        $content = [
            'Логін' => array_combine($id, $logins),
            'Роль' => [1 => 'Адміністратор', 2 => 'Постачальник', 3 => 'Менеджер'],
            'action' => 'userEdit'
        ];
        break;
    case('storeList'):
        $stores = Store::getInfoStores($db);
        $content = $stores;
        break;
    case('addStore'):
        $users = User::getManagersWithoutStore($db);
        $logins = array_column($users, 'login');
        $id = array_column($users, 'user_id');
        $content = [
            
            'Назва' => 'Назва магазину',
            'Менеджер' => [-1 => 'Відсутній'] + array_combine($id, $logins),
            'action' => 'storeAdd'
        ];
        break;

    case('deleteStore'):
        $store = Store::all($db);
        $name = array_column($store, 'name');
        $id = array_column($store, 'store_id');
        $content = [
            'Магазин' => array_combine($id, $name),
            'action' => 'storeDelete'
        ];
        break;
    case('editStore'):
        $store = Store::all($db);
        $name = array_column($store, 'name');
        $id = array_column($store, 'store_id');

        $users = User::getManagersWithoutStore($db);
        $logins = array_column($users, 'login');
        $user_id = array_column($users, 'user_id');
        $content = [
            'Магазин' => array_combine($id, $name),
            'Менеджер' => [-1 => 'Відсутній'] + array_combine($user_id, $logins),
            'action' => 'storeEdit'
        ];
        break;


        case('addCategory'):
        $content = [
            'Категорія' => 'Назва категорії',
            'action' => 'categoryAdd'
        ];
        break;
        case('deleteCategory'):
        $categories = Category::all($db);
        $name = array_column($categories, 'name');
        $id = array_column($categories, 'category_id');
        $content = [
            'Категорія' => array_combine($id, $name),
            'action' => 'categoryDelete'
        ];
        break;

        case('addRule'):
        $content = [
            'Мінімум' => '1',
            'Максимум' => '999',
            'action' => 'ruleAdd'
        ];
        break;
        case('deleteRule'):
        $rule = Rules::all($db);
        $id = array_column($rule, 'rule_id');

        $mins = array_column($rule, 'min');
        $maxs = array_column($rule, 'max');
        $rule_values = array_map(function ($min, $max) {
            return $min . ' - ' . $max;
            }, $mins, $maxs);

        $content = [
            'Правило' => array_combine($id, $rule_values),
            'action' => 'ruleDelete'
        ];
        break;

        case('addItem'):

        $categories = Category::all($db);
        $cat_name = array_column($categories, 'name');
        $cat_id = array_column($categories, 'category_id');

        $rule = Rules::all($db);
        $rule_id = array_column($rule, 'rule_id');

        $units = Units::all($db);
        $unit_id = array_column($units, 'unit_id');
        $unit_name = array_column($units, 'name');

        $mins = array_column($rule, 'min');
        $maxs = array_column($rule, 'max');
        $rule_values = array_map(function ($min, $max) {
            return $min . ' - ' . $max;
            }, $mins, $maxs);

        $content = [
            'Категорія' => array_combine($cat_id, $cat_name),
            'Назва'=> 'назва товару',
            'Ціна'=> '9.99',
            'Одиниці' => array_combine($unit_id, $unit_name),
            'Правило' => array_combine($rule_id, $rule_values),
            'Фото'=> '',
            'action'=> 'upload-image',
        'action' => 'itemAdd'
        ];
        break;

        case('viewItem'):
        $products = Products::allForProvider($db);
        $categories = Category::all($db);
        $category_map = [];
    foreach ($categories as $category) {
        $category_map[$category['category_id']] = $category['name'];
    }

        $image_files = array_column($products, 'image_url');
        $full_image_urls = array_map(function($file_name) {
        return '.\/img\/' . $file_name;
    }, $image_files);

    $preparedCategories = [];
    foreach (array_column($products, 'category_id') as $catId){
        $preparedCategories[] = $category_map[$catId];
    }

    $rule = Rules::all($db);
    $rule_id = array_column($rule, 'rule_id');
    $mins = array_column($rule, 'min');
    $maxs = array_column($rule, 'max');
    $rule_values = array_map(function ($min, $max) {
        return $min . ' - ' . $max;
        }, $mins, $maxs);

    $preparedRules = [];

    $units = Units::all($db);
    $unit_id = array_column($units, 'units_id');
    $unit_name = array_column($units, 'name');
    $unit_values = array_map(function($unit_name){
        return $unit_name;
    }, $unit_name);


    $preparedUnits = [];
    foreach (array_column($products, 'unit_id') as $unitId){
        $preparedUnits[] = $unit_values[$unitId-1];
    }


    foreach (array_column($products, 'rule_id') as $ruleId){
        $preparedRules[] = $rule_values[$ruleId-1];
    }

    $combinedRulesAndUnits = array_map(function ($rule, $unit) {

    return $rule . ' ' . $unit;
    }, $preparedRules, $preparedUnits);

        $content = [
            'image_url' => $full_image_urls,
            'Назва' => array_column($products, 'name'),
            'Ціна' => array_column($products, 'price'),
            'Правило' => $combinedRulesAndUnits,
            'Категорія' => $preparedCategories,
            'Відображення' => array_column($products, 'is_active')
        ];
        break;

    case('deleteItem'):
        $products = Products::allForProvider($db);
        $id = array_column($products, 'product_id');
        $names = array_column($products, 'name');
        $prices = array_column($products, 'price');

        $products_values = array_map(function ($name, $price) {
            return $name . ' - ' . $price . 'грн';
            }, $names, $prices);

        $content = [
            'Продукт' => array_combine($id, $products_values),
            'action' => 'itemDelete'
        ];
        break;
    case('editItem'):
        $products = Products::allForProvider($db);
        $id = array_column($products, 'product_id');
        $names = array_column($products, 'name');
        $prices = array_column($products, 'price');

        $products_values = array_map(function ($name, $price) {
            return $name . ' - ' . $price . 'грн';
            }, $names, $prices);

        $content = [
            'Продукт' => array_combine($id, $products_values),
            'action' => 'getProduct'
        ];
        break;

    case 'getProduct':

    $productId = $data['product_id'];

    $product = Products::find($db, $productId);


    $categories = Category::all($db);
    $cat_options = array_column($categories, 'name', 'category_id');

    $units = Units::all($db);
    $unit_options = array_column($units, 'name', 'units_id');

    $rules = Rules::all($db);
    $rule_options = [];
    foreach ($rules as $rule) {
        $rule_options[$rule['rule_id']] = $rule['min'] . ' - ' . $rule['max'];
    }

    $content = [
        'Назва' => $product['name'],
        'Ціна' => $product['price'],

        'Категорія' => [
            'options' => $cat_options,
            'selected' => $product['category_id'] -1 
        ],

        'Одиниці' => [
            'options' => $unit_options,
            'selected' => $product['unit_id'] - 1
        ],

        'Правило' => [
            'options' => $rule_options,
            'selected' => $product['rule_id'] - 1 
        ],

        'Відображення' => [
            'options' => ['Ні', 'Так'],
            'selected' => $product['is_active']
        ],

        'action' => 'itemEdit'
    ];
    break;

    case('productCatalog'):
        $products = Products::allForManager($db);
        $categories = Category::all($db);
        $category_map = [];
    foreach ($categories as $category) {
        $category_map[$category['category_id']] = $category['name'];
    }

        $image_files = array_column($products, 'image_url');
        $full_image_urls = array_map(function($file_name) {
        return '.\/img\/' . $file_name;
    }, $image_files);

    $preparedCategories = [];
    foreach (array_column($products, 'category_id') as $catId){
        $preparedCategories[] = $category_map[$catId];
    }

    $rule = Rules::all($db);

    $rule_min_map = [];
    $rule_max_map = [];

    foreach ($rule as $r) {
        $rule_min_map[$r['rule_id']] = $r['min'];
        $rule_max_map[$r['rule_id']] = $r['max'];
    }

    $units = Units::all($db);

    $unit_map = [];
    foreach ($units as $u) {
        $unit_map[$u['unit_id']] = $u['name'];
    }

    $mins = [];
    $maxs = [];
    $unit_names = [];

    foreach ($products as $p) {
        $mins[] = $rule_min_map[$p['rule_id']] ?? null;
        $maxs[] = $rule_max_map[$p['rule_id']] ?? null;
        $unit_names[] = $unit_map[$p['unit_id']] ?? null;
    }

        $content = [
            'image_url' => $full_image_urls,
            'Назва' => array_column($products, 'name'),
            'Ціна' => array_column($products, 'price'),
            'Мінімум' => $mins,
            'Максимум' => $maxs,
            'Вимір' => $unit_names,
            'Категорія' => $preparedCategories,
            'Ідентифікатор' => array_column($products, 'product_id'),
        ];
        break;

    case('currentOrder'):
    $userId = UserToken::getUserIdByToken($db, $data['token']);

    $order = Orders::findCreatingOrder($db, $userId);

    if ($order !== false && isset($order['order_id'])) {

        $orderId = $order['order_id'];

        $items = OrdersItems::findByOrder($db, $orderId);
        $products = Products::all($db);
        $units = Units::all($db);

        $prodMap = [];
        foreach ($products as $p) {
            $prodMap[$p['product_id']] = $p;
        }

        $unitMap = [];
        foreach ($units as $u) {
            $unitMap[$u['unit_id']] = $u['name'];
        }

        $content = [];
        foreach ($items as $item) {
            $product = $prodMap[$item['product_id']];
            $unitName = $unitMap[$product['unit_id']];

            $content[] = [
                'Назва' => $product['name'],
                'Кількість' => $item['amount'] . ' ' . $unitName,
                'Ціна' => $item['price'] . ' грн',
                'item_id' => $item['item_id']
            ];
        }

    } else {
        $content = [[
            'Помилка' => "Cпочатку необхідно додати товар до замовлення"
        ]];
    }
    break;

    case('orderHistory'):
    $userId = UserToken::getUserIdByToken($db, $data['token']);
    $orders = Orders::findByUser($db, $userId);
    
    $content = [];
    foreach($orders as $order){
    $priceTotal = 0.0;
    $items = OrdersItems::findByOrder($db, $order['order_id']);
    $products = Products::all($db);
    $units = Units::all($db);
    
    $prodMap = [];
    foreach ($products as $p) $prodMap[$p['product_id']] = $p;
    
    $unitMap = [];
    foreach ($units as $u) $unitMap[$u['unit_id']] = $u['name'];

    
    $content[] = [
            'Час' => $order['created_at'],
    ];
    foreach ($items as $item) {
        $product = $prodMap[$item['product_id']];
        $unitName = $unitMap[$product['unit_id']];
        $priceTotal += $item['amount'] * $item['price'];
        $content[] = [
            'Назва' => $product['name'],
            'Кількість' => $item['amount'] . ' ' . $unitName,
            'Ціна' => $item['price'] . ' грн',

        ];
    };
    $content[] = [
        'Статус' => "Статус: " . OrderStatus::find($db, $order['status_id'])['status'],
        'Сумма' => "Сума: " . $priceTotal . " грн"
    ];
    $content[] = [
        'empty' => "",
    ];
};
        break;

        case('viewOrders'):
    $userId = UserToken::getUserIdByToken($db, $data['token']);
    $orders = Orders::allSorted($db);
    $statuses = OrderStatus::allForProfider($db);
    $units = Units::all($db);
    $products = Products::all($db);
    
    $content = [];
    foreach($orders as $order){
    $priceTotal = 0.0;
    $items = OrdersItems::findByOrder($db, $order['order_id']);
    
    
    $statusOption = "<select class='order-status-select' data-order-id='" . $order['order_id'] ."'>";
    foreach($statuses as $stat){
        if($stat['status_id'] == $order['status_id']){
            $statusOption = $statusOption . '<option selected value="'. $stat['status_id'] .'">'. $stat['status'] .'</option>';
        }
        else{
            $statusOption = $statusOption .'<option value="'. $stat['status_id'] .'">'. $stat['status'] .'</option>';
        }
    }
    $statusOption = $statusOption ."</select>";


    $prodMap = [];
    foreach ($products as $p) $prodMap[$p['product_id']] = $p;
    
    $unitMap = [];
    foreach ($units as $u) $unitMap[$u['unit_id']] = $u['name'];

    
    $content[] = [
            'Час' => $order['created_at'],
    ];
    foreach ($items as $item) {
        $product = $prodMap[$item['product_id']];
        $unitName = $unitMap[$product['unit_id']];
        $priceTotal += $item['amount'] * $item['price'];
        $content[] = [
            'Назва' => $product['name'],
            'Кількість' => $item['amount'] . ' ' . $unitName,
            'Ціна' => $item['price'] . ' грн',

        ];
    };
    $content[] = [
        'Статус' => $statusOption,
        'Сумма' => "Сума: " . $priceTotal . " грн"
    ];
    $content[] = [
        'empty' => "",
    ];
};
        break;

    default:
        break;
}
echo json_encode([
    "contentHeader" => array_search($data['action'], ACTION_MAP),
    "viewMap" => VIEW_MAP[$data['action']],
    "content" => $content
]);
