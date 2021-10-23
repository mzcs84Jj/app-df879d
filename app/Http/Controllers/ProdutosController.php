<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    public function index()
    {
        $result = Produtos::select('sku', 'nome', 'qtd')
            ->get();

        return response()->json($result);
    }    

    public function show($sku)
    {
        $result = Produtos::find($sku);

        if (!$result) {
            return response()->json([
                'error' => true,
                'message' => 'Produto não encontrado.'
            ], 401);
        }

        return response()->json($result);
    }    

    public function store(Request $request)
    {
        try {
            $produto = new Produtos();
            $produto->fill($request->all());

            $produto->save();

            return response()->json([
                'error' => false,
                'item' => $produto,
                'message' => 'Produto inserido com sucesso.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }    

    public function update(Request $request, $sku)
    {
        try {
            $produto = Produtos::find($sku);

            if (!$produto) {
                return response()->json([
                    'error' => true,
                    'message' => 'Produto não encontrado.'
                ], 401);
            }
    
            $produto->nome = $request->nome;
            $produto->qtd = $request->qtd;
            $produto->save();

            return response()->json([
                'error' => false,
                'item' => $produto,
                'message' => 'Produto atualizado com sucesso.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }    

    public function destroy($sku)
    {
        try{
            $produto = Produtos::find($sku);
            if (!$produto) {
                return response()->json([
                    'error' => true,
                    'message' => 'Produto não encontrado.'
                ], 401);
            }
    
            $produto->delete();

            return response()->json([
                'error' => false,
                'item' => $produto,
                'message' => 'Produto excluído com sucesso.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }                   
    }    
}
