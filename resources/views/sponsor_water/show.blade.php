@extends('layouts.app')

@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>赞助信息</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->nickname}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">金额</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ fen_to_yuan($row->amount)}} 元</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">支付方式</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $pay_modes[$row->pay_mode]}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类别</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $types[$row->type]}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">赞助日期</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->sponsor_date}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-4">
                                <textarea name="remark" rows="5"  class="form-control " readonly> {{ $row->remark }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">添加人</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->members->name}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">最后修改人</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->lastMembers->name}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <span><i class="fa fa-circle {{ $status[$row->status]['class'] }}"></i> {{ $status[$row->status]['name'] }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">创建时间</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->created_at }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">更新时间</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->updated_at }}</p>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-primary" href="{{ route('sponsor_water.edit', $row) }}"><i class="fa fa-edit"></i> 编辑</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footer')

    <!-- iCheck -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        });
    </script>

@endsection