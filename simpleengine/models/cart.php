<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 05.08.2017
 * Time: 22:58
 */

namespace simpleengine\models;

use simpleengine\core\Application;

class Cart
{
    var $id;
    var $sum;

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum." руб.";
    }

    public function add($user_id, $product_id, $price = 0, $quantity = 0, $date = NULL, $color = NULL, $size = NULL)
    {
        $app = Application::instance();
        $sql_color = "";
        $sql_color_val = "";
        if (!($color == NULL)) {
            $sql_color = ", `color`";
            $sql_color_val = ", '".$color."'";
        }
        $sql_size = "";
        $sql_size_val = "";
        if (!($size == NULL)) {
            $sql_size = ", `size`";
            $sql_size_val = ", '".$size."'";
        }

        $sql = "INSERT INTO `Clothing_Store`.`basket` 
(`id_user`, 
`id_product`, 
`product_price`, 
`quantity`, 
`datetime_insert`".$sql_color.$sql_size." 
) 
VALUES ('".$user_id."', 
'".$product_id."', 
'".$price."', 
'".$quantity."', 
'".$date."'".$sql_color_val.$sql_size_val." 
);";

        $db = $app->db();
        $result = $db->getArrayBySqlQuery($sql);

        if (isset($result) AND (gettype($result) <> "array")) {
            $this->id = 0;
            return false;
        }
        else {
            return true;
        }
    }

    public function getCartByUser($user_id) {
        $app = Application::instance();
        $sql = "SELECT 
b.id AS id,
p.id AS product_id,
p.product_name AS product_name,
b.color AS color,
b.size AS psize,
b.quantity AS quantity,
b.product_price AS price,
MIN(v.property_value) AS img
FROM `Clothing_Store`.basket AS b
LEFT JOIN `Clothing_Store`.products AS p ON b.id_product = p.id
LEFT JOIN `Clothing_Store`.product_properties_values AS v ON b.id_product = v.id_product AND v.id_property = 1
WHERE b.id_user = '".$user_id."' AND b.id_order IS NULL 
GROUP BY
b.id,
p.id,
p.product_name,
b.color,
b.size,
b.quantity,
b.product_price";

        $db = $app->db();
        $arr_products = $db->getArrayBySqlQuery($sql);

        $img_dir = "img/goods/";
        $sum = 0;
        foreach($arr_products as &$value) {
            $value["img"] = $img_dir.$value["img"];
            $value["src"] = "../product/?prod=".$value["product_id"];
            $total = $value["price"] * $value["quantity"];
            $sum += $total;
            $value["str_total"] = $total." руб.";
            $value["price"] = $value["price"]." руб.";
        }
        $this->sum = $sum;
        return $arr_products;
    }

    public function edit($id, $quantity) {
        $app = Application::instance();

        $sql = "UPDATE `Clothing_Store`.`basket` SET `quantity`='".$quantity."' WHERE  `id`=".$id.";";

        $db = $app->db();
        $result = $db->getArrayBySqlQuery($sql);

        if (isset($result) AND (gettype($result) <> "array")) {
            $this->id = 0;
            return false;
        }
        else {
            return true;
        }
    }

    public function delete($id) {
        $app = Application::instance();

        $sql = "DELETE FROM `Clothing_Store`.`basket` WHERE  `id`=".$id.";";

        $db = $app->db();
        $result = $db->getArrayBySqlQuery($sql);

        if (isset($result) AND (gettype($result) <> "array")) {
            $this->id = 0;
            return false;
        }
        else {
            return true;
        }
    }

    public function clear($user_id) {
        $app = Application::instance();

        $sql = "DELETE FROM `Clothing_Store`.`basket` WHERE  `id_user`=".$user_id.";";

        $db = $app->db();
        $result = $db->getArrayBySqlQuery($sql);

        if (isset($result) AND (gettype($result) <> "array")) {
            $this->id = 0;
            return false;
        }
        else {
            return true;
        }
    }

    public function getOrderProductsByUser($user_id) {
        $app = Application::instance();
        $sql = "SELECT 
b.id AS id,
p.id AS product_id,
b.id_order AS order_id,
p.product_name AS product_name,
b.color AS color,
b.size AS psize,
b.quantity AS quantity,
b.product_price AS price,
MIN(v.property_value) AS img
FROM `Clothing_Store`.basket AS b
LEFT JOIN `Clothing_Store`.products AS p ON b.id_product = p.id
LEFT JOIN `Clothing_Store`.product_properties_values AS v ON b.id_product = v.id_product AND v.id_property = 1
WHERE b.id_user = '".$user_id."' AND b.id_order IS NOT NULL 
GROUP BY
b.id,
p.id,
b.id_order,
p.product_name,
b.color,
b.size,
b.quantity,
b.product_price";

        $db = $app->db();
        $arr_products = $db->getArrayBySqlQuery($sql);

        $img_dir = "img/goods/";
        $sum = 0;
        foreach($arr_products as &$value) {
            $value["img"] = $img_dir.$value["img"];
            $value["src"] = "../product/?prod=".$value["product_id"];
            $total = $value["price"] * $value["quantity"];
            $sum += $total;
            $value["str_total"] = $total." руб.";
            $value["price"] = $value["price"]." руб.";
        }
        $this->sum = $sum;
        return $arr_products;
    }
}