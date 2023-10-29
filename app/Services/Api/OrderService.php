<?php

namespace App\Services\Api;

use App\Services\Service;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class OrderService extends Service
{
    public function createOrder($request){
        try {
           $orderid = Order::insertGetId([
                'user_id' => $request['user_id'] ?? '',
            ]);

            $saveOrderDetails = OrderDetails::insert([
               'order_id' => $orderid,
               'item_name' => $request['item_name'] ?? '',
               'item_qty' => $request['item_qty'] ?? 0,
               'amount' => $request['amount'] ?? 0,
               'discount' => $request['discount'] ?? 0,
               'total_payable' => ($request['item_qty'] ?? 0) * ($request['amount'] ?? 0) - ($request['discount'] ?? 0),
            ]);

             $data = OrderDetails::where('order_id',$orderid)->first();
            if(!empty($saveOrderDetails)){
                 return $data;
            }else{
                  return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function GetOrder($request){
        try {
            $orderid = $request['order_id'];
           $order = Order::where('id',$orderid)->first();
           $orderdetails = OrderDetails::where('order_id',$orderid)->get();
           $data = [];
           foreach($orderdetails as $orderdetail){
            $data=  $orderdetail;
            $data->user_id = $order->user_id;
           }
           if(!empty($data)){
            return $data;
           }else{
            return false;
           }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
