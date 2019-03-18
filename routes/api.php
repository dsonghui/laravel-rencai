<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('auth/register', 'AuthController@register');

// 需要登录验证
Route::middleware('auth:api')->group(function () {

    Route::get('me', 'UserController@me');
    Route::post('user/company', 'UserController@me');

});


Route::apiResource('company', 'CompanyController', ['only'=>['index','show','update','store']]);
Route::apiResource('talent', 'TalentController', ['only'=>['index','show','update','store']]);