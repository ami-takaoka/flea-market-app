@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}">
@endsection

@section('content')

    <div class="profile-form__content">
        <div class="profile-form__heading">
            <h1 class="form__title">
                プロフィール設定
            </h1>
        </div>

        <form class="form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf

            <input type="hidden" name="action" value="{{ $action }}">

            {{-- プロフィール画像 --}}
            <div class="profile-form__image">
                <div class="profile-form__image-preview-wrapper">
                    @if ($user->image)
                        <img class="profile-form__image-preview" src="{{ asset('storage/' . $user->image) }}" alt="プロフィール画像">
                    @else
                        <div class="profile-form__image-preview profile-form__image--empty"></div>
                    @endif
                </div>

                <div class="profile-form__image-button">
                    <label for="image" class="profile-form__image-label">
                        画像を選択する
                    </label>

                    <input id="image" type="file" name="image" hidden>

                    <div class="profile-form__file-name"></div>
                </div>

                <div class="form__error">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            {{-- ユーザー名 --}}
            <div class="form__group">
                <div class="form__group-title">
                    <label for="name" class="form__label--item">
                        ユーザー名
                    </label>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="form__error">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 郵便番号 --}}
            <div class="form__group">
                <div class="form__group-title">
                    <label for="postal_code" class="form__label--item">
                        郵便番号
                    </label>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                    </div>

                    <div class="form__error">
                        @error('postal_code')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 住所 --}}
            <div class="form__group">
                <div class="form__group-title">
                    <label for="address" class="form__label--item">
                        住所
                    </label>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
                    </div>

                    <div class="form__error">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 建物名 --}}
            <div class="form__group">
                <div class="form__group-title">
                    <label for="building" class="form__label--item">
                        建物名
                    </label>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
                    </div>

                    <div class="form__error">
                        @error('building')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 更新ボタン --}}
            <div class="form__button">
                <button class="form__button-submit" type="submit">
                    更新する
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const input = document.getElementById('image');
        const fileName = document.querySelector('.profile-form__file-name');

        input.addEventListener('change', function (e) {

            const file = e.target.files[0];

            if (!file) return;

            fileName.textContent = file.name;

            const reader = new FileReader();

            reader.onload = function (e) {

                const wrapper = document.querySelector(
                    '.profile-form__image-preview-wrapper'
                );

                wrapper.innerHTML = `
                    <img
                        class="profile-form__image-preview"
                        src="${e.target.result}"
                        alt="プロフィール画像"
                    >
                `;

            };

            reader.readAsDataURL(file);

        });

    });
</script>
@endpush