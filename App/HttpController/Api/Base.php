<?php

namespace App\HttpController\Api;

use EasySwoole\Core\Http\AbstractInterface\Controller;

/**
 * Api模块下的基础类库
 * Class Base
 * @package App\HttpController\Api
 */
class Base extends Controller
{

    public function index()
    {
        // TODO: Implement index() method.
    }

    /**
     * @param $action
     * @return bool|null
     */
    public function onRequest($action): ?bool
    {
        return true;
    }

    /**
     * @param \Throwable $throwable
     * @param $actionName
     * @throws \Throwable
     */
    protected function onException(\Throwable $throwable,$actionName):void
    {
         $this->writeJson(400,"请求不合法!");
    }

}