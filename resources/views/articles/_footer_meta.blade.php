<div class="article-footer-meta clearfix">
    <label class="js-action text-heart" data-action="Like" data-toggle="tooltip" title="点赞"><i class="fa fa-{{$currentUser && $article->likes()->byUser($currentUser->id)->count() ? 'thumbs-up' : 'thumbs-o-up'}}"></i> <span>{{$article->like_count}}</span></label>
    <a href="#commentsLists" data-toggle="tooltip" title="评论"><i class="fa fa-comment-o"></i> <span class="commentNum">{{$article->comment_count}}</span></a>
    <div class="pull-right">
        <label class="js-action" data-action="Collect" data-toggle="tooltip" title="收藏"><i class="fa fa-bookmark{{$currentUser && App\Collect::isCollect($currentUser, $article) ? '' : '-o'}}"></i> <span>{{$article->collect_count}}</span></label>
        <img title="{{ $article->user->name }}" data-toggle="tooltip" src="{{ getAvarar($article->user->email, 25) }}" class="avatar avatar-25 mt--4">
    </div>
</div>