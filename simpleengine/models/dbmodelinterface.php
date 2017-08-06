<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 09.07.2017
 * Time: 19:07
 */

namespace simpleengine\models;


interface DbModelInterface
{
    public function find($id);

    public function save();

    //public function deactivate();
}