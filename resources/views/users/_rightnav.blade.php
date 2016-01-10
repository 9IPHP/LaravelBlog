<ul class="nav nav-tabs nav-justified">
    <li role="presentation" class="{{ classActiveSegment(3, null) }}"><a href="/user/{{ $user->id }}">Home</a></li>
    <li role="presentation" class="{{ classActiveSegment(3, 'articles') }}"><a href="/user/{{ $user->id }}/articles">文章</a></li>
    <li role="presentation" class="{{ classActiveSegment(3, 'collects') }}"><a href="/user/{{ $user->id }}/collects">收藏</a></li>
    <li role="presentation" class="{{ classActiveSegment(3, 'follows') }}"><a href="/user/{{ $user->id }}/follows">关注</a></li>
    <li role="presentation" class="{{ classActiveSegment(3, 'fans') }}"><a href="/user/{{ $user->id }}/fans">粉丝</a></li>
    @if($currentUser && $user->id == $currentUser->id)
        <li role="presentation" class="{{ classActiveSegment(3, 'trash') }}"><a href="/user/{{ $user->id }}/trash">回收站</a></li>
        <li role="presentation" class="{{ classActiveSegment(3, 'notifications') }}"><a href="/user/{{ $user->id }}/notifications">Notifications <span class="badge @if(App\User::noticeCount())grow bg-danger @endif">{{App\User::noticeCount()}}</span></a></li>
    @endif
</ul>