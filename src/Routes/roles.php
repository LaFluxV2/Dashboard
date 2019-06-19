<?php

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth:admin']], function () {
    Route::get('/addroles', [
        'middleware' => 'acl:add',
        'name' => 'Add Roles',
        'as' => 'extensionsvalley.admin.addroles',
        'uses' => 'ExtensionsValley\Dashboard\RolesController@addRoles',
    ]);
    Route::get('/editroles/{id}', [
        'middleware' => 'acl:edit',
        'name' => 'Edit Roles',
        'as' => 'extensionsvalley.admin.editroles',
        'uses' => 'ExtensionsValley\Dashboard\RolesController@editRoles',
    ]);
    Route::get('/viewroles/{id}', [
        'middleware' => 'acl:view',
        'name' => 'view Roles',
        'as' => 'extensionsvalley.admin.viewroles',
        'uses' => 'ExtensionsValley\Dashboard\RolesController@viewRoles',
    ]);
    Route::post('/saveroles', [
        'middleware' => 'acl:add',
        'name' => 'Save Roles',
        'as' => 'extensionsvalley.admin.saveroles',
        'uses' => 'ExtensionsValley\Dashboard\RolesController@saveRoles',
    ]);
    Route::post('/updateroles', [
        'middleware' => 'acl:edit',
        'name' => 'Save Roles',
        'as' => 'extensionsvalley.admin.updateroles',
        'uses' => 'ExtensionsValley\Dashboard\RolesController@updateRoles',
    ]);
});
