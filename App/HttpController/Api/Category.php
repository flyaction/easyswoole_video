<?php

namespace App\HttpController\Api;


class Category extends Base
{

    public function index(){
        $data = array(
            1=>'体育',
            2=>'北京',
            3=>'科技',
            4=>'乡村',
        );

        return $this->writeJson(200,"OK",$data);
    }

}