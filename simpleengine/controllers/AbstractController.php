<?php
/**
 * Created by PhpStorm.
 * User: Alex Pryakhin
 * Date: 18.04.2017
 * Time: 13:36
 */

namespace simpleengine\controllers;


use simpleengine\core\Application;
use simpleengine\core\exception\ApplicationException;

abstract class AbstractController
{
    protected $requestedAction = "index";

    abstract public function actionIndex();

    protected function render(string $template = "", array $variables = []) : string{
        if($template == "")
            $template = $this->requestedAction;

        if ($template == "top" || $template == "bottom" || $template == "message") {
            $dir = Application::instance()->get("DIR")["VIEWS"]."general/";
        }
        else {
            $dir = Application::instance()->get("DIR")["VIEWS"];

            $dir .= mb_strtolower(substr(Application::instance()->router()->getController(), 0, -10), "UTF-8");
        }

        try {
            $loader = new \Twig_Loader_Filesystem($dir);
            $twig = new \Twig_Environment($loader, []);
        }
        catch(\Exception $e){
            throw new ApplicationException("Template " . $dir . $template . " not found", 0504);
        }

        return $twig->render($template.".tmpl", $variables);
    }

    public function setRequestedAction(string $actionName){
        $this->requestedAction = $actionName;
    }
}