<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\PetController::class, 'index'])->name('pets.index');
Route::get('/pet', [\App\Http\Controllers\PetController::class, 'create'])->name('pets.create');
Route::get('/pet/{id}/edit', [\App\Http\Controllers\PetController::class, 'edit'])->name('pets.edit');
Route::post('/pet', [\App\Http\Controllers\PetController::class, 'store'])->name('pets.store');
Route::post('/pet/{id}', [\App\Http\Controllers\PetController::class, 'update'])->name('pets.update');
Route::delete('/pet/{id}', [\App\Http\Controllers\PetController::class, 'delete'])->name('pets.delete');


