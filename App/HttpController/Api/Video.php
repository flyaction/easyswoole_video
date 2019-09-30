<?php

namespace App\HttpController\Api;

use App\Model\Video as VideoModel;
use EasySwoole\Core\Http\Message\Status;
use EasySwoole\Core\Utility\Validate\Rules;
use EasySwoole\Core\Utility\Validate\Rule;
use EasySwoole\Core\Component\Logger;

class Video extends Base
{
    public $logType = 'video:';
    public function add(){
        $params = $this->request()->getRequestParam();
        Logger::getInstance()->log($this->logType.'add:'.json_encode($params));
        //数据校验
        $ruleObj = new Rules();
        $ruleObj->add('name','视频名称错误')->withRule(Rule::REQUIRED)->withRule(Rule::MIN_LEN,2)->withRule(Rule::MAX_LEN,20);
        $ruleObj->add('url','视频地址错误')->withRule(Rule::REQUIRED);
        $ruleObj->add('image','图片地址错误')->withRule(Rule::REQUIRED);
        $ruleObj->add('content','视频描述错误')->withRule(Rule::REQUIRED);
        $ruleObj->add('cat_id','栏目id错误')->withRule(Rule::REQUIRED);

        $validata = $this->validateParams($ruleObj);
        if($validata->hasError()){
            //print_r($validata->getErrorList());
            return $this->writeJson(Status::CODE_BAD_REQUEST,"提交视频有误!",$validata->getErrorList()->first()->getMessage());
        }

        $data = array(
            'name'=>$params['name'],
            'url'=>$params['url'],
            'image'=>$params['image'],
            'content'=>$params['content'],
            'cat_id'=>intval($params['cat_id']),
            'create_time'=>time(),
            'uploader'=>'action',
            'status'=>\Yaconf::get('status.normal')
        );
        try{
            $modelObj = new VideoModel();
            $videoId = $modelObj->add($data);
        }catch (\Exception $e){
            return $this->writeJson(Status::CODE_BAD_REQUEST,$e->getMessage());
        }
        if($videoId){
            return $this->writeJson(Status::CODE_OK,"OK",['id'=>$videoId]);
        }else{
            return $this->writeJson(Status::CODE_BAD_REQUEST,"提交视频有误!",['id'=>0]);
        }


    }
}