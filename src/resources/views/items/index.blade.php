@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/item-card.css') }}">
@endsection

@section('content')

    <div class="item-list__tab">

        <a
            href="{{ route('items.index', [
                'keyword' => request('keyword')
            ]) }}"
            class="item-list__tab-link {{ request('tab') !== 'mylist' ? 'item-list__tab-link--active' : '' }}"
        >
            おすすめ
        </a>

        <a
            href="{{ route('items.index', [
                'tab' => 'mylist',
                'keyword' => request('keyword')
            ]) }}"
            class="item-list__tab-link {{ request('tab') === 'mylist' ? 'item-list__tab-link--active' : '' }}"
        >
            マイリスト
        </a>

    </div>

    <div class="item-list">

        @foreach ($items as $item)

            <x-item-card :item="$item" />

        @endforeach

    </div>

@endsection