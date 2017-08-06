<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 05.08.2017
 * Time: 13:39
 */

namespace simpleengine\controllers;

use \simpleengine\core\Application;
use \simpleengine\models\Product;

class ProductController extends AbstractController
{

    public function actionIndex()
    {
        $app = Application::instance();
        $get = $app->router()->getGet();
        $c_user = $app->getCurrentUser()->getUser()->info();

        if (isset($get['prod']) AND ($get['prod'] > 0)){
            $product = new Product($get['prod']);

            $id = $product->getId();
            if (isset($id)) {
                $this->renderPage($product, $c_user);
            }
            else
            {
                $this->renderMessage("Товар не существует", $c_user);
            }

        }
        else {
            $this->renderMessage("Товар не существует", $c_user);
        }

    }

    public function renderPage($product, $c_user) {
        echo $this->render("top", [
            "css" => "css/styles/style_product.css",
            "js" => "js/product_slider.js",
            "username" => $c_user
        ]);

        echo $this->render("product", [
            "img" => $product->getImg(),
            "id" => $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "colors" => $product->getColors(),
            "sizes" => $product->getSizes()
        ]);
        echo $this->render("bottom");
    }

    public function renderMessage($message, $c_user) {
        echo $this->render("top", [
            "css" => "css/styles/style_product.css",
            "js" => "js/product_slider.js",
            "username" => $c_user
        ]);
        echo $this->render("message", [
            "msg" => $message
        ]);
        echo $this->render("bottom");
    }
}
