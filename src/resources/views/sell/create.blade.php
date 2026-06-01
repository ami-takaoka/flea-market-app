@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell/create.css') }}">
@endsection

@section('content')

<div class="sell-form__content">

    <div class="sell-form__heading">
        <h2>商品の出品</h2>
    </div>

    <form
        class="form"
        action="{{ route('sell.store') }}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf

        {{-- 商品画像 --}}
        <div class="form__group">

            <h3 class="form__section-title">
                商品画像
            </h3>

            <div class="form__image">

                <div class="form__image-preview">

                    <img
                        id="preview"
                        class="form__image-preview-img"
                        src=""
                        alt=""
                        style="display: none;"
                    >

                </div>

                <label
                    class="form__image-button"
                    for="image"
                >
                    画像を選択する
                </label>

                <input
                    type="file"
                    name="image"
                    id="image"
                    accept="image/jpeg,image/png"
                >

            </div>

            @error('image')

                <p class="form__error">
                    {{ $message }}
                </p>

            @enderror

        </div>

        {{-- 商品の詳細 --}}
        <div class="form__group">

            <h3 class="form__section-title">
                商品の詳細
            </h3>

            {{-- カテゴリー --}}
            <div class="form__item">

                <label class="form__label">
                    カテゴリー
                </label>

                <div class="form__category-list">

                    @foreach ($categories as $category)

                        <label class="form__category-tag">

                            <input
                                class="form__category-checkbox"
                                type="checkbox"
                                name="categories[]"
                                value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                            >

                            <span class="form__category-name">
                                {{ $category->name }}
                            </span>

                        </label>

                    @endforeach

                </div>

                @error('categories')

                    <p class="form__error">
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- 商品の状態 --}}
            <div class="form__item">

                <label
                    class="form__label"
                    for="condition"
                >
                    商品の状態
                </label>

                <select
                    class="form__select"
                    name="condition"
                    id="condition"
                >
                    <option value="">
                        選択してください
                    </option>

                    <option
                        value="1"
                        {{ old('condition') == 1 ? 'selected' : '' }}
                    >
                        良好
                    </option>

                    <option
                        value="2"
                        {{ old('condition') == 2 ? 'selected' : '' }}
                    >
                        目立った傷や汚れなし
                    </option>

                    <option
                        value="3"
                        {{ old('condition') == 3 ? 'selected' : '' }}
                    >
                        状態が悪い
                    </option>

                </select>

                @error('condition')

                    <p class="form__error">
                        {{ $message }}
                    </p>

                @enderror

            </div>

        </div>

        {{-- 商品名と説明 --}}
        <div class="form__group">

            <h3 class="form__section-title">
                商品名と説明
            </h3>

            {{-- 商品名 --}}
            <div class="form__item">

                <label
                    class="form__label"
                    for="name"
                >
                    商品名
                </label>

                <input
                    class="form__input"
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                >

                @error('name')

                    <p class="form__error">
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- ブランド名 --}}
            <div class="form__item">

                <label
                    class="form__label"
                    for="brand_name"
                >
                    ブランド名
                </label>

                <input
                    class="form__input"
                    type="text"
                    name="brand_name"
                    id="brand_name"
                    value="{{ old('brand_name') }}"
                >

            </div>

            {{-- 商品説明 --}}
            <div class="form__item">

                <label
                    class="form__label"
                    for="description"
                >
                    商品の説明
                </label>

                <textarea
                    class="form__textarea"
                    name="description"
                    id="description"
                >{{ old('description') }}</textarea>

                @error('description')

                    <p class="form__error">
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- 販売価格 --}}
            <div class="form__item">

                <label
                    class="form__label"
                    for="price"
                >
                    販売価格
                </label>

                <div class="form__price">

                    <span class="form__price-mark">
                        ¥
                    </span>

                    <input
                        class="form__input"
                        type="number"
                        name="price"
                        id="price"
                        value="{{ old('price') }}"
                    >

                </div>

                @error('price')

                    <p class="form__error">
                        {{ $message }}
                    </p>

                @enderror

            </div>

        </div>

        {{-- 出品ボタン --}}
        <div class="form__button">

            <button
                class="form__button-submit"
                type="submit"
            >
                出品する
            </button>

        </div>

    </form>

</div>

<script>
    const imageInput = document.getElementById('image');
    const preview = document.querySelector('.form__image-preview-img');

    imageInput.addEventListener('change', function () {

        const file = this.files[0];

        if (file) {

            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';

        }

    });
</script>

@endsection