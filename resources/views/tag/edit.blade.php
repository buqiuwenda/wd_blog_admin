@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>编辑标签 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                @include('errors.error')
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{ route('tag.update', $row) }}">
                        {{ method_field('put') }}
                        @csrf
                        <div class="form-group {{ $errors->has('tag') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">标签 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="tag" placeholder="标签，如：PHP" value="@if(old('tag')) {{ old('tag') }} @else {{$row->tag}} @endif" maxlength="64">
                            </div>
                            @if($errors->has('tag'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tag') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">标题 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="title" placeholder="标题，如：PHP" value="@if(old('title')) {{ old('title') }} @else {{$row->title}} @endif" maxlength="128">
                            </div>
                            @if($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">描述 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="meta_description" placeholder="描述" value="@if(old('meta_description')) {{ old('meta_description') }} @else {{$row->meta_description}} @endif" maxlength="255">
                            </div>
                            @if($errors->has('meta_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('meta_description') }}</strong>
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
