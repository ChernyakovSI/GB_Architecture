<?php
/**
 * Created by PhpStorm.
 * User: Alex Pryakhin
 * Date: 18.04.2017
 * Time: 16:30
 */

namespace simpleengine\controllers;


use simpleengine\models\builders\ProductBuilder;
use \simpleengine\core\Application;

class DefaultController extends AbstractController
{
    public function actionIndex()
    {
        $app = Application::instance();
        $c_user = $app->getCurrentUser()->getUser()->info();

        $productBuilder = new ProductBuilder();
        $model = $productBuilder->build();

        echo $this->render("top", [
            "css" => "css/styles/style_login1.css",
            "js" => "js/empty.js",
            "username" => $c_user
        ]);
        echo $this->render("index", [
            "items" => $model->getAllProducts()
        ]);
        echo $this->render("bottom");
    }
}