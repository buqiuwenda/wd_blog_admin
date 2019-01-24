<?php
/**
 * Class IpLocal
 * @package App\Http\Jobs
 * Author:huangzhongxi@rockfintech.com
 * Date: 2019/1/24 11:31 AM
 */
namespace App\Http\Jobs;

use Log;
use App\Model\ArticleVisitor;
use App\Model\IPInfo;
use App\Tools\IPLocal\itbdw\IpLocation;

class IpLocalDeal {



    public function run()
    {
        Log::info('处理访问IP开始--'.date('Y-m-d H:i:s'));

        $ips = ArticleVisitor::query()->groupBy('ip')->select('ip')->get();

        if($ips){
            foreach($ips->toArray() as $value){

                $ip_data = IpLocation::getLocation($value['ip']);
                Log::info('ip_data', ['data' => $ip_data]);
                print_r($ip_data);

                if($ip_data){
                    if(isset($ip_data['county'])){
                        unset($ip_data['county']);
                    }

                    $info = IPInfo::query()->where('ip', '=', $value['ip'])->first();
                    if(empty($info)) {
                        $model = new IPInfo();
                        $model->fill($ip_data);
                        $model->save();
                    }
                }
            }
        }


        Log::info('处理访问IP结束--'.date('Y-m-d H:i:s'));
    }
}