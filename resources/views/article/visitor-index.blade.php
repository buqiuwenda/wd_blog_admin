@extends('layouts.app')

@section('header')

    <link href="{{ asset('css/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>访问列表 </h5>
                    <div class="ibox-tools">

                        分页: {{ $rows->perPage() }} / {{ $rows->lastPage() }} / {{ $rows->currentPage() }} 总计: {{ $rows->total() }}
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                            <form action="{{ route('visitor.index') }}" method="get">
                                <div class="col-sm-2">

                                    <select class="form-control m-b input-sm"  name="limit" >
                                        @foreach($pageSizes as $val)
                                            <option value="{{$val}}" @if(request('limit') == $val) selected @endif> 每页{{$val}}条</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-sm-2">
                                    <select class="form-control m-b input-sm"  name="article_id" >
                                        <option value="">文章标题</option>
                                        @foreach($articles as $article)
                                            <option value="{{$article->id}}" @if(request('article_id') == $article->id) selected @endif> {{$article->title}}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-sm-3">
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control"  name="start_time" value="{{ request('start_time') }}" placeholder="开始时间">
                                        <div class="input-group-addon">to</div>
                                        <input type="text" class="form-control" name="end_time" value="{{request('end_time')}}" placeholder="结束时间">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" placeholder="IP" class="input-sm form-control" name="ip" value="{{ request('ip') }}">
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
                                <th>ID</th>
                                <th>文章标题</th>
                                <th>IP</th>
                                <th>地区</th>
                                <th>运营商</th>
                                <th>访问用户</th>
                                <th>点击次数</th>
                                <th>创建时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td>
                                        {{ $row->id }}
                                    </td>
                                    <td>
                                        {{ $row->article->title }}
                                    </td>
                                    <td>
                                       {{ $row->ip }}
                                    </td>
                                    <td>
                                        @if(!empty($ip_data[$row->ip]) && $row->ip != '127.0.0.1')
                                            {{ $ip_data[$row->ip]['country'] }}
                                            @if(!empty($ip_data[$row->ip]['province']))  -{{$ip_data[$row->ip]['province']}} @endif
                                            @if(!empty($ip_data[$row->ip]['city']))  -{{$ip_data[$row->ip]['city']}} @endif
                                        @else
                                            本地IP
                                        @endif

                                    </td>
                                    <td>
                                        @if($ip_data && $row->ip != '127.0.0.1')
                                            @if(!empty($ip_data[$row->ip]['isp'])) {{$ip_data[$row->ip]['isp']}} @else 未知 @endif
                                        @else
                                          未知
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->user_id) {{ $row->user->name }}  @else 游客 @endif
                                    </td>
                                    <td>
                                        {{ $row->clicks }}
                                    </td>

                                    <td>
                                        {{ $row->created_at }}
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