<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 30.06.2018
 * Time: 16:27
 */

namespace simpleengine\controllers\decorators;


class RenderProduct extends RenderPage
{
    public function actionIndex() {
        exit;
    }

    public function renderPage($productBuilder) {
        return $this->render("product", [
            "img" => $productBuilder->getImg(),
            "id" => $productBuilder->getId(),
            "name" => $productBuilder->getName(),
            "price" => $productBuilder->getPrice(),
            "colors" => $productBuilder->getColors(),
            "sizes" => $productBuilder->getSizes()
        ]);
    }
}