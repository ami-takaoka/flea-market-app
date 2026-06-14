@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')

    <div class="login-form__content">
        <div class="login-form__heading">
            <h2>ログイン</h2>
        </div>

        {{-- ログインフォーム --}}
        <form class="form" action="{{ route('login') }}" method="post" novalidate>
            @csrf

            <div class="form__group">
                <div class="form__group-title">
                    <label for="email" class="form__label--item">
                        メールアドレス
                    </label>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="email" id="email" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="form__error">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <label for="password" class="form__label--item">
                        パスワード
                    </label>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="password" id="password" name="password">
                    </div>

                    <div class="form__error">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit">
                    ログインする
                </button>
            </div>
        </form>

        <div class="login-form__register">
            <a class="login-form__register-link" href="{{ route('register') }}">
                会員登録はこちら
            </a>
        </div>
    </div>

@endsection