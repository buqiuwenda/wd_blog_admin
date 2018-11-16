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
            $query->where('name', 'like', '%'.$request->get('name').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;

        $rows = $query->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        return view('system.menu-index')->with(['rows' => $rows, 'parents' => $this->getParents(), 'pageSizes' => $this->pageSizes]);
    }


    public function show($id)
    {

    }


    public function create()
    {
        $nodes = Node::query()->where('parent_id', '=', 0)->get();

        return view('system.node-create')->with(['nodes' => $nodes]);
    }


    public function store(Request $request)
    {

    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {

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