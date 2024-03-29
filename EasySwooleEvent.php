<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/1/9
 * Time: 下午1:04
 */

namespace EasySwoole;

use \EasySwoole\Core\AbstractInterface\EventInterface;
use \EasySwoole\Core\Swoole\ServerManager;
use \EasySwoole\Core\Swoole\EventRegister;
use \EasySwoole\Core\Http\Request;
use \EasySwoole\Core\Http\Response;
use \EasySwoole\Core\Component\Di;
use App\Lib\Redis\Redis;
use EasySwoole\Core\Utility\File;
use EasySwoole\Core\Swoole\Process\ProcessManager;
use App\Lib\Process\ConsumerTest;

Class EasySwooleEvent implements EventInterface {

    public static function frameInitialize(): void
    {
        // TODO: Implement frameInitialize() method.
        date_default_timezone_set('Asia/Shanghai');
        // 载入项目 Config 文件夹中所有的配置文件
        self::loadConf(EASYSWOOLE_ROOT . '/Config');
    }

    public static function loadConf($ConfPath)
    {
        $Conf  = Config::getInstance();
        $files = File::scanDir($ConfPath);
        foreach ($files as $file) {
            $data = require_once $file;
            $Conf->setConf(strtolower(basename($file, '.php')), (array)$data);
        }
    }

    public static function mainServerCreate(ServerManager $server,EventRegister $register): void
    {
        // TODO: Implement mainServerCreate() method.
        //mysql相关
        Di::getInstance()->set('MYSQL',\MysqliDb::class,Array (
                'host' => '127.0.0.1',
                'username' => 'root',
                'password' => 'yiyi1314',
                'db'=> 'videos',
                'port' => 3306,
                'charset' => 'utf8')
        );

        //redis相关
        Di::getInstance()->set('REDIS',Redis::getInstance());


        $allNum = 3;
        for ($i = 0 ;$i < $allNum;$i++){
            ProcessManager::getInstance()->addProcess("action_consumer_test_{$i}",ConsumerTest::class);
        }
    }

    public static function onRequest(Request $request,Response $response): void
    {
        // TODO: Implement onRequest() method.
    }

    public static function afterAction(Request $request,Response $response): void
    {
        // TODO: Implement afterAction() method.
    }


}