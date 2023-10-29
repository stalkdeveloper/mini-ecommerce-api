<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\ProductService;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{

    public function __construct(ProductService $productService)
    {
        $this->ProductService = $productService;
    }

    public function index(Request $request){
        try {
            $products = $this->ProductService->productAll($request);
            return ProductResource::collection($products);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(),[
                'name'            =>'required|string|max:255',
                'description'   =>'required',
                'price'             =>'required',
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors(),400);
            }
            $store = $this->ProductService->productStore($request);
            if($store){
                return response()->json([
                    'data' => new ProductResource($request),
                    'message' => 'Product Store',
                ], 200);                
            }
            return response()->json(['error' => 'Something went wrong!'], 500);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function getOneProduct($id){
        try {
            $product = $this->ProductService->oneProductGet($id);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            return response()->json([
                'data' => new ProductResource($product),
                'message' => 'Product Details',
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'An error occurred'], 500);        }
    }

    public function updateProduct(Request $request, Product $product){
        try {
            $validator = Validator::make($request->all(),[
                'id'                   =>'required|integer',
                'name'            =>'required|string|max:255',
                'description'   =>'required',
                'price'             =>'required',
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors(),400);
            }

            $update = $this->ProductService->productUpdate($request);
            if($update){
                return response()->json([
                    'data' => new ProductResource($request),
                    'message' => 'Product Updated',
                ], 200);
            }
            return response()->json(['error' => 'Something went wrong!'], 500);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred'], 500); 
        }
    }

    public function deleteProduct($id){
        try {
            $products = $this->ProductService->oneProductGet($id);
            $product = $this->ProductService->productDelete($id);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            return response()->json([
                'data' => new ProductResource($products),
                'message' => 'Product Deleted',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred'], 500); 
        }
    }


    public function searchProduct(Request $request){
        try {
            $validation = Validator::make($request->all(), [
                'search' => 'required',
            ]);
    
            if ($validation->fails()) {
                $errors = $validation->errors()->all();
                return response()->json($errors, 422);
            } else {
                $getProducts = $this->ProductService->searchProduct($request);
                if (!empty($getProducts)) {
                    return response()->json([
                    'data' => $getProducts,
                    'message' =>'Product Get Successfully',
                    'code' => 200
                    ]);
                } else {
                    return response()->json('Unable to get products', 400);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred'], 500); 
        }
    }
}
