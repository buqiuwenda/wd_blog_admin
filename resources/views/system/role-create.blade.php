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
                    <h5>新增角色 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                @include('errors.error')
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{ route('role.store') }}">
                        @csrf
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">角色名称 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" placeholder="用户名称，如：超级管理员" value="{{ old('name') }}" maxlength="64">
                            </div>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('alias') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">角色标识 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="alias" placeholder="角色标识，如：admin" value="{{ old('alias') }}" maxlength="64">
                            </div>

                            @if ($errors->has('alias'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('alias') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-2 control-label">权限节点 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <ul id="ztree" class="ztree"></ul>
                            </div>
                            <input type="hidden" name="nodes" value="" >
                        </div>

                        <div class="form-group {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">简述 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                <textarea rows="5" class="form-control" name="meta_description" >{{old('meta_description')}}</textarea>
                            </div>

                            @if ($errors->has('meta_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('meta_description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">状态 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-4">
                                @foreach($status as $key =>$state)
                                    <label class="radio-inline">
                                        <input type="radio" name="status"  @if($key == 'enable') checked @endif value="{{ $key }}"> {{ $state['name'] }}
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
    <script src="{{ asset('js/jquery.ztree.core.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ztree.excheck.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });


            var url ="{{route('node.treeList')}}";

            var setting = {
                check: {
                    enable: true,
                    chkStyle: "checkbox",
                    chkDisabledInherit: false,
                    chkboxType: { "Y": "ps", "N": "ps" }
                },
                callback: {
                    onCheck: zTreeOnCheck
                },
                view: {
                    showIcon: true
                }
            };

            $.get(
                url,
                {
                    status:1
                },function(data){
                    zTreeObj = $.fn.zTree.init($("#ztree"), setting, data);
                }
            );


            function zTreeOnCheck(event, treeId, treeNode) {

                var tId = treeNode.tId;
                var isParent = treeNode.isParent;

                var nodesInput = $("input[name='nodes']").val();
                var nodes = new Array();
                if(nodesInput){
                    nodes = new String(nodesInput).split(',');
                }


                var arr = new Array();
                var i =0;

                $.get(
                    url,
                    {
                        status:1
                    },function(data){
                        $.each(data, function(index, val){
                            i++;
                            arr[i] = val.id;

                            if(val.children){
                                $.each(val.children,function(io,vo){
                                    i++;
                                    arr[i] = vo.id;
                                })
                            }
                        });

                        var Str = new String(tId);
                        var id = Str.substr(Str.indexOf('_')+1, Str.length);
                        var nodeId = arr[id];

                        if(isParent !== true){

                            if(treeNode.checked === true){
                                if($.inArray(nodeId, nodes)){
                                    nodes.push(nodeId);
                                }
                            }else{
                                if($.inArray(nodeId, nodes)){
                                    nodes.splice($.inArray(nodeId, nodes),1);
                                }
                            }
                        }else{

                            if(treeNode.checked === true){
                                if($.inArray(nodeId, nodes)){
                                    $.each(data, function(index, value){
                                        if(value.id  == nodeId){
                                            $.each(value.children,function(io,vo){
                                                nodes.push(vo.id);
                                            })
                                        }
                                    })
                                }
                            }else{
                                if($.inArray(nodeId, nodes)){
                                    $.each(data, function(index, value){
                                        if(value.id  == nodeId){
                                            $.each(value.children,function(io,vo){
                                                nodes.splice($.inArray(vo.id, nodes),1);
                                            })
                                        }
                                    })
                                }
                            }
                        }
                        $("input[name='nodes']").val(nodes.toString());
                    }
                );

            }
        });
    </script>

@endsection
