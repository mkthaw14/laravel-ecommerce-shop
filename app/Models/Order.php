<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Order extends Model
{
    use HasFactory;

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    function getNextStatusName()
    {
        $status = $this->status;
        $nextStatus = "";

        switch($status)
        {
            case "pending":
                $nextStatus = "delivered";
                break;
            case "delivered":
                $nextStatus = "received";
                break;
        }

        return $nextStatus;
    }

    function isCancelledOrReceived()
    {
        $status = $this->status;
        return $status == "cancelled" || $status == "received";
    }
}
