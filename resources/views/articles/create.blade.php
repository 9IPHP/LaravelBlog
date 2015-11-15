@extends('articles.main')

@section('title')
    发布文章 - @parent
@stop

@section('head')
    <link href="/css/simditor.css" rel="stylesheet">
    <link href="/css/dropzone.css" rel="stylesheet">
    <link href="/css/selectize.bootstrap3.css" rel="stylesheet" />
    <link href="/css/bootstrap-tagsinput.css" rel="stylesheet" />
    <script src="/js/mobilecheck.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('site-heading')
    <div class="site-heading">
        <h1>发布文章</h1>
    </div>
@stop

@section('container')
    @include('errors.errlist')
    {!! Form::open(['url' => '/articles/upload', 'id' => 'my-dropzone', 'class' => 'dropzone', 'file' => true]) !!}
        <div class="dz-message">
            <h4 style="text-align: center;color:#428bca;">拖拽图片到这里  <span class="glyphicon glyphicon-hand-down"></span></h4>
        </div>
        <div class="dropzone-previews" id="dropzonePreview"></div>
    {!! Form::close() !!}
    <div id="preview-img"></div>
    {!! Form::open(['url' => '/article']) !!}

    <div class="form-group">
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => '标题']) !!}
    </div>
    <div class="form-group">
        {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => '别名 Slug']) !!}
    </div>
    {!! Form::hidden('thumb') !!}
    <div class="form-group">
        <label class="checkbox-inline">
            <input type="checkbox" name="is_active" value="1" checked="checked"> 是否显示
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="comment_status" value="1" checked="checked"> 启用评论
        </label>
    </div>

    <div class="form-group">
        {!! Form::textarea('excerpt', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => '文章摘要，若留空，则取内容前一部分']) !!}
    </div>

    <div class="form-group editor">
        {!! Form::textarea('body', null, ['id' => 'myEditor', 'class' => 'form-control', 'placeholder' => '文章内容']) !!}
    </div>

    <div class="form-group">
        {{-- {!! Form::label('tags', 'Tags:') !!} --}}
        {!! Form::select('tags[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple', 'placeholder' => '标签( 只允许汉字 英文 数字 - _ )']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('发布', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}
@stop

@section('footer')
    <script src="/js/module.js"></script>
    <script src="/js/hotkeys.js"></script>
    <script src="/js/uploader.js"></script>
    <script src="/js/simditor.js"></script>
    <script src="/js/dropzone.js"></script>
    <script src="/js/selectize.min.js"></script>
    <script src="/js/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript">
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $(function(){
        $('#tag_list').selectize({
            maxItems: 5,
            persist: false,
            createOnBlur: true,
            create: true,
        });
        var $preview, editor, mobileToolbar, toolbar;
        Simditor.locale = 'zh-CN';
        toolbar = ['title', 'bold', 'italic', 'strikethrough', 'color', 'ol', 'ul', 'blockquote', 'code', 'link', 'image', 'hr', '|', 'indent', 'outdent', 'alignment'];
        mobileToolbar = ["bold", "underline", "strikethrough", "color", "ul", "ol"];
        if (mobilecheck()) {
            toolbar = mobileToolbar;
        }
        editor = new Simditor({
            textarea: $('#myEditor'),
            placeholder: '',
            toolbar: toolbar,
            pasteImage: false,
            defaultImage: '/img/image.png',
            upload: {
                url: '/articles/upload',
                fileKey: 'file'
            }
        });
        $preview = $('#preview');
        if ($preview.length > 0) {
            return editor.on('valuechanged', function(e) {
                return $preview.html(editor.getValue());
            });
        }
        Dropzone.options.myDropzone = {
            maxFiles : 1,
            acceptedFiles: 'image/*',
            maxFilesize: 2,
            thumbnailWidth: 400,
            thumbnailHeight: 100,
            addRemoveLinks: true,
            dictRemoveFile: 'Remove',
            dictFileTooBig: 'Image is bigger than 2MB',
            // previewTemplate: '<div id="preview-template" style="display: none;"></div>',
            init: function() {
                this.on('success', function(file, response){
                    $("input[name=thumb]").val(response.file_path);
                }).on('removedfile', function(file){
                    $("input[name=thumb]").val('');
                })
            }
        };
    })
    </script>
@stop