<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(CategoriaController::class)->group(function () {
    Route::get("/categoria", "index");
    Route::get("/categoria/{id}", "show");
    Route::post("/categoria", "store");
    Route::put("/categoria/{id}", "update");
    Route::delete("/categoria/{id}", "destroy");
});

Route::controller(ProductoController::class)->group(function () {
    Route::get("/producto", "index");
    Route::get("/producto/{id}", "show");
    Route::post("/producto", "store");
    Route::put("/producto/{id}", "update");
    Route::delete("/producto/{id}", "destroy");
});
