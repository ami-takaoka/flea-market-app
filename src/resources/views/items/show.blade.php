@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('content')

<div class="item-detail">

    {{-- 商品画像 --}}
    <div class="item-detail__image">
        <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
    </div>

    {{-- 商品情報 --}}
    <div class="item-detail__content">

        <h2 class="item-detail__name">
            {{ $item->name }}
        </h2>

        {{-- ブランド --}}
        <p class="item-detail__brand">
            {{ $item->brand }}
        </p>

        {{-- 価格 --}}
        <p class="item-detail__price">
            ¥{{ number_format($item->price) }}
            <span>(税込)</span>
        </p>

        {{-- いいね・コメント数 --}}
        <div class="item-detail__actions">

            {{-- いいね --}}
            <div class="item-detail__action-icon">

                @if (Auth::check() && $item->likes->where('user_id', Auth::id())->count())

                    <form action="{{ route('likes.destroy', $item) }}" method="post">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="item-detail__like-button">

                            <img src="{{ asset('images/ハートロゴ_ピンク.png') }}" alt="いいね済み">

                        </button>

                    </form>

                @else

                    <form action="{{ route('likes.store', $item) }}" method="post">

                        @csrf

                        <button type="submit" class="item-detail__like-button">

                            <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}" alt="いいね">

                        </button>

                    </form>

                @endif

                <p>{{ $item->likes->count() }}</p>

            </div>

            {{-- コメント数 --}}
            <div class="item-detail__action-icon">

                <img src="{{ asset('images/ふきだしロゴ.png') }}" alt="コメント">

                <p>{{ $item->comments->count() }}</p>

            </div>

        </div>

        {{-- 購入ボタン --}}
        <div class="item-detail__button">

            @if ($item->purchase)

                <p class="item-detail__sold">
                    Sold
                </p>

            @else

                <a
                    href="{{ route('purchase.create', $item) }}"
                    class="item-detail__button-submit"
                >
                    購入手続きへ
                </a>

            @endif

        </div>

        {{-- 商品説明 --}}
        <div class="item-detail__description">

            <h3>商品説明</h3>

            <p>
                {{ $item->description }}
            </p>

        </div>

        {{-- 商品情報 --}}
        <div class="item-detail__info">

            <h3>商品の情報</h3>

            {{-- カテゴリー --}}
            <div class="item-detail__category">

                <p>カテゴリー</p>

                @foreach ($item->categories as $category)

                    <span>
                        {{ $category->name }}
                    </span>

                @endforeach

            </div>

            {{-- 商品状態 --}}
            <div class="item-detail__condition">

                <p>商品の状態</p>

                <span>
                    {{ $item->condition_label }}
                </span>

            </div>

        </div>

        {{-- コメント --}}
        <div class="item-detail__comments">

            <h3>
                コメント({{ $item->comments->count() }})
            </h3>

            @foreach ($item->comments->sortBy('created_at') as $comment)

                <div class="item-detail__comment">

                    {{-- ユーザー --}}
                    <div class="item-detail__comment-user">

                        @if ($comment->user->image)

                            <img
                                class="item-detail__user-image"
                                src="{{ asset('storage/' . $comment->user->image) }}"
                                alt="プロフィール画像"
                            >

                        @else

                            <div class="item-detail__user-icon"></div>

                        @endif

                        <p>
                            {{ $comment->user->name }}
                        </p>

                    </div>

                    {{-- コメント内容 --}}
                    <p class="item-detail__comment-content">
                        {{ $comment->content }}
                    </p>

                </div>

            @endforeach

        </div>

        {{-- コメント投稿 --}}
        <div class="item-detail__form">

            <h3 class="item-detail__form-title">
                商品へのコメント
            </h3>

            <form action="{{ route('comments.store', $item) }}" method="post">

                @csrf

                {{-- コメント入力 --}}
                <textarea
                    name="content"
                    class="item-detail__textarea"
                >{{ old('content') }}</textarea>

                {{-- バリデーションエラー --}}
                @error('content')

                    <p class="item-detail__error">
                        {{ $message }}
                    </p>

                @enderror

                {{-- 送信ボタン --}}
                <button
                    type="submit"
                    class="item-detail__comment-button"
                >
                    コメントを送信する
                </button>

            </form>

        </div>

    </div>

</div>

@endsection