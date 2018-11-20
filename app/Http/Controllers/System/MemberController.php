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

class MemberController extends ResetController
{

    public function index(Request $request)
    {
        $query = Member::query();
        if(!empty($request->get('name'))){
            $query->where('name', 'like', '%'.$request->get('name').'%')
            ->orWhere('nickname', 'like', '%'.$request->get('name').'%')
            ->orWhere('email', 'like', '%'.$request->get('name').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;

        $rows = $query->leftJoin('rbac_roleables','merchants.id', '=','rbac_roleables.roleable_id')
            ->leftJoin('rbac_roles', 'rbac_roleables.role_id', '=', 'rbac_roles.id')
            ->where('rbac_roleables.roleable_type', '=', 'member_role')
            ->select('member.*', 'rbac_roles.name')
            ->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        return view('system.member-index')->with(['rows' => $rows, 'pageSizes' => $this->pageSizes]);
    }


    public function show($id)
    {

    }


    public function create()
    {
        $roles = Role::query()->get();

        return view('system.member-create')->with(['roles' => $roles, 'status' => $this->ableStatus]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:64',
            'email'   => 'required|string|email|max:255|unique:members',
            'status'    => 'required|string|in:enable,disable',
            'password' => 'required|string|confirmed|regex:/^(?![0-9]+$)(?![A-Za-z]+$)[0-9A-Za-z!@#$%^&*)(]{6,16}$/',
        ]);

        $data = $request->all();

        if(!empty($data['nickname'])){
            if(strlen($data['nickname']) >= 64){
                return back()->withErrors(['msg' => 'nickname 长度超出']);
            }
        }else{
            $data['nickname'] = '';
        }


        $id = Member::create([
                                 'name' => $data['name'],
                                 'email' => $data['email'],
                                 'nickname' => $data['nickname'],
                                 'password' => Hash::make($data['password']),
                                 'avatar' => (new Identicon())->getImageDataUri($data['name'], 256),
                                 'status' => $data['status']
                             ]);

        if(!$id){
            return back()->withErrors(['msg' => '创建失败']);
        }

        return redirect()->route('member.index');
    }


    public function edit($id)
    {

    }


    public function update(Request $request)
    {

    }



}