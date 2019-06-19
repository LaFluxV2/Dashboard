<?php

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth:admin']], function () {
    // update
    Route::post('/assignusers', [
//        'middleware' => 'acl:edit',
        'name' => 'Update Assign Users',
        'as' => 'extensionsvalley.admin.assignusers',
        'uses' => 'ExtensionsValley\Dashboard\UserroleController@assignUsers',
    ]);

    // Remove Users
    Route::post('/removeusers', [
//        'middleware' => 'acl:edit',
        'name' => 'Remove Assigned Users',
        'as' => 'extensionsvalley.admin.removeusers',
        'uses' => 'ExtensionsValley\Dashboard\UserroleController@removeUsers',
    ]);

    // Remove
    Route::get('/removeuser', [
//        'middleware' => 'acl:edit',
        'name' => 'Remove Assigned User',
        'as' => 'extensionsvalley.admin.removeuser',
        'uses' => 'ExtensionsValley\Dashboard\UserroleController@removeUser',
    ]);

});
