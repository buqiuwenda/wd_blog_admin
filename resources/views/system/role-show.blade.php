@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/zTreeStyle.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>角色信息 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" >
                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色名称 </label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->name }}</p>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色标识 </label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->alias }}</p>
                            </div>

                        </div>

                        <div class="form-group ">
                            <label class="col-sm-2 control-label">权限节点 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <ul id="ztree" class="ztree"></ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">简述 </label>
                            <div class="col-sm-4">
                                <textarea rows="5" class="form-control" name="meta_description" >{{ $row->meta_description }}</textarea>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态 </label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <span><i class="fa fa-circle {{ $status[$row->status]['class'] }}"></i> {{ $status[$row->status]['name'] }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">创建时间</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->created_at }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">更新时间</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $row->updated_at }}</p>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-primary" href="{{ route('role.edit', $row) }}"><i class="fa fa-edit"></i> 编辑</a>
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
    <script src="{{ asset('js/jquery.ztree.core.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ztree.excheck.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            if(!window.sessionStorage){
                alert("浏览器版本过低");
            }

            var url ="{{route('node.treeList')}}";

            var setting = {
                check: {
                    enable: true,
                    chkStyle: "checkbox",
                    chkDisabledInherit: false,
                    chkboxType: { "Y": "p", "N": "s" }
                },
                callback: {
                    onCheck: zTreeOnCheck
                },
                view: {
                    showIcon: true
                }
            };

            getDatas();
            var data = sessionStorage.getItem('ztreeDataShow');

            zTreeObj = $.fn.zTree.init($("#ztree"), setting, JSON.parse(data));

            function zTreeOnCheck(event, treeId, treeNode) {

            }
            
            function getDatas() {
                var node_id = "{{ $node_ids }}";

                 $.get(
                      url,
                        {
                            status:0,
                            node_id:node_id
                        },function(data){
                            sessionStorage.setItem('ztreeDataShow',JSON.stringify(data));
                        }
                    );
            }

        });
    </script>

@endsection
