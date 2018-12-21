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
use App\Model\Node;

class NodeController extends ResetController
{

    public function index(Request $request)
    {
        $query = Node::query();
        if(!empty($request->get('name'))){
            $query->where('name', 'like', '%'.$request->get('name').'%')
              ->orWhere('routing', 'like', '%'.$request->get('name').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;

        $rows = $query->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        return view('system.node-index')
            ->with(['rows' => $rows, 'parents' => $this->getParents(), 'pageSizes' => $this->pageSizes, 'status' => $this->ableStatus]);
    }


    public function show($id)
    {
        $row = Node::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('system.node-show')
            ->with(['row' => $row, 'parents' => $this->getParents(), 'status' => $this->ableStatus]);
    }


    public function create()
    {
        $nodes = Node::query()->where('parent_id', '=', 0)->get();

        return view('system.node-create')->with(['nodes' => $nodes, 'status' => $this->ableStatus]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:128',
            'parent_id' => 'required|integer|min:0',
            'routing'   => 'required|string|max:255',
            'status'    => 'required|string|in:enable,disable',
            'memo'      => 'required|string|max:255'
        ]);

        $data = $request->all();

        $model = new Node();
        $model->fill($data);
        $id = $model->save();
        if(!$id){
            return back()->withErrors(['msg' => '创建失败']);
        }

        return redirect()->route('node.index');
    }


    public function edit($id)
    {
        $row = Node::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        $nodes = Node::query()->where('parent_id', '=', 0)->get();

        return view('system.node-edit')
            ->with(['row' => $row, 'nodes' => $nodes, 'status' => $this->ableStatus]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:128',
            'parent_id' => 'required|integer|min:0',
            'routing'   => 'required|string|max:255',
            'status'    => 'required|string|in:enable,disable',
            'memo'      => 'required|string|max:255'
        ]);

        $row = Node::query()->find($id);
        if(empty($row)){
            abort(404);
        }

        $params = $request->all();
        $info = Node::query()->where('name', '=', $params['name'])->where('routing', '=', $params['routing'])
            ->where('id', '<>', $id)->first();
        if($info){
            return back()->withErrors(['msg' => '节点名称和路由别名必须唯一']);
        }

        $data = [
           'name' => $params['name'],
           'parent_id' => $params['parent_id'],
           'routing' => $params['routing'],
           'status' => $params['status'],
           'memo'  => $params['memo']
        ];


        $id = Node::query()->where('id', '=', $id)->update($data);
        if(!$id){
            return back()->withErrors(['msg' => '编辑失败']);
        }

        return redirect()->route('node.index');
    }


    public function destroy($id)
    {
        $row = Node::query()->find($id);
        if(empty($row)){
            abort(404);
        }

        $id = Node::query()->where('id', '=', $id)->delete();
        if(!$id){
            return back()->withErrors(['msg' => '删除失败']);
        }

        return redirect()->route('node.index');
    }


    private function getParents()
    {
        $menus = Node::query()->where('parent_id', '=', 0)->get();
        $parents = [];
        if($menus){
            foreach($menus->toArray() as $val){
                $parents[$val['id']] = $val['name'];
            }
        }

        return $parents;
    }
}