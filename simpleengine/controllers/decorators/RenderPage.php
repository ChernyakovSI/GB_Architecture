<?php
/**
 * Created by PhpStorm.
 * User: palad
 * Date: 30.06.2018
 * Time: 16:18
 */

namespace simpleengine\controllers\decorators;

use simpleengine\controllers\AbstractController;
use simpleengine\controllers\IRenderable;

abstract class RenderPage extends AbstractController implements IRenderable
{
    /*protected $objectBuilder = null;

    public function __construct(IRenderable $object)
    {
        $this->objectBuilder = $object->objectBuilder;
    }*/
}
