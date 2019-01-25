<?php
/**
 * Class CommentController
 * @package App\Http\Controllers\Article
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/12/17 3:19 PM
 */
namespace App\Http\Controllers\Article;


use App\Http\Controllers\ResetController;
use Illuminate\Http\Request;
use App\Model\ArticleVisitor;
use App\Model\Article;
use App\Model\IPInfo;

class VisitorController extends ResetController
{
   public function index(Request $request)
   {
        $query = ArticleVisitor::query();

        if(!empty($request->get('article_id'))){
            $query->where('article_id', '=', $request->get('article_id'));
        }

       if(!empty($request->get('ip'))){
           $query->where('ip', '=', $request->get('ip'));
       }
       $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;
       $rows = $query->orderBy('article_visitors.id', 'desc')->paginate($limit);
       $rows = $rows->appends($request->all());

       if($rows->count()){
         $ip_data =  $this->getIpLocalList($rows);
       }else{
           $ip_data = [];
       }

       $article = Article::query()->where('status', '=', 1)->where('is_draft', '=', 0)->get();

       return view('article.visitor-index')->with(['rows' => $rows, 'pageSizes' => $this->pageSizes, 'articles' => $article, 'ip_data' => $ip_data]);
   }


   protected function getIpLocalList($rows)
   {
       $ips = $data = [];
        foreach($rows as $row){
            $ips[] = $row->ip;
        }

        $ips = array_unique($ips);

       $ip_list = IPInfo::query()->whereIn('ip', $ips)->get()->toArray();

       if($ip_list){
           foreach($ip_list as $key=> $val){
               $data[$val['ip']] = $val;
           }
       }

        return $data;
   }
}