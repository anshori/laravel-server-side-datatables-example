<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TableController;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [TableController::class, 'datatables'])->name('datatables');
Route::get('/map', [MapController::class, 'index'])->name('map');