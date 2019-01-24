<?php
/**
 * Class ${NAME}
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/30 4:37 PM
 */
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

if(!function_exists('is_white_route')){
    function is_white_route($route){
        $whiteList = config('permission.white_list');
        foreach ($whiteList as $item){
            if(strpos($route, $item) !== false){
                return true;
            }
        }
        return false;
    }
}

if(!function_exists('make_randString')){
    function make_randString($pre = '', $length = 12, $is_upper = true)
    {
        $arr = [0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l'
                ,'m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

        $upper = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

        if(!$is_upper){
           $arr = array_merge($arr, $upper);

        }
        $max = count($arr)-1;

        $string = '';
        for($i=0; $i< $length; $i++){
            $string .= $arr[mt_rand(0,$max)];
        }

        if($is_upper){
            return  $pre.strtoupper($string);
        }else{
            return $pre.$string;
        }
    }
}


if(!function_exists('human_filesize')) {
    /**
     * Get a readable file size.
     *
     * @param $bytes
     * @param int $decimals
     * @return string
     */
    function human_filesize($bytes, $decimals = 2) {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];

        $floor = floor((strlen($bytes)-1)/3);

        return sprintf("%.{$decimals}f", $bytes/pow(1024, $floor)).@$size[$floor];
    }
}

if (! function_exists('str_slug')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @param  string  $language
     * @return string
     */
    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }
}

if (! function_exists('str_random')) {
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     *
     * @throws \RuntimeException
     */
    function str_random($length = 16)
    {
        return Str::random($length);
    }
}

/**
 * 当前路由名称
 */
if(!function_exists('route_name')){

    function route_name(){
        return Route::currentRouteName();
    }
}

/**
 * 当前使用的命名空间位置，相对于Controllers
 */
if(!function_exists('current_namespace')){
    function current_namespace(){
        $namespace = Route::current()->action['namespace'];
        $arr = explode('\\', $namespace);
        if(isset($arr[3])){
            return $arr[3];
        }
        return '';
    }
}

if(!function_exists('get_precentage')){
    function get_precentage($start_num, $end_num)
    {
        $is_up = true;
        if($start_num){
            $num = $start_num-$end_num;
            if( $num== 0){
                $precentage = 0;
            }elseif($num > 0){
                $precentage = round(($num/$start_num), 2) * 100;
            }else{
                $precentage = round((abs($num)/$start_num), 2) * 100;
                $is_up = false;
            }

        }else{
            if($end_num){
                $precentage = $end_num;
                $is_up = false;
            }else{
                $precentage = 0;
            }
        }

        return [
            'is_up' => $is_up,
            'precentage' => $precentage
        ];
    }
}


if(!function_exists('check_ip')){
    function check_ip($ip){
       if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)){
           return true;
       }elseif($ip == '127.0.0.1'){
           return false;
       }

        return false;
    }
}

