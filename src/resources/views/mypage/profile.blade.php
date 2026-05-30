@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}">
@endsection

@section('content')

    <div class="profile-form__content">

        <div class="profile-form__heading">
            <h2>プロフィール設定</h2>
        </div>

        <form class="form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" novalidate>

            @csrf

            {{-- プロフィール画像 --}}
            <div class="profile-form__image">

                <img
                    class="profile-form__image-preview {{ !$user->image ? 'profile-form__image--empty' : '' }}"
                    src="{{ $user->image ? asset('storage/' . $user->image) : '' }}"
                    alt="プロフィール画像"
                >

                <div class="profile-form__image-button">

                    <label for="image" class="profile-form__image-label">
                        画像を選択する
                    </label>

                    <input
                        id="image"
                        type="file"
                        name="image"
                        hidden
                    >

                    <div class="file-name"></div>

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
                    <span class="form__label--item">
                        ユーザー名
                    </span>
                </div>

                <div class="form__group-content">

                    <div class="form__input--text">
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                        >
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
                    <span class="form__label--item">
                        郵便番号
                    </span>
                </div>

                <div class="form__group-content">

                    <div class="form__input--text">
                        <input
                            type="text"
                            name="postal_code"
                            value="{{ old('postal_code', $user->postal_code) }}"
                        >
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
                    <span class="form__label--item">
                        住所
                    </span>
                </div>

                <div class="form__group-content">

                    <div class="form__input--text">
                        <input
                            type="text"
                            name="address"
                            value="{{ old('address', $user->address) }}"
                        >
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
                    <span class="form__label--item">
                        建物名
                    </span>
                </div>

                <div class="form__group-content">

                    <div class="form__input--text">
                        <input
                            type="text"
                            name="building"
                            value="{{ old('building', $user->building) }}"
                        >
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

                <button
                    class="form__button-submit"
                    type="submit"
                >
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
    const preview = document.querySelector('.profile-form__image-preview');
    const fileName = document.querySelector('.file-name');

    input.addEventListener('change', function (e) {

        const file = e.target.files[0];

        if (!file) return;

        fileName.textContent = file.name;

        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;

            preview.classList.remove('profile-form__image--empty');
        };

        reader.readAsDataURL(file);

    });

});
</script>
@endpush