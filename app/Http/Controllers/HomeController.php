<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RedisService;
use App\Services\StatisticService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $key = 'admin_statistic_data';

        $redisServices = new RedisService();

        $list = $redisServices->getRedis($key);

        if($list){
            $list = json_decode($list, true);
        }else{
            $statisticService = new StatisticService();

            $user = $statisticService->getUserMonthly();
            $article = $statisticService->getArticleMonthly();
            $visitor = $statisticService->getArticleVisitorMonthly();
            $comment = $statisticService->getCommentMonthly();
            $sponsor = $statisticService->getSponsorMonthly();

            $list = [
               'user' => $user,
               'article' => $article,
               'visitor' => $visitor,
               'comment' => $comment,
               'sponsor' => $sponsor,

            ];

            $redisServices->setexRedis($key, json_encode($list), 600);
        }



        return view('home', compact('list'));
    }


}
