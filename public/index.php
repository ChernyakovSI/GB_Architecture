<?php
// Подключаем автозагрузчик
require(__DIR__ . "/../vendor/autoload.php");
require(__DIR__ . "/../simpleengine/core/autoload.php");

// Подключаем конфигурацию
$configuration = [];
require(__DIR__ . "/../configuration/main.config.php");

// Стартуем приложение
try {
    $app = simpleengine\core\Application::instance();
    $app->setConfiguration($configuration);
    $app->run();
}
catch (simpleengine\core\exception\ApplicationException $e){
    echo "Inner app exception ".$e->getCode()." ".$e->getMessage();
}
catch (Exception $e){
    $msg = $e->getMessage()."<br>";
    $msg .= "<pre>" . $e->getTraceAsString() . "</pre>";
    echo $msg;
}