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

class VisitorController extends ResetController
{
   public function index(Request $request)
   {
        $query = ArticleVisitor::query()->rightJoin('ip_infos', 'article_visitors.ip', 'ip_infos.ip');

        if(!empty($request->get('article_id'))){
            $query->where('article_id', '=', $request->get('article_id'));
        }

       $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;
       $rows = $query->orderBy('article_visitors.id', 'desc')->paginate($limit);
       $rows = $rows->appends($request->all());

       $article = Article::query()->where('status', '=', 1)->where('is_draft', '=', 0)->get();

       return view('article.visitor-index')->with(['rows' => $rows, 'pageSizes' => $this->pageSizes, 'articles' => $article]);
   }
}