<?php

namespace simpleengine\core;

class Router
{
    private $urlData = [];
    private $package = "";
    private $controller = "";
    private $action = "";

    public function __construct()
    {
        $urlParts = explode("?", $_SERVER["REQUEST_URI"]);
        $this->urlData["main"] = $urlParts[0];

        if(isset($urlParts[1])){
            $strGet = explode("&", $urlParts[1]);

            $arrget = [];
            foreach ($strGet as &$value) {
                $var_val = explode("=", $value);
                $arrget[$var_val[0]] = (int)$var_val[1];
            }

            $this->urlData["get"] = $arrget;
        }
        else {
            $this->urlData["get"] = [];
        }

        $this->applyUrlMapping();
    }

    public function getController() : string {
        return $this->controller;
    }

    public function getAction() : string {
        return $this->action;
    }

    public function getPackage() : string {
        return $this->package;
    }

    public function getGet() : array {
        return $this->urlData["get"];
    }

    /**
     * Метод разборки URL
     */
    private function applyUrlMapping(){
        if(!empty($this->urlData["main"])){
            $rules = Application::instance()->get("ROUTER");

            $activeRule = [];

            foreach($rules as $ruleSource => $ruleTarget){
                // превращаем правило в регулярное выражение
                $ruleData = explode("/", $ruleSource);

                $pcre = "/\/";
                foreach($ruleData as $rulePart){
                    if(mb_substr($rulePart, 0, 1, "UTF-8") != '<'){
                        // если это фиксированная часть
                        $pcre .= $rulePart."\/";
                    }
                    else{
                        // это шаблон
                        $pcre .= "([a-z0-9-]+\/)*";
                    }
                }
                $pcre .= "/";

                if(preg_match($pcre, $this->urlData["main"])){
                    $activeRule['pattern'] = $ruleSource;
                    $activeRule['controller'] = $ruleTarget;
                    break;
                }
            }

            if(!empty($activeRule)){
                $this->setUpRouting($activeRule);
            }
        }
    }

    /**
     * Метод назначения управляющих конструкций, исходя из URL
     * @param $activeRule
     */
    private function setUpRouting($activeRule){
        $command = $activeRule["controller"];

        $urlPartsTmp = array_filter(explode("/", $this->urlData["main"]));
        $urlParts = [];
        foreach($urlPartsTmp as $item){
            if(!empty($item))
                $urlParts[] = $item;
        }

        // если правило - это шаблон
        if(preg_match("/</", $activeRule["pattern"])) {
            foreach (explode("/", $activeRule["pattern"]) as $partKey => $patternPart) {
                if (preg_match("/</", $patternPart)) {
                    $command = str_replace($patternPart, $urlParts[$partKey], $command);

                    if (preg_match("/action/", $patternPart)) {
                        $this->action = $urlParts[$partKey];
                    }

                    if (preg_match("/controller/", $patternPart)) {
                        $this->controller = $urlParts[$partKey];
                    }

                    if (preg_match("/package/", $patternPart)) {
                        $this->package = $urlParts[$partKey];
                    }
                }
            }
        }

        $commandParts = explode("/", $command);

        if($this->action == "" && isset($commandParts[2]) && $commandParts[2] != ""){
            $this->action = $commandParts[2];
        }
        elseif ($this->action == ""){
            $this->action = "index";
        }


        if($this->controller == "" && isset($commandParts[1]) && $commandParts[1] != ""){
            $this->controller = $commandParts[1];
        }
        else{
            $this->controller = "DefaultController";
        }

        if($this->package == "" && isset($commandParts[0]) && $commandParts[0] != ""){
            $this->package = $commandParts[0];
        }
        else{
            $this->package = "controllers";
        }
    }
}