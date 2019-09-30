<?php

namespace App\HttpController\Api;

use App\Lib\Upload\Image;
use \EasySwoole\Core\Component\Di;
use App\Lib\Upload\Video;
use App\Lib\ClassArr;

/**
 * Class Upload
 * @package App\HttpController\Api
 */
class Upload extends Base
{
    public function file(){
        $request = $this->request();
        $files = $request->getSwooleRequest()->files;
        $types = array_keys($files);
        $type = $types[0];
        if(empty($type)){
            return $this->writeJson(400,'上传文件不合法');
        }

        try{
            $classArr = new ClassArr();
            $obj = $classArr->initClass($type,$classArr->uploadClassStat(),array($request,$type));
            $file = $obj->upload();

        }catch (\Exception $e){
            return $this->writeJson(400,$e->getMessage());
        }

        if(empty($file)){
            return $this->writeJson(400,'上传失败');
        }
        $data = [
            'url'=>$file,
        ];
        return $this->writeJson(200,'OK',$data);

        /*$request = $this->request();
        $videos = $request->getUploadedFile('file');
        $flag = $videos->moveTo('/data/www/easyswoole2/webroot/1.mp4');
        $data = [
            'url'=>'1.mp4',
            'flag'=>$flag
        ];
        if($flag){
            return $this->writeJson(200,'OK',$data);
        }else{
            return $this->writeJson(400,'OK',$data);
        }*/

    }

}