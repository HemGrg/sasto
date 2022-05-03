<?php

use Modules\Role\Http\Controllers\RoleController;


Route::prefix('role')->group(function() {
    Route::get('/', 'RoleController@index');
});

Route::group(['middleware' => ['auth', 'role:super_admin'],'prefix'=>'admin'], function () {
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::get('/role/view/{id}', [RoleController::class, 'view'])->name('role.view');
});
