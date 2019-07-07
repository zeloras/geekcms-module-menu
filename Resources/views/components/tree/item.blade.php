<li class="dd-item" data-id="{{ $item->id }}">

    <div class="dd-handle @if (isset($item_detail) && $item_detail->id === $item->id) dd-handle-selected @endif">
        {{ $item->name }}
    </div>

    <div class="dd-actions">
        @component('menu::components.tree.actions')
            @slot('item', $item)
        @endcomponent
    </div>
</li>
