<?php
/**
 * Class SponsorWaterController
 * @package App\Http\Controllers\Other
 * Author:huangzhongxi@rockfintech.com
 * Date: 2019/5/23 2:44 PM
 */
namespace App\Http\Controllers\Other;

use App\Http\Controllers\ResetController;
use App\Model\Member;
use Illuminate\Http\Request;
use App\Model\SponsorWater;
use Illuminate\Support\Facades\Auth;

class SponsorWaterController extends ResetController
{
    private $type = [
       'personal' => '个人',
       'company'  => '企业',
    ];


    private $payMode = [
      'alipay' => '支付宝',
      'weixin' => '微信'
    ];

    public function index(Request $request)
    {
        $query = SponsorWater::query();

        if($request->get('status') !== null){
            $query->where('status', '=', $request->get('status'));
        }

        if($request->get('member_id')){
            $query->where('member_id', $request->get('member_id'));
        }

        if($request->get('type')){
            $query->where('type', $request->get('type'));
        }

        if($request->get('pay_mode')){
            $query->where('pay_mode', $request->get('pay_mode'));
        }

        if($request->get('start_time')){
            $query->where('sponsor_date', '>=',$request->get('start_time'));
        }

        if($request->get('end_time')){
            $query->where('sponsor_date', '<=',$request->get('end_time'));
        }

        $limit = !empty($request->get('limit')) ? $request->get('limit') : 25;

        $rows = $query->orderBy('sponsor_date', 'desc')->orderBy('id', 'desc')->paginate($limit);
        $rows = $rows->appends($request->toArray());

        $members = Member::query()->get();

        return view('sponsor_water.index')->with(['rows' => $rows,
                                             'pageSizes' => $this->pageSizes,
                                             'members' => $members,
                                             'status' => $this->successStatus,
                                             'types' => $this->type,
                                             'pay_modes' => $this->payMode
                                            ]);
    }

    public function show($id)
    {
        $row = SponsorWater::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('sponsor_water.show')->with([
            'row' => $row,
            'status' => $this->successStatus,
            'types' => $this->type,
            'pay_modes' => $this->payMode

                                                ]);
    }

    public function create()
    {
        return view('sponsor_water.create',
                    [
                        'status' => $this->successStatus,
                        'types' => $this->type,
                        'pay_modes' => $this->payMode

                    ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nickname' => 'required|string|max:255',
            'amount' => 'required|min:1',
            'pay_mode' => 'required|string|in:alipay,weixin',
            'type' => 'required|string|in:personal,company',
            'sponsor_date' => 'required|date',
            'remark' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        $params = $request->toArray();
        $params['member_id'] = Auth::id();
        $params['last_member_id'] = Auth::id();

        $model = new SponsorWater();
        $model->fill($params);
        $id =  $model->save();

        if(!$id){
            return back()->withErrors(['msg' => '创建失败']);
        }

        return redirect()->route('sponsor_water.index');
    }


    public function edit($id)
    {
        $row = SponsorWater::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        return view('sponsor_water.edit')->with([
            'row' => $row,
            'status' => $this->successStatus,
            'types' => $this->type,
            'pay_modes' => $this->payMode
             ]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nickname' => 'required|string|max:255',
            'amount' => 'required|min:1',
            'pay_mode' => 'required|string|in:alipay,weixin',
            'type' => 'required|string|in:personal,company',
            'sponsor_date' => 'required|string',
            'remark' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        $row = SponsorWater::query()->find($id);

        if(empty($row)){
            abort(404);
        }

        $params = $request->all();

        $data = [
            'nickname' => $params['nickname'],
            'amount' => $params['amount'],
            'pay_mode' => $params['pay_mode'],
            'type' => $params['type'],
            'sponsor_date' => $params['sponsor_date'],
            'remark' => $params['remark'],
            'status' => $params['status']
        ];

        $id = SponsorWater::query()->where('id', '=', $id)->update($data);
        if(!$id){
            return back()->withErrors(['msg' => '编辑失败']);
        }

        return redirect()->route('sponsor_water.index');
    }

    public function destroy($id)
    {

    }
}