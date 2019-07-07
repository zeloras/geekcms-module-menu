<form method="POST" action="{{ route('admin.menu.item.save', ['item' => $item->id ?? null]) }}">
    @csrf
    <input name="action" class="menu_item_action" id="action" type="hidden">
    <input name="menu_id" id="menuId" type="hidden" value="{{ $menu->id ?? '' }}">

    <div class="form-group">
        <label for="itemName">{{ \Translate::get('module_menu::admin/main.title') }}:</label>
        <input required class="form-control" id="itemName" name="name" value="{{ old('name',$item->name ?? '') }}">
    </div>

    <div class="form-group">
        <label for="itemId">{{ \Translate::get('module_menu::admin/main.parent_item') }}:</label>
        <select class="form-control" id="item_id" name="item_id">
            <option value="">-</option>
            @foreach($menu->items as $menu_item)
                @if (!isset($item) || $item->id !== $menu_item->id)
                    <option value="{{ $menu_item->id }}" {{ $menu_item->id === old('item_id', $item->item_id ?? '') ? 'selected': '' }}>
                        {{ $menu_item->name }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="actionType">{{ \Translate::get('module_menu::admin/main.link_type') }}:</label>

        <select class="form-control menu_admin_type" id="actionType" required>
            <option></option>
            @php
            $action = ($item)
                ? array_get(array_keys($item->action), 0)
                : null;

            $isPage = ('route' === $action && 'page.open' === array_get($item->action, 'route'))
                ? true
                : false;
            @endphp
            <option value="route" {{ $action == 'route' ? 'selected': '' }}>
                {{ \Translate::get('module_menu::admin/main.route_link') }}
            </option>
            <option value="link" {{ $action == 'link' ? 'selected': '' }}>
                {{ \Translate::get('module_menu::admin/main.direct_link') }}
            </option>
            <option value="anhor" {{ $action == 'anhor' ? 'selected': '' }}>
                {{ \Translate::get('module_menu::admin/main.anchor') }}
            </option>
            <option value="page" {{ $isPage  ? 'selected': '' }}>
                {{ \Translate::get('module_menu::admin/main.page') }}
            </option>
        </select>

        <small id="actionTypeHelp" class="form-text text-muted"></small>
    </div>

    {{--start--}}
    <div class="form-group">
        <label for="iActionLink">{{ \Translate::get('module_menu::admin/main.link') }}:</label>
        <input class="form-control" type="url" id="iActionLink" value="{{ array_get($item->action ?? '', 'link') }}" placeholder="https://google.com">
    </div>

    <div class="form-group">
        <label for="iActionAnhor">{{ \Translate::get('module_menu::admin/main.anchor') }}:</label>
        <input class="form-control" id="iActionAnhor" type="text" value="{{ array_get($item->action ?? '', 'anhor') }}" placeholder="#title">
    </div>

    <div class="form-group">
        <label for="iActionPage">{{ \Translate::get('module_menu::admin/main.page') }}:</label>
        <select required class="form-control" id="iActionPage">
            <option></option>
            @foreach($pages as $page)
                @php
                $selected = ($item && 'page.open' === array_get($item->action, 'route')
                    && array_get($item->action, 'params.page') === $page->slug)
                    ? 'selected'
                    : '';
                @endphp
                <option value="route::page.open|page={{ $page->slug }}" {{$selected}}>{{ $page->name }} ({{ $page->lang }})</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="iActionRoute">{{ \Translate::get('module_menu::admin/main.route_link') }}:</label>
        <select required class="form-control" id="iActionRoute">
            <option></option>
            @foreach($routes as $route)
                @php
                    $route_name = $route->getName();
                    $route_action = in_array('GET', $route->methods());
                @endphp
                @if ($route_action && (!$item || 'page.open' !== array_get($item->action, 'route')) && $route_name !== 'page.open' && !empty($route_name))
                    @php
                    $selected = ($item && array_get($item->action, 'route') === $route_name) ? 'selected' : '';
                    @endphp
                    <option value="route::{{ $route_name }}" {{$selected}}>{{ $route_name }}</option>
                @endif
            @endforeach
        </select>
    </div>

    @if (isset($item) && !empty($item))
        <button id="itemCreate" class="btn btn-primary">{{ \Translate::get('module_menu::admin/main.change_button') }}</button>
    @else
        <button id="itemCreate" class="btn btn-primary">{{ \Translate::get('module_menu::admin/main.save_button') }}</button>
    @endif
</form>