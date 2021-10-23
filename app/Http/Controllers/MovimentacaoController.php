<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use App\Models\Movimentacao;
use Illuminate\Http\Request;

class MovimentacaoController extends Controller
{
    /**
     * @OA\Get(
     *      tags={"/movimentacao"},
     *      summary="Retorna o histórico das movimentações",
     *      description="Retorna um objeto com o histórico das movimentações",
     *      path="/movimentacao",
     *      @OA\Response(
     *          response="200", description="Histórico de movimentações"
     *      )
     * )
     */    
    public function index()
    {
        $result = Movimentacao::select('*')
            ->get();

        return response()->json($result);
    }    

    /**
     * @OA\Get(
     *      tags={"/movimentacao"},
     *      summary="Retorna uma movimentação especifica",
     *      description="Retorna os dados de uma movimentação especifica",
     *      path="/movimentacao/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id da movimentação",
     *          required=false,
     *          @OA\Schema(
     *              type="bigint"
     *          )
     *      ),
     *      @OA\Response(
     *          response="200", description="Dados da movimentação"
     *      ),
     *      @OA\Response(
     *          response="401", description="Movimentação não encontrada"
     *      )
     * )
     */
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

    /**
     * @OA\Post(
     *      tags={"/movimentacao"},
     *      summary="Insere uma movimentação",
     *      description="Insere uma movimentação",
     *      path="/movimentacao",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="sku", type="string"),
     *              @OA\Property(property="qtd", type="integer"), 
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200", description="Movimentação inserida com sucesso"
     *      ),
     *      @OA\Response(
     *          response="401", description="Produto não encontrado"
     *      )
     * )
     */      
    public function store(Request $request)
    {
        try {
            $produto = Produtos::find($request->sku);

            if (!$produto) {
                return response()->json([
                    'error' => true,
                    'message' => 'Produto não encontrado.'
                ], 401);    
            }

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

   /**
     * @OA\Put(
     *      tags={"/movimentacao"},
     *      summary="Atualiza uma movimentação",
     *      description="Atualiza uma movimentação",
     *      path="/movimentacao/{id}",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="sku", type="string"),
     *              @OA\Property(property="qtd", type="integer"), 
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200", description="Movimentação atualizada com sucesso"
     *      ),
     *      @OA\Response(
     *          response="401", description="Movimentação ou Produto não encontrados"
     *      ),
     * )
     */       
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
    
            $produto = Produtos::find($request->sku);

            if (!$produto) {
                return response()->json([
                    'error' => true,
                    'message' => 'Produto não encontrado.'
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

     /**
     * @OA\Delete(
     *      tags={"/movimentacao"},
     *      summary="Exclui uma movimentação",
     *      description="Exclui uma movimentação",
     *      path="/movimentacao/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id da movimentação",
     *          required=false,
     *          @OA\Schema(
     *              type="bigint"
     *          )
     *      ),
     *      @OA\Response(
     *          response="200", description="Movimentação excluida com sucesso"
     *      ),
     *      @OA\Response(
     *          response="401", description="Movimentação não encontrada"
     *      ),
     * )
     */  
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

    /**
     * @OA\Get(
     *      tags={"/movimentacao"},
     *      summary="Retorna as movimentações de um produto",
     *      description="Retorna as movimentações de um produto",
     *      path="/movimentacao/sku/{sku}",
     *      @OA\Parameter(
     *          name="sku",
     *          in="path",
     *          description="SKU",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response="200", description="Todas movimentações de um produto"
     *      ),
     *      @OA\Response(
     *          response="401", description="Produto não encontrado"
     *      )
     * )
     */         
    public function getMovimentacaoSku($sku)
    {
        $produto = Produtos::find($sku);

        if (!$produto) {
            return response()->json([
                'error' => true,
                'message' => 'Produto não encontrado.'
            ], 401);
        }
        
        $result = Movimentacao::select('*')
            ->where('sku', $sku)
            ->get();

        return response()->json($result);
    }      
}
