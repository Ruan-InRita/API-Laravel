<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Client\Request;

class ProductController extends Controller
{
    //
    public function __construct(Product $product) {
        $this->product = $product;
    }   

    public function index(){
        return response()->json($this->product::all());
    }

    public function show($id){
        $product = $this->product::find($id);
        if(!$product) return response()->json(['data' => ['info' => 'Product not a found']],404);
        return response()->json( ['data' => $product]);
    }

    public function store(Request $request){
        try{
            $productData = $request->all();
            $this->product->create($productData);
            $return = ['data' => ['msg' => 'Success created products!']];
            return response()->json($return ,201);
        }catch(\Exception $e){
            if(config('app.debug')){
                return response()->json(ApiError::errorMessage($e->getMessage(),1010));
            }
            return response()->json(ApiError::errorMessage("Houve um erro ao realizar a operação de cadastro"));
        }
    }   

    public function delete($id = null){
        if($id){
            return json_encode([202 => "Deleted"]);

        }else{
            return json_encode([404 => "Not a found"]);
        }
        Product::where("id", $id)->delete();
    }

    public function update($id){

    }
}
