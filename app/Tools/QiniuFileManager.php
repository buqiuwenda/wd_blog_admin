<?php
/**
 * Class QiniuFileManage
 * @package App\Tools
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/12/11 5:49 PM
 */
namespace App\Tools;

use Mockery\Exception;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Illuminate\Http\File;
use Qiniu\Storage\BucketManager;

class QiniuFileManager
{

    protected $access_key;
    protected $secret_key;
    protected $bucket;
    protected $domain;

    public function __construct()
    {
        $this->access_key = config('services.qiniu.access_key');
        $this->secret_key = config('services.qiniu.secret_key');
        $this->bucket = config('services.qiniu.bucket');
        $this->domain = config('services.qiniu.domain');

        if(!$this->access_key || !$this->secret_key || !$this->bucket){
            throw new Exception('qiniu config can not empty');
        }
    }


    public function uploadFile(File $file, $path, $name = '')
    {
        $hashName = empty($name) ?   str_ireplace('.jpeg','.jpg', $file->hashName()) : $name;

        $mime = $file->getMimeType();
        $key = $path.'/'.$hashName;

        $auth = new Auth($this->access_key, $this->secret_key);

        $token = $auth->uploadToken($this->bucket);

        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();

      // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $file);
        if ($err !== null) {
            return [
               'status' => 0,
               'msg' => $err
            ];
        } else {
           return [
              'status' => 1,
              'filename' => $hashName,
              'mime' => $mime,
              'size' => human_filesize($file->getSize()),
              'real_path' => $ret['key'],
              'relative_url' => "storage/".$ret['key'],
              'url' => $this->domain.$ret['key']
           ];
        }
    }


    public function deleteFile($path)
    {
        $key = str_replace($this->domain, '', $path);

        $auth = new Auth($this->access_key, $this->secret_key);

        $config = new \Qiniu\Config();

        $bucketManager = new BucketManager($auth, $config);

        $err = $bucketManager->delete($this->bucket, $key);

        if($err){
            return [
               'status' => 0,
               'msg' => $err,
            ];
        }else{
            return [
                'status' => '1',
                'msg'  => '删除成功'
            ];
        }
    }
}