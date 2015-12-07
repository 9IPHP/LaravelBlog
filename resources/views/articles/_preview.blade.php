@if(count($articles) > 0)
    @foreach($articles as $article)
        <div class="post-preview">
            <h2 class="post-title">
                <img src="{{ getAvarar($article->user->email, 35) }}" class="avatar-35 avatar">
                <a href="/article/{{ $article->id }}">
                    {{ $article->title }}
                </a>
            </h2>
            <p class="post-excerpt">
                {{ $article->excerpt }}
            </p>
            <p class="post-meta">@include('articles._meta')</p>
        </div>
        <hr>
    @endforeach
@endif

{!! $articles->render() !!}