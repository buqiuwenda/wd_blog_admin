<?php
/**
 * Class SystemController
 * @package App\Http\Controllers\System
 * Author:huangzhongxi@rockfintech.com
 * Date: 2019/1/24 10:24 AM
 */
namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;

class SystemController extends Controller
{

    public function getSystemInfo()
    {
        $pdo = \DB::connection()->getPdo();

        $version = $pdo->query('select version()')->fetchColumn();

        $data =[
            'server'=>$_SERVER['SERVER_SOFTWARE'],
            'http_host'=>$_SERVER['HTTP_HOST'],
            'remote_host'=>isset($_SERVER['REMOTE_HOST'])?$_SERVER['REMOTE_HOST']: $_SERVER['REMOTE_ADDR'],
            'user_agent'=>$_SERVER['HTTP_USER_AGENT'],
            'php'=>phpversion(),
            'sapi_name'=>php_sapi_name(),
            'extensions'=>implode(',',get_loaded_extensions()),
            'db_connection'=>isset($_SERVER['DB_CONNECTION'])?$_SERVER['DB_CONNECTION']:'Secret',
            'db_database'=>isset($_SERVER['DB_DATABASE'])?$_SERVER['DB_DATABASE']:'Secret',
            'db_version'=>$version
        ];

        return view('system.index', compact('data'));
    }
}