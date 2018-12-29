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
use App\Model\Member;
use App\Model\Role;
use Identicon\Identicon;
use Illuminate\Support\Facades\Hash;
use Log;

class MemberController extends ResetController
{

    public function index(Request $request)
    {
        $query = Member::query();

        if(!empty($request->get('status'))){
            $query->where('status', '=', $request->get('status'));
        }

        if(!empty($request->get('name'))){
            $query->where('name', 'like', '%'.$request->get('name').'%')
            ->orWhere('nickname', 'like', '%'.$request->get('name').'%')
            ->orWhere('email', 'like', '%'.$request->get('name').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;
        $rows = $query->with('roles')->orderBy('id', 'desc')->paginate($limit);

        $rows = $rows->appends($request->toArray());
        return view('system.member-index')->with(['rows' => $rows, 'pageSizes' => $this->pageSizes, 'status' => $this->ableStatus]);
    }


    public function show($id)
    {
        $row = Member::query()->with('roles')->find($id);

        if(empty($row)){
            abort('404');
        }

        return view('system.member-show')->with(['row' => $row, 'status' => $this->ableStatus]);
    }


    public function create()
    {
        $roles = Role::query()->where('status', '=', 'enable')->get();

        return view('system.member-create')->with(['roles' => $roles, 'status' => $this->ableStatus]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:64',
            'nickname' => 'required|string|max:64',
            'email'   => 'required|string|email|max:255|unique:members',
            'status'    => 'required|string|in:enable,disable',
            'password' => 'required|string|confirmed|regex:/^(?![0-9]+$)(?![A-Za-z]+$)[0-9A-Za-z!@#$%^&*)(]{6,16}$/',
        ]);

        $data = $request->all();

        $model = Member::create([
                                 'name' => $data['name'],
                                 'email' => $data['email'],
                                 'nickname' => $data['nickname'],
                                 'password' => Hash::make($data['password']),
                                 'avatar' => (new Identicon())->getImageDataUri($data['name'], 256),
                                 'status' => $data['status']
                             ]);

        if(!$model){
            return back()->withErrors(['msg' => '创建失败']);
        }else{
            if(!empty($data['role_id'])){
                $model->roles()->sync([$data['role_id']]);
            }
        }

        return redirect()->route('member.index');
    }


    public function edit($id)
    {
        $row = Member::query()->with('roles')->find($id);

        if(empty($row)){
            abort('404');
        }

        $roles = Role::query()->get();

        return view('system.member-edit')->with(['row' => $row,'roles' => $roles, 'status' => $this->ableStatus]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:64',
            'nickname' => 'required|string|max:64',
            'status'    => 'required|string|in:enable,disable',
        ]);


        $row = Member::query()->find($id);
        if(empty($row)){
           abort(404);
        }

        $params = $request->all();

        $data = [
           'name' => $params['name'],
           'nickname' => $params['nickname'],
           'status' => $params['status']
        ];

        $id = Member::query()->where('id', '=', $id)->update($data);

        if(!$id){
            return back()->withErrors(['msg' => '编辑失败']);
        }else{
            if($params['role_id']){
               $row->roles()->sync([$params['role_id']]);
            }
        }

        return redirect()->route('member.index');
    }

}