@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('content')

<div class="item-detail">

    {{-- 商品画像 --}}
    <div class="item-detail__image">

        @if ($item->image_url)

            <img
                class="item-detail__image-img"
                src="{{ $item->image_url }}"
                alt="商品画像"
            >

        @else

            <div class="item-detail__image-placeholder">
                商品画像
            </div>

        @endif

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
            ¥
            <span class="item-detail__price-value">
                {{ number_format($item->price) }}
            </span>
            <span class="item-detail__price-tax">
                （税込）
            </span>
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

                            <img class="item-detail__like-icon" src="{{ asset('images/ハートロゴ_ピンク.png') }}" alt="いいね済み">

                        </button>

                    </form>

                @else

                    <form action="{{ route('likes.store', $item) }}" method="post">

                        @csrf

                        <button type="submit" class="item-detail__like-button">

                            <img class="item-detail__like-icon" src="{{ asset('images/ハートロゴ_デフォルト.png') }}" alt="いいね">

                        </button>

                    </form>

                @endif

                <p class="item-detail__action-count item-detail__action-count--like">
                    {{ $item->likes->count() }}
                </p>

            </div>

            {{-- コメント数 --}}
            <div class="item-detail__action-icon">

                <img class="item-detail__comment-icon" src="{{ asset('images/ふきだしロゴ.png') }}"
                alt="コメント">

                <p class="item-detail__action-count item-detail__action-count--comment">
                    {{ $item->comments->count() }}
                </p>

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

            <h3 class="item-detail__section-title">
                商品説明
            </h3>

            <p class="item-detail__description-text">
                {{ $item->description }}
            </p>

        </div>

        {{-- 商品情報 --}}
        <div class="item-detail__info">

            <h3 class="item-detail__section-title">
                商品の情報
            </h3>

            {{-- カテゴリー --}}
            <div class="item-detail__category">

                <p class="item-detail__label">
                    カテゴリー
                </p>

                <div class="item-detail__category-list">

                    @foreach ($item->categories as $category)

                        <span class="item-detail__category-tag">
                            {{ $category->name }}
                        </span>

                    @endforeach

                </div>

            </div>

            {{-- 商品状態 --}}
            <div class="item-detail__condition">

                <p class="item-detail__label">
                    商品の状態
                </p>

                <span class="item-detail__condition-text">
                    {{ $item->condition_label }}
                </span>

            </div>

        </div>

        {{-- コメント --}}
        <div class="item-detail__comments">

            <h3 class="item-detail__comments-title">
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

                        <p class="item-detail__user-name">
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

            <form
                class="item-detail__comment-form"
                action="{{ route('comments.store', $item) }}"
                method="post"
            >

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