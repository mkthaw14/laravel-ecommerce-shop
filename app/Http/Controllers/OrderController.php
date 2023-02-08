<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        $status = session("status");
        return view("backend.order", compact("orders", "status"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $status = session("status");
        return view("backend.order_detail", compact("order", "status"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if($order->isCancelledOrReceived())
            $order->delete();

        return redirect()->route("order.index");
    }

    public function updateStatus(Request $request, Order $order)
    {
        //dd($order->id);
        $order = Order::find($order->id);
        $order->status = $order->getNextStatusName();
        $order->save();

        return redirect()->route("order.show", $order->id);
    }

    public function statusCancel(Request $request, Order $order)
    {
        $order = Order::find($order->id);

        $order = Order::find($order->id);
        $order->status = "cancelled";
        $order->save();

        return redirect()->route("order.show", $order->id);
    }
}
