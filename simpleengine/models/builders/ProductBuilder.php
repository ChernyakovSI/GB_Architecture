<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 23.06.2018
 * Time: 17:18
 */

namespace simpleengine\models\builders;


use simpleengine\models\DB\ProductsAR;
use simpleengine\models\DB\ProductsGetById;
use simpleengine\models\Product;

class ProductBuilder
{
    private $id;
    private $name;
    private $price;
    private $img = [];
    private $colors = [];
    private $sizes = [];

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price." руб.";
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getImg(): array
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img[] = $img;
    }

    public function getColors(): array
    {
        return $this->colors;
    }

    public function setColors($color)
    {
        $this->colors[] = $color;
    }

    public function getSizes(): array
    {
        return $this->sizes;
    }

    public function setSizes($size)
    {
        $this->sizes[] = $size;
    }

    public function build(): Product
    {
        return new Product($this);
    }

    public function __construct($id = null){
        if ($id > 0) {
            if (!($this->getProduct($id) == true)) {
                echo "Ошибка получения товара!";
            }
        }
    }

    public function getProduct($id){
        $model = new ProductsGetById();
        $arr_product = ProductsAR::execute($model, $id);

        $img_dir = "img/goods/";
        $general = false;
        foreach($arr_product as &$value) {
            if ($general == false) {
                $this->setId($value["id"]);
                $this->setName($value["pname"]);
                $this->setPrice($value["price"]);
                $general = true;
            }

            if ($value["property"] == 1) {
                $this->setImg($img_dir.$value["pvalue"]);
            }

            if ($value["property"] == 3) {
                $this->setColors($value["pvalue"]);
            }

            if ($value["property"] == 2) {
                $this->setSizes($value["pvalue"]);
            }
        }

        return true;
    }
}