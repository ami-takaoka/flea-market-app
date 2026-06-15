@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase/create.css') }}">
@endsection

@section('content')

    <div class="purchase-content">
        <form class="purchase-form" action="{{ route('purchase.store', $item->id) }}" method="post">
            @csrf

            <div class="purchase-content__left">

                {{-- 商品情報 --}}
                <div class="purchase-item">
                    <img class="purchase-item__image" src="{{ $item->image }}" alt="商品画像">

                    <div class="purchase-item__detail">
                        <h2 class="purchase-item__name">
                            {{ $item->name }}
                        </h2>

                        <p class="purchase-item__price">
                            <span class="purchase-item__price-mark">¥</span>
                            <span class="purchase-item__price-value">
                                {{ number_format($item->price) }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- 支払い方法 --}}
                <div class="purchase-form__group purchase-form__group--payment">
                    <div class="purchase-form__heading">
                        <h3 class="purchase-form__title">
                            支払い方法
                        </h3>
                    </div>

                    <select name="payment_method" id="payment_method" class="purchase-form__select">
                        <option value="" {{ old('payment_method') === null ? 'selected' : '' }}>
                            選択してください
                        </option>

                        <option value="{{ \App\Models\Purchase::PAYMENT_CONVENIENCE }}"
                            {{ old('payment_method') == \App\Models\Purchase::PAYMENT_CONVENIENCE ? 'selected' : '' }}>
                            コンビニ払い
                        </option>

                        <option value="{{ \App\Models\Purchase::PAYMENT_CARD }}"
                            {{ old('payment_method') == \App\Models\Purchase::PAYMENT_CARD ? 'selected' : '' }}>
                            カード支払い
                        </option>
                    </select>

                    <div class="form__error">
                        @error('payment_method')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- 配送先 --}}
                <div class="purchase-form__group purchase-form__group--address">
                    <div class="purchase-form__heading">
                        <h3 class="purchase-form__title">
                            配送先
                        </h3>

                        <a class="purchase-form__link" href="{{ route('purchase.address.edit', $item->id) }}">
                            変更する
                        </a>
                    </div>

                    <div class="form__error">
                        @if ($errors->has('postal_code') || $errors->has('address'))
                            配送先を入力してください
                        @endif
                    </div>

                    <div class="purchase-form__address">
                        <input type="hidden" name="postal_code" value="{{ $address['postal_code'] ?? $user->postal_code ?? '' }}">

                        <input type="hidden" name="address" value="{{ $address['address'] ?? $user->address ?? '' }}">

                        <input type="hidden" name="building" value="{{ $address['building'] ?? $user->building ?? '' }}">

                        <p class="purchase-form__postal-code">
                            〒{{ $address['postal_code'] ?? $user->postal_code ?? '' }}
                        </p>

                        <p class="purchase-form__address-text">
                            {{ $address['address'] ?? $user->address ?? '' }}
                        </p>

                        <p class="purchase-form__building">
                            {{ $address['building'] ?? $user->building ?? '' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="purchase-content__right">
                <div class="purchase-summary">
                    <div class="purchase-summary__row">
                        <span class="purchase-summary__label">
                            商品代金
                        </span>

                        <span class="purchase-summary__price">
                            <span class="purchase-summary__yen">¥</span>{{ number_format($item->price) }}
                        </span>
                    </div>

                    <div class="purchase-summary__row">
                        <span class="purchase-summary__label">
                            支払い方法
                        </span>

                        <span id="payment_method_display" class="purchase-summary__payment-method">
                            選択してください
                        </span>
                    </div>
                </div>

                <div class="purchase-form__button">
                    <button class="purchase-form__button-submit" type="submit">
                        購入する
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
    const PAYMENT_CONVENIENCE = '{{ \App\Models\Purchase::PAYMENT_CONVENIENCE }}';
    const PAYMENT_CARD = '{{ \App\Models\Purchase::PAYMENT_CARD }}';

    document.addEventListener('DOMContentLoaded', function () {

        const select = document.getElementById('payment_method');
        const display = document.getElementById('payment_method_display');

        function updatePaymentMethod() {
            const value = select.value;

            if (value === PAYMENT_CONVENIENCE) {
                display.textContent = 'コンビニ払い';

            } else if (value === PAYMENT_CARD) {
                display.textContent = 'カード支払い';

            } else {
                display.textContent = '選択してください';
            }
        }

        select.addEventListener('change', updatePaymentMethod);

        updatePaymentMethod();

    });
</script>
@endpush