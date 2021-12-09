<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminOrderComponent extends Component
{

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed $order_id
     * @param  mixed $status
     * @return void
     */
    public function updateOrderStatus($order_id, $status)
    {
        $order = Order::find($order_id);
        $order->status = $status;
        if ($status == 'delivered') {
            $order->delivered_date = DB::raw('CURRENT_TIMESTAMP');
        } elseif ($status == 'canceled') {

            $order->canceled_date = DB::raw('CURRENT_TIMESTAMP');
        }
        $order->save();
        session()->flash('order_message', 'Order status updated successfully');
    }

    public function render()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(12);
        return view('livewire.admin.admin-order-component', compact('orders'))->layout('layouts.base');
    }
}
