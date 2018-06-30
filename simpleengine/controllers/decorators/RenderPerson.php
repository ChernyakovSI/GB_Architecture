<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 30.06.2018
 * Time: 17:44
 */

namespace simpleengine\controllers\decorators;


class RenderPerson extends RenderPage
{
    public function actionIndex() {
        exit;
    }

    public function renderPage($personBuilder) {

        $arrProducts = $personBuilder['products'];
        $arrOrders = $personBuilder['orders'];

        return $this->render("person", [
            "products" => $arrProducts,
            "orders" => $arrOrders
        ]);
    }
}