<div class="media" id="comment-{{ $comment->id }}">
    <div class="pull-left">
        <a href="/user/{{ $comment->user_id }}">
            <img class="media-object avatar" src="{{ getAvarar($comment->user->email, 48) }}" alt="{{ $comment->user->name }}">
        </a>
    </div>
    <div class="media-body">
        <div class="media-heading">
            <a href="/user/{{ $comment->user_id }}">{{ $comment->user->name }}</a>  • {{ $comment->created_at->diffForHumans() }}
        </div>
        <div class="comment-body">{!! $comment->body !!}</div>
    </div>
</div>
<hr>