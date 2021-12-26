<?php

namespace App\Http\Livewire\User;

use App\Models\Order;
use Livewire\Component;

class UserDashboardComponent extends Component
{
    public function render()
    {
        $orders = Order::orderBy('created_at', 'desc')->where('user_id', auth()->user()->id)->get()->take(10);
        $totalCost = Order::where('status', '!=', 'canceled')->where('user_id', auth()->user()->id)->sum('total');
        $totalPurchase = Order::where('status', '!=', 'canceled')->where('user_id', auth()->user()->id)->count();
        $totalDelivered = Order::where('status', 'delivered')->where('user_id', auth()->user()->id)->count();
        $totalCanceled = Order::where('status', 'canceled')->where('user_id', auth()->user()->id)->count();

        return view('livewire.user.user-dashboard-component', compact('orders', 'totalCost', 'totalPurchase', 'totalDelivered', 'totalCanceled'))->layout('layouts.base');
    }
}
