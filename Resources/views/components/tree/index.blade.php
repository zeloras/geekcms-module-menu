<form method="POST" action="{{ route('admin.menu.save', ['menu' => $menu->id]) }}">
    @csrf
    <div class="row">
        <div class="col">
            <div class="dd menu_admin">
                <ol class="dd-list">
                    @foreach($menu->items as $item)
                        @if(!$item->items->count())
                            @component('menu::components.tree.item')
                                @slot('item', $item)
                                @slot('item_detail', $item_detail)
                            @endcomponent
                        @else
                            @component('menu::components.tree.child')
                                @slot('item', $item)
                            @endcomponent
                        @endif

                    @endforeach
                </ol>
            </div>
            <input id="sorts" class="menu_admin_sort_data" name="sorts" type="hidden">
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group text-center">
                @if (!empty($item_detail))
                    <a href="{{ route('admin.menu', ['menu' => $menu->id]) }}" class="btn btn-success">
                        {{ \Translate::get('module_menu::admin/main.navigation_create') }}
                    </a>
                @endif

                <button id="menuSave" class="btn btn-primary">{{ \Translate::get('module_menu::admin/main.save_button') }}</button>

                <a href="{{ route('admin.menu.delete', ['menu' => $menu->id]) }}" class="btn btn-danger" data-delete="{{ \Translate::get('module_menu::admin/main.will_be_removed') }}">
                    {{ \Translate::get('module_menu::admin/main.navigation_delete') }}
                </a>
            </div>
        </div>
    </div>
</form>