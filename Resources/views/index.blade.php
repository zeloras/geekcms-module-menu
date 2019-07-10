@extends('admin.layouts.main')

@section('title',  Translate::get('module_menu::admin/main.page_title'))

@section('content')

    <section class="box-typical container pb-3">
        <header class="box-typical-header">
            <div class="tbl-row">
                <div class="tbl-cell tbl-cell-title">
                    <h3>{{ Translate::get('module_menu::admin/main.menu_list') }}</h3>
                </div>
                <div class="tbl-cell tbl-cell-action-bordered">
                    <a href="{{ route('admin.menu.create') }}"
                       data-toggle="tooltip" data-placement="left"
                       data-original-title="{{ Translate::get('module_menu::admin/main.create_navigation') }}"
                       class="action-btn">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                <div class="tbl-cell tbl-cell-action-bordered">
                    <button type="button" data-token="{!! csrf_token() !!}"
                            data-toggle="tooltip" data-placement="left"
                            data-original-title="{{ Translate::get('module_menu::admin/main.delete_selected_navigation') }}"
                            data-text="Are you sure?" data-inputs=".delete-item-check:checked"
                            data-action="{{ route('admin.menu.delete.all') }}"
                            class="action-btn delete-all">
                        <i class="font-icon font-icon-trash"></i>
                    </button>
                </div>
            </div>
        </header>
        <div class="box-typical-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                    <tr>
                        <th class="table-check"></th>
                        <th class="table-title">{{ Translate::get('module_menu::admin/main.name') }}</th>
                        <th>{{ Translate::get('module_menu::admin/main.language') }}</th>
                        <th>{{ Translate::get('module_menu::admin/main.elements_cnt') }}</th>
                        <th>{{ Translate::get('module_menu::admin/main.created_at') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($elements as $element)
                        <tr>
                            <td class="table-check">
                                <div class="checkbox checkbox-only">
                                    <input type="checkbox" class="delete-item-check" id="table-check-{{ $element->id }}"
                                           value="{{ $element->id }}">
                                    <label for="table-check-{{ $element->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.menu', ['menu' => $element->id]) }}">
                                    {{ $element->name }}
                                </a>
                            </td>
                            <td class="color-blue-grey-lighter">
                                {{ $element->lang }}
                            </td>
                            <td class="color-blue-grey-lighter">
                                {{ count($element->allItems) }}
                            </td>
                            <td class="table-date">{{ $element->created_at }} <i class="font-icon font-icon-clock"></i>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

