<ul class="nav nav-tabs nav-justified">
    <li role="presentation" class="{{ classActiveSegment(3, null) }}"><a href="/user/{{ $user->id }}">Home</a></li>
    <li role="presentation" class="{{ classActiveSegment(3, 'articles') }}"><a href="/user/{{ $user->id }}/articles">文章</a></li>
    <li role="presentation" class="{{ classActiveSegment(3, 'collects') }}"><a href="/user/{{ $user->id }}/collects">收藏</a></li>
    <li role="presentation" class="{{ classActiveSegment(3, 'follows') }}"><a href="/user/{{ $user->id }}/follows">关注</a></li>
    <li role="presentation" class="{{ classActiveSegment(3, 'fans') }}"><a href="/user/{{ $user->id }}/fans">粉丝</a></li>
    @if($currentUser && $user->id == $currentUser->id)
        <li role="presentation" class="{{ classActiveSegment(3, 'trash') }}"><a href="/user/{{ $user->id }}/trash">回收站</a></li>
    @endif
    <li role="presentation"><a href="#">Messages</a></li>
</ul>