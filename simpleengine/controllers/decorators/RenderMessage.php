<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 30.06.2018
 * Time: 17:06
 */

namespace simpleengine\controllers\decorators;


class RenderMessage extends RenderPage
{
    public function actionIndex() {
        exit;
    }

    public function renderPage($message) {
        return $this->render("message", [
            "msg" => $message
        ]);
    }
}