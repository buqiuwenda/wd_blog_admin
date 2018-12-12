<?php
/**
 * Class ${NAME}
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/30 4:37 PM
 */

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