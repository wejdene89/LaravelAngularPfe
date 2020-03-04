<?php

use Illuminate\Http\Request;

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('details', 'AuthController@details');
    Route::post('signupImage', 'AuthController@signupImage');
    Route::post('signup', 'AuthController@signup');
    Route::get('Image','AuthController@Image');
    Route::post('signupAdmin', 'AuthController@signupAdmin');
    Route::post('sendPasswordReset', 'ResetPasswordController@sendEmail');
    Route::post('responsepasswordreset', 'ChangePasswordController@process');

});
