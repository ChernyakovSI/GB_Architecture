<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 16.06.2018
 * Time: 19:54
 */

namespace simpleengine\models\DB;

use simpleengine\core\Application;

class ProductsGetAllBeginWith implements Query
{
    public function execute($num)
    {
        $app = Application::instance();
        return $app->db()->getArrayBySqlQuery("
    SELECT 
      p.id as id, 
      p.product_name as pname, 
      p.product_price as price, 
      MIN(v.property_value) as img 
    FROM products p 
    LEFT JOIN product_properties_values v 
    ON p.id = v.id_product and v.id_property = 1
    GROUP BY p.product_name, p.product_price, p.id
    ORDER BY p.id
    LIMIT ".$num.", 8");
    }
}