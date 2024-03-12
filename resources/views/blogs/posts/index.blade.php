@extends('layouts.app')

@section('title', "글 목록")

@section('content')
    <ul>
        @foreach($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>

    {{ $posts->links() }}
@endsection
