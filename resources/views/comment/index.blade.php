@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>评论列表 </h5>
                    <div class="ibox-tools">

                        分页: {{ $rows->perPage() }} / {{ $rows->lastPage() }} / {{ $rows->currentPage() }} 总计: {{ $rows->total() }}
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                            <form action="{{ route('comment.index') }}" method="get">
                                <div class="col-sm-2">

                                    <select class="form-control m-b input-sm"  name="limit" >
                                        @foreach($pageSizes as $val)
                                            <option value="{{$val}}" @if(request('limit') == $val) selected @endif> 每页{{$val}}条</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-sm-3">

                                    <select class="form-control m-b input-sm"  name="commentable_type" >
                                        <option value="">类型</option>
                                        @foreach($commentTypes as $key=>$val)
                                            <option value="{{$val}}" @if(request('commentable_type') == $val) selected @endif> {{$val}}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </form>

                    </div>
                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>用户名</th>
                                <th>评论标题</th>
                                <th>评论类型</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
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
                                        {{ $row->user->name }}
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        {{ $commentTypes[$row->commentable_type] }}
                                    </td>

                                    <td>
                                        {{ $row->created_at }}
                                    </td>
                                    <td>
                                        {{ $row->updated_at }}
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a class="btn-white btn btn-xs" href="{{ route('comment.show', $row) }}"><i class="fa fa-eye"></i> 查看</a>
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