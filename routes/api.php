<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutosController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('produtos')->group(function(){
    Route::get('/',[ProdutosController::class, 'index']);
    Route::get('/{id}',[ProdutosController::class, 'show']);
    Route::post('/',[ProdutosController::class, 'store']);
    Route::put('/{id}',[ProdutosController::class, 'update']);
    Route::delete('/{id}',[ProdutosController::class, 'destroy']);
});
