<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 16.07.2017
 * Time: 16:31
 */

namespace simpleengine\core;


use simpleengine\models\User;

class CurrentUser
{
    var $user = NULL;

    /**
     * @return null|User
     */
    public function getUser()
    {
        if (isset($this->user) OR $this->user->isExist()) {
            return $this->user;
        }
        else
        {

            $this->initialize();
            return $this->user;
        }

    }

    public function __construct(string $connection_name = "DB")
    {
        try {
            $app = Application::instance();

            if (isset($_POST['disconnect']))
            {
                echo "Выход";
                $this->disconnect();
            }
            else
            {
                if (!(isset($this->user) AND $this->user->isExist())) {
                    $this->initialize();
                }
            }



            //die("Заглушка");
        }
        catch (\PDOException $e) {
            echo "Can't log in";
        }
    }

    public function disconnect()
    {
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        $this->user = NULL;

        setcookie("username", $_SESSION['username'], time()-1);
        setcookie("password", $_SESSION['password'], time()-1);

        $_SERVER["REQUEST_URI"] = "/login/";
    }

    public function initialize()
    {
            if (isset($_POST['username']) AND $_POST['username'] <> "" AND
                isset($_POST['password']) AND $_POST['password'] <> "")
            {
                $_POST['password'] = md5($_POST['password']);
                $this->user = new User(0, $_POST['username'], $_POST['password']);
                if ($this->user->isExist()) {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['password'] = $_POST['password'];

                    if (isset($_POST['remember'])) {
                        setcookie("username", $_SESSION['username'], time()+3600);
                        setcookie("password", $_SESSION['password'], time()+3600);
                    }
                }
                else
                {
                    $this->disconnect();
                }

            }
            elseif (isset($_POST['new_username']) AND $_POST['new_username'] <> "" AND
                isset($_POST['new_password']) AND $_POST['new_password'] <> "")
            {
                $_POST['new_password'] = md5($_POST['new_password']);
                $this->user = new User(null, $_POST['new_username'], $_POST['new_password'],
                    $_POST['firstname'], $_POST['lastname'], $_POST['middlename']);
                if ($this->user->isExist()) {
                    $_SESSION['username'] = $_POST['new_username'];
                    $_SESSION['password'] = $_POST['new_password'];

                    if (isset($_POST['remember'])) {
                        setcookie("username", $_SESSION['username'], time()+3600);
                        setcookie("password", $_SESSION['password'], time()+3600);
                    }
                }
                else
                {
                    $this->disconnect();
                }

            }
            else {
                if (!isset($_SESSION['username']) OR !isset($_SESSION['password']))
                {
                    if (isset($_COOKIE['username']) AND isset($_COOKIE['password']))
                    {
                        $this->user = new User(0, $_COOKIE['username'], $_COOKIE['password']);

                        $_SESSION['username'] = $_COOKIE['username'];
                        $_SESSION['password'] = $_COOKIE['password'];
                    }
                    else
                    {
                        $this->disconnect();
                    }
                }
                elseif ($_SESSION['username'] === "" OR $_SESSION['password'] === "")
                {
                    if (isset($_COOKIE['username']) AND isset($_COOKIE['password']))
                    {
                        $this->user = new User(0, $_COOKIE['username'], $_COOKIE['password']);

                        $_SESSION['username'] = $_COOKIE['username'];
                        $_SESSION['password'] = $_COOKIE['password'];
                    } else {
                        $this->disconnect();
                    }
                }
                elseif(!(isset($this->user))) {
                    $this->user = new User(0, $_SESSION['username'], $_SESSION['password']);
                }
            }


    }
}