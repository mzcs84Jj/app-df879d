<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    /**
     * @OA\Get(
     *      tags={"/produtos"},
     *      summary="Retorna todos os produtos",
     *      description="Retorna um objeto com todos os produtos",
     *      path="/produtos",
     *      @OA\Response(
     *          response="200", description="Lista de produtos"
     *      )
     * )
     */       
    public function index()
    {
        $result = Produtos::select('sku', 'nome', 'qtd')
            ->get();

        return response()->json($result);
    }    

    /**
     * @OA\Get(
     *      tags={"/produtos"},
     *      summary="Retorna um produto especifico",
     *      description="Retorna os dados de um produto especifico",
     *      path="/produtos/{sku}",
     *      @OA\Parameter(
     *          name="sku",
     *          in="path",
     *          description="SKU do produto",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response="200", description="Dados do produto"
     *      ),
     *      @OA\Response(
     *          response="401", description="Produto não encontrado"
     *      )
     * )
     */    
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

     /**
     * @OA\Post(
     *      tags={"/produtos"},
     *      summary="Insere um produto",
     *      description="Insere um produto",
     *      path="/produtos",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="sku", type="string"),
     *              @OA\Property(property="nome", type="string"),
     *              @OA\Property(property="qtd", type="integer"), 
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200", description="Produto inserido com sucesso"
     *      ),
     * )
     */        
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

     /**
     * @OA\Put(
     *      tags={"/produtos"},
     *      summary="Atualiza um produto",
     *      description="Atualiza um produto",
     *      path="/produtos/{sku}",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="sku", type="string"),
     *              @OA\Property(property="nome", type="string"),
     *              @OA\Property(property="qtd", type="integer"), 
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200", description="Produto atualizado com sucesso"
     *      ),
     *      @OA\Response(
     *          response="401", description="Produto não encontrado"
     *      ),
     * )
     */       
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

    /**
     * @OA\Delete(
     *      tags={"/produtos"},
     *      summary="Exclui um produto",
     *      description="Exclui um produto",
     *      path="/produtos/{sku}",
     *      @OA\Parameter(
     *          name="sku",
     *          in="path",
     *          description="SKU do produto",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response="200", description="Produto excluido com sucesso"
     *      ),
     *      @OA\Response(
     *          response="401", description="Produto não encontrado"
     *      ),
     * )
     */     
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
