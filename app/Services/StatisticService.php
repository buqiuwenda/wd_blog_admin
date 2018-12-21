<?php
/**
 * Class StatisticService
 * @package App\Services
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/12/21 10:08 AM
 */
namespace App\Services;

use App\Model\User;
use App\Model\Article;
use App\Model\ArticleVisitor;
use App\Model\Comment;

class StatisticService
{

    protected $start_date;
    protected $end_date;
    protected $pre_start_date;
    protected $pre_end_date;

    public function __construct()
    {
        $start_date = date('Y-m-01 00:00:00');

        $d =date('t') - date('j');
        $end_date = date('Y-m-d 23:59:59', strtotime("+{$d} day"));

        $pre_start_date = mktime(0,0,0,date('m')-1, date('01'), date('Y'));
        $last_days = date('t', $pre_start_date);
        $pre_end_date = mktime(23,59,59,date('m')-1, date($last_days), date('Y'));

        $this->start_date = $start_date;
        $this->end_date = $end_date;

        $this->pre_start_date = $pre_start_date;
        $this->pre_end_date = $pre_end_date;
    }


    public function getUserMonthly()
    {

        $user = User::query()->where('created_at','>=', $this->start_date)->where('created_at', '<=', $this->end_date)
            ->count();

        $last_user = User::query()->where('created_at','>=', $this->pre_start_date)->where('created_at', '<=', $this->pre_end_date)
                ->count();

        $precentage = get_precentage($user, $last_user);

        return array_merge($precentage, ['total' => $user]);
    }


    public function getArticleMonthly()
    {
        $article = Article::query()->where('created_at','>=', $this->start_date)->where('created_at', '<=', $this->end_date)
            ->where('status', '=', 1)->where('is_draft', '=', 0)->count();

        $last_article = Article::query()->where('created_at','>=', $this->pre_start_date)->where('created_at', '<=', $this->pre_end_date)
                ->where('status', '=', 1)->where('is_draft', '=', 0)->count();

        $precentage = get_precentage($article, $last_article);

        return array_merge($precentage, ['total' => $article]);
    }


    public function getArticleVisitorMonthly($is_user = false)
    {
        $query = ArticleVisitor::query();

        if($is_user){
            $query->where('user_id', '>', 0);
        }

        $visitor = $query->where('created_at','>=', $this->start_date)->where('created_at', '<=', $this->end_date)->sum('clicks');

        $last_visitor = $query->where('created_at','>=', $this->pre_start_date)->where('created_at', '<=', $this->pre_end_date)->sum('clicks');

        $precentage = get_precentage($visitor, $last_visitor);

        return array_merge($precentage, ['total' => $visitor]);

    }


    public function getCommentMonthly()
    {

        $comment = Comment::query()->where('created_at','>=', $this->start_date)->where('created_at', '<=', $this->end_date)
            ->count();

        $last_comment = Comment::query()->where('created_at','>=', $this->pre_start_date)->where('created_at', '<=', $this->pre_end_date)
            ->count();

        $precentage = get_precentage($comment, $last_comment);

        return array_merge($precentage, ['total' => $comment]);
    }

}