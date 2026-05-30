@props(['item'])

<a href="{{ route('items.show', $item->id) }}">

    <div class="item-card">

        <div class="item-card__image">
            <img src="{{ $item->image }}" alt="商品画像">

            @if ($item->purchase)
                <span class="item-card__sold">SOLD</span>
            @endif
        </div>

        <div class="item-card__body">
            <p class="item-card__name">{{ $item->name }}</p>
        </div>

    </div>

</a>