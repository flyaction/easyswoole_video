<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/28
 * Time: 15:14
 */

namespace App\Lib\Upload;

use App\Lib\Utils;

class Base
{
    /** 上传文件的file-key
     * @var string
     */
    public $type = "";

    public function __construct($request,$type=null)
    {
        $this->request = $request;
        if(empty($type)){
            $files = $this->request->getSwooleRequest()->files;
            $types = array_keys($files);
            $this->type = $types[0];
        }else{
            $this->type = $type;
        }

    }

    public function upload(){
        if($this->type != $this->fileType){
            return false;
        }
        $videos = $this->request->getUploadedFile($this->type);
        $this->size = $videos->getSize();
        $this->checkSize();
        $fileName = $videos->getClientFilename();
        $this->clientMediaType = $videos->getClientMediaType();
        $this->checkMediaType();

        $file = $this->getFile($fileName);
        $flag = $videos->moveTo($file);
        if($flag){
            return $this->file;
        }

        return false;

    }

    public function getFile($fileName){
        $extension = pathinfo($fileName,PATHINFO_EXTENSION);
        $dirname = "/".$this->type.'/'.date('Ym');
        $dir = EASYSWOOLE_ROOT.'/webroot'.$dirname;
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        $basename = '/'.Utils::getFileKey($fileName).'.'.$extension;
        $this->file = $dirname.$basename;
        return $dir.$basename;

    }
    /**
     * 检测文件格式
     * @return bool
     * @throws \Exception
     */
    public function checkMediaType(){
        $type = explode('/',$this->clientMediaType);
        $type = $type[1]??"";
        if(empty($type)){
            throw new \Exception("上传{$this->type}文件不合法");
        }
        if(!in_array($type,$this->fileExtTypes)){
            throw new \Exception("上传{$this->type}文件不合法");
        }
        return true;
    }

    /**
     *  检测文件大小
     * @return bool
     */
    public function checkSize(){
        if(empty($this->size)){
            return false;
        }
        if($this->size > $this->maxSize){
            return false;
        }
        return true;
    }

}