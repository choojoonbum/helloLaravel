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
@endsection
