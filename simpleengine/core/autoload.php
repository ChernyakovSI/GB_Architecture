<?php
spl_autoload_register("simpleEngineAutoloader");

function simpleEngineAutoloader($class){
    // разбиваем класс на части
    $class_data = explode("\\", $class);

    //$path = __DIR__."/..";
    $path = $_SERVER["DOCUMENT_ROOT"]."/..";

    foreach($class_data as $item){
        $path .= "/".strtolower($item);
    }

    $path .= ".php";
	
    if(file_exists($path)){
        require_once($path);
    }
    else{
        throw new Exception("Class " . $class . " wasn't found in ".$path, 0404);
    }
}