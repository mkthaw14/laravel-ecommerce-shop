<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createOrder(1, "kyaw" ,"Yangon", "091234455" , "pending", 3400);
        $this->createOrder(1, "khant" ,"Yangon", "091234455" , "delivered", 299);
        $this->createOrder(2, "soe" ,"Yangon", "091234455" , "cancelled", 599);
        $this->createOrder(3, "lin" ,"Yangon", "091234455" , "received", 600);
        $this->createOrder(3, "naing" ,"Yangon", "091234455" , "pending", 500);

        $this->createOrderItem(1, 1, 3);
        $this->createOrderItem(3, 1, 5);
        $this->createOrderItem(1, 2, 8);
        $this->createOrderItem(4, 2, 4);
        $this->createOrderItem(1, 3, 4);
        $this->createOrderItem(3, 4, 4);
        $this->createOrderItem(2, 5, 4);
        $this->createOrderItem(4, 5, 4);
        $this->createOrderItem(1, 5, 4);
    }

    function createOrder($user_id, $receiver_name , $receiver_address, $receiver_phone, $status, $amount)
    {
        $order = new Order;
        $order->user_id = $user_id; // user is who make the order by his/her account
        $order->receiver_name = $receiver_name; // receiver is who will receive the order but it could be the original user who made the order or someone
        $order->receiver_address = $receiver_address;
        $order->receiver_phone = $receiver_phone;
        $order->status = $status;
        $order->total_amount = $amount;
        $order->save();
    }

    function createOrderItem($product_id, $order_id, $qty)
    {
        $orderItem = new OrderItem;
        $orderItem->product_id = $product_id;
        $orderItem->order_id = $order_id;
        $orderItem->qty = $qty;
        $orderItem->save();
    }
}
