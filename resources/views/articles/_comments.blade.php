@foreach($comments as $comment)
    @include('articles._comment')
@endforeach
{!! $comments->render() !!}