<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 05.08.2017
 * Time: 21:56
 */

namespace simpleengine\controllers;

use \simpleengine\core\Application;
use \simpleengine\models\Cart;

class CartController extends AbstractController
{
    public function actionIndex()
    {
        $app = Application::instance();
        $user = $app->getCurrentUser()->getUser();
        $c_user = $user->info();
        $user_id = $user->getId();

        $cart = new Cart();

        $arrProducts = $cart->getCartByUser($user_id);
        if (isset($arrProducts) AND count($arrProducts) > 0) {
            $this->renderPage($arrProducts, $c_user, $cart);
        }
        else
        {
            $this->renderMessage("Корзина пуста", $c_user);
        }
    }

    public function renderPage($arrProducts, $c_user, $cart) {
        echo $this->render("top", [
            "css" => "css/styles/style_cart.css",
            "js" => "js/cart.js",
            "username" => $c_user
        ]);

        echo $this->render("cart", [
            "products" => $arrProducts,
            "sum" => $cart->getSum()
        ]);
        echo $this->render("bottom");
    }

    public function renderMessage($message, $c_user) {
        echo $this->render("top", [
            "css" => "css/styles/style_cart.css",
            "js" => "js/empty.js",
            "username" => $c_user
        ]);
        echo $this->render("message", [
            "msg" => $message
        ]);
        echo $this->render("bottom");
    }

    public function actionAdd()
    {
        if (isset($_POST['product'])) {

            if(isset($_POST['price'])){
                $price = $_POST['price'];
            }
            else{
                $price = 0;
            }

            if(isset($_POST['quantity'])){
                $quantity = $_POST['quantity'];
            }
            else{
                $quantity = 1;
            }

            if(isset($_POST['color'])){
                if($_POST['color'] == "Цвет..."){
                    $color = NULL;
                }
                else
                {
                    $color = $_POST['color'];
                }
            }
            else{
                $color = NULL;
            }

            if(isset($_POST['size'])){
                if($_POST['size'] == "Размер..."){
                    $size = NULL;
                }
                else
                {
                    $size = $_POST['size'];
                }
            }
            else{
                $size = NULL;
            }

            $app = Application::instance();
            $user_id = $app->getCurrentUser()->getUser()->getId();

            $date = date("Y-m-d H:i:s");

            $cart = new Cart();
            if ($cart->add($user_id, $_POST['product'], $price, $quantity, $date, $color, $size)) {
                return true;
            }
            else{
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function actionEdit()
    {
        if (isset($_POST['cart_id']) AND isset($_POST['quantity'])) {
            $cart = new Cart();

            $cart_id = $_POST['cart_id'];
            $quantity = $_POST['quantity'];

            $result = $cart->edit($cart_id, $quantity);

            return $result;
        }
        else
        {
            return false;
        }

    }

    public function actionDelete()
    {
        if (isset($_POST['cart_id'])) {
            $cart = new Cart();

            $cart_id = $_POST['cart_id'];

            $result = $cart->delete($cart_id);

            return $result;
        }
        else
        {
            return false;
        }
    }

    public function actionClear()
    {
        $app = Application::instance();
        $user = $app->getCurrentUser()->getUser();
        $user_id = $user->getId();
        if (isset($user_id)) {
            $cart = new Cart();

            $result = $cart->clear($user_id);

            return $result;
        }
        else
        {
            return false;
        }
    }
}