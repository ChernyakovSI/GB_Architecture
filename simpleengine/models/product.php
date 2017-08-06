<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 31.07.2017
 * Time: 22:57
 */

namespace simpleengine\models;

use simpleengine\core\Application;

class Product
{
    private $id;
    private $name;
    private $price;
    private $img = [];
    private $colors = [];
    private $sizes = [];

    /**
     * @return array
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @return array
     */
    public function getSizes(): array
    {
        return $this->sizes;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price." руб.";
    }

    /**
     * @return array
     */
    public function getImg(): array
    {
        return $this->img;
    }

    public function __construct($id = null){
        if ($id > 0) {
            if (!($this->getProduct($id) == true)) {
                echo "Ошибка получения товара!";
            }
        }
    }

    public function getAllProducts($start = 0){
        $app = Application::instance();
        $arr_products = $app->db()->getArrayBySqlQuery("
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
LIMIT ".$start.", 8");

        $img_dir = "img/goods/";
        foreach($arr_products as &$value) {
            $value["img"] = $img_dir.$value["img"];
            $value["src"] = "product/?prod=".$value["id"];
        }
        return $arr_products;
    }

    public function getProduct($id){
        $app = Application::instance();
        $arr_product = $app->db()->getArrayBySqlQuery("
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

        $img_dir = "img/goods/";
        $general = false;
        foreach($arr_product as &$value) {
            if ($general == false) {
                $this->id = $value["id"];
                $this->name = $value["pname"];
                $this->price = $value["price"];
                $general = true;
            }

            if ($value["property"] == 1) {
                $this->img[] = $img_dir.$value["pvalue"];
            }

            if ($value["property"] == 3) {
                $this->colors[] = $value["pvalue"];
            }

            if ($value["property"] == 2) {
                $this->sizes[] = $value["pvalue"];
            }
        }

        return true;
    }
}