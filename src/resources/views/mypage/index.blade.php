@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')

    {{-- プロフィール情報 --}}
    <div class="mypage">

        <div class="mypage__profile">

            <div class="mypage__profile-left">

                <img
                    class="mypage__profile-image"
                    src="{{ $user->image ? asset('storage/' . $user->image) : '' }}"
                    alt="プロフィール画像"
                >

                <h2 class="mypage__profile-name">
                    {{ $user->name }}
                </h2>

            </div>

            <a
                href="{{ route('profile.edit', ['action' => 'edit']) }}"
                class="mypage__profile-button"
            >
                プロフィールを編集
            </a>

        </div>

    </div>

    {{-- タブ --}}
    <div class="mypage__tab">

        <a
            href="{{ url('/mypage?page=sell') }}"
            class="{{ request('page') !== 'buy' ? 'active' : '' }}"
        >
            出品した商品
        </a>

        <a
            href="{{ url('/mypage?page=buy') }}"
            class="{{ request('page') === 'buy' ? 'active' : '' }}"
        >
            購入した商品
        </a>

    </div>

    {{-- 商品一覧 --}}
    <div class="item-list">

        @foreach ($items as $item)
            <x-item-card :item="$item" />
        @endforeach

    </div>

@endsection