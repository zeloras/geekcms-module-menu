<?php

Route::group(['middleware' => ['web', 'permission:admin_access'], 'prefix' => getAdminPrefix('menu')], function () {
    Route::group(['middleware' => ['permission:modules_menu_admin_create']], function () {
        Route::any('/create', 'GeekCms\Menu\Http\Controllers\AdminController@createMenu')
            ->name('admin.menu.create')
        ;
    });

    Route::group(['middleware' => ['permission:modules_menu_admin_delete']], function () {
        Route::get('/item/delete/{item?}', 'GeekCms\Menu\Http\Controllers\AdminController@deleteItem')
            ->name('admin.menu.item.delete')
        ;

        Route::post('/delete/all', 'GeekCms\Menu\Http\Controllers\AdminController@deleteAllMenu')
            ->name('admin.menu.delete.all')
        ;

        Route::get('/{menu}/delete/all', 'GeekCms\Menu\Http\Controllers\AdminController@deleteMenu')
            ->name('admin.menu.delete')
        ;
    });

    Route::group(['middleware' => ['permission:modules_menu_admin_edit']], function () {
        Route::post('/item/save/{item?}', 'GeekCms\Menu\Http\Controllers\AdminController@saveItem')
            ->name('admin.menu.item.save')
        ;

        Route::post('/{menu}/save', 'GeekCms\Menu\Http\Controllers\AdminController@saveMenu')
            ->name('admin.menu.save')
        ;
    });

    // Link for show menu lists or detail menu page
    Route::group(['middleware' => ['permission:modules_menu_admin_list']], function () {
        Route::get('/{menu?}/{item?}', 'GeekCms\Menu\Http\Controllers\AdminController@index')
            ->name('admin.menu')
        ;
    });
});
