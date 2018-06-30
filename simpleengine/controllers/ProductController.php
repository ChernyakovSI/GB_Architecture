<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 05.08.2017
 * Time: 13:39
 */

namespace simpleengine\controllers;

use simpleengine\controllers\decorators\RenderMessage;
use simpleengine\controllers\decorators\RenderProduct;
use \simpleengine\core\Application;
use simpleengine\models\builders\ProductBuilder;

class ProductController extends AbstractController implements IRenderable
{

    protected $productBuilder = null;
    protected $current_user = null;

    public function actionIndex()
    {
        $app = Application::instance();
        $get = $app->router()->getGet();
        $this->current_user = $app->getCurrentUser()->getUser()->info();

        if (isset($get['prod']) AND ($get['prod'] > 0)){
            $this->productBuilder = new ProductBuilder($get['prod']);

            $id = $this->productBuilder->getId();
            if (isset($id)) {
                $this->renderProduct($this->productBuilder);
            }
            else
            {
                $this->renderMessage("Товар не существует");
            }

        }
        else {
            $this->renderMessage("Товар не существует");
        }

    }

    public function actionProduct()
    {
        $app = Application::instance();
        $get = $app->router()->getGet();
        $this->current_user = $app->getCurrentUser()->getUser()->info();

        if (isset($get['prod']) AND ($get['prod'] > 0)){
            $this->productBuilder = new ProductBuilder($get['prod']);

            $id = $this->productBuilder->getId();
            if (isset($id)) {
                $this->renderProduct($this->productBuilder);
            }
            else
            {
                $this->renderMessage("Товар не существует");
            }

        }
        else {
            $this->renderMessage("Товар не существует");
        }

    }

    public function renderProduct($productBuilder) {

        $page = new RenderProduct();
        $renderArray['object'] = $page;
        $renderArray['attributes'] = $productBuilder;
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
            "css" => "css/styles/style_product.css",
            "js" => "js/product_slider.js",
            "username" => $this->current_user
        ]);

        echo $page->renderPage($attributes);

        echo $this->render("bottom");
    }
}
