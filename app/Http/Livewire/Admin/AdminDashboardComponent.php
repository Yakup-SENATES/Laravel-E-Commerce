<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class AdminDashboardComponent extends Component
{
    public function render()
    {
<<<<<<< main
        return view('livewire.admin.admin-dashboard-component')->layout('layouts.base');
=======
        $orders  = Order::orderBy('created_at', 'desc')->take(10)->get();
        $totalSales = Order::where('status', 'delivered')->count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total');

        $todaySales = Order::where('status', 'delivered')->whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Order::where('status', 'delivered')->whereDate('created_at', Carbon::today())->sum('total');


        return view('livewire.admin.admin-dashboard-component', compact('orders', 'totalSales', 'totalRevenue', 'todaySales', 'todayRevenue'))->layout('layouts.admin');
>>>>>>> local
    }
}
