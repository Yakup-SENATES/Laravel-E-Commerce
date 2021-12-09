<?php

namespace App\Http\Livewire\User;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserOrderDetailsComponent extends Component
{

    public $order_id;


    /**
     * Mount Component
     *
     * @param  mixed $order_id
     * @return void
     */
    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function cancelOrder()
    {
        $order = Order::find($this->$order_id);
        $order->status = 'canceled';
        $order->cancel_date = DB::raw('CURRENT_TIMESTAMP');
        $order->save();
        session()->flash('order_message', 'Order has been canceled');
    }


    /**
     * Render the view component
     *   
     * @return \Illuminate\View\View
     * @return void
     */
    public function render()
    {
        $order = Order::where('user_id', auth()->user()->id)->where('id', $this->order_id)->first();
        return view('livewire.user.user-order-details-component', compact('order'))->layout('layouts.base');
    }
}
