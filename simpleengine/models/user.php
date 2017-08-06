<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 09.07.2017
 * Time: 19:01
 */

namespace simpleengine\models;

use simpleengine\core\Application;

class User implements DbModelInterface
{
    private $id;
    private $firstname;
    private $lastname;
    private $middlename;
    private $email;
    private $is_admin;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct($id = null, $username = "", $password = "", $firstname = "", $lastname = "",
                                $middlename = "", $is_admin = 0){
        if ($id > 0) {
            $this->find($id);
        }
        elseif ((isset($id)) AND ($id == 0)) //авторизация по логину и паролю
        {
            $this->auth($username, $password);
        }
        else // регистрация по логину и паролю
        {
            $this->add($username, $password, $firstname, $lastname, $middlename, $is_admin);
        }
    }

    public function auth($login, $pass) {
        $app = Application::instance();
        //$sql = "SELECT * FROM users u WHERE u.email = '".$login."' AND u.hash_pass = md5('".$pass."')";
        $sql = "SELECT * FROM users u WHERE u.email = '".$login."' AND u.hash_pass = '".$pass."'";
        $db = $app->db();
        $result = $db->getArrayBySqlQuery($sql);

        if (isset($result[0])){
            $this->id = $result[0]["id"];
            $this->firstname = $result[0]["firstname"];
            $this->lastname = $result[0]["lastname"];
            $this->middlename = $result[0]["middlename"];
            $this->email = $result[0]["email"];
            $this->is_admin = $result[0]["is_admin"];
        }
        else {
            $this->id = 0;
        }
    }

    public function find($id)
    {
        $app = Application::instance();
        $sql = "SELECT * FROM users u WHERE u.id = '".(int)$id."'";
        $db = $app->db();
        $result = $db->getArrayBySqlQuery($sql);

        if (isset($result[0])){
            $this->id = $result[0]["id"];
            $this->firstname = $result[0]["firstname"];
            $this->lastname = $result[0]["lastname"];
            $this->middlename = $result[0]["middlename"];
            $this->email = $result[0]["email"];
            $this->is_admin = $result[0]["is_admin"];
            return true;
        }
        else {
            $this->id = 0;
            return false;
        }
    }

    public function save()
    {

    }

    /**
     * @return string firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return string lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return string middlename
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * @return string email
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function isExist()
    {
        return ($this->id) > 0;
    }

    public function add($username, $password, $firstname, $lastname, $middlename, $is_admin)
    {
        $app = Application::instance();
        $sql = "INSERT INTO users (firstname, lastname, middlename, email, hash_pass, is_admin)".
            " VALUES('".$firstname."', '".$lastname."', '".$middlename."', '".$username."', '".$password."', ".$is_admin.")";
        $db = $app->db();
        $result = $db->getArrayBySqlQuery($sql);

        if (isset($result) AND (gettype($result) <> "array")) {
            $this->id = 0;
            return false;
        }
        else {
            $this->auth($username, $password);
            return true;
        }
    }

    public function info()
    {
        return $this->lastname." ".mb_substr($this->firstname, 0, 1,"UTF-8").". ".mb_substr($this->middlename, 0, 1,"UTF-8").".";
    }
}