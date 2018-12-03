@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>编辑类别 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                @include('errors.error')
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{ route('category.update') }}">
                        @csrf
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">类别名称 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" placeholder="类别名称，如：PHP" value="@if(old('name')) {{ old('name') }} @else {{$row->name}}  @endif" maxlength="128">
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
                                    <option value="0" @if($row->parent_id == 0) selected @endif>无</option>
                                    @if($parents)
                                    @foreach($parents as $key =>$parent)
                                        <option @if(old('parent_id') == $key || $row->parent_id == $key) selected @endif value="{{ $key }}">{{ $parent }}</option>
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

                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">描述 </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="description" placeholder="描述" value="@if(old('description')) {{ old('description') }} @else {{ $row->description }}  @endif" maxlength="255">
                            </div>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
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
