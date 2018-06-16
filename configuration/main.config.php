<?php
$configuration = [];

// Настройки окружения
$configuration["ENVIRONMENT"] = "PROD";

// настройки директорий
$configuration["DIR"]["VIEWS"] = $_SERVER["DOCUMENT_ROOT"]."/../simpleengine/views/";

// Настройки БД
$configuration["DB"]["DB_HOST"] = "localhost"; // сервер БД
$configuration["DB"]["DB_USER"] = "root"; // логин
$configuration["DB"]["DB_PASS"] = ""; // пароль
$configuration["DB"]["DB_NAME"] = "Clothing_Store"; // имя БД

// Настройки роутинга
$configuration["ROUTER"] = [
    "customController/<action>" => "controllers/CustomController/<action>",
    "hello/<action>" => "controllers/HelloController/<action>",
    "login/<action>" => "controllers/LoginController/<action>",
    "index/<action>" => "controllers/DefaultController/<action>",
    "product/<action>" => "controllers/ProductController/<action>",
    //"index.php/product/<action>" => "controllers/ProductController/<action>",
    "cart/<action>" => "controllers/CartController/<action>",
    "checkout/<action>" => "controllers/CheckoutController/<action>",
    "person/<action>" => "controllers/PersonController/<action>",
    "<controller>/<action>" => "<controller>/<action>"
];


