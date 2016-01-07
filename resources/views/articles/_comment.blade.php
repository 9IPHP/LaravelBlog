<div class="media" id="comment-{{ $comment->id }}">
    <div class="pull-left">
        <a href="/user/{{ $comment->user_id }}">
            <img class="media-object avatar avatar-48" src="{{ getAvarar($comment->user->email, 48) }}" alt="{{ $comment->user->name }}">
        </a>
    </div>
    <div class="media-body">
        <div class="media-heading">
            <a href="/user/{{ $comment->user_id }}">{{ $comment->user->name }}</a>  • {{ $comment->created_at->diffForHumans() }}
            <span class="pull-right">
                {{-- <i class="fa fa-thumbs-o-up js-action" data-action="LikeComment"></i> --}}
                <i class="fa fa-reply pointer" onclick="replyTo('{{ $comment->user->name }}')"></i>
            </span>
        </div>
        {{-- <div class="comment-body">{!! Markdown::parse(App\Comment::atParse($comment->body)) !!}</div> --}}
        <div class="comment-body">{!! $comment->body !!}</div>
    </div>
</div>
<hr>