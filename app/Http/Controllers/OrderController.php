<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        return Order::where('customer_id', Auth()->user()->id)->paginate(config('constants.options.RECORD_PER_PAGE'));
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
        $productIds = $this->makeArray($request->productId);
        
        $orderDetails = $this->insertDetails($productIds);

        return 'Order placed with '.$orderDetails.' products';
    }

    private function insertDetails($productIds){
        $insertCounter = 0;

        foreach($productIds as $productId){

            // If the product id is valid

            if(!Product::find($productId)){
                continue;
            }

            // If at least one valid product available for order then order table will keep the record

            if(!$insertCounter){
                $orderId = Order::insertGetId([
                    'customer_id' => Auth()->user()->id,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);
            }

            OrderDetail::create([
                'order_id' => $orderId,
                'product_id' => $productId
            ]);

            $insertCounter++;
        }

        return $insertCounter;
    }


    private function makeArray($productString){
        return explode(",", $productString);
    }
}
