<?php

Route::post('/login', [
    'name' => 'Log In',
    'as' => 'login',
    'uses' => 'ExtensionsValley\Dashboard\LoginController@getIndex',
]);
