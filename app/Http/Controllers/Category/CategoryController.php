<?php
/**
 * Class TagController
 * @package App\Http\Controllers\Tag
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/30 5:36 PM
 */
namespace App\Http\Controllers\Category;

use App\Http\Controllers\ResetController;
use Illuminate\Http\Request;
use App\Model\Category;

class CategoryController extends ResetController
{
    public function index(Request $request)
    {
        $query = Category::query();

        if(!empty($request->get('keyword'))){
            $query->where('name', 'like', '%'.$request->get('keyword').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;

        $rows = $query->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        return view('category.index')->with(['rows' => $rows, 'pageSizes' => $this->pageSizes, 'parents' => $this->getParents()]);
    }

    public function show($id)
    {
        $row = Category::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('category.show')->with(['row' => $row, 'parents' => $this->getParents()]);
    }

    public function create()
    {

        return view('category.create')->with(['parents' => $this->getParents()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:64',
            'parent_id' => 'required|integer|min:0',
            'description' => 'required|string|max:255',
        ]);

        $params = $request->toArray();
        if($params['parent_id'] != 0){
            $row = Category::query()->find($params['parent_id']);

            $params['path'] = $row['path'].','.$params['parent_id'];
            $params['level'] = $row['level'] +1;
        }else{
            $params['path'] = '0';
            $params['level'] = 1;
        }

        $model = new Category();
        $model->fill($params);
        $id =  $model->save();

        if(!$id){
            return back()->withErrors(['msg' => '创建失败']);
        }

        return redirect()->route('category.index');

    }


    public function edit($id)
    {
        $row = Category::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('category.edit')->with(['row' => $row, 'parents' => $this->getParents()]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:64',
            'parent_id' => 'required|integer|min:0',
            'description' => 'required|string|max:255',
        ]);

        $info = Category::query()->find($id);

        if(empty($info)){
            abort(404);
        }

        $params = $request->all();

        if($params['parent_id'] == $id){
            return back()->withErrors(['msg' => '父级类别不可用']);
        }

        if($params['parent_id'] != 0){
            $row = Category::query()->find($params['parent_id']);

            $params['path'] = $row['path'].','.$params['parent_id'];
            $params['level'] = $row['level'] +1;
        }else{
            $params['path'] = '0';
            $params['level'] = 1;
        }

        $data = [
           'name' => $params['name'],
           'parent_id' => $params['parent_id'],
           'description' => $params['description'],
           'path' => $params['path'],
           'level' => $params['level']
        ];

        $id = Category::query()->where('id', '=', $id)->update($data);
        if(!$id){
            return back()->withErrors(['msg' => '编辑失败']);
        }

        return redirect()->route('category.index');
    }

    public function destroy($id)
    {

    }

    private function getParents()
    {
        $menus = Category::query()->where('parent_id', '=', 0)->get();
        $parents = [];
        if($menus){
            foreach($menus->toArray() as $val){
                $parents[$val['id']] = $val['name'];
            }
        }

        return $parents;
    }
}