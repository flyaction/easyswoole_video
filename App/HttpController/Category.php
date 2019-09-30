<?php

namespace App\HttpController;

use EasySwoole\Core\Http\AbstractInterface\Controller;

/**
 * Class Category
 * @package App\HttpController
 */
class Category extends Controller
{
    /**
     * 首页方法
     * @author : evalor <master@evalor.cn>
     */
    public function index()
    {
        $data = array(
            'id'=>1,
            'name'=>"action"
        );

        return $this->writeJson(200,"OK",$data);
    }


    public function show(){
        return $this->response()->write('Category - show!');
    }
}