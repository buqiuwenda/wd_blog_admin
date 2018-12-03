<?php
/**
 * Class TagController
 * @package App\Http\Controllers\Tag
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/30 5:36 PM
 */
namespace App\Http\Controllers\Tag;

use App\Http\Controllers\ResetController;
use Illuminate\Http\Request;
use App\Model\Tag;

class TagController extends ResetController
{
    public function index(Request $request)
    {
        $query = Tag::query();

        if(!empty($request->get('keyword'))){
            $query->where('tag', 'like', '%'.$request->get('keyword').'%')
                ->orWhere('title', 'like', '%'.$request->get('keyword').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;

        $rows = $query->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        return view('tag.index')->with(['rows' => $rows, 'pageSizes' => $this->pageSizes]);
    }

    public function show($id)
    {
        $row = Tag::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('tag.show')->with(['row' => $row]);
    }

    public function create()
    {
        return view('tag.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tag' => 'required|string|max:64',
            'title' => 'required|string|max:128',
            'meta_description' => 'required|string|max:255',
        ]);

        $model = new Tag();
        $model->fill($request->toArray());
        $id =  $model->save();

        if(!$id){
            return back()->withErrors(['msg' => '创建失败']);
        }

        return redirect()->route('tag.index');

    }


    public function edit($id)
    {
        $row = Tag::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('tag.edit')->with(['row' => $row]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tag' => 'required|string|max:64',
            'title' => 'required|string|max:128',
            'meta_description' => 'required|string|max:255',
        ]);

        $row = Tag::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        $params = $request->all();

        $data = [
           'tag' => $params['tag'],
           'title' => $params['title'],
           'meta_description' => $params['meta_description']
        ];

        $id = Tag::query()->where('id', '=', $id)->update($data);
        if(!$id){
            return back()->withErrors(['msg' => '编辑失败']);
        }

        return redirect()->route('tag.index');
    }

    public function destroy($id)
    {

    }
}