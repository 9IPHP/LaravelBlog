@can('image.upload')
{!! Form::open(['url' => '/articles/upload', 'id' => 'my-dropzone', 'class' => 'dropzone', 'file' => true]) !!}
    <input type="hidden" name="crop" value="1">
    <div class="dz-message">
        <h4 style="text-align: center;color:#428bca;">拖拽图片到这里  <span class="glyphicon glyphicon-hand-down"></span></h4>
    </div>
    <div class="dropzone-previews" id="dropzonePreview"></div>
{!! Form::close() !!}
<div id="preview-img"></div>
@endcan