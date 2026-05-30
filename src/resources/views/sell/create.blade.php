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

            <div class="image-form">

                <div class="image-preview">

                    <img
                        id="preview"
                        src=""
                        alt=""
                        style="display: none;"
                    >

                </div>

                <label
                    class="image-upload-button"
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

    </form>

</div>

@endsection