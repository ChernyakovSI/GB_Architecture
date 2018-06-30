<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 30.06.2018
 * Time: 16:13
 */

namespace simpleengine\controllers;


interface IRenderable
{
    public function renderPage($objectBuilder);
}