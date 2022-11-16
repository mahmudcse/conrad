<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeOrder(Request $request){
        $productIds = explode(",", $request->productId);
        
        $orderId = Order::insertGetId([
            'customer_id' => Auth()->user()->id
        ]);

        $insertCounter = 0;

        foreach($productIds as $productId){
            OrderDetail::create([
                'order_id' => $orderId,
                'product_id' => $productId
            ]);

            $insertCounter++;
        }

        return 'Order placed with '.$insertCounter.' products';
    }
}
