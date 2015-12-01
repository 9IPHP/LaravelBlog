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

{{-- <div id="preview"></div> --}}

<div class="form-group">
    {{-- {!! Form::label('tags', 'Tags:') !!} --}}
    {!! Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple', 'placeholder' => '标签( 只允许汉字 英文 数字 - _ )']) !!}
</div>

<div class="form-group">
    {!! Form::submit('发布', ['class' => 'btn btn-primary form-control']) !!}
</div>