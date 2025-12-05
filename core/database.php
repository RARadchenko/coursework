<?php

class DB {
    private static $pdo;

    public static function connect($path) {
        $isNew = !file_exists($path);

        if (!self::$pdo) {
            self::$pdo = new PDO("sqlite:" . $path);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        if ($isNew) {
            self::initialize();
        }

        return self::$pdo;
    }

    private static function initialize() {
        $sql = "
CREATE TABLE roles(
role_id INTEGER PRIMARY KEY AUTOINCREMENT,
name text NOT NULL
);

CREATE TABLE users(
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    login text NOT NULL UNIQUE,
    password_hash text NOT NULL,
    role_id INTEGER NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

CREATE TABLE stores(
    store_id INTEGER PRIMARY KEY AUTOINCREMENT,
    address TEXT NOT NULL,
    manager_id INTEGER NOT NULL,
    FOREIGN KEY (manager_id) references users(user_id)
);

CREATE TABLE units(
    unit_id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);

CREATE TABLE products_category(
    category_id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);

CREATE TABLE products_rules(
    rule_id INTEGER PRIMARY KEY AUTOINCREMENT ,
    min INTEGER NOT NULL,
    max INTEGER NOT NULL
);

CREATE TABLE products(
    product_id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price REAL NOT NULL,
    image_url TEXT DEFAULT NULL,

    unit_id INTEGER NOT NULL,
    category_id INTEGER NOT NULL,
    rule_id INTEGER NOT NULL,


    is_active INTEGER NOT NULL DEFAULT 1,

    FOREIGN KEY (unit_id) references units(unit_id),
    FOREIGN KEY (category_id) references products_category(category_id),
    FOREIGN KEY (rule_id) references products_rules(rule_id)
);

CREATE TABLE orders_status(
    status_id INTEGER PRIMARY KEY AUTOINCREMENT ,
    status TEXT NOT NULL
);

CREATE TABLE orders (
    order_id INTEGER PRIMARY KEY AUTOINCREMENT,

    user_id INTEGER NOT NULL,
    store_id INTEGER NOT NULL,
    status_id INTEGER NOT NULL default 0,

    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (store_id) REFERENCES stores(store_id),
    FOREIGN KEY (status_id) REFERENCES orders_status(status_id)
);

CREATE TABLE order_items (
    item_id INTEGER PRIMARY KEY AUTOINCREMENT ,

    order_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,

    amount REAL NOT NULL,
    price REAL NOT NULL,

    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE user_tokens (
    token_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER UNIQUE NOT NULL,
    token TEXT UNIQUE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TRIGGER update_tokens_timestamp
AFTER UPDATE ON user_tokens
FOR EACH ROW
BEGIN
    UPDATE user_tokens SET updated_at = CURRENT_TIMESTAMP WHERE token_id = NEW.token_id;
END;

        ";

        self::$pdo->exec($sql);
    }
}
