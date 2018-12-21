@extends('layouts.app')


@section('header')

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/bootstrap-fileinput/fileinput.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
    <link href="{{ asset('css/plugins/bootstrap-fileinput/themes/explorer-fas/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/bootstrap-markdown/bootstrap-markdown.min.css') }}" rel="stylesheet">
    <link href="{{asset('css/plugins/datepicker/datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">


@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>编辑文章 <small> <span class="text-danger">[*]</span>为必填项</small></h5>
                </div>
                @include('errors.error')
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" >

                        <div class="form-group ">
                            <label class="col-sm-2 control-label">标题 </label>
                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $row->title }}</p>
                            </div>

                        </div>


                        <div class="form-group ">
                            <label class="col-sm-2 control-label">子标题 </label>
                            <div class="col-sm-6">
                               <p class="form-control-static">{{ $row->subtitle }}</p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">文章类别 </label>
                            <div class="col-sm-6">
                                <select name="category_id" class="form-control m-b">
                                    <option value="">请选择</option>
                                    @if($categorys)
                                        @foreach($categorys as $key=>$name)
                                            <option @if(old('category_id') == $key || $row->category_id == $key) selected @endif value="{{ $key }}">{{ $name }}</option>
                                        @endforeach
                                    @else
                                        <option value="0">无</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="col-sm-2 control-label"> 文章图片 <small class="text-danger">[*]</small></label>
                            <div class="col-sm-6">
                                <div class="file-loading">
                                    <input name="image"  id="image" type="file">
                                </div>
                                <div id="errorBlock" class="help-block"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"> 简述 </label>
                            <div class="col-sm-6">
                               <p class="form-control-static">{{ $row->meta_description }}</p>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group ">
                            <label class="col-sm-2 control-label"> 文章内容 </label>
                            <div class="col-sm-8">
                                <textarea name="content"  data-provide="markdown" rows="10">{{ $content }}</textarea>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标签 </label>
                            <div class="col-sm-6">
                                <select class="select2_tag form-control" name="tags[]" multiple="multiple" >
                                    @if($tags)
                                        @foreach($tags as $key=>$name)
                                            <option  value="{{ $key }}" @if(in_array($key, $tagData)) selected="selected"  @endif>{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">发布时间 </label>
                            <div class="col-sm-4">
                                <div class="input-group date ">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="published_at" class="form-control" value="@if(old('published_at')) {{ old('published_at') }}  @else {{ $row->published_at }} @endif">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否原创 </label>
                            <div class="col-sm-2">
                                <input type="checkbox" name="is_original" class="js-switch"  @if($row->is_original) checked @endif />
                            </div>
                            <label class="col-sm-2 control-label">是否草稿 </label>
                            <div class="col-sm-2">
                                <input type="checkbox" name="is_draft" class="js-switch2"  @if($row->is_draft) checked @endif  />
                            </div>

                            <label class="col-sm-1 control-label">状态 </label>
                            <div class="col-sm-2">
                                <input type="checkbox" name="status" class="js-switch3"   @if($row->status) checked @endif />
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
                                <a class="btn btn-primary" href="{{ route('article.edit', $row) }}"><i class="fa fa-edit"></i> 编辑</a>
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
    <script src="{{ asset('js/plugins/bootstrap-fileinput/fileinput.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-fileinput/locales/zh.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-markdown/bootstrap-markdown.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-markdown/markdown.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-markdown/locales/bootstrap-markdown.zh.js') }}"></script>
    <script src="{{ asset('css/plugins/bootstrap-fileinput/themes/explorer-fas/theme.js') }}"></script>
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });



            var fileInfo = '<?php echo $fileInfo; ?>';
            if(fileInfo) {
                var fileInfoJson = JSON.parse(fileInfo);
            }else{
                var fileInfoJson = '';
            }

            $("#image").fileinput({
                'language':'zh',
                'theme': 'explorer-fas',
                'uploadUrl': '#',
                'allowedFileExtensions': ['jpeg','jpg', 'png', 'gif'],
                'elErrorContainer': '#errorBlock',
                maxFileSize: 2048,
                maxFilesNum: 1,
                showUpload:false,
                overwriteInitial: false,
                initialPreviewAsData:true,
                initialPreview: [
                    fileInfoJson.url
                ],
                initialPreviewConfig: [
                    {caption: fileInfoJson.name, size: fileInfoJson.fsize, width: "120px", url: fileInfoJson.url, key: 1}
                ],
                layoutTemplates: {
                    'actionDelete':'',
                    'actionUpload':''
                }


            });

            $("#some-textarea").markdown({
                language:'zh',
                autofocus:false,
                savable:false
            });


            $('.input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true
            });


            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { color: '#1AB394' });

            var elem2 = document.querySelector('.js-switch2');
            var switchery2 = new Switchery(elem2, { color: '#1AB394' });

            var elem3 = document.querySelector('.js-switch3');
            var switchery3 = new Switchery(elem3, { color: '#1AB394' });


            $(".select2_tag").select2({
                placeholder: "选择标签",
                allowClear: true,
                multiple:true,
                closeOnSelect: true,
                maximumSelectionLength:5
            });

        });
    </script>

@endsection
