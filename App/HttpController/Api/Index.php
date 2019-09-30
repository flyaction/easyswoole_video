<?php

namespace App\HttpController\Api;

use \EasySwoole\Core\Component\Di;
use App\Lib\Redis\Redis;

class Index extends Base
{


    public function video(){
        $data = array(
            'id'=>1,
            'name'=>"video",
            'time'=>date('Y-m-d',strtotime('-1 day')),
            'params'=>$this->request()->getRequestParam()
        );

        return $this->writeJson(200,"OK",$data);
    }


    public function getVideo(){
        $db = Di::getInstance()->get('MYSQL');
        $data = $db->where('id',15)->getOne('video');
        return $this->writeJson(200,"OK",$data);

    }

    public function getRedis(){
        //$redis = Redis::getInstance();
        $redis = Di::getInstance()->get('REDIS');
        $data = $redis->get('name');
        return $this->writeJson(200,"OK",$data);
    }

    public function getYaconf(){

        $data = \Yaconf::get('db');
        return $this->writeJson(200,"OK",$data);
    }

    public function pub(){
        $params = $this->request()->getRequestParam();
        Di::getInstance()->get('REDIS')->rPush('action_list_test',$params['f']);
    }
}