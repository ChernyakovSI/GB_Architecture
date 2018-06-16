<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 16.06.2018
 * Time: 19:58
 */

namespace simpleengine\models\DB;


class ProductsAR
{
    public static function execute(Query $query, $num) {
        return $query->execute($num);
    }
}