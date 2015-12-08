<div class="article-footer-meta clearfix" data-article-id="{{$article->id}}">
    <label class="js-actionLike text-heart"><i class="fa fa-heart-o"></i> {{$article->like_count}}</label>
    <label><i class="fa fa-comment-o"></i> {{$article->comment_count}}</label>
    <div class="pull-right">
        <label><i class="fa fa-bookmark-o"></i> {{$article->collect_count}}</label>
        <img src="{{ getAvarar($article->user->email, 25) }}" class="avatar">
    </div>
</div>