<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PalamuninController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\Api\AxieController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('/user', [AuthController::class , 'profile']);

    Route::group(['prefix' => 'palamunin'], function () {
        $controller = PalamuninController::class;
        
        Route::get('/', [$controller , 'index']);
        Route::get('/all', [$controller , 'all']);
        Route::post('/add', [$controller, 'add']);
        Route::delete('/delete/{id}', [$controller, 'delete']);

    });

    Route::group(['prefix' => 'food'], function () {
        $controller = FoodController::class;
        
        Route::post('/add', [$controller, 'add']);
        Route::put('/update/{id}', [$controller, 'update']);
        Route::get('/edit/{id}', [$controller, 'edit']);

    });

    Route::group(['prefix' => 'calendar'], function () {
        $controller = CalendarController::class;
        
        Route::get('/', [$controller, 'index']);

    });
});

// Axie Scholars API
Route::group(['prefix' => 'axie'], function () {
    
    Route::get('/account/details/{ronin_address}', [AxieController::class, 'index']);
    Route::get('/accounts/all', [AxieController::class, 'all']);

});
