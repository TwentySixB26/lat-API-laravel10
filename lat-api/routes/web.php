<?php

use App\Http\Controllers\BukuController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/buku', action: [BukuController::class,'index']);
Route::post('/buku', action: [BukuController::class,'store']);

Route::get('/buku/{id}', action: [BukuController::class,'edit']);

Route::put('/buku/{id}', action: [BukuController::class,'update']);

Route::delete('/buku/{id}', action: [BukuController::class,'destroy']);

