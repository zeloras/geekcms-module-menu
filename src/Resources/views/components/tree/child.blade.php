<li class="dd-item" data-id="{{ $item->id }}">
    <div class="dd-handle">{{ $item->name }}</div>
    <div class="dd-actions">
        @component('menu::components.tree.actions')
            @slot('item', $item)
        @endcomponent
    </div>
    <ol class="dd-list">
        @foreach($item->items as $item)
            @if(!$item->items->count())
                @component('menu::components.tree.item')
                    @slot('item', $item)
                @endcomponent
            @else
                @component('menu::components.tree.child')
                    @slot('item', $item)
                @endcomponent
                <div class="dd-actions">
                    @component('menu::components.tree.actions')
                        @slot('item', $item)
                    @endcomponent
                </div>
            @endif
        @endforeach
    </ol>
</li>