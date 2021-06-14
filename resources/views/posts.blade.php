asdfsadf

@foreach ($posts as $post)
    {{$post->title}}

    {{$post->body}}

    <a href="/posts/{{$post->id}}">View Post Details</a>

@endforeach