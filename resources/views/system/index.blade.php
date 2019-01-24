@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/zTreeStyle.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>系统信息 </h5>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" >
                        <div class="form-group">
                            <label class="col-sm-2 control-label">服务器名称</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['server'] }}</p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">域名</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['http_host'] }}</p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">IP地址</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['remote_host'] }}</p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">UserAgent</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['user_agent'] }}</p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">PHP版本</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['php'] }}</p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">PHP管理</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['sapi_name'] }}</p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">PHP拓展</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['extensions'] }}</p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">数据库</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['db_connection'] }}</p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">数据库库名</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['db_database'] }}</p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">数据库版本</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $data['db_version'] }}</p>
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
    <script src="{{ asset('js/jquery.ztree.core.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ztree.excheck.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

        });
    </script>

@endsection
