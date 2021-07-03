<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PalamuninController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\CalendarController;

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

    });

    Route::group(['prefix' => 'calendar'], function () {
        $controller = CalendarController::class;
        
        Route::get('/', [$controller, 'index']);

    });
});
