<?php

use App\Http\Controllers\NutrientController;
use Illuminate\Support\Facades\Route;

Route::get('/about', function() {
    return view('about');
})->name('about');

Route::get('/', [NutrientController::class, "index"])->name("home");
Route::get('/foods/{id}', [NutrientController::class, "foods"])->name("food_by_id");
Route::get('/vegetables', [NutrientController::class, "index"])->name("vegetables");
Route::get('/potatoes_and_tubers', [NutrientController::class, "index"])->name("potatoes_and_tubers");
Route::get('/fruits', [NutrientController::class, "index"])->name("fruits");
Route::get('/nuts_and_seeds', [NutrientController::class, "index"])->name("nuts_and_seeds");
Route::get('/meat', [NutrientController::class, "index"])->name("meat");
Route::get('/legumes', [NutrientController::class, "index"])->name("legumes");
Route::get('/fats_and_oils', [NutrientController::class, "index"])->name("fats_and_oils");

