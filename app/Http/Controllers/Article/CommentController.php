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
use App\Model\Comment;

class CommentController extends ResetController
{
    protected $commentType = [
       'articles' => '文章'
    ];

    public function index(Request $request)
    {
        $query = new Comment();


        if(!empty($request->get('commentable_type'))){
            $query->where('commentable_type', '=', $request->get('commentable_type'));
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;
        $rows = $query->with('user','commentable')->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        return view('comment.index')->with(['rows' => $rows,
                                            'pageSizes' => $this->pageSizes,
                                            'status' => $this->status,
                                            'commentTypes' => $this->commentType
                                             ]);
    }


    public function show($id)
    {
        $row  = Comment::query()->with('user', 'commentable')->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('comment.show')->with(['row' => $row,
                                           'status' => $this->status,
                                           'commentTypes' => $this->commentType  ]);
    }
}