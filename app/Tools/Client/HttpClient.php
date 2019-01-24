<?php
/**
 * Class Client
 * @package App\Traits
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/8/17 上午11:23
 */


namespace App\Tools\Client;


class HttpClient
{

    const TYPE_JSON = 'application/json';
    const TYPE_FORM_ENCODE = 'application/x-www-form-urlencoded';
    const TYPE_TEXT = 'text/plain';
    const TYPE_XML = 'application/xml';
    const TYPE_XML_TEXT = 'text/xml';

    protected $url;

    protected $headers;

    protected $body;

    protected $proxy;

    protected $sslVersion;

    protected $timeout;

    protected $timeoutMs;

    protected $debug = false;

    protected $method = 'post';

    public function __construct($url)
    {
        $this->url = $url;
        $this->defaultHeaders();
        $this->timeout = 60;
    }

    protected function defaultHeaders(){
        $headers = array();
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8,application/json';
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = 'Content-Type:application/json; charset=utf-8';
        $headers[] = 'Expect:';
        $this->headers = $headers;
    }


    public function header(array $headers){
        $arr = [];
        foreach ($headers as $key => $header){
            $arr[] = $key . ':'.$header;

        }
        $this->headers = array_merge($this->headers, $arr);
        return $this;
    }

    public function setSSLVersion($version){
        $this->sslVersion = $version;
        return $this;
    }

    public function data($data){
        $this->body = $data;
        return $this;
    }

    public function debug($bool = true){
        $this->debug = $bool;
        return $this;
    }

    /**
     * 设置超时
     * @param $second
     * @return $this
     */
    public function setTimeout($second){
        $this->timeout = $second;
        return $this;
    }

    public function setTimeoutMs($ms){
        $this->timeoutMs = $ms;
        return $this;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }
    /**
     * 设置代理
     * @param $proxyServer
     * @param $proxyPort
     * @throws \Exception
     * @return $this
     */
    public function proxy($proxyServer, $proxyPort){

        if($proxyServer === null || $proxyPort === null){
            throw new \Exception('proxy set error');
        }

        $this->proxy['server'] = $proxyServer;
        $this->proxy['port'] = $proxyPort;
        return $this;
    }

    public function setContentType($contentType, $charset = 'utf-8'){
        $pos = $this->findHeader('Content-Type');
        $type = 'Content-Type:'.$contentType.'; charset='.$charset;
        if($pos){
            $this->headers[$pos] = $type;
        }else{
            $this->headers[] = $type;
        }

        $this->log('header', $this->headers);
    }

    /**
     * @param $header
     * @return int|null
     */
    protected function findHeader($header){
        foreach ($this->headers as $key => &$header){
            if(strstr($header, 'Content-Type')){
                return $key;
            }
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getContentType(){
        $pos = $this->findHeader('Content-Type');

        if($pos){

            $str = $this->headers[$pos];
            $start = strpos($str, ':') ;
            $end = strpos($str, ';');
            $type = substr($this->headers[$pos], $start + 1, $end - $start - 1);
            return $type;
        }

        return null;
    }

    public function send()
    {

        // body数据
        $params = $this->body;
        switch ($this->getContentType()){
            case self::TYPE_JSON:
                $body = json_encode($params);
                break;
            case self::TYPE_FORM_ENCODE:
                $body = http_build_query($params);
                break;
            case self::TYPE_TEXT:
                $body = $params;
                break;
            default:
                $body = $params;
                break;
        }


        // header数据
        $headers = $this->headers;


        $curl = curl_init();  // 启动一个CURL会话
        if($this->method == 'post') {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);// 请求头
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);   // 请求体
        }
        curl_setopt($curl, CURLOPT_URL, $this->url);     // 请求地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);          // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);          // 从证书中检查SSL加密算法是否存在

        if($this->method == 'post') {
            curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        }

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout); // 设置响应超时
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout); // 设置传输超时

        if($this->timeoutMs !== null){
            curl_setopt($curl, CURLOPT_NOSIGNAL, true);    //注意，毫秒超时一定要设置这个
            curl_setopt($curl, CURLOPT_TIMEOUT_MS, $this->timeoutMs);    //超时时间200毫秒
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true); // 变量存储
        curl_setopt($curl, CURLINFO_HEADER_OUT, true); // 请求头信息

        if($this->debug){
            curl_setopt($curl, CURLOPT_VERBOSE, true);      // 显示详细信息
            curl_setopt($curl, CURLOPT_STDERR, fopen($_SERVER['DOCUMENT_ROOT'] . '/'.date('Y-m-d').'_http.txt', 'a+'));
        }

        // 代理
        if(!empty($this->proxy)){
            curl_setopt($curl,CURLOPT_PROXY, $this->proxy['server']);
            curl_setopt($curl,CURLOPT_PROXYPORT, $this->proxy['port']);
        }

        if($this->sslVersion !== null){
            curl_setopt($curl, CURLOPT_SSLVERSION, $this->sslVersion);
        }


        $response['data'] = curl_exec($curl); // 执行操作
        $response['status'] = curl_getinfo($curl,CURLINFO_HTTP_CODE); // 获取状态码
        $response['info'] = curl_getinfo($curl);

        if (curl_errno($curl)) {
            $response['error'] = curl_error($curl);//捕抓异常
        }

        curl_close($curl); // 关闭CURL会话

        if($response['status'] != 200){
            $this->log('target host error: ' . $this->url, $response);
        }

        return $response; // 返回数数
    }

    protected function log($title, $data){
        $loger = '\\Illuminate\Support\\Facades\\Log';

        if(!empty($loger)){
            $loger::error($title, $data);
        }
    }


    public function downloadFile($path, $fileName)
    {
        // body数据
        $params = $this->body;
        switch ($this->getContentType()){
            case self::TYPE_JSON:
                $body = json_encode($params);
                break;
            case self::TYPE_FORM_ENCODE:
                $body = http_build_query($params);
                break;
            case self::TYPE_TEXT:
                $body = $params;
                break;
            default:
                $body = $params;
                break;
        }


        if(!is_dir($path)){
            mkdir($path, 0777, true);
        }

        $fp = fopen($path.'/'.$fileName, 'w+');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);// 请求头
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);   // 请求体
        curl_setopt($curl, CURLOPT_URL, $this->url);     // 请求地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);          // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);          // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout); // 设置响应超时
        curl_setopt($curl, CURLOPT_TIMEOUT, 300); // 设置传输超时
        curl_setopt($curl, CURLOPT_FILE, $fp);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);
        curl_close($curl);
        fclose($fp);

        return $response;
    }

}