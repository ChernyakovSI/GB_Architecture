<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 31.07.2017
 * Time: 22:57
 */

namespace simpleengine\models;

use simpleengine\models\builders\ProductBuilder;
use simpleengine\models\DB\ProductsAR;
use simpleengine\models\DB\ProductsGetAllBeginWith;

class Product
{
    private $id;
    private $name;
    private $price;
    private $img = [];
    private $colors = [];
    private $sizes = [];

    public function __construct(ProductBuilder $productBuilder){
        $this->id = $productBuilder->getId();
        $this->name = $productBuilder->getName();
        $this->price = $productBuilder->getPrice();
        $this->img = $productBuilder->getImg();
        $this->colors = $productBuilder->getColors();
        $this->sizes = $productBuilder->getSizes();
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
}