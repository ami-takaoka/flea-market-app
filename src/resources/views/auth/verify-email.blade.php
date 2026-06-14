@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')

    <div class="verify-email__content">
        <div class="verify-email__message">
            <p class="verify-email__message-text">
                登録していただいたメールアドレスに認証メールを送付しました。<br>
                メール認証を完了してください。
            </p>
        </div>

        <div class="verify-email__button">
            <a href="http://localhost:8025" target="_blank" class="verify-email__button-submit">
                認証はこちらから
            </a>
        </div>

        <div class="verify-email__resend">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="verify-email__resend-button">
                    認証メールを再送する
                </button>
            </form>
        </div>
    </div>

@endsection