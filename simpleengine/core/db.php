<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 09.07.2017
 * Time: 17:21
 */

namespace simpleengine\core;

use \simpleengine\core\Application;

class Db
{
    private $pdo;

    public function __construct(string $connection_name = "DB")
    {
        try {
            $app = Application::instance();

            $pass = $app->get($connection_name)["DB_PASS"];
            $user = $app->get($connection_name)["DB_USER"];
            $name = $app->get($connection_name)["DB_NAME"];
            $host = $app->get($connection_name)["DB_HOST"];
            $dsn = 'mysql:dbname='.$name.';host='.$host.';charset=UTF8';

            $this->pdo = new \PDO($dsn, $user, $pass);
        }
        catch (\PDOException $e) {
            echo "Can't connect to database";
        }
    }

    public function getArrayBySqlQuery(string $sql){
        $statement = $this->pdo->query($sql);

        if ($statement <> false) {
            $result = $statement->fetchAll();

            return $result;
        }
        else  // Была ошибка в запросе
            return false;

    }

    public function lastID() {
        return $this->pdo->lastInsertId();
    }
}