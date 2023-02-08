<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view("frontend.index", compact("products", "categories"));
    }

    public function cart()
    {
        $status = session("status");
        return view("frontend.cart", compact("status"));
    }

    public function login()
    {
        return view("frontend.login");
    }

    public function checkOut()
    {
        return view("frontend.checkout");
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            "receiverName" => "required",
            "receiverAddress" => "required",
            "receiverPhone" => "required",
        ]);

        if($request->orderItems == null || empty($request->orderItems)
        || count($request->orderItems) < 1)
            return response()->json([
                "error" => "Something is wrong",
            ]);

        $order = new Order;
        DB::transaction(function() use($request, $order) {

            $receiverName = $request->receiverName;
            $receiverAddress = $request->receiverAddress;
            $receiverPhone = $request->receiverPhone;


            $order->receiver_name = $receiverName;
            $order->receiver_address = $receiverAddress;
            $order->receiver_phone = $receiverPhone;
            $order->status = "pending";
            $order->user_id = Auth::user()->id;
            $order->total_amount = 0;
            $order->save();

            $totalAmount = 0;
            foreach($request->orderItems as $item)
            {
                $orderItem = new OrderItem;
                $orderItem->product_id = $item["id"];
                $orderItem->order_id = $order->id;
                $orderItem->qty = $item["qty"];

                $product = Product::find($item["id"]);
                $totalAmount += $product->price * $item["qty"];
                //print_r(" ".$item["id"]." ");
                $orderItem->save();
            }

            $order->total_amount = $totalAmount;
            $order->save();
        });


        //$user = auth()->user();
        return response()->json([
            "message" => "success",
            "order" => $order,
        ]);
    }

    public function getProductByCategory(Request $request)
    {
        $category = Category::find($request->category_id);

        $products = $category == null || 0 ? Product::all() : $category->products;
        return response()->json([
            "products" => $products
        ]);
    }
}
