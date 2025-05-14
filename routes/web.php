<?php

use App\Http\Controllers\NutrientController;
use Illuminate\Support\Facades\Route;

Route::get('/about', function() {
    return view('about');
})->name('about');

Route::get('/nutrients', [NutrientController::class, "index"])->name("nutrients");
Route::get('/groente', [NutrientController::class, "index"])->name("groente");
Route::get('/fruit', [NutrientController::class, "index"])->name("fruit");

