<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>flea-market-app</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

    @yield('css')
</head>

<body>

    <header class="header">
        <div class="header__inner">
            <a href="{{ route('items.index') }}" class="header__logo">
                <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
            </a>

            <form class="header__search" action="{{ route('items.index') }}" method="GET">
                <input class="header__search-input" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
            </form>

            <nav class="header__nav">
                <ul class="header__list">
                    <li class="header__item">
                        @guest
                            <a class="header__link" href="{{ route('login') }}">
                                ログイン
                            </a>
                        @endguest

                        @auth
                            <form class="header__form" action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button class="header__logout-button" type="submit">
                                    ログアウト
                                </button>
                            </form>
                        @endauth
                    </li>

                    <li class="header__item">
                        <a class="header__link" href="{{ route('mypage') }}">
                            マイページ
                        </a>
                    </li>

                    <li class="header__item">
                        <a class="header__link header__link--button" href="{{ route('sell.create') }}">
                            出品
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @stack('scripts')

</body>

</html>