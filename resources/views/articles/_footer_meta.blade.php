<div class="article-footer-meta clearfix" data-article-id="{{$article->id}}">
    <label class="js-action text-heart" data-action="Like"><i class="fa fa-{{$currentUser && $article->likes()->byUser($currentUser->id)->count() ? 'thumbs-up' : 'thumbs-o-up'}}"></i> <span>{{$article->like_count}}</span></label>
    <label><i class="fa fa-comment-o"></i> <span>{{$article->comment_count}}</span></label>
    <div class="pull-right">
        <label class="js-action" data-action="Collect"><i class="fa fa-{{$currentUser && $article->collects()->byUser($currentUser->id)->count() ? 'bookmark' : 'bookmark-o'}}"></i> <span>{{$article->collect_count}}</span></label>
        <img src="{{ getAvarar($article->user->email, 25) }}" class="avatar">
    </div>
</div>