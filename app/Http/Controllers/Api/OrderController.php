<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Api\OrderService;
class OrderController extends Controller
{
    public function __construct(OrderService $OrderService)
    {
          $this->OrderService = $OrderService;
    }
    public function create(Request $request){
        try {
                $validation = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'item_name' => 'required',
                    'item_qty' => 'required',
                    'amount' => 'required',
                ]);
                if ($validation->fails()) {
                    $errors = $validation->errors()->all();
                    return response()->json($errors, 422);
                } else {
                    $saveOrder = $this->OrderService->createOrder($request);
                    if (!empty($saveOrder)) {
                        return response()->json([
                            'data' => $saveOrder,
                            'message' =>'Order Created Successfully',
                            'code' => 200,
                        ]);
                    } else {
                        return response()->json('Unable to create order', 400);
                    }
            }
        } catch (\Exception $e) {
            return response()->json('Something went wrong', 500);
        }
    }

    public function GetOrder(Request $request){
        try {
            $validation = Validator::make($request->all(), [
                'order_id' => 'required',
            ]);
    
            if ($validation->fails()) {
                $errors = $validation->errors()->all();
                return response()->json($errors, 422);
            } else {
                $getOrder = $this->OrderService->GetOrder($request);
                if (!empty($getOrder)) {
                    return response()->json([
                    'data' => $getOrder,
                    'message' =>'Order Get Successfully',
                    'code' => 200
                    ]);
                } else {
                    return response()->json('Unable to get order', 400);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
