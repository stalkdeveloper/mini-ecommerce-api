<?php

namespace App\Services\Api;

use App\Services\Service;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductService extends Service
{
    public function productAll($request){
        try {
            $product = Product::orderBy('id', 'desc')->get();
            return $product;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function productStore($request){
        try {
            $data = [
                'name' => $request['name'],
                '.description'=>$request['description'],
                'price' => $request['price'],
                'created_at' => now(),
                'updated_at' =>now(),
            ];
            $save = Product::insert($data);
            return $save;
        } catch (\Throwable $e) {

        }
    }

    public function oneProductGet($id){
        try {
            $data = Product::where('id', $id)->first();
            return $data;
        } catch (\Throwable $e) {

        }
    }

    public function productUpdate($request){
        try {
            $data = [
                'name' => $request['name'],
                '.description'=>$request['description'],
                'price' => $request['price'],
                'updated_at' =>now(),
            ];
            $update = Product::where('id', $request['id'])->update($data);
            return $update;
        } catch (\Throwable $e) {

        }
    }

    public function productDelete($id){
        try {
            $data = Product::where('id', $id)->delete();
            return $data;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function searchProduct($request){
        try {
            $products  = Product::where('name', 'like', '%' . $request['search'] . '%')->get();
            if(!empty($products)){
                return $products;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
