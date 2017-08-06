<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 06.08.2017
 * Time: 18:46
 */

namespace simpleengine\models;

use simpleengine\core\Application;

class Order
{
    private $id;

    public function __construct($id = NULL, $user_id = NULL)
    {
        if (($id == NULL) AND ($user_id > 0))
        {
            $this->add($user_id);
            if ($this->id > 0) {
                $this->basketToOrder($this->id, $user_id);
            }

        }
    }

    public function add($user_id) {
        $app = Application::instance();
        $date = date("Y-m-d H:i:s");

        $sql = "SELECT SUM(b.product_price * b.quantity) as sum 
FROM `Clothing_Store`.basket AS b
WHERE id_user = '".$user_id."'";
        $db = $app->db();
        $result = $db->getArrayBySqlQuery($sql);
        if (isset($result) AND isset($result[0]["sum"])) {
            $sql = "INSERT INTO `Clothing_Store`.`orders` 
(`id_user`, 
`datetime_create`, 
`datetime_update`, 
`amount`, 
`id_order_status` 
) 
VALUES ('".$user_id."', 
'".$date."', 
'".$date."', 
'".$result[0]["sum"]."', 
'1' 
);";

            $db = $app->db();
            $db->getArrayBySqlQuery($sql);

            $this->id = $db->lastID();
        }
        else {
            $this->id = 0;
            return false;
        }
    }

    public function basketToOrder($id, $user_id) {
        $app = Application::instance();

        $sql = "UPDATE `Clothing_Store`.`basket` SET `id_order`='".$id."' WHERE  `id_order` IS NULL AND `id_user` = '".$user_id."';";
        $db = $app->db();
        $result = $db->getArrayBySqlQuery($sql);

    }

    public function getOrdersByUser($user_id) {
        $app = Application::instance();
        $sql = "SELECT
o.id AS id,
o.datetime_create AS datetime_create,
o.datetime_update AS datetime_update,
o.amount AS amount,
os.status_name AS ostatus
FROM `Clothing_Store`.orders AS o
LEFT JOIN `Clothing_Store`.order_statuses AS os ON o.id_order_status = os.id
WHERE o.id_user = '".$user_id."'";

        $db = $app->db();
        $arr_products = $db->getArrayBySqlQuery($sql);

        return $arr_products;
    }
}