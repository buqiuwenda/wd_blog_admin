<?php
/**
 * Class DealIPLocal
 * @package App\Console\Commands
 * Author:huangzhongxi@rockfintech.com
 * Date: 2019/1/24 11:44 AM
 */
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Jobs\IpLocalDeal;

class DealIPLocal extends Command
{
    protected $signature = 'getIpLocal:ip';

    protected $description = 'ip-获取IP信息';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $jobs = new IpLocalDeal();

        $jobs->run();
    }
}