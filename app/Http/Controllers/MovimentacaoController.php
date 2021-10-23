<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use App\Models\Movimentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentacaoController extends Controller
{
    public function index()
    {
        $result = Movimentacao::select('sku', 'qtd', 'created_at')
            ->get();

        return response()->json($result);
    }    

    public function show($id)
    {
        $result = Movimentacao::find($id);

        if (!$result) {
            return response()->json([
                'error' => true,
                'message' => 'Movimentação não encontrada.'
            ], 401);
        }

        return response()->json($result);
    }    

    public function store(Request $request)
    {
        try {
            $mov = new Movimentacao();
            $mov->fill($request->all());

            $mov->save();

            return response()->json([
                'error' => false,
                'item' => $mov,
                'message' => 'Movimentação inserida com sucesso.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }    

    public function update(Request $request, $id)
    {
        try {
            $mov = Movimentacao::find($id);

            if (!$mov) {
                return response()->json([
                    'error' => true,
                    'message' => 'Movimentação não encontrada.'
                ], 401);
            }
    
            $mov->fill($request->all());
            $mov->save();

            return response()->json([
                'error' => false,
                'item' => $mov,
                'message' => 'Movimentação atualizada com sucesso.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }    

    public function destroy($id)
    {
        try{
            $mov = Movimentacao::find($id);
            if (!$mov) {
                return response()->json([
                    'error' => true,
                    'message' => 'Movimentação não encontrada.'
                ], 401);
            }
    
            $mov->delete();

            return response()->json([
                'error' => false,
                'item' => $mov,
                'message' => 'Movimentação excluída com sucesso.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }                   
    }    

    public function getMovimentacaoSku($sku)
    {
        $produto = Produtos::find($sku);

        if (!$produto) {
            return response()->json([
                'error' => true,
                'message' => 'Produto não encontrado.'
            ], 401);
        }
        
        $result = Produtos::with('movimentacao')
            ->where('produtos.sku', $sku)
            ->get();

        return response()->json($result);
    }      

    public function getEstoqueAtual($sku)
    {
        $result = Movimentacao::select(
            'movimentacao.sku',
            DB::raw('produtos.qtd + SUM(movimentacao.qtd) AS estoque')
        )
            ->join('produtos', function ($join) {
                $join->on('produtos.sku', 'movimentacao.sku');
            })
            ->where('movimentacao.sku', DB::raw("'$sku'"))
            ->get();

        return response()->json($result, 200, [], JSON_NUMERIC_CHECK);
    }
}
