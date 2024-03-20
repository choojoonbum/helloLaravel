<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>라라벨 - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ url('/') }}">홈</a></li>
            @guest
                <li><a href="{{ route('login') }}">로그인</a></li>
                <li><a href="{{ route('register') }}">회원가입</a></li>
            @else
                <li><a href="{{ route('profile.show') }}">마이페이지</a></li>
                <li><a href="{{ route('dashboard.blogs') }}">대시보드</a></li>
                <li><a href="{{ route('blogs.index') }}">블로그</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">로그아웃</button>
                    </form>
                </li>
            @endguest
        </ul>
    </nav>
    <form action="{{ route('search') }}" method="get">
        <input type="search" name="query" placeholder="Search...">
        <button type="submit">검색</button>
    </form>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <ul>
                <li>{{ $error }}</li>
            </ul>
        @endforeach
    @endif
    @if(session()->has('status'))
        <div>{{ session()->get('status') }}</div>
    @endif

    <main>@yield('content')</main>

    @auth
        <script type="module">
            const id = "{{ auth()->user()->id }}"

            Echo.private(`App.Models.User.${id}`)
                .notification(n => {
                    switch (n.type) {
                        case 'App\\Notifications\\Subscribed':
                            return console.log(n.user)
                        case 'App\\Notifications\\Published':
                            return console.log(n.post)
                    }
                })
        </script>
    @endauth
</body>
</html>
