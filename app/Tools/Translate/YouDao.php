<?php
/**
 * Class YouDao 翻译
 * @package App\Tools\Translate
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/12/13 10:41 AM
 */
namespace App\Tools\Translate;

use Log;

class YouDao
{
    protected $domain;
    protected $app_key;
    protected $app_secret;
    protected $timeout;


    public function __construct()
    {
        $this->domain = config('services.youdao.domain');
        $this->app_key = config('services.youdao.app_key');
        $this->app_secret = config('services.youdao.app_secret');
        $this->timeout = config('services.youdao.timeout');
    }


    public function translate($query, $from = 'zh-CHS', $to = 'EN')
    {
        $data= [
           'q' => $query,
           'appKey' => $this->app_key,
           'salt' => rand(10000,99999),
           'from' => $from,
           'to' => $to
        ];

        $data['sign']  = $this->buildSign($query, $data['salt']);

        $params = $this->convert($data);

        $ret = $this->call($params);
        if($ret['errorCode'] == 0){
            return $ret['translation'][0];
        }else {
            return '';
        }
    }


    protected function convert(&$args)
    {
        $data = '';
        if (is_array($args))
        {
            foreach ($args as $key=>$val)
            {
                if (is_array($val))
                {
                    foreach ($val as $k=>$v)
                    {
                        $data .= $key.'['.$k.']='.rawurlencode($v).'&';
                    }
                }
                else
                {
                    $data .="$key=".rawurlencode($val)."&";
                }
            }
            return trim($data, "&");
        }
        return $args;
    }

    protected function buildSign($query, $salt)
    {
        $str = $this->app_key . $query . $salt . $this->app_secret;
        $ret = md5($str);
        return $ret;
    }


    protected function call($data)
    {
        $ret = false;
        $i = 0;
        while($ret === false)
        {
            if($i > 1)
                break;
            if($i > 0)
            {
                sleep(1);
            }
            $ret = $this->callOne($data);
            $i++;
        }
        return $ret;
    }

    protected function callOne($data)
    {
        $url = $this->domain;
        $method = 'post';
        Log::info('request youdao data '.$data);
        $ch = curl_init();
        if($method == "post")
        {

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        else
        {

            if($data)
            {
                if(stripos($url, "?") > 0)
                {
                    $url .= "&$data";
                }
                else
                {
                    $url .= "?$data";
                }
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!empty($headers))
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $r = curl_exec($ch);

        curl_close($ch);

        Log::info('response youdao res '.$r);

        $res = json_decode($r, true);

        return $res;




    }

}