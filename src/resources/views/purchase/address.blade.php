@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase/address.css') }}">
@endsection

@section('content')

    <div class="address-form__content">
        <div class="address-form__heading">
            <h2>住所の変更</h2>
        </div>

        <form class="form" action="{{ route('purchase.address.update', $item->id) }}" method="post" novalidate>
            @csrf

            {{-- 郵便番号 --}}
            <div class="form__group">
                <div class="form__group-title">
                    <label for="postal_code" class="form__label--item">
                        郵便番号
                    </label>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $address['postal_code']) }}">
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
                        <input type="text" id="address" name="address" value="{{ old('address', $address['address']) }}">
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
                        <input type="text" id="building" name="building" value="{{ old('building', $address['building']) }}">
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