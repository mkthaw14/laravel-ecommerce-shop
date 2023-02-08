<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\MOdels\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashBoardController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        $orders = Order::all();
        $numberOfOrderAmount = Order::sum("total_amount");
        //return view("backend.dashboard", compact("categories", "products", "orders", "numberOfOrderAmount"));
        return redirect()->route("category.index");
    }
}
