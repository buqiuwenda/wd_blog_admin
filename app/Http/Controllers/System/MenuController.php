<?php
/**
 * Class MemberController
 * @package App\Http\Controllers\Member
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/6 10:10 AM
 */
namespace App\Http\Controllers\System;

use App\Http\Controllers\ResetController;
use Illuminate\Http\Request;
use App\Model\Menu;
use Illuminate\Validation\Rule;

class MenuController extends ResetController
{

    public function index(Request $request)
    {
        $query = Menu::query();
        if(!empty($request->get('name'))){
            $query->where('name', 'like', '%'.$request->get('name').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;

        $rows = $query->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        return view('system.menu-index')->with(['rows' => $rows, 'parents' => $this->getParents(), 'pageSizes' => $this->pageSizes]);
    }


    public function show($id)
    {
        $row = Menu::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('system.menu-show')->with(['row' => $row, 'parents' => $this->getParents()]);
    }


    public function create()
    {
        $menus = Menu::query()->where('parent_id', '=', 0)->get();

        return view('system.menu-create')->with(['menus' => $menus]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:128',
            'parent_id' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if($data['parent_id'] != 0 && empty($data['routing'])){
            return back()->withErrors(['msg' => '有父级菜单路由别名不能为空']);
        }

        if($data['parent_id'] == 0 && empty($data['icon_class'])){
            return back()->withErrors(['msg' => '没有父级菜单菜单图标不能为空']);
        }

        if(empty($data['routing'])){
            $data['routing'] = '#';
        }

        $model = new Menu();
        $model->fill($data);
        $id = $model->save();
        if(!$id){
            return back()->withErrors(['msg' => '创建失败']);
        }

        return redirect()->route('menu.index');

    }


    public function edit($id)
    {
        $row = Menu::query()->find($id);
        if(empty($row)){
            abort(404);
        }

        $menus = Menu::query()->where('parent_id', '=', 0)->get();

        return view('system.menu-edit')->with(['row' => $row, 'menus' => $menus]);

    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('menus')->ignore($id),
                'max:64'
            ],
            'parent_id' => 'required|integer|min:0',
        ]);

        $row = Menu::query()->find($id);
        if(empty($row)){
            abort(404);
        }

        $data = $request->all();

        if($data['parent_id'] != 0 && empty($data['routing'])){
            return back()->withErrors(['msg' => '有父级菜单路由别名不能为空']);
        }

        if($data['parent_id'] == 0 && empty($data['icon_class'])){
            return back()->withErrors(['msg' => '没有父级菜单菜单图标不能为空']);
        }

        if(empty($data['routing'])){
            $data['routing'] = '#';
        }

        $update = [
           'name' => $data['name'],
           'parent_id' => $data['parent_id'],
           'routing' => $data['routing'],
           'icon_class' => $data['icon_class']
        ];

        $id = Menu::query()->where('id', '=', $id)->update($update);

        if(!$id){
            return back()->withErrors(['msg' => '更新失败']);
        }

        return redirect()->route('menu.index');
    }


    public function destroy($id)
    {
        $row = Menu::query()->find($id);
        if(empty($row)){
            abort(404);
        }

        $id = Menu::query()->where('id', '=', $id)->delete();
        if(!$id){
            return back()->withErrors(['msg' => '删除失败']);
        }

        return redirect()->route('menu.index');
    }



    private function getParents()
    {
        $menus = Menu::query()->where('parent_id', '=', 0)->get();
        $parents = [];
        if($menus){
            foreach($menus->toArray() as $val){
                $parents[$val['id']] = $val['name'];
            }
        }

        return $parents;
    }


}