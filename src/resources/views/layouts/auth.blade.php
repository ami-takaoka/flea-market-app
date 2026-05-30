<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>flea-market-app</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    @yield('css')
</head>

<body>

    <header class="header">
        <div class="header__inner">
            <a href="{{ route('items.index') }}" class="header__logo">
                <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>