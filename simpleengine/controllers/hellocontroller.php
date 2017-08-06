<?php
/**
 * Created by PhpStorm.
 * User: Alex Pryakhin
 * Date: 18.04.2017
 * Time: 17:37
 */

namespace simpleengine\controllers;


use simpleengine\models\User;

class HelloController extends AbstractController
{

    public function actionIndex()
    {

        $user = new User(2);

        echo $user->getEmail();

        //echo __CLASS__;
    }
}