@extends('layouts.app')

@section('title', '로그인')

@section('content')
    <form action="{{ route('login') }}" method="post">
        @csrf
        <input type="text" name="email" value="{{ old('email') }}">
        <input type="password" name="password">
        <input type="checkbox" name="remember">

        <button type="submit">로그인</button>
        @each('auth.social', $providers, 'provider')
    </form>
    <a href="{{ route('password.request') }}">비밀번호 재설정</a>
@endsection
