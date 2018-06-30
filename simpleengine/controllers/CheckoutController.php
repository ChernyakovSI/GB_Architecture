<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 06.08.2017
 * Time: 17:48
 */

namespace simpleengine\controllers;

use \simpleengine\core\Application;
use \simpleengine\models\Order;

class CheckoutController extends AbstractController
{
    public function actionIndex()
    {
        $app = Application::instance();
        $user = $app->getCurrentUser()->getUser();
        $c_user = $user->info();
        $user_id = $user->getId();

        $this->renderPage($c_user, $user_id);
    }

    public function renderPage($c_user, $user_id) {
        echo $this->render("top", [
            "css" => "css/styles/style_checkout.css",
            "js" => "js/checkout.js",
            "username" => $c_user
        ]);

        echo $this->render("checkout", [
            "user_id" => $user_id
        ]);
        echo $this->render("bottom");
    }

    public function actionCreate()
    {
        $app = Application::instance();
        $user = $app->getCurrentUser()->getUser();
        $user_id = $user->getId();

        $order = new Order(null, $user_id);
    }
}