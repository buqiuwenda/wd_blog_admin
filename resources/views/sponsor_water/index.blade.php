@extends('layouts.app')

@section('header')

    <link href="{{ asset('css/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>赞助管理 </h5>
                    <div class="ibox-tools">

                        分页: {{ $rows->perPage() }} / {{ $rows->lastPage() }} / {{ $rows->currentPage() }} 总计: {{ $rows->total() }}
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-2 m-b-xs">
                            <a href="{{ route('sponsor_water.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> 新增赞助</a>
                        </div>
                        <form action="{{ route('sponsor_water.index') }}" method="get">
                                <div class="col-sm-2">

                                    <select class="form-control m-b input-sm"  name="limit" >
                                        @foreach($pageSizes as $val)
                                            <option value="{{$val}}" @if(request('limit') == $val) selected @endif> 每页{{$val}}条</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <select class="form-control m-b input-sm"  name="type" >
                                        <option value="">类别</option>
                                        @foreach($types as $key =>$type)
                                            <option @if(request('type') == $key ) selected @endif value="{{ $key }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <select class="form-control m-b input-sm"  name="pay_mode" >
                                        <option value="">支付方式</option>
                                        @foreach($pay_modes as $key =>$pay_mode)
                                            <option @if(request('pay_mode') == $key) selected @endif value="{{ $key }}">{{ $pay_mode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control m-b input-sm"  name="member_id" >
                                        <option value="">添加人</option>
                                        @foreach($members as $member)
                                            <option value="{{$member->id}}" @if(request('member_id') == $member->id) selected @endif> {{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control m-b input-sm"  name="status" >
                                        <option value="">状态</option>
                                        @foreach($status as $key =>$state)
                                            <option @if(request('status') == $key && request('status') !== null) selected @endif value="{{ $key }}">{{ $state['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control"  name="start_time" value="{{ request('start_time') }}" placeholder="赞助时间">
                                        <div class="input-group-addon">to</div>
                                        <input type="text" class="form-control" name="end_time" value="{{request('end_time')}}" placeholder="赞助时间">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> 搜索</button>
                                        </span>
                                    </div>
                                </div>
                            </form>

                    </div>
                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>昵称</th>
                                <th>金额/元</th>
                                <th>支付方式</th>
                                <th>类别</th>
                                <th>赞助时间</th>
                                <th>状态</th>
                                <th>添加人</th>
                                <th>添加时间</th>
                                <th class="text-right">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td>
                                       {{ $row->nickname }}
                                    </td>
                                    <td>
                                       {{ fen_to_yuan($row->amount) }}元
                                    </td>
                                    <td>{{$pay_modes[$row->pay_mode] }}</td>
                                    <td>{{$types[$row->type] }}</td>
                                    <td>{{ $row->sponsor_date }}</td>
                                    <td>
                                        <span><i class="fa fa-circle {{ $status[$row->status]['class'] }}"></i> {{ $status[$row->status]['name'] }}</span>
                                    </td>
                                    <td>
                                        {{ $row->members->name }}
                                    </td>
                                    <td>
                                        {{ $row->created_at }}
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a class="btn-white btn btn-xs" href="{{ route('sponsor_water.show', $row) }}"><i class="fa fa-eye"></i> 查看</a>
                                            <a class="btn-white btn btn-xs" href="{{ route('sponsor_water.edit', $row) }}"><i class="fa fa-edit"></i> 编辑</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        @if(empty($rows->count()))

                            <h3 class="font-bold">找不到内容</h3>
                            <div class="error-desc">
                                当前页面没有内容，或搜索结果不存在, 请访问其它页面或更换关键词重新搜索
                            </div>

                        @endif

                        {!! $rows->links() !!}

                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('footer')
    <script src="{{ asset('js/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.input-daterange').datepicker({
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