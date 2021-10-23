<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\MovimentacaoController;

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
    Route::get('/{sku}',[ProdutosController::class, 'show']);
    Route::post('/',[ProdutosController::class, 'store']);
    Route::put('/{sku}',[ProdutosController::class, 'update']);
    Route::delete('/{sku}',[ProdutosController::class, 'destroy']);
});

Route::prefix('movimentacao')->group(function(){
    Route::get('/',[MovimentacaoController::class, 'index']);
    Route::get('/{id}',[MovimentacaoController::class, 'show']);
    Route::get('/sku/{sku}',[MovimentacaoController::class, 'getMovimentacaoSku']);    
    Route::post('/',[MovimentacaoController::class, 'store']);
    Route::put('/{id}',[MovimentacaoController::class, 'update']);
    Route::delete('/{id}',[MovimentacaoController::class, 'destroy']);
});
