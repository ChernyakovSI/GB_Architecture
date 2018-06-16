<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 16.06.2018
 * Time: 20:03
 */

namespace simpleengine\models\DB;

use simpleengine\core\Application;

class ProductsGetById implements Query
{
    public function execute($id)
    {
        $app = Application::instance();
        return $app->db()->getArrayBySqlQuery("
    SELECT 
      p.id as id, 
      p.product_name as pname, 
      p.product_price as price, 
      v.id_property as property, 
      v.property_value as pvalue 
    FROM products p 
    LEFT JOIN product_properties_values v 
    ON p.id = v.id_product
    WHERE p.id = ".$id."
    ORDER BY v.id_property, v.property_value");
        }
}