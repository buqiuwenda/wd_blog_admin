@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>新增菜单 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                @include('errors.error')
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{ route('menu.store') }}">
                        @csrf
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">菜单名 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" placeholder="菜单名，如：用户管理" value="{{ old('name') }}" maxlength="128">
                            </div>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">父级菜单 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <select name="parent_id" class="form-control m-b">
                                    <option value="">请选择</option>
                                    <option value="0">无</option>
                                    @if($menus)
                                    @foreach($menus as $menu)
                                        <option @if(old('parent_id') == $menu->id) selected @endif value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            @if ($errors->has('parent_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('parent_id') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('routing') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">路由别名 </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="routing" placeholder="路由别名，如：member.index" value="{{ old('routing') }}" maxlength="255">
                            </div>

                            @if ($errors->has('routing'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('routing') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('icon_class') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">菜单图标 </label>
                            <div class="col-sm-4">
                                <select name="icon_class" class="form-control m-b">
                                    <option value="">请选择</option>
                                    <option value="fa-th-large"> fa-th-large</option>
                                </select>
                            </div>

                            @if ($errors->has('icon_class'))
                                <span class="help-block">
                                <strong>{{ $errors->first('icon_class') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white" type="button" onclick="history.back()"><i class="fa fa-mail-reply"></i> 取消</button>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-cloud-upload"></i> 保存</button>

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
