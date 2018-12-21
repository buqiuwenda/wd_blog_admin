@extends('layouts.app')

@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>菜单信息</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">菜单名</label>
                            <div class="col-sm-4"><p class="form-control-static">{{ $row->name }}</p></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">父级菜单</label>
                            <div class="col-sm-4"><p class="form-control-static">
                                 @if($row->parent_id == 0) 无 @else {{$parents[$row->parent_id]}}  @endif</p></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">路由别名</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->routing}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">菜单图标</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->icon_class }}</p>
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
                                <a class="btn btn-primary" href="{{ route('menu.edit', $row) }}"><i class="fa fa-edit"></i> 编辑</a>
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
                radioClass: 'iradio_square-green',
            });
        });
    </script>

@endsection