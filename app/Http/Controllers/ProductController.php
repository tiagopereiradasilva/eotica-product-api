<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts() {
        $products = Product::get()->toJson(JSON_PRETTY_PRINT);
        return response($products, 200);
    }

    public function createProduct(Request $request) {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->brand = $request->brand;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->color = $request->color;
        $product->save();

        if(!$product->save()){
            return response()->json([
                'error' => true,
                'message' => 'Não foi possível cadastrar o produto'
            ], 403);
        }

        return response()->json([
            'error' => false,
            'message' => 'Produto cadastrado!'
        ], 201);
    }

    public function getProduct($id) {
        if(Product::where('id', $id)->exists()){
            $product = Product::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response([
                'error' => true,
                'data' => $product
            ], 200);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Produto não encontrato!'
            ], 404);
        }
    }

    public function updateProduct(Request $request, $id) {
        if(Product::where('id', $id)->exists()){
            $product = Product::find($id);
            $product->name = is_null($request->name) ? $product->name : $request->name;
            $product->description = is_null($request->description) ? $product->description : $request->description;
            $product->brand = is_null($request->brand) ? $product->brand : $request->brand;
            $product->category = is_null($request->category) ? $product->category : $request->category;
            $product->price = is_null($request->price) ? $product->price : $request->price;
            $product->color = is_null($request->color) ? $product->color : $request->color;
            $product->save();
            return response()->json([
                'error' => false,
                'message' => 'Produto atualizado!'
            ], 200);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Não foi possível atualizar produto!'
            ], 404);
        }
    }

    public function deleteProduct ($id) {
        if(Product::where('id', $id)->exists()){
            $product = Product::find($id);
            $product->delete();
            return response()->json([
                'error' => false,
                'message' => 'Produto deletato!'
            ], 200);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Não foi possível deletar o produto!'
            ], 404);
        }
    }
}
