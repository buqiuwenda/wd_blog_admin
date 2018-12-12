<?php
/**
 * Class ArticleController
 * @package App\Http\Controllers\Article
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/12/3 4:10 PM
 */
namespace App\Http\Controllers\Article;

use App\Http\Controllers\ResetController;
use Illuminate\Http\Request;
use App\Model\Article;

class ArticleController extends  ResetController
{

    public function index(Request $request)
    {
        $query = Article::query();

        if(!empty($request->get('category_id'))){
            $query->where('category_id', '=', $request->get('category_id'));
        }

        if(!empty($request->get('member_id'))){
            $query->where('member_id', '=', $request->get('member_id'));
        }

        if(!empty($request->get('is_original'))){
            $query->where('is_original', '=', $request->get('is_original'));
        }

        if(!empty($request->get('keyword'))){
            $query->where('title','like', '%'.$request->get('keyword').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;
        $rows = $query->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        return view('article.index')->with(['rows' => $rows,
                                    'pageSizes' => $this->pageSizes,
                                     'members' => $this->getList('member'),
                                    'categorys' => $this->getList(),
                                     'status' => $this->status]);
    }

    public function show($id)
    {
        $row = Article::query()->find($id);
        if(empty($row)){
            abort(404);
        }

        return view('article.show')->with(['row' => $row,
                                           'members' => $this->getList('member'),
                                           'categorys' => $this->getList()]);
    }

    public function create()
    {
        return view('article.create')->with(['members' => $this->getList('member'),
                                                'categorys' => $this->getList(),
                                                'tag' => $this->getTagList()]);
    }

    public function store(Request $request)
    {

    }


    public function edit($id)
    {

    }

    public function update(Request $request , $id)
    {

    }

    public function destroy($id)
    {

    }

}