<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        return Order::where('customer_id', Auth()->user()->id)->paginate(5);
    }

    public function show($id){

        $orderDetails = DB::table('order_details as od')
                        ->select(DB::raw('
                        od.product_id,
                        p.name,
                        p.price'))
                        ->leftJoin('products as p', 'od.product_id', '=', 'p.id')
                        ->where('od.order_id', $id)
                        ->get();
        return $orderDetails;
    }

    public function store(Request $request){
        $productIds = explode(",", $request->productId);

        if(count($productIds)<1){
            return 'No valid products to place order';
        }
        
        $orderId = Order::insertGetId([
            'customer_id' => Auth()->user()->id
        ]);

        $insertCounter = 0;

        foreach($productIds as $productId){

            if(!Product::find($productId)){
                continue;
            }

            OrderDetail::create([
                'order_id' => $orderId,
                'product_id' => $productId
            ]);

            $insertCounter++;
        }

        return 'Order placed with '.$insertCounter.' products';
    }
}
