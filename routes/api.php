<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::fallback(function(){
    return response()->json(['status' => 'error_not_found', 'message' => 'Not Found.'], 404);
})->name('api.fallback.404');

Route::apiResource('announcement', 'AnnouncementController')->except(['destroy', 'update']);
