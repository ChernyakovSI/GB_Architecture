<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 16.06.2018
 * Time: 19:52
 */

namespace simpleengine\models\DB;


interface Query
{
    public function execute($num);
}