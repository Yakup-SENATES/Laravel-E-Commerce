<?php

namespace App\Http\Livewire\User;

use App\Models\Order;
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
