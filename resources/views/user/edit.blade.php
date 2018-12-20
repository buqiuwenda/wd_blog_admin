@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>编辑用户 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                @include('errors.error')
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{ route('user.update', $row) }}">
                        {{ method_field('put') }}
                        @csrf
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">用户名称 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->name }}</p>
                            </div>

                        </div>

                        <div class="form-group ">
                            <label class="col-sm-2 control-label">昵称 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->nickname }}</p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">邮箱 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->email }}</p>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">状态 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                @foreach($status as $key =>$state)
                                    <label class="radio-inline">
                                        <input type="radio" name="status"  @if($row->status == $key) checked @endif value="{{ $key }}"> {{ $state['name'] }}
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
                radioClass: 'iradio_square-green'
            });
        });
    </script>

@endsection
