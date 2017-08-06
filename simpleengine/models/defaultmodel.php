<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.06.2017
 * Time: 21:23
 */

namespace simpleengine\models;

use simpleengine\core\Application;

class DefaultModel
{
    public function testMethod(){
        //$app = Application::instance();
        //$app->db()->getArrayBySqlQuery();

        return "GeekUnivercity is awesome";
    }
}