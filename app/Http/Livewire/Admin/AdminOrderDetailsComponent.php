<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class AdminOrderDetailsComponent extends Component
{
    public $order_id;


    /**
     * Mount  component
     *
     * @param  mixed $order_id
     * @return void
     */
    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }


    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        $order = Order::findOrFail($this->order_id);

        return view('livewire.admin.admin-order-details-component', compact('order'))->layout('layouts.base');
    }
}
