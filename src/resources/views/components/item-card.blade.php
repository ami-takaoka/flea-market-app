@props(['item'])

<a href="{{ route('items.show', $item) }}" class="item-card__link">

    <div class="item-card">
        <div class="item-card__image">
            <img class="item-card__image-img" src="{{ $item->image_url }}" alt="{{ $item->name }}">

            @if ($item->purchase)
                <span class="item-card__sold">
                    SOLD
                </span>
            @endif
        </div>

        <div class="item-card__body">
            <p class="item-card__name">
                {{ $item->name }}
            </p>
        </div>
    </div>
</a>