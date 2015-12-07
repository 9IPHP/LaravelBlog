{{-- <img src="{{ getAvarar($article->user->email, 20) }}" class="avatar-20"> --}}
<i class="fa fa-user"></i> <a href="/user/{{ $article->user->id }}">{{ $article->user->nickname }}</a>
<i class="fa fa-eye"></i> {{ $article->view_count }} views
<i class="fa fa-calendar"></i> {{ $article->created_at->diffForHumans() }}
@can('update', $article)
    <i class="fa fa-edit"></i> <a href="/article/{{ $article->id }}/edit">Update</a>
@endcan