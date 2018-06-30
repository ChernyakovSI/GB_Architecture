<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 06.08.2017
 * Time: 20:08
 */

namespace simpleengine\controllers;

use simpleengine\controllers\decorators\RenderMessage;
use simpleengine\controllers\decorators\RenderPerson;
use \simpleengine\core\Application;
use \simpleengine\models\Cart;
use \simpleengine\models\Order;

class PersonController extends AbstractController implements IRenderable
{
    protected $personBuilder = null;
    protected $current_user = null;

    public function actionIndex()
    {
        $app = Application::instance();
        $user = $app->getCurrentUser()->getUser();
        $user_id = $user->getId();
        $this->current_user = $user->info();

        $cart = new Cart();
        $arrProducts = $cart->getOrderProductsByUser($user_id);
        if (isset($arrProducts) AND count($arrProducts) > 0) {
            $orders = new Order();
            $arrOrders = $orders->getOrdersByUser($user_id);
            if (isset($arrOrders) AND count($arrOrders) > 0) {
                $this->renderPerson($arrProducts, $arrOrders);
            }
            else
            {
                $this->renderMessage("Пока нет заказов");
            }
        }
        else
        {
            $this->renderMessage("Пока нет заказов");
        }

    }

    public function renderPerson($arrProducts, $arrOrders) {

        $page = new RenderPerson();
        $renderAttributes['products'] = $arrProducts;
        $renderAttributes['orders'] = $arrOrders;

        $renderArray['object'] = $page;
        $renderArray['attributes'] = $renderAttributes;
        echo $this->renderPage($renderArray);


    }

    public function renderMessage($message) {

        $page = new RenderMessage();
        $renderArray['object'] = $page;
        $renderArray['attributes'] = $message;
        echo $this->renderPage($renderArray);
    }

    public function renderPage($renderArray) {
        $page = $renderArray['object'];
        $attributes = $renderArray['attributes'];

        echo $this->render("top", [
            "css" => "css/styles/style_person.css",
            "js" => "js/empty.js",
            "username" => $this->current_user
        ]);

        echo $page->renderPage($attributes);

        echo $this->render("bottom");
    }
}