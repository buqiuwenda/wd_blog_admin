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
use App\Tools\QiniuFileManager;
use Illuminate\Validation\Rule;

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
        $row = Article::query()->with('tags')->find($id);
        if(empty($row)){
            abort(404);
        }

        $qiniu = new QiniuFileManager();

        $fileInfo = $qiniu->getFileInfo($row['page_image']);
        if($fileInfo['status'] ==1 ){
            $files = json_encode($fileInfo['info']);
        }else{
            $files = '';
        }

        $tags = $row->getRelation('tags');

        $tagData = [];

        if($tags){
            foreach($tags->toArray() as $val){
                $tagData[] = $val['id'];
            }
        }

        $content = json_decode($row['content'], true);

        return view('article.show')->with(['row' => $row,
                                           'members' => $this->getList('member'),
                                           'categorys' => $this->getList(),
                                           'fileInfo' => $files,
                                           'tags' => $this->getTagList(),
                                           'tagData' => $tagData,
                                           'content' => $content['raw']
                                          ]);
    }

    public function create()
    {
        return view('article.create')->with(['members' => $this->getList('member'),
                                                'categorys' => $this->getList(),
                                                'tags' => $this->getTagList()]);
    }

    public function store(Request $request)
    {
       $this->validate($request, [
           'title' => 'required|string|max:255|unique:articles',
           'subtitle' => 'required|string|max:255|unique:articles',
           'page_image' => 'required|max:255',
           'category_id' => 'required|min:1',
           'meta_description' => 'required|string|max:255',
           'content' => 'required|string',
           'tags' => 'required',
           'published_at' => 'required|date',
           'is_original' => 'required|string|in:on,off',
           'is_draft' => 'required|string|in:on,off',
           'status' => 'required|string|in:on,off',
       ]);

       $params = $request->all();

       $params['member_id'] = \Auth::id();
       $params['last_member_id'] = \Auth::id();

       $params['is_original'] = str_replace(['on', 'off'], [1,0], $params['is_original']);
       $params['is_draft'] = str_replace(['on', 'off'], [1,0], $params['is_draft']);
       $params['status'] = str_replace(['on', 'off'], [1,0], $params['status']);

       $model = new Article();
       $model->fill($params);
       $id = $model->save();

       if($id){
           $model->tags()->sync($params['tags']);
           return redirect()->route('article.index');
       }else{
           return back()->withErrors(['msg' => '创建失败']);
       }

    }


    public function edit($id)
    {
        $row = Article::query()->with('tags')->find($id);
        if(empty($row)){
            abort(404);
        }

        $qiniu = new QiniuFileManager();

        $fileInfo = $qiniu->getFileInfo($row['page_image']);
        if($fileInfo['status'] ==1 ){
            $files = json_encode($fileInfo['info']);
        }else{
            $files = '';
        }
        $tags = $row->getRelation('tags');

        $tagData = [];

        if($tags){
            foreach($tags->toArray() as $val){
               $tagData[] = $val['id'];
            }
        }

        $content = json_decode($row['content'], true);

        return view('article.edit')->with(['row' => $row,
                                           'members' => $this->getList('member'),
                                           'categorys' => $this->getList(),
                                            'fileInfo' => $files,
                                           'tags' => $this->getTagList(),
                                              'tagData' => $tagData,
                                              'content' => $content['raw']]);
    }

    public function update(Request $request , $id)
    {

        $this->validate($request, [
            'title' =>  'required',
            Rule::unique('articles')->ignore($id),
            'max:255',
            'subtitle' => 'required',
            Rule::unique('articles')->ignore($id),
            'max:255',
            'page_image' => 'required|max:255',
            'category_id' => 'required|min:1',
            'meta_description' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'required',
            'published_at' => 'required|date',
            'is_original' => 'required|string|in:on,off',
            'is_draft' => 'required|string|in:on,off',
            'status' => 'required|string|in:on,off',
        ]);

        $row = Article::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        $params = $request->all();

        $params['last_member_id'] = \Auth::id();

        $params['is_original'] = str_replace(['on', 'off'], [1,0], $params['is_original']);
        $params['is_draft'] = str_replace(['on', 'off'], [1,0], $params['is_draft']);
        $params['status'] = str_replace(['on', 'off'], [1,0], $params['status']);

        $id = $row->update($params);
        if($id){
            $row->tags()->sync($params['tags']);
            return redirect()->route('article.index');
        }else{
            return back()->withErrors(['msg' => '编辑失败']);
        }
    }

    public function destroy($id)
    {

    }

}