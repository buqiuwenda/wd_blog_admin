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
use App\Model\Role;
use Illuminate\Validation\Rule;

class RoleController extends ResetController
{

    public function index(Request $request)
    {
        $query = Role::query();

        if(!empty($request->get('status'))){
            $query->where('status', '=', $request->get('status'));
        }

        if(!empty($request->get('name'))){
            $query->where('name', 'like', '%'.$request->get('name').'%')
                ->orWhere('alias', 'like', '%'.$request->get('alias').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;

        $rows = $query->orderBy('id', 'desc')->paginate($limit);

        $rows = $rows->appends($request->toArray());

        return view('system.role-index')->with(['rows' => $rows, 'pageSizes' => $this->pageSizes, 'status' => $this->ableStatus]);
    }


    public function show($id)
    {

    }


    public function create()
    {
        return view('system.role-create')->with(['status' => $this->ableStatus]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:64|unique:rbac_roles',
            'alias' => 'required|string|max:64|unique:rbac_roles',
            'meta_description' => 'required|string|max:255',
            'status' => 'required|string|in:enable,disable',
            'nodes'  => 'required|string'
        ]);


        $data = $request->all();

        $roles = new Role();
        $roles->fill($data);
        $id = $roles->save();

        if(!$id){
            return back()->withErrors(['msg' => '创建失败']);
        }else{
            $model = Role::find($id);
           $model->nodes()->sync(array_unique(explode(",",$data['nodes'])));
        }

        return redirect()->route('role.index');

    }


    public function edit($id)
    {
        $row = Role::query()->with('nodes')->find($id);
        if(empty($row)){
            abort(404);
        }

        $nodes = $row->getRelation('nodes');

        $node_ids = [];

        foreach($nodes->toArray() as $val){
            $node_ids[] = $val['id'];
        }

        return view('system.role-edit')->with(['row' => $row, 'node_ids' => implode(',',$node_ids), 'status' => $this->ableStatus]);

    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('rbac_roles')->ignore($id),
                'max:64'
            ],
            'alias' => [
                'required',
                Rule::unique('rbac_roles')->ignore($id),
                'max:64'
            ],
            'meta_description' => 'required|string|max:255',
            'status' => 'required|string|in:enable,disable',
            'nodes'  => 'required|string'
        ]);

        $row = Role::query()->find($id);
        if(empty($row)){
            abort('500');
        }

        $params = $request->all();
        $data = [
           'name' => $params['name'],
           'alias' => $params['alias'],
           'meta_description' => $params['meta_description'],
           'status' => $params['status']
        ];

        $id = Role::query()->where('id', '=', $id)->update($data);
        if(!$id){
            return back()->withErrors(['msg' => '编辑失败']);
        }else{
            $row->nodes()->sync(array_unique(explode(",",$params['nodes'])));
        }

        return redirect()->route('role.index');
    }


    public function destroy($id)
    {

    }

}