<?php
/**
 * Class RedisService
 * @package App\Services
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/12/21 11:50 AM
 */
namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Log;

class RedisService
{
    public function getRedis($key)
    {
        try {
            return Redis::get($key);
        }catch(\Exception $exception){
            Log::info('exception error info '.$exception->getMessage());
            return null;
        }
    }

    public function setRedis($key, $value)
    {
        try{
            Redis::set($key, $value);
            return true;
        }catch(\Exception $exception){
            Log::info('exception error info '.$exception->getMessage());
            return null;
        }
    }

    public function hgetRedis($HKey, $key)
    {
        try{
            return Redis::hget($HKey, $key);
        }catch(\Exception $exception){
            Log::info('exception error info '.$exception->getMessage());
            return null;
        }
    }

    public function hsetRedis($HKey, $key, $value)
    {
        try{
            Redis::hset($HKey, $key, $value);
            return true;
        }catch(\Exception $exception){
            Log::info('exception error info '.$exception->getMessage());
            return null;
        }
    }


    public function setexRedis($key, $value, $seconds = 60)
    {
        try{
            Redis::setex($key, $seconds, $value);
            return true;
        }catch(\Exception $exception){
            Log::info('exception error info '.$exception->getMessage());
            return null;
        }
    }

    public function incrbyRedis($key, $number)
    {
        try{
            Redis::incrby($key, $number);
            return true;
        }catch(\Exception $exception){
            Log::info('exception error info '.$exception->getMessage());
            return null;
        }
    }


    public function existsKey($key)
    {
        try{
            return  Redis::exists($key);
        }catch(\Exception $exception){
            Log::info('exception error info '.$exception->getMessage());
            return null;
        }
    }


    public function deleteRedis($keys)
    {
        try{
            Redis::del($keys);
            return true;
        }catch(\Exception $exception){
            Log::info('exception error info '.$exception->getMessage());
            return null;
        }
    }
}