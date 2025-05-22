<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TableController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/json', [TableController::class, 'json'])->name('api.json');
Route::get('/geojson', [MapController::class, 'geojson'])->name('api.geojson');
