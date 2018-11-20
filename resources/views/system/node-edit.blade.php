@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>编辑节点 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                @include('errors.error')
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{ route('node.update', $row) }}">
                        {{ method_field('put') }}
                        @csrf
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">节点名称 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" placeholder="节点名称，如：用户管理" value="@if(old('name')) {{ old('name') }} @else {{$row->name}} @endif" maxlength="128">
                            </div>
                            @if($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">父级菜单 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <select name="parent_id" class="form-control m-b">
                                    <option value="0">无</option>
                                    @if($nodes)
                                    @foreach($nodes as $node)
                                        <option @if($row->parent_id == $node->id || old('parent_id') == $node->id) selected @endif value="{{ $node->id }}">{{ $node->name }}</option>
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
                                <input type="text" class="form-control" name="routing" placeholder="路由别名，如：member.index" value="@if(old('routing')) {{ old('routing') }} @else {{ $row->routing }} @endif" maxlength="255">
                            </div>

                            @if ($errors->has('routing'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('routing') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('memo') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">备注 <small class="text-danger">[*]</small> </label>
                            <div class="col-sm-4"><textarea name="memo" rows="5"  class="form-control "> @if(old('memo')) {{ old('memo') }} @else  {{ $row->memo }} @endif</textarea></div>
                            @if ($errors->has('memo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('memo') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">状态 </label>
                            <div class="col-sm-4">
                                @foreach($status as $key =>$state)
                                    <label class="radio-inline">
                                        <input type="radio" name="status"  @if(old('status') == $key || $row->status == $key) checked @endif value="{{ $key }}"> {{ $state['name'] }}
                                    </label>
                                @endforeach
                            </div>

                            @if ($errors->has('status'))
                                <span class="help-block">
                                <strong>{{ $errors->first('status') }}</strong>
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
