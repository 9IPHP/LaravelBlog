@if(count($articles) > 0)
    @foreach($articles as $article)
        <div class="post-preview">
            <h2 class="post-title">
                <img src="{{ getAvarar($article->user->email, 35) }}" class="avatar-35 avatar mt--4">
                <a href="/article/{{ $article->id }}">
                    {{ $article->title }}
                </a>
            </h2>
            @if($article->thumb)
                <a href="/article/{{ $article->id }}">
                    <img class="post-thumb" src="{{ getThumb($article->thumb, 'big') }}">
                </a>
            @endif
            <p class="post-excerpt">
                {{ $article->excerpt }}
            </p>
            <p class="post-meta">@include('articles._meta')</p>
        </div>
        <hr>
    @endforeach
    {!! $articles->render() !!}
@endif
