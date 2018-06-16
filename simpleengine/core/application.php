<?php
namespace simpleengine\core;

use PMA\libraries\dbi\DBIDummy;
use simpleengine\core\exception\ApplicationException;
use simpleengine\core\db;

class Application {
    use Singleton;

    private $router;
    private $configuration = [];
    private $db = NULL;
    private $current_user = NULL;

    /**
     * @return null
     */
    public function getCurrentUser()
    {
        if (isset($this->current_user)){
            return $this->current_user;
        }
        else{
            var_dump("+");
            $this->current_user = new CurrentUser();
            return $this->current_user;
        }

    }

    public function run(){
        if (!isset($this->current_user)) {
            $this->current_user = new CurrentUser();
        }
        $this->router = new Router();

        $class = "\\simpleengine\\" . $this->router->getPackage() . "\\" . $this->router->getController();
        $method = "action" . ucfirst($this->router->getAction());

        //var_dump(class_exists($class));
        //exit();

        if(class_exists($class)){
            $controller = new $class;
            $controller->setRequestedAction($this->router->getAction());

            if(method_exists($controller, $method)){
                $controller->$method();
            }
            else{
                throw new ApplicationException("Method " . $class . " not found", 0503);
            }
        }
        else{
            throw new ApplicationException("Class " . $class . " not found", 0502);
        }


    }

    public function setConfiguration(array $configuration){
        if(empty($this->configuration))
            $this->configuration = $configuration;
        else
            throw new ApplicationException("Configuration has been already set up", 0501);
    }

    public function get(string $parameterName){
        $value = NULL;

        if(key_exists($parameterName, $this->configuration))
            $value = $this->configuration[$parameterName];

        return $value;
    }

    public function router() : Router{
        return $this->router;
    }

    public function db()
    {
        if ($this->db == NULL) {
            $this->db = new Db();
            //echo ($this->db == NULL)."<br>";

        }

        return $this->db;
    }
}