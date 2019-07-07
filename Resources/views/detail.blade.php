@extends('admin.layouts.main')

@section('title',  \Translate::get('module_menu::admin/main.page_title'))

@section('content')

<script>
    var menuIndexUrl = '{{ route('admin.menu') }}';
    var menuId = {{ $menu->id ?? 0 }};
</script>

<section class="box-typical">
    <header class="box-typical-header">
        <div class="tbl-row">
            <div class="tbl-cell tbl-cell-title border-bottom">
                <form class="form-inline">
                    <label class="mr-sm-2" for="menu">
                        {{ \Translate::get('module_menu::admin/main.navigation_choose') }}:
                    </label>

                    <select class="form-control mb-2 mr-sm-2 mb-sm-0 menu_main_list" id="menu">
                        <option></option>

                        @foreach($elements as $element)
                            @php($selected = ($menu && $element->id == $menu->id) ? 'selected' : '')

                            <option value="{{ $element->id }}" {{$selected}}>
                                {{ $element->name }} ({{ $element->lang }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </header>
    <div class="box-typical-body pt-3 pb-3">
        <div class="table-responsive container">
            <div class="row">
                <div class="col-6">
                    @if($menu)
                        @component('menu::components.tree.index')
                            @slot('menu', $menu)
                            @slot('item_detail', $item)
                        @endcomponent
                    @endif

                </div>

                <div class="col-6">
                    @if($menu)
                        @include('menu::components.form')
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
