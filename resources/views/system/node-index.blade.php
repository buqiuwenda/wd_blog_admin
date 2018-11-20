@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>菜单管理 </h5>
                    <div class="ibox-tools">

                        分页: {{ $rows->perPage() }} / {{ $rows->lastPage() }} / {{ $rows->currentPage() }} 总计: {{ $rows->total() }}
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-5 m-b-xs">
                            <a href="{{ route('menu.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> 新增菜单</a>
                        </div>

                            <form action="{{ route('menu.index') }}" method="get">
                                <div class="col-sm-1">

                                    <select class="form-control m-b input-sm"  name="limit" >
                                        @foreach($pageSizes as $val)
                                            <option value="{{$val}}" @if(request('limit') == $val) selected @endif> 每页{{$val}}条</option>
                                        @endforeach
                                    </select>


                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" placeholder="菜单名" class="input-sm form-control" name="name" value="{{ request('name') }}">
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
                                <th>菜单名</th>
                                <th>父级菜单</th>
                                <th>路由别名</th>
                                <th>添加时间</th>
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
                                        {{ $row->name }}
                                    </td>
                                    <td>
                                        @if($parents && $row->parent_id)
                                            {{ $parents[$row->parent_id] }}
                                        @else
                                            无
                                        @endif
                                    </td>
                                    <td>
                                        {{ $row->routing }}
                                    </td>
                                    <td>
                                        {{ $row->created_at }}
                                    </td>
                                    <td>
                                        {{ $row->updated_at }}
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a class="btn-white btn btn-xs" href="{{ route('menu.show', $row) }}"><i class="fa fa-eye"></i> 查看</a>
                                            <a class="btn-white btn btn-xs" href="{{ route('menu.edit', $row) }}"><i class="fa fa-edit"></i> 编辑</a>
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