<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 31.07.2017
 * Time: 22:57
 */

namespace simpleengine\models;

use simpleengine\core\Application;
use simpleengine\models\DB\ProductsAR;
use simpleengine\models\DB\ProductsGetAllBeginWith;
use simpleengine\models\DB\ProductsGetById;
use simpleengine\models\DB\Query;

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
        $model = new ProductsGetAllBeginWith();
        $arr_products = ProductsAR::execute($model, $start);

        $img_dir = "/img/goods/";
        foreach($arr_products as &$value)
        {
            $value["img"] = $img_dir.$value["img"];
            $value["src"] = "index.php/product/?prod=".$value["id"];
        }
        return $arr_products;
    }

    public function getProduct($id){
        $model = new ProductsGetById();
        $arr_product = ProductsAR::execute($model, $id);

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