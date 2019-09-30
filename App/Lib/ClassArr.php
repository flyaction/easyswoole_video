<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31
 * Time: 15:45
 */

namespace App\Lib;

/**
 * 做一些反射机制有关的处理
 * Class ClassArr
 * @package App\Lib
 */
class ClassArr
{
    /**
     * @return array
     */
    public function uploadClassStat(){
        return [
            'image'=>'\App\Lib\Upload\Image',
            'video'=>'\App\Lib\Upload\Video',
        ];
    }

    public function initClass($type,$supportedClass,$params = [],$needInstance=true){
        if(!array_key_exists($type,$supportedClass)){
            return false;
        }
        $className = $supportedClass[$type];
        return $needInstance?(new \ReflectionClass($className))->newInstanceArgs($params):$className;

    }
}