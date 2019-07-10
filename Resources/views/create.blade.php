@extends('admin.layouts.main')

@section('title',  Translate::get('module_menu::admin/main.page_title'))

@section('content')
    <section class="card">
        <div class="card-block">
            <div class="row">
                <div class="col-12">
                    <form class="form-inline" method="POST" action="{{ route('admin.menu.create') }}">
                        @csrf

                        <label class="mr-sm-2" for="menu">
                            {{ Translate::get('module_menu::admin/main.create_navigation') }}:
                        </label>

                        <input type="text" name="name" max="50" class="form-control mb-2 mr-sm-2 mb-sm-0">

                        <select class="form-control mb-2 mr-sm-2 mb-sm-0" id="lang" name="lang">
                            @foreach($locales as $locale => $lang)
                                <option value="{{ $locale }}">
                                    {{ array_get($lang, 'name', $locale) }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                                class="btn btn-primary">{{ Translate::get('module_menu::admin/main.create_button') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
