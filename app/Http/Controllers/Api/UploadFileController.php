<?php
/**
 * Class UploadFileController
 * @package App\Http\Controllers\Api
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/12/10 11:57 AM
 */
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Tools\QiniuFileManager;



class UploadFileController extends Controller
{
     protected $manager ;
     public function __construct()
     {
         $this->manager = new QiniuFileManager();
     }

    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,jpg,png,gif'
        ]);

        $strategy = $request->get('strategy','images');
        if(!$request->hasFile('image')){
            return [
                 'status'=> 0,
                 'msg'=>'文件未找到'
            ];
        }

        $file = new File($request->file('image'));

        $path = $strategy .'/'.date('Y-m-d');

        $result = $this->manager->uploadFile($file, $path);

        return $result;
    }



    public function deleteFile(Request $request)
    {
        $this->validate($request, [
            'key' => 'required|string|max:255'
        ]);

        $key = $request->all()['key'];

        $result = $this->manager->deleteFile($key);

        return $result;
    }



}