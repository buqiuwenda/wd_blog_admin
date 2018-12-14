@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>文章列表 </h5>
                    <div class="ibox-tools">

                        分页: {{ $rows->perPage() }} / {{ $rows->lastPage() }} / {{ $rows->currentPage() }} 总计: {{ $rows->total() }}
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-2 m-b-xs">
                            <a href="{{ route('article.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> 新增文章</a>
                        </div>
                            <form action="{{ route('article.index') }}" method="get">
                                <div class="col-sm-1">

                                    <select class="form-control m-b input-sm"  name="limit" >
                                        @foreach($pageSizes as $val)
                                            <option value="{{$val}}" @if(request('limit') == $val) selected @endif> 每页{{$val}}条</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-sm-2">

                                    <select class="form-control m-b input-sm"  name="category_id" >
                                        <option value="">类别</option>
                                        @foreach($categorys as $key=>$val)
                                            <option value="{{$val}}" @if(request('category_id') == $val) selected @endif> {{$val}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-sm-2">

                                    <select class="form-control m-b input-sm"  name="member_id" >
                                        <option value="">发表人</option>
                                        @foreach($members as $key=>$val)
                                            <option value="{{$val}}" @if(request('member_id') == $val) selected @endif> {{$val}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-sm-2">

                                    <select class="form-control m-b input-sm"  name="status" >
                                        <option value="">状态</option>
                                        <option value="1">启用</option>
                                        <option value="0">禁用</option>

                                    </select>

                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" placeholder="标题|子标题" class="input-sm form-control" name="keyword" value="{{ request('keyword') }}">
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
                                <th>标题</th>
                                <th>子标题</th>
                                <th>类别</th>
                                <th>发表人</th>
                                <th>最后修改人</th>
                                <th>是否原创</th>
                                <th>浏览次数</th>
                                <th>状态</th>
                                <th>发布时间</th>
                                <th class="text-right">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td>
                                        {{ $row->id }}
                                    </td>
                                    <td>
                                        {{ $row->title }}
                                    </td>
                                    <td>
                                       {{ $row->subtitle }}
                                    </td>
                                    <td>
                                        {{ $categorys[$row->category_id] }}
                                    </td>
                                    <td>
                                        {{ $members[$row->member_id] }}
                                    </td>
                                    <td>
                                        {{ $members[$row->last_member_id] }}
                                    </td>
                                    <td>
                                        @if($row->is_original == 1)
                                            <span class="label label-info">是 </span>
                                         @else
                                            <span class="label label-danger">否</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $row->view_count }}
                                    </td>
                                    <td>
                                        <span><i class="fa fa-circle {{ $status[$row->status]['class'] }}"></i> {{ $status[$row->status]['name'] }}</span>
                                    </td>
                                    <td>
                                        {{ $row->published_at }}
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a class="btn-white btn btn-xs" href="{{ route('article.show', $row) }}"><i class="fa fa-eye"></i> 查看</a>
                                            <a class="btn-white btn btn-xs" href="{{ route('article.edit', $row) }}"><i class="fa fa-edit"></i> 编辑</a>
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