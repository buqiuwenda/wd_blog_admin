@extends('layouts.app')

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

                                <div class="col-sm-3">

                                    <select class="form-control m-b input-sm"  name="article_id" >
                                        <option value="">文章标题</option>
                                        @foreach($articles as $article)
                                            <option value="{{$article->id}}" @if(request('article_id') == $article->id) selected @endif> {{$article->title}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-sm-4">
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
                                       {{ $row->country }}
                                        @if($row->province)  -{{$row->province}} @endif
                                        @if($row->city)  -{{$row->city}} @endif
                                    </td>
                                    <td>
                                        {{ $row->isp }}
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
                                    <td>
                                        {{ $row->updated_at }}
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