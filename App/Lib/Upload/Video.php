<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/28
 * Time: 15:14
 */

namespace App\Lib\Upload;

class Video extends Base
{
    /*
     * @var string
     */
    public $fileType = 'video';
    /**
     * @var string
     */
    public $maxSize = '4*1024*2014';

    /**
     * 文件后缀
     * @var array
     */
    public $fileExtTypes = [
      'mp4','x-flv'
    ];
}