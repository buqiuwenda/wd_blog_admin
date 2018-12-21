<?php
/**
 * Class UserController
 * @package App\Http\Controllers\User
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/12/3 4:38 PM
 */
namespace App\Http\Controllers\User;

use App\Http\Controllers\ResetController;
use Illuminate\Http\Request;
use App\Model\User;

class UserController extends ResetController
{

    public function index(Request $request)
    {
        $query = User::query();

        if(!empty($request->get('keyword'))){
            $query->where('name', 'like', '%'.$request->get('keyword').'%')
                ->orWhere('email', 'like', '%'.$request->get('keyword').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;
        $rows = $query->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        return view('user.index')->with(['rows' => $rows, 'status' => $this->ableStatus, 'pageSizes' => $this->pageSizes]);
    }

    public function show($id)
    {
        $row = User::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('user.show')->with(['row' => $row, 'status' => $this->ableStatus]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {
        $row = User::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('user.edit')->with(['row' => $row, 'status' => $this->ableStatus]);

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status'    => 'required|string|in:enable,disable',
        ]);

        $row = User::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        $params = $request->all();
        $data = [
           'status' => $params['status']
        ];

        $id = User::query()->where('id', '=', $id)->update($data);

        if(!$id){
            return back()->withErrors(['msg' => '编辑失败']);
        }

        return redirect()->route('user.index');
    }

    public function destroy($id)
    {

    }
}