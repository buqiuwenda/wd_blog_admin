@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>新增公告 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                @include('errors.error')
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{ route('bulletin.store') }}">
                        @csrf

                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">标题 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="title" placeholder="标题" value="{{ old('title') }}" maxlength="32">
                            </div>

                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('context') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">内容 <small class="text-danger">[*]</small> </label>
                            <div class="col-sm-4"><textarea name="context" rows="5"  class="form-control "> {{ old('context') }}</textarea></div>
                            @if ($errors->has('context'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('context') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">优先级 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="priority" placeholder="数字越大优先级越高" value="{{ old('priority') }}" maxlength="3">
                            </div>

                            @if ($errors->has('priority'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('priority') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">状态 </label>
                            <div class="col-sm-4">
                                @foreach($status as $key =>$state)
                                    <label class="radio-inline">
                                        <input type="radio" name="status"  @if($key == 1) checked @endif value="{{ $key }}"> {{ $state['name'] }}
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
