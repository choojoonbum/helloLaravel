@extends('layouts.app')

@section('title', '블로그 관리')

@section('content')
    <form action="{{ route('blogs.update', $blog) }}" method="post">
        @method('put')
        @csrf
        <input type="text" name="name" value="{{ $blog->name }}">
        <input type="text" name="display_name" value="{{ $blog->display_name }}">
        <button type="submit">이름 바꾸기</button>
    </form>
    <form action="{{ route('blogs.destroy', $blog) }}" method="post">
        @method('delete')
        @csrf
        <button type="submit">삭제</button>
    </form>

    <h3>글</h3>
    <ul>
        @foreach($blog->posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                <a href="{{ route('posts.edit', $post) }}">수정</a>
                <form action="{{ route('posts.destroy', $post) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">삭제</button>
                </form>
            </li>
        @endforeach
    </ul>

    <h3>댓글</h3>
    <ul>
        @foreach($blog->comments as $comment)
            <li>
                <a href="{{ route('posts.show', $comment->commentable) }}">{{ $comment->commentable->title }}</a>
                <h4>{{ $comment->user->name }}</h4>
                <p>{{ $comment->content }}</p>
                <form action="{{ route('comments.destroy', $comment) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">삭제</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
