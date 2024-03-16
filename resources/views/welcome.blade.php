@extends('layouts.app')

@section('title', '홈')

@section('content')
    <ul>
        @foreach($posts as $post)
            <li>
               <h href="{{ route('posts.show', $post) }}">{{ $post->title }}</h>
            </li>
        @endforeach
    </ul>
    {{ $posts->links() }}
@endsection
