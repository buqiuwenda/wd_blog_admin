@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>编辑赞助 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                @include('errors.error')
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{ route('sponsor_water.update', $row) }}">
                        {{ method_field('put') }}
                        @csrf


                        <div class="form-group {{ $errors->has('nickname') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">昵称 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nickname" placeholder="昵称" value="@if(old('nickname')){{ old('nickname') }}@else{{$row->nickname}} @endif" maxlength="255">
                            </div>
                            @if($errors->has('nickname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nickname') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">金额<small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="amount" placeholder="金额单位分" value="@if(old('amount')){{ old('amount') }}@else{{ $row->amount }}@endif" maxlength="10">
                            </div>

                            @if ($errors->has('amount'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('pay_mode') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">支付方式 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <select class="form-control m-b input-sm"  name="pay_mode" >
                                    <option value="">支付方式</option>
                                    @foreach($pay_modes as $key =>$pay_mode)
                                        <option @if(old('pay_mode') == $key || $row->pay_mode == $key) selected @endif value="{{ $key }}">{{ $pay_mode }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($errors->has('pay_mode'))
                                <span class="help-block">
                                <strong>{{ $errors->first('pay_mode') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">类别<small class="text-danger">[*]</small> </label>
                            <div class="col-sm-4">
                                <select class="form-control m-b input-sm"  name="type" >
                                    <option value="">类别</option>
                                    @foreach($types as $key =>$type)
                                        <option @if(old('type') == $key || $row->type == $key) selected @endif value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($errors->has('type'))
                                <span class="help-block">
                                <strong>{{ $errors->first('type') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('sponsor_date') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">赞助日期<small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control datepicker" name="sponsor_date" placeholder="赞助日期" data-provide="datepicker" value="@if(old('sponsor_date')){{ old('sponsor_date') }}@else{{ $row->sponsor_date }} @endif" >
                            </div>

                            @if ($errors->has('sponsor_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sponsor_date') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('remark') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">备注 <small class="text-danger">[*]</small> </label>
                            <div class="col-sm-4"><textarea name="remark" rows="5"  class="form-control "> @if(old('remark')){{ old('remark') }}@else{{$row->remark}}@endif</textarea></div>
                            @if ($errors->has('remark'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('remark') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">状态 </label>
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
    <script src="{{ asset('js/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $('.datepicker').datepicker({
                weekStart: 1,
                todayBtn:  true,
                autoclose: true,
                todayHighlight: 1,
                format: 'yyyy-mm-dd',
                startDate: '-30d'
            });

        });
    </script>

@endsection
