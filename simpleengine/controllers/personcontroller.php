<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 06.08.2017
 * Time: 20:08
 */

namespace simpleengine\controllers;

use \simpleengine\core\Application;
use \simpleengine\models\Cart;
use \simpleengine\models\Order;

class PersonController extends AbstractController
{
    public function actionIndex()
    {
        $app = Application::instance();
        $user = $app->getCurrentUser()->getUser();
        $user_id = $user->getId();
        $c_user = $user->info();

        $cart = new Cart();
        $arrProducts = $cart->getOrderProductsByUser($user_id);
        if (isset($arrProducts) AND count($arrProducts) > 0) {
            $orders = new Order();
            $arrOrders = $orders->getOrdersByUser($user_id);
            if (isset($arrOrders) AND count($arrOrders) > 0) {
                $this->renderPage($arrProducts, $arrOrders, $c_user);
            }
            else
            {
                $this->renderMessage("Пока нет заказов", $c_user);
            }
        }
        else
        {
            $this->renderMessage("Пока нет заказов", $c_user);
        }

    }

    public function renderPage($arrProducts, $arrOrders, $c_user) {
        echo $this->render("top", [
            "css" => "css/styles/style_person.css",
            "js" => "js/empty.js",
            "username" => $c_user
        ]);

        echo $this->render("person", [
            "products" => $arrProducts,
            "orders" => $arrOrders
        ]);
        echo $this->render("bottom");
    }

    public function renderMessage($message, $c_user) {
        echo $this->render("top", [
            "css" => "css/styles/style_person.css",
            "js" => "js/empty.js",
            "username" => $c_user
        ]);
        echo $this->render("message", [
            "msg" => $message
        ]);
        echo $this->render("bottom");
    }
}