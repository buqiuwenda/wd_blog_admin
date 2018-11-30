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