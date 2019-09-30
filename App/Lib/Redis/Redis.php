<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/28
 * Time: 15:14
 */

namespace App\Lib\Redis;

use EasySwoole\Core\AbstractInterface\Singleton;
use EasySwoole\Config;

class Redis
{
    use Singleton;
    public $redis = "";
    private function __construct()
    {
        if(!extension_loaded("redis")){
            throw new \Exception('redis.so文件不存在!');
        }
        try{
            //$redisConfig = Config::getInstance()->getConf('redis.REDIS');
            $redisConfig = \Yaconf::get('redis');
            $this->redis = new \Redis();
            $result = $this->redis->connect($redisConfig['host'],$redisConfig['port'],$redisConfig['time_out']);
        }catch (\Exception $e){
            //throw new \Exception($e->getMessage());
            throw new \Exception('redis服务异常!');
        }

        if($result === false){
            throw new \Exception('redis连接失败!');
        }
    }

    /**
     * @param $key
     * @return bool|string
     */
    public function get($key){
        if(empty($key)){
            return '';
        }
        return $this->redis->get($key);
    }

    /**
     * @param $key
     * @return bool|string
     */
    public function lPop($key){
        if(empty($key)){
            return '';
        }
        return $this->redis->lpop($key);
    }

    /**
     * @param $key
     * @param $value
     * @return bool|int|string
     */
    public function rPush($key,$value){
        if(empty($key) || empty($value)){
            return '';
        }
        return $this->redis->lPush($key,$value);
    }
}