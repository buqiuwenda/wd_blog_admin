@extends('layouts.app')

@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>评论信息</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-4"><p class="form-control-static">{{ $row->user->name }}</p></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">评论标题</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">  {{ $row->commentable->title }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">评论类型</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"> {{ $commentTypes[$row->commentable_type] }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">评论内容</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->content }}</p>
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
                                <a class="btn btn-primary" href="{{ route('tag.edit', $row) }}"><i class="fa fa-edit"></i> 编辑</a>
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