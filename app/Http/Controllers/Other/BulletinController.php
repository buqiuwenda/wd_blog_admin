<?php
/**
 * Class Bulletin
 * @package App\Http\Controllers\Bulletin
 * Author:huangzhongxi@rockfintech.com
 * Date: 2019/5/23 2:44 PM
 */
namespace App\Http\Controllers\Other;

use App\Http\Controllers\ResetController;
use App\Model\Member;
use Illuminate\Http\Request;
use App\Model\Bulletin;
use Illuminate\Support\Facades\Auth;

class BulletinController extends ResetController
{
    public function index(Request $request)
    {
        $query = Bulletin::query();

        if($request->get('status') !== null){
            $query->where('status', '=', $request->get('status'));
        }

        if($request->get('member_id')){
            $query->where('member_id', $request->get('member_id'));
        }

        if(!empty($request->get('keyword'))){
            $query->where('tag', 'like', '%'.$request->get('keyword').'%');
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;

        $rows = $query->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        $members = Member::query()->get();

        return view('bulletin.index')->with(['rows' => $rows,
                                             'pageSizes' => $this->pageSizes,
                                             'members' => $members,
                                             'status' => $this->status
                                            ]);
    }

    public function show($id)
    {
        $row = Bulletin::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('bulletin.show')->with(['row' => $row, 'status' => $this->status]);
    }

    public function create()
    {
        return view('bulletin.create', ['status' => $this->status]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:32',
            'context' => 'required|string',
            'status' => 'required|in:0,1'
        ]);

        $params = $request->toArray();
        $params['member_id'] = Auth::id();
        $params['last_member_id'] = Auth::id();

        $model = new Bulletin();
        $model->fill($params);
        $id =  $model->save();

        if(!$id){
            return back()->withErrors(['msg' => '创建失败']);
        }

        return redirect()->route('bulletin.index');

    }


    public function edit($id)
    {
        $row = Bulletin::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('bulletin.edit')->with(['row' => $row, 'status' => $this->status]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:32',
            'context' => 'required|string',
            'status' => 'required|in:0,1'
        ]);

        $row = Bulletin::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        $params = $request->all();

        $data = [
            'title' => $params['title'],
            'context' => $params['context'],
            'status' => $params['status'],
            'last_member_id' => Auth::id()
        ];

        $id = Bulletin::query()->where('id', '=', $id)->update($data);
        if(!$id){
            return back()->withErrors(['msg' => '编辑失败']);
        }

        return redirect()->route('bulletin.index');
    }

    public function destroy($id)
    {

    }
}