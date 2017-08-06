<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 16.07.2017
 * Time: 19:17
 */

namespace simpleengine\controllers;

use \simpleengine\core\Application;

class LoginController extends AbstractController
{
    public function actionIndex()
    {
        $app = Application::instance();

        echo $this->render("top", [
            "css" => "css/styles/style_login.css",
            "js" => "js/empty.js",
            "username" => "Гость"
        ]);
        echo $this->render("login");
        echo $this->render("bottom");


        //echo __CLASS__;
    }
}